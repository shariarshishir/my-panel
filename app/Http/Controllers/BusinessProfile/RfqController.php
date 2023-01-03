<?php

namespace App\Http\Controllers\BusinessProfile;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Rfq;
use App\Models\User;
use App\Models\Product;
use App\Models\RfqImage;
use App\Models\Certification;
use App\Models\UserVerify;
use App\Userchat;
use App\RfqApp;
use Illuminate\Support\Str;
use App\Jobs\NewRfqHasAddedJob;
use App\Models\BusinessProfile;
use App\Models\CompanyOverview;
use App\Events\NewRfqHasAddedEvent;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
Use DB;
use stdClass;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use App\Models\Manufacture\Product as ManufactureProduct;
use App\Models\Product as WholesalerProduct;
use App\Models\ProductTag;
use App\Models\supplierQuotationToBuyer;
use App\Events\NewAnonymousUserHasRegisteredEvent;
use App\Events\NewRFQHasPostedEvent;
use App\Models\Manufacture\ProductCategory;
use App\Models\Proforma;
use App\Models\ProductTypeMapping;
use App\Models\Countrywithcallingcode;


class RfqController extends Controller
{
    public function index($alias, Request $request)
    {
        $business_profile=BusinessProfile::where('alias',$alias)->firstOrFail();

        if((auth()->id() == $business_profile->user_id) || (auth()->id() == $business_profile->representative_user_id))
        {

            if($business_profile->business_type == 'manufacturer'){
                $collection=collect(ManufactureProduct::withTrashed()
                ->latest()
                ->with('product_images','product_video','businessProfile')
                ->where(function($query) use ($request, $business_profile){
                    $query->where('business_profile_id', '!=', null)->get();
                    if(isset($request->search)){
                        $query->where('title','like', '%'.$request->search.'%')->get();
                    }

                })
                ->get());

                $controller_max_moq = $collection->max('moq');
                $controller_min_moq = $collection->min('moq');
                $controller_max_lead_time = $collection->max('lead_time');
                $controller_min_lead_time = $collection->min('lead_time');

                if(isset($request->product_tag)){
                    $ptags = [];
                    foreach($request->product_tag as $tag){
                        $product_tag = ProductTag::where('id',$tag)->first();
                        array_push($ptags,$product_tag->name);
                    }
                    $collection= $collection->filter(function($item) use ($ptags){
                        if(isset($item['product_tag'])){
                            $check = array_intersect($item['product_tag'], $ptags);
                            if(empty($check)){
                                return false;
                            }
                            return true;
                        }
                        return false;
                    });
                }

                if(isset($request->product_type_mapping_child_id)){
                    $collection = $collection->filter(function($item) use ($request){
                        if(isset($item['product_type_mapping_child_id'])){
                            $check = array_intersect($item['product_type_mapping_child_id'], $request->product_type_mapping_child_id);
                            if(empty($check)){
                                return false;
                            }
                            return true;
                        }
                        return false;
                    });
                }

                if(isset($request->min_moq) && isset($request->max_moq)){
                    $collection = $collection->whereBetween('moq', [$request->min_moq, $request->max_moq]);
                    $collection->all();
                }

                if(isset($request->min_lead) && isset($request->max_lead)){
                    $collection = $collection->whereBetween('lead_time', [$request->min_lead, $request->max_lead]);
                    $collection->all();
                }

                $page = Paginator::resolveCurrentPage() ?: 1;
                $perPage = 9;
                $products = new \Illuminate\Pagination\LengthAwarePaginator(
                    $collection->forPage($page, $perPage),
                    $collection->count(),
                    $perPage,
                    $page,
                    ['path' => Paginator::resolveCurrentPath()],
                );

                $colors=['Red','Blue','Green','Black','Brown','Pink','Yellow','Orange','Lightblue','Multicolor'];
                $sizes=['S','M','L','XL','XXL','XXXL'];
                $view = isset($request->view)? $request->view : 'grid';
                return view('new_business_profile.rfqs',compact('alias','products','business_profile','view','colors','sizes','controller_max_moq','controller_min_moq','controller_max_lead_time','controller_min_lead_time'));
            }


            if($business_profile->business_type == 'wholesaler'){

                $collection=collect(WholesalerProduct::withTrashed()
                ->where(function($query) use ($request, $business_profile){
                    $query->where('business_profile_id', '!=', null)->get();
                    if(isset($request->search)){
                        $query->where('name','like', '%'.$request->search.'%')->get();
                    }})
                ->latest()
                ->with('images','video')
                ->get());

                $controller_max_moq = $collection->max('moq');
                $controller_min_moq = $collection->min('moq');
                $controller_max_lead_time = 0;
                $controller_min_lead_time = 0;
                foreach($collection as $product){
                    if(isset($product->attribute) && $product->product_type == 1){
                        foreach(json_decode($product->attribute) as $lead_time)
                        {
                            if ($lead_time[3] > $controller_max_lead_time) {
                                $controller_max_lead_time = $lead_time[3];
                            }

                            if ($lead_time[3] < $controller_min_lead_time) {
                                $controller_min_lead_time = $lead_time[3];
                            }
                        }
                    }
                }

                if(isset($request->product_tag)){
                    $ptags = [];
                    foreach($request->product_tag as $tag){
                        $product_tag = ProductTag::where('id',$tag)->first();
                        array_push($ptags,$product_tag->name);
                    }
                    $collection = $collection->filter(function($item) use ($ptags){
                        if(isset($item['product_tag'])){
                            $check = array_intersect($item['product_tag'], $ptags);
                            if(empty($check)){
                                return false;
                            }
                            return true;
                        }
                        return false;

                    });
                }

                if(isset($request->product_type_mapping_child_id)){
                    $collection = $collection->filter(function($item) use ($request){
                        if(isset($item['product_type_mapping_child_id'])){
                            $check = array_intersect($item['product_type_mapping_child_id'], $request->product_type_mapping_child_id);
                            if(empty($check)){
                                return false;
                            }
                            return true;
                        }
                        return false;
                    });
                }

                if(isset($request->min_lead) && isset($request->max_lead)){
                    $p_id=[];
                    foreach($collection as $product){
                        if(isset($product->attribute) && $product->product_type == 1){
                            foreach(json_decode($product->attribute) as $lead_time)
                            {
                                if ( $lead_time[3] >= $request->min_lead && $lead_time[3] <= $request->max_lead){
                                    array_push($p_id,$product->id);
                                }
                            }
                        }
                    }

                    $collection = $collection->whereIn('id', $p_id);
                    $collection->all();
                }

                if(isset($request->min_moq) && isset($request->max_moq)){
                    $collection = $collection->whereBetween('moq', [$request->min_moq, $request->max_moq]);
                    $collection->all();
                }

                $page = Paginator::resolveCurrentPage() ?: 1;
                $perPage = 9;
                $products = new \Illuminate\Pagination\LengthAwarePaginator(
                    $collection->forPage($page, $perPage),
                    $collection->count(),
                    $perPage,
                    $page,
                    ['path' => Paginator::resolveCurrentPath()],
                );
                $view = isset($request->view)? $request->view : 'grid';
                return view('new_business_profile.rfqs',compact('alias','products','business_profile','view','controller_max_moq','controller_min_moq','controller_max_lead_time','controller_min_lead_time'));
            }

            if($business_profile->business_type == 'design_studio'){

                $collection=collect(WholesalerProduct::withTrashed()
                ->where(function($query) use ($request, $business_profile){
                    $query->where('business_profile_id', '!=', null)->get();
                    if(isset($request->search)){
                        $query->where('name','like', '%'.$request->search.'%')->get();
                    }})
                ->latest()
                ->with('images','video')
                ->get());

                $controller_max_moq = $collection->max('moq');
                $controller_min_moq = $collection->min('moq');
                $controller_max_lead_time = 0;
                $controller_min_lead_time = 0;
                foreach($collection as $product){
                    if(isset($product->attribute) && $product->product_type == 1){
                        foreach(json_decode($product->attribute) as $lead_time)
                        {
                            if ($lead_time[3] > $controller_max_lead_time) {
                                $controller_max_lead_time = $lead_time[3];
                            }

                            if ($lead_time[3] < $controller_min_lead_time) {
                                $controller_min_lead_time = $lead_time[3];
                            }
                        }
                    }
                }

                if(isset($request->product_tag)){
                    $ptags = [];
                    foreach($request->product_tag as $tag){
                        $product_tag = ProductTag::where('id',$tag)->first();
                        array_push($ptags,$product_tag->name);
                    }
                    $collection = $collection->filter(function($item) use ($ptags){
                        if(isset($item['product_tag'])){
                            $check = array_intersect($item['product_tag'], $ptags);
                            if(empty($check)){
                                return false;
                            }
                            return true;
                        }
                        return false;

                    });
                }

                if(isset($request->product_type_mapping_child_id)){
                    $collection = $collection->filter(function($item) use ($request){
                        if(isset($item['product_type_mapping_child_id'])){
                            $check = array_intersect($item['product_type_mapping_child_id'], $request->product_type_mapping_child_id);
                            if(empty($check)){
                                return false;
                            }
                            return true;
                        }
                        return false;
                    });
                }

                if(isset($request->min_lead) && isset($request->max_lead)){
                    $p_id=[];
                    foreach($collection as $product){
                        if(isset($product->attribute) && $product->product_type == 1){
                            foreach(json_decode($product->attribute) as $lead_time)
                            {
                                if ( $lead_time[3] >= $request->min_lead && $lead_time[3] <= $request->max_lead){
                                    array_push($p_id,$product->id);
                                }
                            }
                        }
                    }

                    $collection = $collection->whereIn('id', $p_id);
                    $collection->all();
                }

                if(isset($request->min_moq) && isset($request->max_moq)){
                    $collection = $collection->whereBetween('moq', [$request->min_moq, $request->max_moq]);
                    $collection->all();
                }

                $page = Paginator::resolveCurrentPage() ?: 1;
                $perPage = 9;
                $products = new \Illuminate\Pagination\LengthAwarePaginator(
                    $collection->forPage($page, $perPage),
                    $collection->count(),
                    $perPage,
                    $page,
                    ['path' => Paginator::resolveCurrentPath()],
                );
                $view = isset($request->view)? $request->view : 'grid';
                return view('new_business_profile.rfqs',compact('alias','products','business_profile','view','controller_max_moq','controller_min_moq','controller_max_lead_time','controller_min_lead_time'));
            }

            if($business_profile->business_type == 'brand' || $business_profile->business_type == 'retailShop' || $business_profile->business_type == 'tradingCompany')
            {

                // this merged collection will show at buyer business profile > explore menu

                $wholesaler_products = collect(WholesalerProduct::withTrashed()
                ->where(function($query) use ($request, $business_profile){
                    $query->where('business_profile_id', '!=', null)->get();
                    $query->where(['state' => 1])->get();
                    $query->where('product_type_mapping_child_id', 'LIKE', '[\"6\"]')->get();
                    if(isset($request->search)){
                        $query->where('name','like', '%'.$request->search.'%')->get();
                    }})
                ->latest()
                ->with('images','video')
                ->get());

                $manufacture_products = collect(ManufactureProduct::withTrashed()
                ->latest()
                ->with('product_images','product_video','businessProfile')
                ->where(function($query) use ($request, $business_profile){
                    $query->where('business_profile_id', '!=', null)->get();
                    $query->where('product_type_mapping_child_id', 'LIKE', '[\"6\"]')->get();
                    if(isset($request->search)){
                        $query->where('title','like', '%'.$request->search.'%')->get();
                    }

                })
                ->get());

                $collection = $wholesaler_products->mergeRecursive($manufacture_products)->sortBy([ ['created_at', 'desc'] ])->values();

                //dd($collection);

                $controller_max_moq = $collection->max('moq');
                $controller_min_moq = $collection->min('moq');
                $controller_max_lead_time = 0;
                $controller_min_lead_time = 0;
                foreach($collection as $product){
                    if(isset($product->attribute) && $product->product_type == 1){
                        foreach(json_decode($product->attribute) as $lead_time)
                        {
                            if ($lead_time[3] > $controller_max_lead_time) {
                                $controller_max_lead_time = $lead_time[3];
                            }

                            if ($lead_time[3] < $controller_min_lead_time) {
                                $controller_min_lead_time = $lead_time[3];
                            }
                        }
                    }
                }

                if(isset($request->product_tag)){
                    $ptags = [];
                    foreach($request->product_tag as $tag){
                        $product_tag = ProductTag::where('id',$tag)->first();
                        array_push($ptags,$product_tag->name);
                    }
                    $collection = $collection->filter(function($item) use ($ptags){
                        if(isset($item['product_tag'])){
                            $check = array_intersect($item['product_tag'], $ptags);
                            if(empty($check)){
                                return false;
                            }
                            return true;
                        }
                        return false;

                    });
                }

                if(isset($request->product_type_mapping_child_id)){
                    $collection = $collection->filter(function($item) use ($request){
                        if(isset($item['product_type_mapping_child_id'])){
                            $check = array_intersect($item['product_type_mapping_child_id'], $request->product_type_mapping_child_id);
                            if(empty($check)){
                                return false;
                            }
                            return true;
                        }
                        return false;
                    });
                }

                if(isset($request->min_lead) && isset($request->max_lead)){
                    $p_id=[];
                    foreach($collection as $product){
                        if(isset($product->attribute) && $product->product_type == 1){
                            foreach(json_decode($product->attribute) as $lead_time)
                            {
                                if ( $lead_time[3] >= $request->min_lead && $lead_time[3] <= $request->max_lead){
                                    array_push($p_id,$product->id);
                                }
                            }
                        }
                    }

                    $collection = $collection->whereIn('id', $p_id);
                    $collection->all();
                }

                if(isset($request->min_moq) && isset($request->max_moq)){
                    $collection = $collection->whereBetween('moq', [$request->min_moq, $request->max_moq]);
                    $collection->all();
                }

                $page = Paginator::resolveCurrentPage() ?: 1;
                $perPage = 9;
                $products = new \Illuminate\Pagination\LengthAwarePaginator(
                    $collection->forPage($page, $perPage),
                    $collection->count(),
                    $perPage,
                    $page,
                    ['path' => Paginator::resolveCurrentPath()],
                );

                $view = isset($request->view)? $request->view : 'grid';
                return view('new_business_profile.rfqs_buyer',compact('alias','products','business_profile','view','controller_max_moq','controller_min_moq','controller_max_lead_time','controller_min_lead_time'));

            }

        }
        abort(401);
    }

    public function searchRfq(Request $request, $alias)
    {
        // $response = Http::get(env('RFQ_APP_URL').'/api/quotation/filter/'.$request->search_input.'/page/1/limit/20');
        // $data = $response->json();
        // $rfqLists = $data['data'] ?? [];
        // $business_profile = BusinessProfile::with('user')->where('alias',$alias)->firstOrFail();
        // return view('new_business_profile.rfqs',compact('rfqLists','alias','business_profile'));


        // this merged collection will show at buyer business profile > explore menu
        $business_profile = BusinessProfile::where('alias',$alias)->firstOrFail();
        //dd($business_profile->profile_type);
        $wholesaler_products = collect(WholesalerProduct::withTrashed()
        ->latest()
        ->with('images','video')
        ->where(function($query) use ($request, $business_profile){
            $query->where('business_profile_id', '!=', null)->get();
            $query->where(['state' => 1])->get();
            $query->where('name','like', '%'.$request->search_input.'%')->get();
        })
        ->get());

        $manufacture_products = collect(ManufactureProduct::withTrashed()
        ->latest()
        ->with('product_images','product_video','businessProfile')
        ->where(function($query) use ($request, $business_profile){
            $query->where('business_profile_id', '!=', null)->get();
            $query->where('title','like', '%'.$request->search_input.'%')->get();
        })
        ->get());

        $collection = $wholesaler_products->mergeRecursive($manufacture_products)->sortBy([ ['created_at', 'desc'] ])->values();

        //dd($collection);

        $controller_max_moq = $collection->max('moq');
        $controller_min_moq = $collection->min('moq');
        $controller_max_lead_time = 0;
        $controller_min_lead_time = 0;
        foreach($collection as $product){
            if(isset($product->attribute) && $product->product_type == 1){
                foreach(json_decode($product->attribute) as $lead_time)
                {
                    if ($lead_time[3] > $controller_max_lead_time) {
                        $controller_max_lead_time = $lead_time[3];
                    }

                    if ($lead_time[3] < $controller_min_lead_time) {
                        $controller_min_lead_time = $lead_time[3];
                    }
                }
            }
        }

        if(isset($request->product_tag)){
            $ptags = [];
            foreach($request->product_tag as $tag){
                $product_tag = ProductTag::where('id',$tag)->first();
                array_push($ptags,$product_tag->name);
            }
            $collection = $collection->filter(function($item) use ($ptags){
                if(isset($item['product_tag'])){
                    $check = array_intersect($item['product_tag'], $ptags);
                    if(empty($check)){
                        return false;
                    }
                    return true;
                }
                return false;

            });
        }

        if(isset($request->product_type_mapping_child_id)){
            $collection = $collection->filter(function($item) use ($request){
                if(isset($item['product_type_mapping_child_id'])){
                    $check = array_intersect($item['product_type_mapping_child_id'], $request->product_type_mapping_child_id);
                    if(empty($check)){
                        return false;
                    }
                    return true;
                }
                return false;
            });
        }

        if(isset($request->min_lead) && isset($request->max_lead)){
            $p_id=[];
            foreach($collection as $product){
                if(isset($product->attribute) && $product->product_type == 1){
                    foreach(json_decode($product->attribute) as $lead_time)
                    {
                        if ( $lead_time[3] >= $request->min_lead && $lead_time[3] <= $request->max_lead){
                            array_push($p_id,$product->id);
                        }
                    }
                }
            }

            $collection = $collection->whereIn('id', $p_id);
            $collection->all();
        }

        if(isset($request->min_moq) && isset($request->max_moq)){
            $collection = $collection->whereBetween('moq', [$request->min_moq, $request->max_moq]);
            $collection->all();
        }

        $page = Paginator::resolveCurrentPage() ?: 1;
        $perPage = 9;
        $products = new \Illuminate\Pagination\LengthAwarePaginator(
            $collection->forPage($page, $perPage),
            $collection->count(),
            $perPage,
            $page,
            ['path' => Paginator::resolveCurrentPath()],
        );

        $view = isset($request->view)? $request->view : 'grid';

        return view('new_business_profile.rfqs',compact('alias','products','business_profile','view','controller_max_moq','controller_min_moq','controller_max_lead_time','controller_min_lead_time'));

    }

    public function rfqByPageNumber(Request $request)
    {
        $page = $request->page;
        $response = Http::get(env('RFQ_APP_URL').'/api/quotation/filter/null/page/'.$page.'/limit/10');
        $data = $response->json();
        $rfqLists = $data['data'] ?? [];
        return view('rfq.rfq_list',compact('rfqLists'))->render();
    }
    public function myRfqList(Request $request, $alias)
    {
        $page = isset($request->page) ? $request->page : 1;
        $business_profile = BusinessProfile::with('user')->where('alias',$alias)->firstOrFail();
        $user = Auth::user();
        $token = Cookie::get('sso_token');
        //get all rfqs of auth user
        $response = Http::withToken($token)
        ->get(env('RFQ_APP_URL').'/api/quotation/user/'.$user->sso_reference_id.'/filter/null/page/'.$page.'/limit/10');
        $data = $response->json();
        //dd($data);
        $rfqLists = $data['data'] ?? [];
        $rfqsCount = $data['count'];
        $noOfPages = ceil($data['count']/10);
        //all messages of auth user from mongodb messages collection
        $chatdataRfqIds = Userchat::where('to_id',$user->sso_reference_id)->orWhere('from_id',$user->sso_reference_id)->pluck('rfq_id')->toArray();
        $uniqueRfqIdsWithChatdata = array_unique($chatdataRfqIds);
        //all rfqs where auth user has messages
        $rfqs = RfqApp::whereIn('id',$uniqueRfqIdsWithChatdata)->latest()->get();
        if(count($rfqs)>0){
            //messages of first rfq of auth user
            $response = Http::get(env('RFQ_APP_URL').'/api/messages/'.$rfqLists[0]['id'].'/user/'.$user->sso_reference_id);
            $data = $response->json();
            $chats = $data['data']['messages'];

            //$chatdata = $chats;
            $chatdataAllData = $chats;
            $chatdata = $chatdataAllData;
            foreach ($chatdataAllData as $key => $value) {
                $messageStr = preg_replace('!(((f|ht)tp(s)?://)[-a-zA-Zа-яА-Я()0-9@:%_+.~#?&;//=]+)!i', '<a href="$1">$1</a>', $value['message']);
                $chatdata[$key]['message'] = $messageStr;
                //echo "<pre>"; print_r($chatdataAllData[$key]); exit();
            }

            if($rfqs[0]['user']['user_picture'] !=""){
                $userImage = $rfqs[0]['user']['user_picture'];
                $userNameShortForm = "";
            }else{
                $userImage = $rfqs[0]['user']['user_picture'];
                //if user picture does not exist then we need to show user name short form insetad of user image in chat box
                $nameWordArray = explode(" ", $rfqs[0]['user']['user_name']);
                $firstWordFirstLetter = $nameWordArray[0][0];
                $secorndWordFirstLetter = $nameWordArray[1][0] ??'';
                $userNameShortForm = $firstWordFirstLetter.$secorndWordFirstLetter;
            }
        }else{
            $chatdata = [];
            $userImage ="";
            //if user picture does not exist then we need to show user name short form insetad of user image in chat box
            $nameWordArray = explode(" ", $user->name);
            $firstWordFirstLetter = $nameWordArray[0][0];
            $secorndWordFirstLetter = $nameWordArray[1][0] ??'';
            $userNameShortForm = $firstWordFirstLetter.$secorndWordFirstLetter;
        }
        $quotations = Userchat::select("*", DB::raw('count(*) as total'))
        ->groupBy('rfq_id')
        ->get();

        if(env('APP_ENV') == 'local'){
            $adminUser = User::Find('5552');
        }else{
            $adminUser = User::Find('5771');
        }
        $adminUserImage = isset($adminUser->image) ? asset($adminUser->image) : asset('images/frontendimages/no-image.png');
        $pageTitle = "My RFQs";
        $pageActive = "RFQ";
        return view('new_business_profile.my_rfqs',compact('pageTitle','pageActive','rfqLists','noOfPages','alias','chatdata','business_profile','adminUserImage','userImage','userNameShortForm','user'));
    }

    public function searchMyRfqList(Request $request, $alias)
    {
        $page = isset($request->page) ? $request->page : 1;
        $business_profile = BusinessProfile::with('user')->where('alias',$alias)->firstOrFail();
        $user = Auth::user();
        $token = Cookie::get('sso_token');
        //get requested rfqs of auth user
        $response = Http::get(env('RFQ_APP_URL').'/api/quotation/user/'.$user->sso_reference_id.'/filter/'.$request->search_input.'/page/1/limit/20');

        $data = $response->json();
        //dd($data);
        $rfqLists = $data['data'] ?? [];
        $rfqsCount = $data['count'];
        $noOfPages = ceil($data['count']/10);
        //all messages of auth user from mongodb messages collection
        $chatdataRfqIds = Userchat::where('to_id',$user->sso_reference_id)->orWhere('from_id',$user->sso_reference_id)->pluck('rfq_id')->toArray();
        $uniqueRfqIdsWithChatdata = array_unique($chatdataRfqIds);
        //all rfqs where auth user has messages
        $rfqs = RfqApp::whereIn('id',$uniqueRfqIdsWithChatdata)->latest()->get();
        if(count($rfqs)>0){
            //messages of first rfq of auth user
            $response = Http::get(env('RFQ_APP_URL').'/api/messages/'.$rfqLists[0]['id'].'/user/'.$user->sso_reference_id);
            $data = $response->json();
            $chats = $data['data']['messages'];

            //$chatdata = $chats;
            $chatdataAllData = $chats;
            $chatdata = $chatdataAllData;
            foreach ($chatdataAllData as $key => $value) {
                $messageStr = preg_replace('!(((f|ht)tp(s)?://)[-a-zA-Zа-яА-Я()0-9@:%_+.~#?&;//=]+)!i', '<a href="$1">$1</a>', $value['message']);
                $chatdata[$key]['message'] = $messageStr;
                //echo "<pre>"; print_r($chatdataAllData[$key]); exit();
            }

            if($rfqs[0]['user']['user_picture'] !=""){
                $userImage = $rfqs[0]['user']['user_picture'];
                $userNameShortForm = "";
            }else{
                $userImage = $rfqs[0]['user']['user_picture'];
                //if user picture does not exist then we need to show user name short form insetad of user image in chat box
                $nameWordArray = explode(" ", $rfqs[0]['user']['user_name']);
                $firstWordFirstLetter = $nameWordArray[0][0];
                $secorndWordFirstLetter = $nameWordArray[1][0] ??'';
                $userNameShortForm = $firstWordFirstLetter.$secorndWordFirstLetter;
            }
        }else{
            $chatdata = [];
            $userImage ="";
            //if user picture does not exist then we need to show user name short form insetad of user image in chat box
            $nameWordArray = explode(" ", $user->name);
            $firstWordFirstLetter = $nameWordArray[0][0];
            $secorndWordFirstLetter = $nameWordArray[1][0] ??'';
            $userNameShortForm = $firstWordFirstLetter.$secorndWordFirstLetter;
        }
        $quotations = Userchat::select("*", DB::raw('count(*) as total'))
        ->groupBy('rfq_id')
        ->get();

        if(env('APP_ENV') == 'local'){
            $adminUser = User::Find('5552');
        }else{
            $adminUser = User::Find('5771');
        }
        $adminUserImage = isset($adminUser->image) ? asset($adminUser->image) : asset('images/frontendimages/no-image.png');
        $pageTitle = "My RFQs";
        $pageActive = "RFQ";
        return view('new_business_profile.my_rfqs',compact('pageTitle','pageActive','rfqLists','noOfPages','alias','chatdata','business_profile','adminUserImage','userImage','userNameShortForm','user'));
    }

    public function myQueries($alias)
    {
        $business_profile = BusinessProfile::with('user')->where('alias',$alias)->firstOrFail();
        $user = Auth::user();
        $token = Cookie::get('sso_token');
        //get all queries of auth user
        $response = Http::withToken($token)
        ->get(env('RFQ_APP_URL').'/api/queries/user/'.$user->sso_reference_id.'/filter/null/page/1/limit/10');
        $data = $response->json();
        $rfqLists = $data['data'] ?? [];
        $rfqsCount = $data['count'];
        $noOfPages = ceil($data['count']/10);
        //all messages of auth user from mongodb messages collection
        $chatdataRfqIds = Userchat::where('to_id',$user->sso_reference_id)->orWhere('from_id',$user->sso_reference_id)->pluck('rfq_id')->toArray();
        $uniqueRfqIdsWithChatdata = array_unique($chatdataRfqIds);
        //all queries where auth user has messages
        $rfqs = RfqApp::whereIn('id',$uniqueRfqIdsWithChatdata)->latest()->get();
        if(count($rfqs)>0){

            $quotation = supplierQuotationToBuyer::where('rfq_id', $rfqLists[0]['id'])->first();
            $quotationOffer = "";
            $quotationOfferunit = "";
            if( isset($quotation['offer_price']) && isset($quotation['offer_price_unit']) ) {
                //$quotationHtml = "Your offcer price on this RFQ: $".$quotation['offer_price']." / ".$quotation['offer_price_unit'];
                $quotationOffer = $quotation['offer_price'];
                $quotationOfferunit = $quotation['offer_price_unit'];
            }

            //messages of first queries of auth user
            $response = Http::get(env('RFQ_APP_URL').'/api/messages/'.$rfqs[0]['id'].'/user/'.$user->sso_reference_id);
            $data = $response->json();
            $chats = $data['data']['messages'];

            //$chatdata = $chats;
            $chatdataAllData = $chats;
            $chatdata = $chatdataAllData;
            foreach ($chatdataAllData as $key => $value) {
                $messageStr = preg_replace('!(((f|ht)tp(s)?://)[-a-zA-Zа-яА-Я()0-9@:%_+.~#?&;//=]+)!i', '<a href="$1">$1</a>', $value['message']);
                $chatdata[$key]['message'] = $messageStr;
                //echo "<pre>"; print_r($chatdataAllData[$key]); exit();
            }

            if($rfqs[0]['user']['user_picture'] !=""){
                $userImage = $rfqs[0]['user']['user_picture'];
                $userNameShortForm = "";
            }else{
                //if user picture does not exist then we need to show user name short form insetad of user image in chat box
                $userImage = $rfqs[0]['user']['user_picture'];
                $nameWordArray = explode(" ", $rfqs[0]['user']['user_name']);
                $firstWordFirstLetter = $nameWordArray[0][0];
                $secorndWordFirstLetter = $nameWordArray[1][0] ??'';
                $userNameShortForm = $firstWordFirstLetter.$secorndWordFirstLetter;
            }
        }else{
            $chatdata = [];
            $userImage ="";
            $quotationOffer = "";
            $quotationOfferunit = "";
            //if user picture does not exist then we need to show user name short form insetad of user image in chat box
            $nameWordArray = explode(" ", $user->name);
            $firstWordFirstLetter = $nameWordArray[0][0];
            $secorndWordFirstLetter = $nameWordArray[1][0] ??'';
            $userNameShortForm = $firstWordFirstLetter.$secorndWordFirstLetter;
        }
        $quotations = Userchat::select("*", DB::raw('count(*) as total'))
        ->groupBy('rfq_id')
        ->get();

        if(env('APP_ENV') == 'local'){
            $adminUser = User::Find('5552');
        }else{
            $adminUser = User::Find('5771');
        }
        $adminUserImage = isset($adminUser->image) ? asset($adminUser->image) : asset('images/frontendimages/no-image.png');
        $pageTitle = "My Queries";
        $pageActive = "Inbox";
        return view('new_business_profile.my_rfqs',compact('pageTitle','pageActive','rfqLists','noOfPages','alias','chatdata','business_profile','adminUserImage','userImage','userNameShortForm','user','quotationOffer','quotationOfferunit'));
    }

    public function searchMyQueries(Request $request, $alias)
    {
        $business_profile = BusinessProfile::with('user')->where('alias',$alias)->firstOrFail();
        $user = Auth::user();
        $token = Cookie::get('sso_token');
        //get requested queries of auth user
        $response = Http::withToken($token)
        ->get(env('RFQ_APP_URL').'/api/queries/user/'.$user->sso_reference_id.'/filter/'.$request->search_input.'/page/1/limit/10');
        $data = $response->json();
        $rfqLists = $data['data'] ?? [];
        $rfqsCount = $data['count'];
        $noOfPages = ceil($data['count']/10);
        //all messages of auth user from mongodb messages collection
        $chatdataRfqIds = Userchat::where('to_id',$user->sso_reference_id)->orWhere('from_id',$user->sso_reference_id)->pluck('rfq_id')->toArray();
        $uniqueRfqIdsWithChatdata = array_unique($chatdataRfqIds);
        //all queries where auth user has messages
        $rfqs = RfqApp::whereIn('id',$uniqueRfqIdsWithChatdata)->latest()->get();
        if(count($rfqs)>0){

            $quotation = supplierQuotationToBuyer::where('rfq_id', $rfqLists[0]['id'])->first();
            $quotationOffer = "";
            $quotationOfferunit = "";
            if( isset($quotation['offer_price']) && isset($quotation['offer_price_unit']) ) {
                //$quotationHtml = "Your offcer price on this RFQ: $".$quotation['offer_price']." / ".$quotation['offer_price_unit'];
                $quotationOffer = $quotation['offer_price'];
                $quotationOfferunit = $quotation['offer_price_unit'];
            }

            //messages of first queries of auth user
            $response = Http::get(env('RFQ_APP_URL').'/api/messages/'.$rfqs[0]['id'].'/user/'.$user->sso_reference_id);
            $data = $response->json();
            $chats = $data['data']['messages'];

            //$chatdata = $chats;
            $chatdataAllData = $chats;
            $chatdata = $chatdataAllData;
            foreach ($chatdataAllData as $key => $value) {
                $messageStr = preg_replace('!(((f|ht)tp(s)?://)[-a-zA-Zа-яА-Я()0-9@:%_+.~#?&;//=]+)!i', '<a href="$1">$1</a>', $value['message']);
                $chatdata[$key]['message'] = $messageStr;
                //echo "<pre>"; print_r($chatdataAllData[$key]); exit();
            }

            if($rfqs[0]['user']['user_picture'] !=""){
                $userImage = $rfqs[0]['user']['user_picture'];
                $userNameShortForm = "";
            }else{
                //if user picture does not exist then we need to show user name short form insetad of user image in chat box
                $userImage = $rfqs[0]['user']['user_picture'];
                $nameWordArray = explode(" ", $rfqs[0]['user']['user_name']);
                $firstWordFirstLetter = $nameWordArray[0][0];
                $secorndWordFirstLetter = $nameWordArray[1][0] ??'';
                $userNameShortForm = $firstWordFirstLetter.$secorndWordFirstLetter;
            }
        }else{
            $chatdata = [];
            $userImage ="";
            $quotationOffer = "";
            $quotationOfferunit = "";
            //if user picture does not exist then we need to show user name short form insetad of user image in chat box
            $nameWordArray = explode(" ", $user->name);
            $firstWordFirstLetter = $nameWordArray[0][0];
            $secorndWordFirstLetter = $nameWordArray[1][0] ??'';
            $userNameShortForm = $firstWordFirstLetter.$secorndWordFirstLetter;
        }
        $quotations = Userchat::select("*", DB::raw('count(*) as total'))
        ->groupBy('rfq_id')
        ->get();

        if(env('APP_ENV') == 'local'){
            $adminUser = User::Find('5552');
        }else{
            $adminUser = User::Find('5771');
        }
        $adminUserImage = isset($adminUser->image) ? asset($adminUser->image) : asset('images/frontendimages/no-image.png');
        $pageTitle = "My Queries";
        $pageActive = "Inbox";
        return view('new_business_profile.my_rfqs',compact('pageTitle','pageActive','rfqLists','noOfPages','alias','chatdata','business_profile','adminUserImage','userImage','userNameShortForm','user','quotationOffer','quotationOfferunit'));
    }

    public function allQueries($alias)
    {
        $page = isset($request->page) ? $request->page : 1;
        $business_profile = BusinessProfile::with('user', 'companyOverview')->where('alias',$alias)->firstOrFail();
        //dd($business_profile);
        //$supplierQuotations = supplierQuotationToBuyer::where('business_profile_id',$business_profile->id)->get();

        //dd($business_profile->companyOverview->data);
        $mainProductValuesData = json_decode($business_profile->companyOverview->data);
        $mainProductsValue = [];
        foreach($mainProductValuesData as $mainProduct) {
            if($mainProduct->name == "main_products") {
                array_push($mainProductsValue, $mainProduct->value);
            }
        }
        array_push($mainProductsValue, $business_profile->factory_type);
        $mainProductsValueImplode = implode(',', $mainProductsValue);
        $mainProductsValueImplode = str_replace("/",",",$mainProductsValueImplode);
        //dd($mainProductsValueImplode);
        $user = Auth::user();
        $token = Cookie::get('sso_token');
        //get all rfqs of auth user
        $response = Http::withToken($token)
        ->get(env('RFQ_APP_URL').'/api/quotation/type/'.$mainProductsValueImplode.'/filter/null/page/'.$page.'/limit/10');
        $data = $response->json();
        $rfqLists = $data['data'] ?? [];
        //dd($rfqLists);
        $rfqsCount = $data['count'] ?? 0;

        if($rfqsCount > 0)
        {
            //dd($rfqsCount);
            $noOfPages = ceil($data['count']/10);

            $quotation = supplierQuotationToBuyer::where('rfq_id', $rfqLists[0]['id'])->first();
            $quotationOffer = "";
            $quotationOfferunit = "";
            if( isset($quotation['offer_price']) && isset($quotation['offer_price_unit']) ) {
                //$quotationHtml = "Your offcer price on this RFQ: $".$quotation['offer_price']." / ".$quotation['offer_price_unit'];
                $quotationOffer = $quotation['offer_price'];
                $quotationOfferunit = $quotation['offer_price_unit'];
            }

            //all messages of auth user from mongodb messages collection
            $chatdataRfqIds = Userchat::where('to_id',$user->sso_reference_id)->orWhere('from_id',$user->sso_reference_id)->pluck('rfq_id')->toArray();
            $uniqueRfqIdsWithChatdata = array_unique($chatdataRfqIds);
            //all rfqs where auth user has messages
            $rfqs = RfqApp::whereIn('id',$uniqueRfqIdsWithChatdata)->latest()->get();
            if(count($rfqs)>0){
                //messages of first rfq of auth user
                $response = Http::get(env('RFQ_APP_URL').'/api/messages/'.$rfqLists[0]['id'].'/user/'.$user->sso_reference_id);
                $data = $response->json();
                $chats = $data['data']['messages'];

                //$chatdata = $chats;
                $chatdataAllData = $chats;
                $chatdata = $chatdataAllData;
                foreach ($chatdataAllData as $key => $value) {
                    $messageStr = preg_replace('!(((f|ht)tp(s)?://)[-a-zA-Zа-яА-Я()0-9@:%_+.~#?&;//=]+)!i', '<a href="$1">$1</a>', $value['message']);
                    $chatdata[$key]['message'] = $messageStr;
                    //echo "<pre>"; print_r($chatdataAllData[$key]); exit();
                }

                if($rfqs[0]['user']['user_picture'] !=""){
                    $userImage = $rfqs[0]['user']['user_picture'];
                    $userNameShortForm = "";
                }else{
                    $userImage = $rfqs[0]['user']['user_picture'];
                    //if user picture does not exist then we need to show user name short form insetad of user image in chat box
                    $nameWordArray = explode(" ", $rfqs[0]['user']['user_name']);
                    $firstWordFirstLetter = $nameWordArray[0][0];
                    $secorndWordFirstLetter = $nameWordArray[1][0] ??'';
                    $userNameShortForm = $firstWordFirstLetter.$secorndWordFirstLetter;
                }
            }else{
                $chatdata = [];
                $userImage ="";
                //if user picture does not exist then we need to show user name short form insetad of user image in chat box
                $nameWordArray = explode(" ", $user->name);
                $firstWordFirstLetter = $nameWordArray[0][0];
                $secorndWordFirstLetter = $nameWordArray[1][0] ??'';
                $userNameShortForm = $firstWordFirstLetter.$secorndWordFirstLetter;
            }
            $quotations = Userchat::select("*", DB::raw('count(*) as total'))
            ->groupBy('rfq_id')
            ->get();

            if(env('APP_ENV') == 'local'){
                $adminUser = User::Find('5552');
            }else{
                $adminUser = User::Find('5771');
            }
        }
        else
        {
            $chatdata = [];
            $userImage ="";
            $noOfPages = "";
            $quotationOffer = "";
            $quotationOfferunit = "";
            //if user picture does not exist then we need to show user name short form insetad of user image in chat box
            $nameWordArray = explode(" ", $user->name);
            $firstWordFirstLetter = $nameWordArray[0][0];
            $secorndWordFirstLetter = $nameWordArray[1][0] ??'';
            $userNameShortForm = $firstWordFirstLetter.$secorndWordFirstLetter;
        }

        $adminUserImage = isset($adminUser->image) ? asset($adminUser->image) : asset('images/frontendimages/no-image.png');
        $pageTitle = "My Queries";
        $pageActive = "All";
        return view('new_business_profile.my_rfqs',compact('pageTitle','pageActive','rfqLists','noOfPages','alias','chatdata','business_profile','adminUserImage','userImage','userNameShortForm','user', 'quotationOffer', 'quotationOfferunit'));
    }

    public function authUserQuotationsByRFQId(Request $request){
        //dd($request->all());
        $cookie = Cookie::get('sso_token');
        $cookie = base64_decode(explode(".",$cookie)[1]);
        $cookie = json_decode(json_decode(json_encode($cookie)));
        //$cookie->subscription_status = 0;

        if($cookie->subscription_status == 1)
        {
            $quotations = Userchat::where('rfq_id',$request->rfqId)->where('factory',true)->get();
            $subscriptionStatus = 1;
        }
        else
        {
            $quotations = [];
            $subscriptionStatus = 0;
        }
        return response()->json(["quotations"=>$quotations, "subscriptionStatus"=>$subscriptionStatus],200);

    }

    public function myQuotationsByRFQId(Request $request){

        $quotation = supplierQuotationToBuyer::where('rfq_id', $request->rfqId)->first();
        $html = "";
        if( isset($quotation['offer_price']) && isset($quotation['offer_price_unit']) ) {
            $html = "Your offcer price on this RFQ: $".$quotation['offer_price']." / ".$quotation['offer_price_unit'];
        } else {
            $html = "No quotation submitted";
        }
        //$offer_price = $quotation['offer_price'] ?? NULL;
        //$offer_price_unit = $quotation['offer_price_unit'] ?? NULL;
        // $quotations = Userchat::where('rfq_id',$request->rfqId)->where('factory',true)->get();
        return response()->json(["quotation" => $quotation, "html" => $html],200);

    }

    public function authUserConversationsByRFQId(Request $request){
        $user = Auth::user();
        $response = Http::get(env('RFQ_APP_URL').'/api/messages/'.$request->rfqId.'/user/'.$user->sso_reference_id);
        $data = $response->json();
        $chatdata = $data['data']['messages'];

        $chatdataAllData = $chatdata;
        $chats = $chatdataAllData;
        foreach ($chatdataAllData as $key => $value) {
            $messageStr = preg_replace('!(((f|ht)tp(s)?://)[-a-zA-Zа-яА-Я()0-9@:%_+.~#?&;//=]+)!i', '<a href="$1">$1</a>', $value['message']);
            $chats[$key]['message'] = $messageStr;
            //echo "<pre>"; print_r($chatdataAllData[$key]); exit();
        }

        $response = Http::get(env('RFQ_APP_URL').'/api/quotation/'.$request->rfqId);
        $data = $response->json();
        $rfq = $data['data']['data'];

        // $quotation = supplierQuotationToBuyer::where('rfq_id', $request->rfqId)->first();
        // $quotationHtml = "";
        // if( isset($quotation['offer_price']) && isset($quotation['offer_price_unit']) ) {
        //     $quotationHtml = "Your offcer price on this RFQ: $".$quotation['offer_price']." / ".$quotation['offer_price_unit'];
        // } else {
        //     $quotationHtml = "No quotation submitted";
        // }

        $quotation = supplierQuotationToBuyer::where('rfq_id', $request->rfqId)->first();
        $quotationOffer = "";
        $quotationOfferunit = "";
        if( isset($quotation['offer_price']) && isset($quotation['offer_price_unit']) ) {
            //$quotationHtml = "Your offcer price on this RFQ: $".$quotation['offer_price']." / ".$quotation['offer_price_unit'];
            $quotationOffer = $quotation['offer_price'];
            $quotationOfferunit = $quotation['offer_price_unit'];
        }

        return response()->json(["chats"=>$chats, "rfq"=>$rfq, "quotationOffer"=>$quotationOffer, "quotationOfferunit"=>$quotationOfferunit],200);
    }

    public function myRfqByPageNumber(Request $request){
        $user = Auth::user();
        $response = Http::get(env('RFQ_APP_URL').'/api/quotation/user/'.$user->sso_reference_id.'/filter/null/page/1/limit/10');
        $data = $response->json();
        $rfqLists = $data['data'] ?? [];
        return view('rfq.my_rfq_list',compact('rfqLists'))->render();
    }


    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'title'       => 'required',
            'quantity'    => 'required',
            'unit'        =>  'required',
            'unit_price'     => 'required',
            'payment_method' => 'required',
            'delivery_time'  => 'required',
            'destination'   => 'required',
            'short_description' => 'required',
            'full_specification' => 'required',

        ]);

        $rfqData = $request->except(['_token','captcha_token','product_images']);
        $rfqData['created_by']=auth()->id();
        $rfqData['status']='pending';
        $rfqData['rfq_from'] = "service";
        $rfqData['link'] = $this->generateUniqueLink();

        $rfq=Rfq::create($rfqData);

        if ($request->hasFile('product_images')){
            foreach ($request->file('product_images') as $index=>$product_image){

                $extension = $product_image->getClientOriginalExtension();
                if($extension=='pdf' ||$extension=='PDF' ||$extension=='doc'||$extension=='docx'|| $extension=='xlsx' || $extension=='ZIP'||$extension=='zip'|| $extension=='TAR' ||$extension=='tar'||$extension=='rar' ||$extension=='RAR'  ){

                    $path=$product_image->store('images','public');
                }
                else{
                    $path=$product_image->store('images','public');
                    $image = Image::make(Storage::get($path))->fit(555, 555)->encode();
                    Storage::put($path, $image);
                }
                RfqImage::create(['rfq_id'=>$rfq->id, 'image'=>$path]);
            }
        }
        $rfq = Rfq::with('images','category')->where('id',$rfq->id)->first();

            $selectedUserToSendMail="success@merchantbay.com";
            event(new NewRfqHasAddedEvent($selectedUserToSendMail,$rfq));


        $msg = "Your RFQ was posted successfully.<br><br>Soon you will receive quotation from <br>Merchant Bay verified relevant suppliers.";
        return back()->with(['rfq-success'=> $msg]);

    }

    public function delete($rfq_id)
    {
        $rfq=Rfq::findOrFail($rfq_id);
        $rfq->delete();
        \Session::flash('success', 'Rfq Successfully deleted');
        return redirect()->back();
    }

    public function active($rfq_id)
    {
        $rfq=Rfq::withTrashed()->findOrFail($rfq_id)->restore();
        \Session::flash('success', 'Rfq Successfully activited');
        return redirect()->back();
    }

    public function edit($rfq_id)
    {
        $rfq=Rfq::withTrashed()->where('id',$rfq_id)->with('images')->first();
        if(!$rfq){
            return response()->json([
                'success' => false,
                'error'  => 'id not exists',
            ],404);
        }
        $date=Carbon::parse($rfq->delivery_time)->format('Y-m-d');
        return response()->json([
            'success' => true,
            'data' => $rfq,
            'date' => $date,
        ],200);
    }

    public function update(Request $request, $rfq_id)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required',
            'title'       => 'required',
            'quantity'    => 'required',
            'unit'        =>  'required',
            'unit_price'     => 'required',
            'payment_method' => 'required',
            'delivery_time'  => 'required',
            'destination'   => 'required',
            'edit_rfq_id'  => 'required',
            'product_images.*' => 'max:10000',
            'short_description' => 'required',
            'full_specification' => 'required',

        ]);

        if ($validator->fails())
        {
            return response()->json(array(
            'success' => false,
            'error' => $validator->getMessageBag()),
            400);
        }

        $rfq=Rfq::withTrashed()->where('id',$rfq_id)->first();
        if(!$rfq){
            return response()->json(array(
                'success' => false,
                'error' => 'rfq not exists'),
                400);
        }
        $rfq->update($request->only(['category_id','title','quantity','unit','unit_price','payment_method','delivery_time','destination','short_description','full_specification']));
        if($request->publish == true && $rfq->deleted_at){
            $rfq->restore();
        }else if($request->publish == false && !$rfq->deleted_at){
            $rfq->delete();
        }
        if ($request->hasFile('product_images')){
            foreach ($request->file('product_images') as $index=>$product_image){

                $extension = $product_image->getClientOriginalExtension();
                if($extension=='pdf' ||$extension=='PDF' ||$extension=='doc'||$extension=='docx'|| $extension=='xlsx' || $extension=='ZIP'||$extension=='zip'|| $extension=='TAR' ||$extension=='tar'||$extension=='rar' ||$extension=='RAR'  ){
                    $path=$product_image->store('images','public');
                }
                else{
                    $path=$product_image->store('images','public');
                    $image = Image::make(Storage::get($path))->fit(555, 555)->encode();
                    Storage::put($path, $image);
                }
                RfqImage::create(['rfq_id'=>$rfq->id, 'image'=>$path]);
            }
        }
        return response()->json([
            'success' => true,
            'msg' => 'rfq successfully updated',
        ],200);


    }

    public function singleImageDelete($rfq_image_id)
    {
            $rfq_image=RfqImage::findOrFail($rfq_image_id);
            if(Storage::exists($rfq_image->image)){
                Storage::delete($rfq_image->image);
            }
            $rfq_image->delete();
            return response()->json([
                'success' => true,
                'msg'   => 'image delete successfully',
            ],200);
    }

    public function generateUniqueLink()
    {
        do {
            $link = Str::random(20);
        } while (Rfq::where('link', $link)->first());

        return $link;
    }

    public function showRfqUsingLink($link, Request $request)
    {
        if (Auth::check() && env('APP_ENV') == 'production'){
            $token= $request->cookie('sso_token');
            $response = Http::withHeaders([
                'Authorization' => 'Bearer '.$token,
            ])->get(env('RFQ_APP_URL').'/api/quotation/'.$link);
        }else{
            $response = Http::get(env('RFQ_APP_URL').'/api/quotation/'.$link);
        }

        $data = $response->json();
        $rfqLists = $data['data'] ?? [];
        return view('rfq.show_using_link',compact('rfqLists'));
    }

    public function share($rfq_id)
    {
        $rfq=Rfq::where('id',$rfq_id)->first();
        if(!$rfq){
            return response()->json(['error' => 'Record not found'],404);
        }

        if($rfq->link){
            $link=route('show.rfq.using.link',$rfq->link);
            return response()->json(['link'=> $link],200);
        }

        $link=$this->generateUniqueLink();
        $rfq->update(['link'=> $link]);
        $link=route('show.rfq.using.link',$rfq->link);
        return response()->json(['link'=> $link],200);
    }

    public function loginFromRfqShareLink(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'rfqpassword' => 'required',
            'rfqemail' => 'required|email',
        ]);

        if ($validator->passes()) {
            // sso checking authentication
            if(env('APP_ENV') == 'production')
            {
                $sso=Http::post(env('SSO_URL').'/api/auth/token/',[
                    'email' => $request->rfqemail,
                    'password' => $request->rfqpassword,
                ]);
                if($sso->successful()){
                    $access_token=$sso['access'];
                    $explode=explode(".",$access_token);
                    $time= base64_decode($explode[1]);
                    $decode_time=json_decode($time);
                    $get_time=$decode_time->exp;
                    $current=strtotime(date('d.m.Y H:i:s'));
                    $totalSecondsDiff = abs($get_time-$current);
                    $totalMinutesDiff = $totalSecondsDiff/60;
                    // $totalHoursDiff   = $totalSecondsDiff/60/60;
                    // $totalDaysDiff    = $totalSecondsDiff/60/60/24;
                    // $totalMonthsDiff  = $totalSecondsDiff/60/60/24/30;
                    // $totalYearsDiff   = $totalSecondsDiff/60/60/24/365;

                    // if($request->hasCookie('sso_token') !== null){
                    //     Cookie::forget('sso_token');
                    // }
                    if(Cookie::has('sso_token')){
                        Cookie::queue(Cookie::forget('sso_token'));
                    }
                   // $set_cookie=Cookie::make('sso_token', $access_token, $totalMinutesDiff);
                    Cookie::queue(Cookie::make('sso_token', $access_token, $totalMinutesDiff));

                    if($request->session()->has('sso_password')){
                        $request->session()->forget('sso_password');
                    }
                    $request->session()->put('sso_password', $request->password);


                }
                else{
                    return response()->json(['msg' => 'No active account found with the given credentials']);
                }
            }


            $credentials = [
                'email' => $request->rfqemail,
                'password' => $request->rfqpassword,
            ];
            $remember_me = $request->remember == 'true' ? true : false;
            if(Auth::attempt($credentials,$remember_me))
            {
                $userId = auth()->user()->id;
                $user = User::whereId($userId)->first();
                $user->update(['last_activity' => Carbon::now(),'fcm_token'=>$request->fcm_token]);

                return response()->json(['user_id'=>$user->user_id, 'url' => url()->previous() ]);
            }
            return response()->json(['msg' => 'Wrong email or password']);

        }

        return response()->json(['error'=>$validator->errors()]);

    }

    public function create($flag = false, $product_id = NULL)
    {

        $countrysList = [];
        $countries = Countrywithcallingcode::get();
        foreach($countries as $item) {
            array_push($countrysList, $item->name);
        }

        $product_type_mapping_id = 1;
        // $child = 'design';
        // $product_type_mapping_child_id = ProductTypeMapping::select('id')->where('title',$child)->first();

        $product = "";
        $preloaded_image = [];
        if($flag == 'mb' && $product_id != NULL)
        {
            $product = ManufactureProduct::with('product_images')->where('id', $product_id)->first();

            //$preloaded_image = array();
            foreach($product->product_images as $key => $image){
                $obj[$key] = new stdClass;
                $obj[$key]->id = $image->id;
                $obj[$key]->src = Storage::disk('s3')->url('public/'.$image->product_image);
                $preloaded_image[] = $obj[$key];
            }
        }

        if($flag == 'shop' && $product_id != NULL)
        {
            $product = WholesalerProduct::with('images')->where('id', $product_id)->first();

            //$preloaded_image = array();
            foreach($product->images as $key => $image){
                $obj[$key] = new stdClass;
                $obj[$key]->id = $image->id;
                $obj[$key]->src = Storage::disk('s3')->url('public/'.$image->image);
                $preloaded_image[] = $obj[$key];
            }
        }

        $design_products = Product::with(['images','businessProfile'])->where('product_type_mapping_id', $product_type_mapping_id)->where(['state' => 1, 'is_featured' => 1])->where('business_profile_id', '!=', null)->inRandomOrder()->limit(4)->get();
        // $manufacture_products = ManufactureProduct::with(['product_images','businessProfile'])->where('product_type_mapping_id', $product_type_mapping_id)->where('business_profile_id', '!=', null)->get();
        // $merged = $wholesaler_products->mergeRecursive($manufacture_products)->sortBy([ ['priority_level', 'asc'], ['created_at', 'desc'] ])->values();

        // $merged = $merged->filter(function($item) use ($product_type_mapping_child_id) {
        //     $result=array_intersect($item->product_type_mapping_child_id,(array)$product_type_mapping_child_id);
        //     if(count($result) > 0){
        //         return true;
        //     }
        // dd($merged);
        //dd($design_products);

        if(auth()->user())
        {
            $businessProfiles = BusinessProfile::withTrashed()->where('user_id',auth()->id())->get();

            $profileAlias = "";
            if(count($businessProfiles) > 0)
            {
                $profileAlias = $businessProfiles[0]['alias'];
            }
            else
            {
                $profileAlias = $businessProfiles['alias'];
            }
            if($flag) {
                return view('rfq.create_from_product',compact('profileAlias', 'flag', 'product', 'preloaded_image', 'design_products', 'countrysList'));
            } else {
                return view('rfq.create',compact('profileAlias', 'design_products', 'countrysList'));
            }

        }
        else
        {
            if($flag) {
                return view('rfq.create_from_product',compact('flag', 'product', 'preloaded_image', 'design_products', 'countrysList'));
            } else {
                return view('rfq.create', compact('countrysList'));
            }
        }

    }

    public function storeFromProductDetails(Request $request)
    {

        $request->validate([
            'category_id' => 'required',
            'title'       => 'required',
            'rfq_quantity'    => 'required',
            'unit'        =>  'required',
            'rfq_unit_price'     => 'required',
            'payment_method' => 'required',
            'delivery_time'  => 'required',
            'destination'   => 'required',
            'short_description' => 'required',
            'full_specification' => 'required',

        ]);

        $rfqData = [
            'category_id' => $request->category_id,
            'title' => $request->title,
            'quantity' => $request->rfq_quantity,
            'unit' => $request->unit,
            'unit_price' => $request->rfq_unit_price,
            'payment_method' => $request->payment_method,
            'delivery_time' => $request->delivery_time,
            'destination' => $request->destination,
            'short_description' => $request->short_description,
            'full_specification' => $request->full_specification,
            'created_by' => auth()->id(),
            'status' => 'pending',
            'rfq_from' => "service",
            'link' => $this->generateUniqueLink(),

        ];

        $rfq=Rfq::create($rfqData);

        /*if ($request->hasFile('product_images')){
            foreach ($request->file('product_images') as $index=>$product_image){

                $extension = $product_image->getClientOriginalExtension();
                if($extension=='pdf' ||$extension=='PDF' ||$extension=='doc'||$extension=='docx'|| $extension=='xlsx' || $extension=='ZIP'||$extension=='zip'|| $extension=='TAR' ||$extension=='tar'||$extension=='rar' ||$extension=='RAR'  ){

                    $path=$product_image->store('images','public');
                }
                else{
                    $path=$product_image->store('images','public');
                    $image = Image::make(Storage::get($path))->fit(555, 555)->encode();
                    Storage::put($path, $image);
                }
                RfqImage::create(['rfq_id'=>$rfq->id, 'image'=>$path]);
            }
        }*/
        if($request->flag == 'mb'){
            $product=ManufactureProduct::with('product_images')->where('id', $request->product_id)->first();
            foreach($product->product_images  as $key => $image){
                RfqImage::create(['rfq_id'=>$rfq->id, 'image'=>$image->product_image]);
               if($key == 2){
                   break;
               }
            }
        }
        if($request->flag == 'shop'){
            $product=Product::with('images')->where('id', $request->product_id)->first();
            foreach($product->images  as $key => $image){
                RfqImage::create(['rfq_id'=>$rfq->id, 'image'=>$image->image]);
               if($key == 2){
                   break;
               }
            }
        }
        $rfq = Rfq::with('images','category')->where('id',$rfq->id)->first();
        //SEND CREATED RFQ DATA TO RFQ APP
        // $response = Http::post(env('RFQ_APP_URL').'/api/quotation',[
        //     $rfq
        // ]);

        // if(env('APP_ENV') == 'production')
        // {
            /* code using redis-cli

            $selectedUsersToSendMail = User::where('id','<>',auth()->id())->get();
            foreach($selectedUsersToSendMail as $selectedUserToSendMail) {
                NewRfqHasAddedJob::dispatch($selectedUserToSendMail, $rfq);
            }

            $selectedUserToSendMail="success@merchantbay.com";
            NewRfqHasAddedJob::dispatch($selectedUserToSendMail, $rfq);

            */
            // $selectedUsersToSendMail = User::where('id','<>',auth()->id())->take(10)->get();
            // foreach($selectedUsersToSendMail as $selectedUserToSendMail) {
            //     event(new NewRfqHasAddedEvent($selectedUserToSendMail,$rfq));
            // }

            $selectedUserToSendMail="success@merchantbay.com";
            event(new NewRfqHasAddedEvent($selectedUserToSendMail,$rfq));
        // }


        $msg = "Your RFQ was posted successfully.<br><br>Thank you for your request. We will get back to you with quotations within 48 hours.";
        return back()->with(['rfq-success'=> $msg]);
    }

    public function storeWithLogin(Request $request)
    {
        if(env('APP_ENV') == 'local')
        {
            return  response()->json(['error' => "change the environment.now environment is local"],401);
        }
        $validator = Validator::make($request->all(), [
            'email' => 'required_without:r_email',
            'password' => 'required_without:r_password',
            'r_email' => 'required_without:email|unique:users,email',
            'r_password' => 'required_without:password',
            'name'      => 'required_without:email',
        ],[
            'r_email.unique' => 'The email has already been taken.'
        ]);
        if ($validator->fails())
        {
            return response()->json(array(
            'success' => false,
            'error' => $validator->getMessageBag()),
            400);
        }


        if(isset($request->email) && isset($request->password))
        {
            $sso=Http::post(env('SSO_URL').'/api/auth/token/',[
                'email' => $request->email,
                'password' => $request->password,
            ]);
            if($sso->successful()){
                $access_token=$sso['access'];
                $explode=explode(".",$access_token);
                $time= base64_decode($explode[1]);
                $decode_time=json_decode($time);
                $get_time=$decode_time->exp;
                $get_time=strtotime(date('d.m.Y H:i:s')) + strtotime(date('d.m.Y H:i:s'));
                $current=strtotime(date('d.m.Y H:i:s'));
                $totalSecondsDiff = abs($get_time-$current);
                $totalMinutesDiff = $totalSecondsDiff/60;

                if(Cookie::has('sso_token')){
                    Cookie::queue(Cookie::forget('sso_token'));
                }
                Cookie::queue(Cookie::make('sso_token', $access_token, $totalMinutesDiff));

                if($request->session()->has('sso_password')){
                    $request->session()->forget('sso_password');
                }
                $request->session()->put('sso_password', $request->password);


            }
            else{
                return response()->json(['error' => 'No active account found with the given credentials or maybe you have provided wrong email or password.'],401);
            }

            $credentials = [
                'email' => $request->email,
                'password' => $request->password,
            ];

            if(!Auth::attempt($credentials))
            {
                return  response()->json(['error' => "Wrong email or password"],401);
            }

            $businessProfiles = BusinessProfile::withTrashed()->where('user_id',auth()->id())->get();

            $profileAlias = "";
            if(count($businessProfiles) > 0)
            {
                $profileAlias = $businessProfiles[0]['alias'];
            }
            else
            {
                $profileAlias = $businessProfiles['alias'];
            }

            $user = User::where('id',auth()->id())->first();
            //event(new NewRFQHasPostedEvent( $user ));

            return response()->json(['access_token' =>  $access_token, 'profileAlias' => $profileAlias, 'flag' => 'login'],200);

        }else{
            $registration_data = [
                'email' => $request->r_email,
                'password' => $request->r_password,
                'name' => $request->name,
                'company' => $request->r_company,
                'phone' => $request->r_phone,
                'user_type' => 'buyer',
                'user_flag' => 'rfq',
            ];

            $registration=Http::post(env('SSO_URL').'/api/auth/signup/',$registration_data);
            if(!$registration->successful()){
                return  response()->json(['error' => 'Registration failed, please try again'],403);
            }
            $fromSso=json_decode($registration->getBody());
            $user_id = IdGenerator::generate(['table' => 'users', 'field' => 'user_id','reset_on_prefix_change' =>true,'length' => 18, 'prefix' => date('ymd').time()]);
            $registration_data_new_user = [
                'user_id'=>$user_id,
                'sso_reference_id' => $fromSso->id,
                'email' => $request->r_email,
                'password' => Hash::make($request->r_password),
                'name' => $request->name,
                'company_name' => $request->r_company,
                'phone' => $request->r_phone,
                'user_type' => 'buyer',
                //'is_email_verified' => 1,
                'ip_address' => $request->ip(),
                'user_agent' => $request->header('User-Agent'),
            ];
            $new_user=User::create($registration_data_new_user);
            if(!$new_user){
                return  response()->json(['error' => 'Somethings went wrong'],403);
            }

            // if user registration successful then we will create a business profile for the new user.
            $business_profile_data=[
                'business_name' => $new_user['company_name'],
                'alias'   => $this->createAlias($new_user['company_name']),
                'user_id'       => $new_user['id'],
                'profile_type'       => "buyer",
                'business_type' => "manufacturer", // forcefully set Manufacturer type
                'has_representative'=> 1, // no representative
                'industry_type' => 'apparel',
            ];
            $business_profile = BusinessProfile::create($business_profile_data);
            $this->createCompanyOverview($business_profile->id);

            $sso=Http::post(env('SSO_URL').'/api/auth/token/',[
                'email' => $request->r_email,
                'password' => $request->r_password,
            ]);
            if($sso->successful())
            {
                $access_token=$sso['access'];
                $explode=explode(".",$access_token);
                $time= base64_decode($explode[1]);
                $decode_time=json_decode($time);
                $get_time=$decode_time->exp;
                $get_time=strtotime(date('d.m.Y H:i:s')) + strtotime(date('d.m.Y H:i:s'));
                $current=strtotime(date('d.m.Y H:i:s'));
                $totalSecondsDiff = abs($get_time-$current);
                $totalMinutesDiff = $totalSecondsDiff/60;

                // if(Cookie::has('sso_token')){
                //     Cookie::queue(Cookie::forget('sso_token'));
                // }
                // Cookie::queue(Cookie::make('sso_token', $access_token, $totalMinutesDiff));

                // if($request->session()->has('sso_password')){
                //     $request->session()->forget('sso_password');
                // }
                // $request->session()->put('sso_password', $request->r_password);


            }
            else{
                return response()->json(['error' => 'No active account found with the given credentials or maybe you have provided wrong email or password.'],401);
            }

            // $credentials = [
            //     'email' => $request->r_email,
            //     'password' => $request->r_password,
            // ];
            // if(!Auth::attempt($credentials))
            // {
            //     return  response()->json(['error' =>  "Wrong email or password"],401);
            // }

            $email_verification_OTP = mt_rand(100000,999999);

            UserVerify::create([
                'user_id' => $new_user->id,
                'token' => $email_verification_OTP
              ]);

            //event(new NewAnonymousUserHasRegisteredEvent($new_user, $email_verification_OTP, $request->r_password));
            //event(new NewRFQHasPostedEvent($new_user));

            return response()->json(['access_token' =>  $access_token, "profileAlias" => $business_profile->alias,'flag'=> 'registration'],200);

            //return response()->json(['access_token' =>  $access_token, "profileAlias" => $business_profile->alias],200);
        }


    }

    public function removeSpecialCharacterFromAlais($alias)
    {
        $lowercase=strtolower($alias);
        $pattern= '/[^A-Za-z0-9\-]/';
        $preg_replace= preg_replace($pattern, '-', $lowercase);
        $single_hypen= preg_replace('/-+/', '-', $preg_replace);
        $alias= $single_hypen;
        return $alias;
    }


    public function createAlias($name)
    {
        $alias = $this->removeSpecialCharacterFromAlais($name);
        return $this->checkExistsAlias($alias);
    }

    public function checkExistsAlias($alias)
    {
        $check_exists=BusinessProfile::where('alias', $alias)->first();
        if($check_exists){
            $create_array= explode('-',$alias);
            $last_key=array_slice($create_array,-1,1);
            $last_key_string=implode(' ',$last_key);
            if(is_numeric($last_key_string)){
                $last_key_string++;
                array_pop($create_array);
                array_push($create_array,$last_key_string);
            }else{
                array_push($create_array,1);
            }
            $alias=implode("-",$create_array);
            return $this->checkExistsAlias($alias);

        }
        return $alias;
    }

    //company overview data
    public function createCompanyOverview($profile_id)
    {
        $name=['annual_revenue','number_of_worker','number_of_female_worker','trade_license_number','year_of_establishment','opertaing_hours','shift_details','main_products'];
        $value=[null,null,null,null,null,null,null,null,null];
        $data=[];
        foreach($name as $key => $value2){
            array_push($data,['name' => $value2, 'value' => $value[$key], 'status' => 0]);
        }
        $companyOverview=CompanyOverview::create([
            'business_profile_id' => $profile_id,
            'data'        => json_encode($data),
        ]);
        return $companyOverview;

    }

    public function rfqMailTriggerForAuthUser()
    {
        // $product_tag = ProductTag::whereIn('id', $request->category)->select('name')->get()->toArray();

        // $rfqData = [
        //     $category = $product_tag,
        //     $title = $request->title,
        //     $description = $request->full_specification,
        //     $quantity = $request->quantity,
        //     $unit = $request->unit,
        //     $unit_price = $request->unit_price,
        //     $payment_method = $request->payment_method,
        //     $destination = $request->destination,
        //     $delivery_time = $request->delivery_time,
        // ];

        $user = User::where('id',auth()->id())->first();
        event(new NewRFQHasPostedEvent( $user ));

        return response()->json(['success' => True], 200);

    }

    public function submitMatchedSuppleirs(Request $request, $data, $link = false){
        // $userIds = explode(",", $userIds);
        // $businessProfiles = explode(",", $businessProfiles);
        $d = json_decode($data);
        $rfqId = $d->rfq_id;
        $businessProfileIds = $d->business_profile_ids;

        $userIdArr = [];
        $selectedBusinessProfilesUserIds = BusinessProfile::whereIn("id", $businessProfileIds)->get();
        foreach($selectedBusinessProfilesUserIds as $item) {
            array_push($userIdArr, $item->user_id);
        }

        $usersPhone = [];
        $selectedUsersPhoneNUmber = User::whereIn("id", $userIdArr)->get();
        foreach($selectedUsersPhoneNUmber as $item) {
            array_push($usersPhone, $item->phone);
        }
        //dd($usersPhone);

        $response = Http::put(env('RFQ_APP_URL').'/api/quotation/'.$rfqId,[
            'selected_business_profiles'=>$businessProfileIds,
            'selected_users_phone'=>$usersPhone
        ]);

        // $users = User::whereIn('id',$userIds)->get();
        // email starts
        return response()->json(['success' => True], 200);
    }
    public function matchedSuppleirs(Request $request, $rfqid, $link = false)
    {
        $response = Http::get(env('RFQ_APP_URL').'/api/quotation/'.$rfqid);
        $data = $response->json();
        $rfq = $data['data']['data'];

        $businessProfilesShortListed = 0;
        $businessProfilesSelectedListed = 0;

        if(Cookie::get('sso_token') !== null)
        {
            $cookie = Cookie::get('sso_token');
            $cookie = base64_decode(explode(".",$cookie)[1]);
            $cookie = json_decode(json_decode(json_encode($cookie)));
        }
        else
        {
            $cookie = new stdClass();
            $cookie->subscription_status = 0;
        }

        if( isset($rfq['short_listed_profiles']) ) {
            $rfq['short_listed_profiles'] = $rfq['short_listed_profiles'];
            $rfq['short_listed_profiles'] = implode("," , $rfq['short_listed_profiles']);

        } else {
            $rfq['short_listed_profiles'] = "";
        }

        if( isset($rfq['selected_profile']) ) {
            $rfq['selected_profile'] = $rfq['selected_profile'];
            $rfq['selected_profile'] = implode("," , $rfq['selected_profile']);
        } else {
            $rfq['selected_profile'] = "";
        }

        $factory_type_value = [];
        foreach($rfq['category'] as $category) {
            array_push($factory_type_value, $category['name']);
        }

        $product_tag = ProductTag::get();

        $product_tag_for_parent_id = ProductTag::with('tagMapping')->whereIn('id',$rfq['category_id'])->get();
        $factory_type_as_tag_parent = [];
        foreach($product_tag_for_parent_id as $tag){
            foreach($tag->tagMapping as $mapping){
                array_push($factory_type_as_tag_parent,$mapping->name);
            }
        }
        // [{"name":"annual_revenue","value":"9.75 Million USD","status":"1"},{"name":"number_of_worker","value":"600","status":"1"},{"name":"number_of_female_worker","value":"300","status":"1"},{"name":"trade_license_number","value":null,"status":"1"},{"name":"year_of_establishment","value":"2005","status":"1"},{"name":"opertaing_hours","value":"8","status":"1"},{"name":"shift_details","value":null,"status":"1"},{"name":"main_products","value":"T-shirt, Polo shirt, Fancy Item, Tank Top, PK Polo Sweatshirt, Fleece.","status":"1"}]
        // WHERE business_profile_id=5640
        // ->leftJoin('certifications', 'certifications.business_profile_id', '=', 'business_profiles.id')
        // ->where('profile_verified_by_admin', '!=', 0)

        if($cookie->subscription_status == 1)
        {
            $businessProfiles = BusinessProfile::select('business_profiles.*')
            ->leftJoin('rfq_quotation_sent_supplier_to_buyer_rel', 'rfq_quotation_sent_supplier_to_buyer_rel.business_profile_id', '=', 'business_profiles.id')
            ->with(['user','supplierQuotationToBuyer'=> function($q) use ($rfqid){
                $q->where('rfq_id', $rfqid);}])
            ->with(['certifications'])
            ->with(['CompanyOverview'])
            ->whereIn('factory_type',$factory_type_value)
            ->orWhereIn('factory_type',$factory_type_as_tag_parent)
            ->groupBy('business_profiles.id')
            ->orderBy('rfq_quotation_sent_supplier_to_buyer_rel.created_at', 'desc')
            ->get()
            ->toArray();
        }
        else
        {
            // All business profile which is matched with rfq.
            $businessProfilesAllCount = BusinessProfile::select('business_profiles.*')
            ->leftJoin('rfq_quotation_sent_supplier_to_buyer_rel', 'rfq_quotation_sent_supplier_to_buyer_rel.business_profile_id', '=', 'business_profiles.id')
            ->with(['user','supplierQuotationToBuyer'=> function($q) use ($rfqid){
                $q->where('rfq_id', $rfqid);}])
            ->with(['certifications'])
            ->with(['CompanyOverview'])
            ->whereIn('factory_type',$factory_type_value)
            ->orWhereIn('factory_type',$factory_type_as_tag_parent)
            ->groupBy('business_profiles.id')
            ->orderBy('rfq_quotation_sent_supplier_to_buyer_rel.created_at', 'desc')
            ->get()
            ->toArray();

            // Radiant sweater and kims corporation business profile for default show.
            $businessProfiles = BusinessProfile::select('business_profiles.*')->where("show_for_non_subscribe_user", 1)
            ->leftJoin('rfq_quotation_sent_supplier_to_buyer_rel', 'rfq_quotation_sent_supplier_to_buyer_rel.business_profile_id', '=', 'business_profiles.id')
            ->with(['user','supplierQuotationToBuyer'=> function($q) use ($rfqid){
                $q->where('rfq_id', $rfqid);}])
            ->with(['certifications'])
            ->with(['CompanyOverview'])
            ->groupBy('business_profiles.id')
            ->orderBy('rfq_quotation_sent_supplier_to_buyer_rel.created_at', 'desc')
            ->get()
            ->toArray();

            //dd($businessProfiles);
        }

        $productCategories = ProductCategory::all('id','name');
        if( env('APP_ENV') == 'production') {
            $user = "5771";
        }
        else{
            $user = "5552";
        }
        $from_user = User::find($user);
        $to_user = User::with('businessProfile')->where('email',$rfq['user']['email'])->first();
        $buyerBusinessProfile = $to_user->businessProfile[0];
        $from_user_image = isset($from_user->image) ? asset($from_user->image) : asset('images/frontendimages/no-image.png');
        if($rfq['user']['user_picture'] !=""){
            $to_user_image = $rfq['user']['user_picture'];
            $userNameShortForm = "";
        }else{
            $to_user_image = $rfq['user']['user_picture'];
            $nameWordArray = explode(" ", $rfq['user']['user_name']);
            $firstWordFirstLetter = $nameWordArray[0][0];
            $secorndWordFirstLetter = $nameWordArray[1][0] ??'';
            $userNameShortForm = $firstWordFirstLetter.$secorndWordFirstLetter;
        }
        //conversation with merchant bay and buyer who created rfq
        $response =   Http::get(env('RFQ_APP_URL').'/api/messages/'.$rfq['id'].'/admin/'.$user.'/user/'.$rfq['created_by']);
        $data = $response->json();
        $chats = $data['data']['messages'];
        $profromaInvoice = Proforma::where('generated_po_from_rfq',$rfqid)->latest()->first();

        //$chatdata = $chats;
        $chatdataAllData = $chats;
        $chatdata = $chatdataAllData;
        foreach ($chatdataAllData as $key => $value) {
            $messageStr = preg_replace('!(((f|ht)tp(s)?://)[-a-zA-Zа-яА-Я()0-9@:%_+.~#?&;//=]+)!i', '<a href="$1">$1</a>', $value['message']);
            $chatdata[$key]['message'] = $messageStr;
            //echo "<pre>"; print_r($chatdataAllData[$key]); exit();
        }

        $buyer = $to_user;
        $userSsoIds = [];
        foreach($businessProfiles as $profile){
            array_push($userSsoIds, $profile['user']['sso_reference_id']);
        }
        $commaSeparatedStringOfSsoId = implode(",",$userSsoIds);
        //suppliers who have unseen messages
        $response = Http::get(env('RFQ_APP_URL').'/api/rfq/'.$rfqid.'/users/'.$commaSeparatedStringOfSsoId.'/conversations');
        $data = $response->json();
        $usersWithMessageUnseen = $data['data'] ?? [];
        $associativeArrayUsingIDandCount = [];
        foreach($usersWithMessageUnseen as $user){
            $associativeArrayUsingIDandCount[$user['user_id']]  = $user;
        }
        $proforma_invoice_url_for_buyer =$profromaInvoice ? route('open.proforma.single.html', $profromaInvoice->id) : '';
        $url_exists=$link;

        return view('rfq._matched_supplier_by_rfq', compact('rfq','businessProfiles','businessProfilesAllCount','businessProfilesShortListed','businessProfilesSelectedListed','buyerBusinessProfile','chatdata','from_user_image','to_user_image','user','buyer','productCategories','userNameShortForm','profromaInvoice','associativeArrayUsingIDandCount','proforma_invoice_url_for_buyer','url_exists', 'product_tag', 'factory_type_as_tag_parent'));
    }

    public function matchedSuppleirsDataModal(Request $request, $rfqid, $link = false)
    {
        $response = Http::get(env('RFQ_APP_URL').'/api/quotation/'.$rfqid);
        $data = $response->json();
        $rfq = $data['data']['data'];

        $businessProfilesShortListed = 0;
        $businessProfilesSelectedListed = 0;

        if( isset($rfq['short_listed_profiles']) ) {
            $rfq['short_listed_profiles'] = $rfq['short_listed_profiles'];
            $rfq['short_listed_profiles'] = implode("," , $rfq['short_listed_profiles']);

        } else {
            $rfq['short_listed_profiles'] = "";
        }

        if( isset($rfq['selected_profile']) ) {
            $rfq['selected_profile'] = $rfq['selected_profile'];
            $rfq['selected_profile'] = implode("," , $rfq['selected_profile']);
        } else {
            $rfq['selected_profile'] = "";
        }

        $factory_type_value = [];
        foreach($rfq['category'] as $category) {
            array_push($factory_type_value, $category['name']);
        }

        $product_tag = ProductTag::get();

        $product_tag_for_parent_id = ProductTag::with('tagMapping')->whereIn('id',$rfq['category_id'])->get();
        $factory_type_as_tag_parent = [];
        foreach($product_tag_for_parent_id as $tag){
            foreach($tag->tagMapping as $mapping){
                array_push($factory_type_as_tag_parent,$mapping->name);
            }
        }
        // [{"name":"annual_revenue","value":"9.75 Million USD","status":"1"},{"name":"number_of_worker","value":"600","status":"1"},{"name":"number_of_female_worker","value":"300","status":"1"},{"name":"trade_license_number","value":null,"status":"1"},{"name":"year_of_establishment","value":"2005","status":"1"},{"name":"opertaing_hours","value":"8","status":"1"},{"name":"shift_details","value":null,"status":"1"},{"name":"main_products","value":"T-shirt, Polo shirt, Fancy Item, Tank Top, PK Polo Sweatshirt, Fleece.","status":"1"}]
        // WHERE business_profile_id=5640
        // ->leftJoin('certifications', 'certifications.business_profile_id', '=', 'business_profiles.id')
        // ->where('profile_verified_by_admin', '!=', 0)
        $businessProfiles = BusinessProfile::select('business_profiles.*')
        ->leftJoin('rfq_quotation_sent_supplier_to_buyer_rel', 'rfq_quotation_sent_supplier_to_buyer_rel.business_profile_id', '=', 'business_profiles.id')
        ->with(['user','supplierQuotationToBuyer'=> function($q) use ($rfqid){
            $q->where('rfq_id', $rfqid);}])
        ->with(['certifications'])
        ->with(['CompanyOverview'])
        ->whereIn('factory_type',$factory_type_value)
        ->orWhereIn('factory_type',$factory_type_as_tag_parent)
        ->groupBy('business_profiles.id')
        ->orderBy('rfq_quotation_sent_supplier_to_buyer_rel.created_at', 'desc')
        ->get()
        ->toArray();

        $productCategories = ProductCategory::all('id','name');
        if( env('APP_ENV') == 'production') {
            $user = "5771";
        }
        else{
            $user = "5552";
        }
        $from_user = User::find($user);
        $to_user = User::with('businessProfile')->where('email',$rfq['user']['email'])->first();
        $buyerBusinessProfile = $to_user->businessProfile[0];
        $from_user_image = isset($from_user->image) ? asset($from_user->image) : asset('images/frontendimages/no-image.png');
        if($rfq['user']['user_picture'] !=""){
            $to_user_image = $rfq['user']['user_picture'];
            $userNameShortForm = "";
        }else{
            $to_user_image = $rfq['user']['user_picture'];
            $nameWordArray = explode(" ", $rfq['user']['user_name']);
            $firstWordFirstLetter = $nameWordArray[0][0];
            $secorndWordFirstLetter = $nameWordArray[1][0] ??'';
            $userNameShortForm = $firstWordFirstLetter.$secorndWordFirstLetter;
        }
        //conversation with merchant bay and buyer who created rfq
        $response =   Http::get(env('RFQ_APP_URL').'/api/messages/'.$rfq['id'].'/admin/'.$user.'/user/'.$rfq['created_by']);
        $data = $response->json();
        $chats = $data['data']['messages'];
        $profromaInvoice = Proforma::where('generated_po_from_rfq',$rfqid)->latest()->first();

        //$chatdata = $chats;
        $chatdataAllData = $chats;
        $chatdata = $chatdataAllData;
        foreach ($chatdataAllData as $key => $value) {
            $messageStr = preg_replace('!(((f|ht)tp(s)?://)[-a-zA-Zа-яА-Я()0-9@:%_+.~#?&;//=]+)!i', '<a href="$1">$1</a>', $value['message']);
            $chatdata[$key]['message'] = $messageStr;
            //echo "<pre>"; print_r($chatdataAllData[$key]); exit();
        }

        $buyer = $to_user;
        $userSsoIds = [];
        foreach($businessProfiles as $profile){
            array_push($userSsoIds, $profile['user']['sso_reference_id']);
        }
        $commaSeparatedStringOfSsoId = implode(",",$userSsoIds);
        //suppliers who have unseen messages
        $response = Http::get(env('RFQ_APP_URL').'/api/rfq/'.$rfqid.'/users/'.$commaSeparatedStringOfSsoId.'/conversations');
        $data = $response->json();
        $usersWithMessageUnseen = $data['data'] ?? [];
        $associativeArrayUsingIDandCount = [];
        foreach($usersWithMessageUnseen as $user){
            $associativeArrayUsingIDandCount[$user['user_id']]  = $user;
        }
        $proforma_invoice_url_for_buyer =$profromaInvoice ? route('open.proforma.single.html', $profromaInvoice->id) : '';
        $url_exists=$link;

        //return view('rfq._matched_supplier_by_rfq', compact('rfq','businessProfiles','businessProfilesShortListed','businessProfilesSelectedListed','buyerBusinessProfile','chatdata','from_user_image','to_user_image','user','buyer','productCategories','userNameShortForm','profromaInvoice','associativeArrayUsingIDandCount','proforma_invoice_url_for_buyer','url_exists', 'product_tag', 'factory_type_as_tag_parent'));
        return response()->json([
            'success' => True,
            'rfq' => $rfq,
            'businessProfiles' => $businessProfiles,
            'businessProfilesShortListed' => $businessProfilesShortListed,
            'businessProfilesShortListed' => $businessProfilesShortListed,
            'businessProfilesSelectedListed' => $businessProfilesSelectedListed,
            'buyerBusinessProfile' => $buyerBusinessProfile,
            'chatdata' => $chatdata,
            'from_user_image' => $from_user_image,
            'to_user_image' => $to_user_image,
            'user' => $user,
            'buyer' => $buyer,
            'productCategories' => $productCategories,
            'userNameShortForm' => $userNameShortForm,
            'profromaInvoice' => $profromaInvoice,
            'associativeArrayUsingIDandCount' => $associativeArrayUsingIDandCount,
            'proforma_invoice_url_for_buyer' => $proforma_invoice_url_for_buyer,
            'url_exists' => $url_exists,
            'product_tag' => $product_tag,
            'factory_type_as_tag_parent' => $factory_type_as_tag_parent,
        ], 200);
    }

    public function profileShortListFromFrontend( Request $request )
    {
        //dd($request->all());
        $rfqId = $request->rfqId;
        $requestForm = $request->requestForm;
//dd($shortList);

        if($requestForm == "from_selected") // request for selected list
        {
            $request_index_to_array = $request->request_index_to_array;
            if($request_index_to_array == "add")
            {
                $responseToGetData = Http::get(env('RFQ_APP_URL').'/api/quotation/'.$rfqId);
                $rfqData = $responseToGetData->json();

                if(isset($rfqData['data']['data']['selected_profile']))
                {
                    $elements = $rfqData['data']['data']['selected_profile'];
                }
                else
                {
                    $elements = $rfqData['data']['data']['selected_profile'] = [];
                }

                array_push($elements, (int)$request->businessProfileId);

                // set unchecked if the profile id is selected from short list.
                $shortListedElements = $rfqData['data']['data']['short_listed_profiles'];
                if (($key = array_search((int)$request->businessProfileId, $shortListedElements)) !== false) {
                    unset($shortListedElements[$key]);
                }

                $response = Http::put(env('RFQ_APP_URL').'/api/quotation/'.$rfqId, [
                    'selected_profile' => $elements,
                    'short_listed_profiles' => $shortListedElements,
                ]);
            }
            else
            {
                $responseToGetData = Http::get(env('RFQ_APP_URL').'/api/quotation/'.$rfqId);
                $rfqData = $responseToGetData->json();
                $elements = $rfqData['data']['data']['selected_profile'];

                if (($key = array_search((int)$request->businessProfileId, $elements)) !== false) {
                    unset($elements[$key]);
                }

                $response = Http::put(env('RFQ_APP_URL').'/api/quotation/'.$rfqId, [
                    'selected_profile' => $elements,
                ]);
            }
        }
        else // request for short list
        {
            $request_index_to_array = $request->request_index_to_array;
            if($request_index_to_array == "add")
            {
                $responseToGetData = Http::get(env('RFQ_APP_URL').'/api/quotation/'.$rfqId);
                $rfqData = $responseToGetData->json();

                if(isset($rfqData['data']['data']['short_listed_profiles']))
                {
                    $elements = $rfqData['data']['data']['short_listed_profiles'];
                }
                else
                {
                    $elements = $rfqData['data']['data']['short_listed_profiles'] = [];
                }

                array_push($elements, (int)$request->businessProfileId);

                $response = Http::put(env('RFQ_APP_URL').'/api/quotation/'.$rfqId, [
                    'short_listed_profiles' => $elements,
                ]);
            }
            else
            {
                $responseToGetData = Http::get(env('RFQ_APP_URL').'/api/quotation/'.$rfqId);
                $rfqData = $responseToGetData->json();
                $elements = $rfqData['data']['data']['short_listed_profiles'];

                if (($key = array_search((int)$request->businessProfileId, $elements)) !== false) {
                    unset($elements[$key]);
                }

                $response = Http::put(env('RFQ_APP_URL').'/api/quotation/'.$rfqId, [
                    'short_listed_profiles' => $elements,
                ]);
            }
        }

        if( $response->status()  == 200){
            return response()->json([
                'msg' => "Profile added in short list successfully.",
            ],200);
        } else {
            return redirect()->back()->withSuccess('Something went wrong!!');
        }
    }

    public function rfqQuotationSetNotInterested( Request $request )
    {
        //dd($request->all());
        $response = Http::post(env('RFQ_APP_URL').'/api/message/update/'.$request->rfqObjID, [
            'not_interested' => 1,
        ]);

        if( $response->status()  == 200){
            return response()->json([
                'msg' => "Updated Successfully",
            ],200);
        } else {
            return redirect()->back()->withSuccess('Something went wrong!!');
        }
    }

}
