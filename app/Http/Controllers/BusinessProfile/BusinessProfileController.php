<?php

namespace App\Http\Controllers\BusinessProfile;

use App\Models\ProductTag;
use Illuminate\Http\Request;
use App\Models\BusinessProfile;
use App\Models\Manufacture\Product;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use App\Models\BusinessProfileVerificationsRequest;
use App\Events\NewBusinessProfileVerificationRequestEvent;
use App\Models\Product as WholesalerProduct;

class BusinessProfileController extends Controller
{

    public function __construct()
    {

    }

    public function index($alias){
        $business_profile = BusinessProfile::withTrashed()->with('user')->where('alias',$alias)->firstOrFail();
        if((auth()->id() == $business_profile->user_id) || (auth()->id() == $business_profile->representative_user_id))
        {
            return view('new_business_profile.index',compact('alias','business_profile'));
        }
        abort(401);
    }

    public function rfqs($alias){
        return view('new_business_profile.rfqs',compact('alias'));
    }

    public function myRfqs($alias){
        return view('new_business_profile.my_rfqs',compact('alias'));
    }



    public function developmentCenter($alias){
        $business_profile = BusinessProfile::withTrashed()->with('user')->where('alias',$alias)->firstOrFail();
        return view('new_business_profile.development_center',compact('alias', 'business_profile'));
    }

    public function orderManagement($alias){
        $business_profile = BusinessProfile::withTrashed()->with('user')->where('alias',$alias)->firstOrFail();
        return view('new_business_profile.order_management',compact('alias', 'business_profile'));
    }

    public function products($alias,Request $request){

        $business_profile=BusinessProfile::withTrashed()->where('alias',$alias)->firstOrFail();
        if((auth()->id() == $business_profile->user_id) || (auth()->id() == $business_profile->representative_user_id))
        {
            if($business_profile->profile_type == 'supplier' && $business_profile->business_type == 'manufacturer'){
                $collection=collect(Product::withTrashed()
                ->latest()
                ->with('product_images','product_video')
                ->where(function($query) use ($request, $business_profile){
                    $query->where('business_profile_id', $business_profile->id)->get();
                    if(isset($request->search)){
                        $query->where('title','like', '%'.$request->search.'%')->get();
                    }

                })
                ->get());

                $controller_max_moq=$collection->max('moq');
                $controller_min_moq=$collection->min('moq');
                $controller_max_lead_time=$collection->max('lead_time');
                $controller_min_lead_time=$collection->min('lead_time');

                if(isset($request->product_tag)){
                    $ptags=[];
                    foreach($request->product_tag as $tag){
                        $product_tag=ProductTag::where('id',$tag)->first();
                        array_push($ptags,$product_tag->name);
                    }
                    $collection= $collection->filter(function($item) use ($ptags){
                        if(isset($item['product_tag'])){
                            $check=array_intersect($item['product_tag'], $ptags);
                            if(empty($check)){
                                return false;
                            }
                            return true;
                        }
                        return false;
                    });
                }

                if(isset($request->product_type_mapping_child_id)){
                    $collection= $collection->filter(function($item) use ($request){
                        if(isset($item['product_type_mapping_child_id'])){
                            $check=array_intersect($item['product_type_mapping_child_id'], $request->product_type_mapping_child_id);
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
                $perPage = 8;
                $products = new \Illuminate\Pagination\LengthAwarePaginator(
                    $collection->forPage($page, $perPage),
                    $collection->count(),
                    $perPage,
                    $page,
                    ['path' => Paginator::resolveCurrentPath()],
                );




                $colors=['Red','Blue','Green','Black','Brown','Pink','Yellow','Orange','Lightblue','Multicolor'];
                $sizes=['S','M','L','XL','XXL','XXXL'];
                $view=isset($request->view)? $request->view : 'grid';
                return view('new_business_profile.manufacturer_products.index',compact('alias','products','business_profile','colors','sizes','view','controller_max_moq','controller_min_moq','controller_max_lead_time','controller_min_lead_time'));
            }


            if($business_profile->profile_type == 'supplier' && $business_profile->business_type == 'wholesaler'){

                $collection=collect(WholesalerProduct::withTrashed()
                ->where(function($query) use ($request, $business_profile){
                    $query->where('business_profile_id', $business_profile->id)->get();
                    if(isset($request->search)){
                        $query->where('name','like', '%'.$request->search.'%')->get();
                    }})
                ->latest()
                ->with('images','video')
                ->get());

                $controller_max_moq=$collection->max('moq');
                $controller_min_moq=$collection->min('moq');
                $controller_max_lead_time=0;
                $controller_min_lead_time=0;
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
                    $ptags=[];
                    foreach($request->product_tag as $tag){
                        $product_tag=ProductTag::where('id',$tag)->first();
                        array_push($ptags,$product_tag->name);
                    }
                    $collection= $collection->filter(function($item) use ($ptags){
                        if(isset($item['product_tag'])){
                            $check=array_intersect($item['product_tag'], $ptags);
                            if(empty($check)){
                                return false;
                            }
                            return true;
                        }
                        return false;

                    });
                }

                if(isset($request->product_type_mapping_child_id)){
                    $collection= $collection->filter(function($item) use ($request){
                        if(isset($item['product_type_mapping_child_id'])){
                            $check=array_intersect($item['product_type_mapping_child_id'], $request->product_type_mapping_child_id);
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
                $perPage = 8;
                $products = new \Illuminate\Pagination\LengthAwarePaginator(
                    $collection->forPage($page, $perPage),
                    $collection->count(),
                    $perPage,
                    $page,
                    ['path' => Paginator::resolveCurrentPath()],
                );

                $view=isset($request->view)? $request->view : 'grid';
                return view('new_business_profile.wholesaler_products.index',compact('alias','products','business_profile','view','controller_max_moq','controller_min_moq','controller_max_lead_time','controller_min_lead_time'));
            }

        }
        abort(401);

    }

    public function businessProfileVerificationRequest(Request $request)
    {

        try
        {
            BusinessProfileVerificationsRequest::where('business_profile_id',$request->verificationRequestedBusinessProfileId)->delete();
            $businessProfileVerificationsRequest = BusinessProfileVerificationsRequest::create([
                'business_profile_id' => $request->verificationRequestedBusinessProfileId,
                'business_profile_name' => $request->verificationRequestedBusinessProfileName,
                'verification_message'=> $request->verificationMsg,
            ]);
            event(new NewBusinessProfileVerificationRequestEvent($businessProfileVerificationsRequest));
            return response()->json([
                'success' => true,
                'message' => 'Request sent successfully.'
            ],200);

        }
        catch(\Exception $e)
        {
            return response()->json([
                'success' => false,
                'error'   => ['message' => $e->getMessage()],
            ],500);

        }
    }    

    public function profileInsights($alias){
        return view('new_business_profile.profile_insights',compact('alias'));
    }

    public function profileHome($alias){
        return view('new_business_profile.profile_home',compact('alias'));
    }


}
