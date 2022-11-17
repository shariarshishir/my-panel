<?php

namespace App\Http\Controllers;

use DB;
use Helper;
use App\Models\Blog;
use App\Models\BusinessMappingTree;
use App\Models\User;
use App\Models\Vendor;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Models\ProductReview;
use App\Models\BusinessProfile;
use App\Models\ProductCategory;
use App\Models\ProductWishlist;
use App\Models\CompanyFactoryTour;
use App\Models\CompanyOverview;
use App\Models\Certification;
use App\Models\ProductTypeMapping;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use App\Models\OrderModificationRequest;
use App\Models\BusinessProfileVerification;
use App\Models\Manufacture\Product as ManufactureProduct;
use App\Models\Manufacture\ProductCategory as ManufatureProductCategeory;
use App\Userchat;
use App\RfqApp;
use Illuminate\Support\Facades\Cookie;
use Carbon\Carbon;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $page = isset($request->page) ? $request->page : 1;

        $business_profile = BusinessProfile::with('user')->firstOrFail();
        $alias = $business_profile->alias;
        $user = Auth::user();

        if($user) {
            $token = Cookie::get('sso_token');
            //get all rfqs of auth user
            $response = Http::withToken($token)
            ->get(env('RFQ_APP_URL').'/api/quotation/user/'.$user->sso_reference_id.'/filter/null/page/'.$page.'/limit/11');
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
            if(count($rfqs)>0 && count($rfqLists)>0){
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

            return view('shoplanding',compact('pageTitle','pageActive','page','rfqLists','noOfPages','alias','chatdata','business_profile','adminUserImage','userImage','userNameShortForm','user'));
        } else {
            //die("User not Authenticated");
            return redirect('/login');
            //return redirect()->route('users.login');
        }

    }

    public function productList(Request $request)
    {

        $wholesaler_products=Product::with(['images','businessProfile'])->where(['state' => 1])->where('business_profile_id', '!=', null)->get();
        $manufacture_products=ManufactureProduct::with(['product_images','businessProfile'])->where('business_profile_id', '!=', null)->get();
        $merged = $wholesaler_products->mergeRecursive($manufacture_products)->sortBy([ ['priority_level', 'asc'], ['created_at', 'desc'] ])->values();

        if(isset($request->product_name)){
            $search=$request->product_name;
            $merged = $merged->filter(function($item) use ($search) {
                if($item->flag == 'mb'){
                    return stripos($item['title'],$search) !== false;
                }
                return stripos($item['name'],$search) !== false;
            });
        }
        if(isset($request->product_type)){
            $array=$request->product_type;
            if(in_array(2, $request->product_type)){
                array_push($array, '3');
            }
            $merged = $merged->whereIn('product_type', $array);
            $merged->all();
        }

        if(isset($request->location)){
            $search=$request->location;
            $merged = $merged->filter(function($item) use ($search) {
                    return stripos($item->businessProfile->location,$search) !== false;
            });
        }

        if(isset($request->product_category)){
            $merged = $merged->where('flag', 'shop')->where('product_category_id', $request->product_category);
            $merged->all();
        }

        if(isset($request->factory_category)){
            $merged = $merged->where('flag', 'mb')->where('product_category', $request->factory_category);
            $merged->all();
        }

        if(isset($request->lead_minimum_range) &&  isset($request->lead_maximum_range)){

            $merged = $merged->where('flag', 'mb')->whereBetween('lead_time', [$request->lead_minimum_range, $request->lead_maximum_range]);
            $merged->all();
        }

        if(isset($request->price_minimum_range) &&  isset($request->price_maximum_range)){
            $price_id=[];
            foreach($merged as $product){
                if($product->flag == 'shop' && isset($product->attribute)){
                    foreach(json_decode($product->attribute) as $price)
                    {
                        if (  $price[2] >= $request->price_minimum_range && $price[2] <= $request->price_maximum_range){
                            array_push($price_id,$product->id);
                        }
                    }
                }
            }
            $merged = $merged->where('flag', 'shop')->whereIn('id', $price_id);
            $merged->all();

        }

        if(isset($request->gender)){

            $merged = $merged->whereIn('gender', $request->gender);
            $merged->all();
        }

        if(isset($request->sample_availability)){

            $merged = $merged->whereIn('sample_availability', $request->sample_availability);
            $merged->all();
        }



        $page = Paginator::resolveCurrentPage() ?: 1;
        $perPage = 32;
        $products = new \Illuminate\Pagination\LengthAwarePaginator(
            $merged->forPage($page, $perPage),
            $merged->count(),
            $perPage,
            $page,
            ['path' => Paginator::resolveCurrentPath()],
        );

        $product_category= ProductCategory::all();
        return view('product.all_products',compact('products', 'product_category'));
    }

    //start products by category sub category and subsub category
    public function productsByCategory($slug)
    {
        $category=ProductCategory::where('slug',$slug)->with('children')->first();
        //$cat_id=collect([$category->id]);
        $get_sel_cat_id=$category->id;
        $get_child_cat_id= $category->getAllChildren()->pluck('id');
        $total_cat_id=$get_child_cat_id->push($get_sel_cat_id)->toArray();
        // $products=Product::with('images')->whereIn('product_category_id', $total_cat_id)->where('state',1)->where('sold',0)->inRandomOrder()->paginate(9);
        // return $products;
        // if($category->children()->exists()){
        //     foreach($category->children as $child){
        //         array_push($total_cat_id,$child->id);
        //         if($child->children()->exists()){
        //             foreach($child->children as $child2){
        //                 array_push($total_cat_id,$child2->id);
        //             }
        //         }
        //     }
        // }
        $products = $this->products($total_cat_id);
        return view('product.categories_product',compact('products','total_cat_id'));
    }

    public function productsBySubCategory($category,$subcategory)
    {
        $category=ProductCategory::where('slug',$subcategory)->first();
        $total_cat_id[]=$category->id;
        if($category->children()->exists()){
            foreach($category->children as $child){
                array_push($total_cat_id,$child->id);
            }
        }
        $products = $this->products($total_cat_id);
        return view('product.categories_product',compact('products','total_cat_id'));
    }

    public function productsBySubSubCategory($category,$subcategory,$subsubcategory)
    {
        $category=ProductCategory::where('slug',$subsubcategory)->first();
        $total_cat_id[]=$category->id;
        $products = $this->products($total_cat_id);
        return view('product.categories_product',compact('products','total_cat_id'));
    }

    public function products($id)
    {
      $products=Product::with('images')->whereIn('product_category_id', $id)->where('state',1)->where('sold',0)->inRandomOrder()->paginate(12);
      return $products;
    }
    //end products category
    //start readystock products
    public function readyStockProducts(Request $request)
    {
        $product_category= ProductCategory::all();
        $price_id=[];
        if(isset($request->price_minimum_range) && isset($request->price_maximum_range)){
            $products = Product::latest()->with('images')->whereIn('product_type', [2,3])->where('business_profile_id', '!=', null)->where('state',1)->where('sold',0)->paginate(32);
            foreach($products as $q){
                foreach(json_decode($q->attribute) as $price){
                    if (  $price[2] >= $request->price_minimum_range && $price[2] <= $request->price_maximum_range){
                        array_push($price_id, $q->id);
                    }
                }
            }

        }

        $products=Product::orderBy('priority_level', 'ASC')->orderBy('created_at', 'DESC')->with(['images','businessProfile','category'])->whereIn('product_type', [2,3])->where('business_profile_id', '!=', null)->where('state',1)->where('sold',0)->where(function($query) use ($request, $price_id){

            if(isset($request->product_name)){
                $query->where('name', 'like', '%'.$request->product_name.'%')->get();
            }
            if(isset($request->location)){
                $query->whereHas('businessProfile', function ($sub_query) use ($request) {
                    $sub_query->where('location', $request->location);
                })->get();
            }
            if(isset($request->product_category)){
                $query->whereHas('category', function ($sub_query) use ($request) {
                    $sub_query->where('id', $request->product_category);
                })->get();
            }
            if(isset($request->gender)){
                $query->whereIn('gender', $request->gender)->get();
            }
            if(isset($request->sample_availability)){
                $query->whereIn('sample_availability', $request->sample_availability)->get();
            }
            if(isset($request->price_minimum_range) && isset($request->price_maximum_range)){

                $query->whereIn('id', $price_id)->get();
            }


        })->paginate(32);

        return view('product.ready_stock_product',compact('products', 'product_category'));
    }

    public function readyStockProductsByCategory($slug)
    {
        $category=ProductCategory::where('slug',$slug)->first();
        $total_cat_id[]=$category->id;
        if($category->children()->exists()){
            foreach($category->children as $child){
                array_push($total_cat_id,$child->id);
                if($child->children()->exists()){
                    foreach($child->children as $child2){
                        array_push($total_cat_id,$child2->id);
                    }
                }
            }
        }
        $products = Product::with('images')->whereIn('product_category_id', $total_cat_id)->whereIn('product_type', [2,3])->where('state',1)->where('sold',0)->inRandomOrder()->paginate(12);
        return view('product.ready_stock_product',compact('products', 'total_cat_id'));
    }


    public function  readyStockProductsBySubcategory($category,$subcategory){
        $category=ProductCategory::where('slug',$subcategory)->first();
        $total_cat_id[]=$category->id;
        if($category->children()->exists()){
            foreach($category->children as $child){
                array_push($total_cat_id,$child->id);
            }
        }
        $products = Product::with('images')->whereIn('product_category_id', $total_cat_id)->whereIn('product_type', [2,3])->where('state',1)->where('sold',0)->inRandomOrder()->paginate(12);
        return view('product.ready_stock_product',compact('products','total_cat_id'));
    }

    public function  readyStockProductsBySubSubcategory($category,$subcategory,$subsubcategory){
        $category=ProductCategory::where('slug',$subsubcategory)->first();
        $products = Product::with('images')->where('product_category_id', $category->id)->whereIn('product_type', [2,3])->where('state',1)->where('sold',0)->inRandomOrder()->paginate(12);
        $total_cat_id[]=$category->id;
        return view('product.ready_stock_product',compact('products','total_cat_id'));
    }
    //end readystock products

    //customizable products
    public function customizable(Request $request)
    {
       // $products = Product::latest()->with('images')->where('customize', true)->where('business_profile_id', '!=', null)->where('state',1)->where('sold',0)->paginate(12);
        $product_category= ProductCategory::all();
        $price_id=[];
        $lead_time=[];
        if(isset($request->price_minimum_range) && isset($request->price_maximum_range)){
            $products = Product::latest()->with('images')->where('customize', true)->where('business_profile_id', '!=', null)->where('state',1)->where('sold',0)->paginate(32);
            foreach($products as $q){
                foreach(json_decode($q->attribute) as $price){
                    if (  $price[2] >= $request->price_minimum_range && $price[2] <= $request->price_maximum_range){
                        array_push($price_id, $q->id);
                    }
                }
            }

        }

        if(isset($request->lead_minimum_range) && isset($request->lead_maximum_range)){
            $products = Product::latest()->with('images')->where('customize', true)->where('business_profile_id', '!=', null)->where('state',1)->where('sold',0)->paginate(32);
            foreach($products as $q){
                foreach(json_decode($q->attribute) as $price){
                    if (  $price[3] >= $request->lead_minimum_range && $price[3] <= $request->lead_maximum_range){
                        array_push($lead_time, $q->id);
                    }
                }
            }

        }
        $products=Product::orderBy('priority_level', 'ASC')->orderBy('created_at', 'DESC')->with(['images','businessProfile','category'])->where('customize', true)->where('business_profile_id', '!=', null)->where('state',1)->where('sold',0)->where(function($query) use ($request,$price_id,$lead_time){

             if(isset($request->product_name)){
                 $query->where('name', 'like', '%'.$request->product_name.'%')->get();
             }
             if(isset($request->location)){
                 $query->whereHas('businessProfile', function ($sub_query) use ($request) {
                     $sub_query->where('location', $request->location);
                 })->get();
             }
             if(isset($request->product_category)){
                 $query->whereHas('category', function ($sub_query) use ($request) {
                     $sub_query->where('id', $request->product_category);
                 })->get();
             }
             if(isset($request->gender)){
                 $query->whereIn('gender', $request->gender)->get();
             }
             if(isset($request->sample_availability)){
                $query->whereIn('sample_availability', $request->sample_availability)->get();
            }
             if(isset($request->price_minimum_range) && isset($request->price_maximum_range)){
                $query->whereIn('id', $price_id)->get();
            }
            if(isset($request->lead_minimum_range) && isset($request->lead_maximum_range)){
                $query->whereIn('id', $lead_time)->get();
            }

         })->paginate(32);
        return view('product.customizable',compact('products','product_category'));
    }

   //start buy design products
    public function buyDesignsProducts(Request $request)
    {
        $product_category= ProductCategory::all();
        $price_id=[];
        $lead_time=[];
        if(isset($request->price_minimum_range) && isset($request->price_maximum_range)){
            $products = Product::latest()->with(['images','businessProfile','category'])->where('product_type', 1)->where('business_profile_id', '!=', null)->where('state',1)->where('sold',0)->paginate(32);
            foreach($products as $q){
                foreach(json_decode($q->attribute) as $price){
                    if (  $price[2] >= $request->price_minimum_range && $price[2] <= $request->price_maximum_range){
                        array_push($price_id, $q->id);
                    }
                }
            }

        }

        if(isset($request->lead_minimum_range) && isset($request->lead_maximum_range)){
            $products = Product::latest()->with(['images','businessProfile','category'])->where('product_type', 1)->where('business_profile_id', '!=', null)->where('state',1)->where('sold',0)->paginate(12);
            foreach($products as $q){
                foreach(json_decode($q->attribute) as $price){
                    if (  $price[3] >= $request->lead_minimum_range && $price[3] <= $request->lead_maximum_range){
                        array_push($lead_time, $q->id);
                    }
                }
            }

        }
        $products=Product::orderBy('priority_level', 'ASC')->orderBy('created_at', 'DESC')->with(['images','businessProfile','category'])->where('product_type', 1)->where('business_profile_id', '!=', null)->where('state',1)->where('sold',0)->where(function($query) use ($request,$price_id, $lead_time){

             if(isset($request->product_name)){
                 $query->where('name', 'like', '%'.$request->product_name.'%')->get();
             }
             if(isset($request->location)){
                 $query->whereHas('businessProfile', function ($sub_query) use ($request) {
                     $sub_query->where('location', $request->location);
                 })->get();
             }
             if(isset($request->product_category)){
                 $query->whereHas('category', function ($sub_query) use ($request) {
                     $sub_query->where('id', $request->product_category);
                 })->get();
             }
             if(isset($request->gender)){
                 $query->whereIn('gender', $request->gender)->get();
             }
             if(isset($request->sample_availability)){
                $query->whereIn('sample_availability', $request->sample_availability)->get();
            }
            if(isset($request->price_minimum_range) && isset($request->price_maximum_range)){

                $query->whereIn('id', $price_id)->get();
            }
            if(isset($request->lead_minimum_range) && isset($request->lead_maximum_range)){

                $query->whereIn('id', $lead_time)->get();
            }


         })->paginate(32);
        return view('product.buy_design_product',compact('products', 'product_category'));
    }

    public function buyDesignProductsByCategory($slug)
    {
        $category=ProductCategory::where('slug',$slug)->first();
        $total_cat_id[]=$category->id;
        if($category->children()->exists()){
            foreach($category->children as $child){
                array_push($total_cat_id,$child->id);
                if($child->children()->exists()){
                    foreach($child->children as $child2){
                        array_push($total_cat_id,$child2->id);
                    }
                }
            }
        }
        $products = Product::with('images')->whereIn('product_category_id', $total_cat_id)->where('product_type', 1)->where('state',1)->where('sold',0)->inRandomOrder()->paginate(12);
        return view('product.buy_design_product',compact('products','total_cat_id'));
    }
    public function  buyDesignProductsBySubcategory($category,$subcategory){
        $category=ProductCategory::where('slug',$subcategory)->first();
        $total_cat_id[]=$category->id;
        if($category->children()->exists()){
            foreach($category->children as $child){
                array_push($total_cat_id,$child->id);
            }
        }
        $products = Product::with('images')->whereIn('product_category_id', $total_cat_id)->where('product_type', 1)->where('state',1)->where('sold',0)->inRandomOrder()->paginate(12);
        return view('product.buy_design_product',compact('products','total_cat_id'));
    }
    public function  buyDesignProductsBySubSubcategory($category,$subcategory,$subsubcategory){
        $category=ProductCategory::where('slug',$subsubcategory)->first();
        $products = Product::with('images')->where('product_category_id', $category->id)->where('product_type', 1)->where('state',1)->where('sold',0)->inRandomOrder()->paginate(12);
        $total_cat_id[]=$category->id;
        return view('product.buy_design_product',compact('products','total_cat_id'));
    }
    //end buy design products
    public function vendorList()
    {
        $userIds=User::where('user_type','wholesaler')->pluck('id');
        $vendors = Vendor::with('user')->whereIn('user_id',$userIds)->paginate(12);
        return view('vendors',compact('vendors'));
    }

    public function productDetails($sku)
    {
        $category = ProductCategory::get();
        $product = Product::with('businessProfile','video')->where('sku',$sku)->first();
        $orderModificationRequest=OrderModificationRequest::where(['product_id' => $product->id, 'type' => 2, 'user_id' =>auth()->id() ])->get();
        $productReviews = ProductReview::where('product_id',$product->id)->get();
        $overallRating = 0;
        $communicationRating = 0;
        $ontimeDeliveryRating = 0;
        $sampleSupportRating = 0;
        $productQualityRating = 0;

        foreach($productReviews as $productReview){
            $overallRating = $productReview->overall_rating+$overallRating;
            $communicationRating = $productReview->communication_rating+$communicationRating;
            $ontimeDeliveryRating = $productReview->ontime_delivery_rating+$ontimeDeliveryRating;
            $sampleSupportRating = $productReview->sample_support_rating+$sampleSupportRating;
            $productQualityRating = $productReview->product_quality_rating+$productQualityRating;

        }
        $ratingSum = $overallRating+$communicationRating+$ontimeDeliveryRating+$sampleSupportRating+$productQualityRating;
        if(count($productReviews)==0){
            $averageRating=0;
        }
        else{
            $averageRating = $ratingSum / count($productReviews) ;
        }

        $averageRating = $averageRating/5;

        $productReviewExistsOrNot = ProductReview::where('created_by',auth()->id())->where('product_id',$product->id)->first();
        $colors_sizes = json_decode($product->colors_sizes);
        $attr = json_decode($product->attribute);
        //recommandiation products
        // $recommandProducts=Product::with(['images','businessProfile'])->where('business_profile_id', '!=', null)->where('state',1)
        // ->where('id','!=',$product->id)
        // ->whereHas('category', function($q) use ($product){
        //      $q->where('id',$product->product_category_id);

        // })
        // ->orWhere(function($query) use ($product){
        //     $query->where('product_type',$product->product_type)
        //           ->where('id', '!=', $product->id)
        //           ->where('business_profile_id', '!=', null);
        // })
        // ->whereHas('businessProfile', function($b){
        //     $b->where('deleted_at' , null);
        // })
        // ->get();
        $recommandProducts=Product::where('state',1)
            ->where('id','!=',$product->id)
            ->where('product_type', $product->product_type)
            ->with(['images','businessProfile'])
            ->inRandomOrder()
            ->limit(5)
            ->get();
         if(Auth()->check()){
             $wishListShopProductsIds=ProductWishlist::where('user_id' , auth()->user()->id)->where('product_id', '!=', null)->pluck('product_id')->toArray();
             $wishListMfProductsIds=ProductWishlist::where('user_id' , auth()->user()->id)->where('manufacture_product_id', '!=', null)->pluck('manufacture_product_id')->toArray();
         }
         else{
             $wishListShopProductsIds=[];
             $wishListMfProductsIds=[];
         }

         return view('product.details',compact('product','colors_sizes','attr','productReviewExistsOrNot','averageRating','orderModificationRequest','recommandProducts','wishListShopProductsIds','wishListMfProductsIds'));
    }

    public function sorting($value, $slug=null, $cat_id=null)
    {

      //home category wise product
      if($cat_id != 'null' && ($slug != 'buy-designs' && $slug != 'ready-stock') ){
                $cat_ids= explode(",", $cat_id);
                if($value == 'name'){
                    $products=Product::whereIn('product_category_id',$cat_ids)->orderBy($value)->where('state',1)->where('sold',0)->inRandomOrder()->paginate(12);
                }
                else{
                    $products=Product::whereIn('product_category_id',$cat_ids)->orderBy($value, 'desc')->where('state',1)->where('sold',0)->inRandomOrder()->paginate(12);
                }
        }
      //product type wise product
      if($cat_id == 'null' && ($slug == 'buy-designs' || $slug == 'ready-stock' ) ){
            $type= $slug == 'buy-designs' ? [1] : [2,3] ;
            if($value == 'name'){
                $products=Product::whereIn('product_type', $type)->orderBy($value)->where('state',1)->where('sold',0)->paginate(12);
            }
            else{
                $products=Product::whereIn('product_type', $type)->orderBy($value, 'desc')->where('state',1)->where('sold',0)->paginate(12);
            }

        }
      //product type plus category wise product
      if( $cat_id != 'null' && ($slug == 'buy-designs' || $slug == 'ready-stock') ){
            $type= $slug == 'buy-designs' ? [1] : [2,3];
            $cat_ids= explode(",", $cat_id);
            if($value == 'name'){
                $products=Product::whereIn('product_category_id',$cat_ids)->whereIn('product_type', $type)->orderBy($value)->where('state',1)->where('sold',0)->paginate(12);
            }
            else{
                $products=Product::whereIn('product_category_id',$cat_ids)->whereIn('product_type', $type)->orderBy($value, 'desc')->where('state',1)->where('sold',0)->paginate(12);
            }
        }

      $data=view('product._products_list',compact('products'))->render();
      return response()->json([
        'data' => $data,
      ],200);

    }
   //vendor sorting
   public function sortingVendor($value)
    {
        $userIds=User::where('user_type','wholesaler')->pluck('id');
        if($value == 'name'){
            $vendors = Vendor::with('user')->whereIn('user_id',$userIds)->orderBy('vendor_name')->paginate(12);
        }
        else{
            $vendors = Vendor::with('user')->whereIn('user_id',$userIds)->orderBy($value, 'desc')->paginate(12);
        }
        $data=view('include.partials._vendor_list',compact('vendors'))->render();

        return response()->json([
            'data' => $data,
        ],200);

    }

    public function liveSearchByProductOrVendor(Request $request){
        if(!empty($request->searchInput)) {
            if($request->selectedSearchOption=="all")
            {
                //$results=Product::with('images')->where('name', 'like', '%'.$request->searchInput.'%')->get();
                $wholesaler_products = Product::with(['images','businessProfile'])->where('name', 'like', '%'.$request->searchInput.'%')->where('business_profile_id', '!=', null)->get();
                $manufacture_products = ManufactureProduct::with(['product_images','businessProfile'])->where('title', 'like', '%'.$request->searchInput.'%')->where('business_profile_id', '!=', null)->get();
                //$blogs = Blog::where('title', 'like', '%'.$request->searchInput.'%')->get();
                $blogs = Blog::where('title', 'like', '%'.$request->searchInput.'%')->orWhere('details', 'like', '%'.$request->searchInput.'%')->get();
                $suppliers = BusinessProfile::with(['user'])->where('business_name', 'like', '%'.$request->searchInput.'%')->get();
                //$results = $wholesaler_products->merge($manufacture_products);

                $allItems = new \Illuminate\Database\Eloquent\Collection;
                $allItems = $allItems->merge($wholesaler_products);
                $allItems = $allItems->merge($manufacture_products);
                $allItems = $allItems->merge($blogs);
                $allItems = $allItems->merge($suppliers);
                //dd($allItems);

                //dd($results);
                //$averageRatings=[];
                //foreach($results as $result){
                //    array_push($averageRatings, productRating($result->id));
                //}


                $resultCount = count($allItems);
                return response()->json([
                    'data' => $allItems,
                    'datatype' => 'blog',
                    'resultCount'=>$resultCount,
                    //'averageRatings'=>$averageRatings,
                    'error' => 0,
                    'searchType' =>$request->selectedSearchOption,
                  ],200);
            }
            elseif($request->selectedSearchOption=="product")
            {
                //$results=Product::with('images')->where('name', 'like', '%'.$request->searchInput.'%')->get();
                $wholesaler_products = Product::with(['images','businessProfile'])->where('name', 'like', '%'.$request->searchInput.'%')->where('business_profile_id', '!=', null)->get();
                $manufacture_products = ManufactureProduct::with(['product_images','businessProfile'])->where('title', 'like', '%'.$request->searchInput.'%')->where('business_profile_id', '!=', null)->get();
                $results = $wholesaler_products->merge($manufacture_products);
                //dd($results);
                //$averageRatings=[];
                //foreach($results as $result){
                //    array_push($averageRatings, productRating($result->id));
                //}


                $resultCount = count($results);
                return response()->json([
                    'data' => $results,
                    'datatype' => 'product',
                    'resultCount'=>$resultCount,
                    //'averageRatings'=>$averageRatings,
                    'error' => 0,
                    'searchType' =>$request->selectedSearchOption,
                  ],200);
            }
            elseif($request->selectedSearchOption=="vendor")
            {
                //$results=Vendor::where('vendor_name', 'like', '%'.$request->searchInput.'%')->get();
                $results = BusinessProfile::where('business_name', 'like', '%'.$request->searchInput.'%')->get();
                $resultCount=count($results);
                return response()->json([
                    'data' => $results,
                    'datatype' => 'manufacturer',
                    'resultCount'=>$resultCount,
                    'error' => 0,
                    'searchType' =>$request->selectedSearchOption,
                    ],200);
            }
        }
        else
        {
            return response()->json([
                'data' => "No result found",
                'resultCount'=>0,
                'error' => 1,
                'searchType' =>$request->selectedSearchOption,
                ],200);
        }

    }

    public function searchByProductOrVendor(Request $request){
        $searchInputValue=$request->search_input;
        if(!empty($request->search_input)) {

            if($request->search_type=="product")
            {
                $wholesaler_products = Product::with(['images','businessProfile'])->where('name', 'like', '%'.$request->search_input.'%')->where('business_profile_id', '!=', null)->get();
                $manufacture_products = ManufactureProduct::with(['product_images','businessProfile'])->where('title', 'like', '%'.$request->search_input.'%')->where('business_profile_id', '!=', null)->get();
                $merged = $wholesaler_products->merge($manufacture_products);
                $page = Paginator::resolveCurrentPage() ?: 1;
                $perPage = 12;
                $low_moq_lists = new \Illuminate\Pagination\LengthAwarePaginator(
                    $merged->forPage($page, $perPage),
                    $merged->count(),
                    $perPage,
                    $page,
                    ['path' => Paginator::resolveCurrentPath()],
                );
                if(Auth()->check()){
                    $wishListShopProductsIds=ProductWishlist::where('user_id' , auth()->user()->id)->where('product_id', '!=', null)->pluck('product_id')->toArray();
                    $wishListMfProductsIds=ProductWishlist::where('user_id' , auth()->user()->id)->where('manufacture_product_id', '!=', null)->pluck('manufacture_product_id')->toArray();
                }
                else{
                    $wishListShopProductsIds=[];
                    $wishListMfProductsIds=[];
                }
                return view('product.low_moq',compact('low_moq_lists','searchInputValue','wishListShopProductsIds','wishListMfProductsIds'));
            }

            elseif($request->search_type=="vendor")
            {
                $suppliers=BusinessProfile::with(['businessCategory', 'user', 'companyOverview'])->where(function($query) use ($request){
                    if(isset($request->search_input)){
                        $query-> where('business_name', 'like', '%'.$request->search_input.'%')->get();
                    }
                })
                ->orderBy('is_business_profile_verified', 'DESC')->paginate(12);
                $business_name_from_home = $request->search_input;

                return view('suppliers.index',compact('suppliers','business_name_from_home'));
            }
            elseif($request->search_type=="all")
            {
                $wholesaler_products = Product::with(['images','businessProfile'])->where('name', 'like', '%'.$request->search_input.'%')->where('business_profile_id', '!=', null)->get();
                $manufacture_products = ManufactureProduct::with(['product_images','businessProfile'])->where('title', 'like', '%'.$request->search_input.'%')->where('business_profile_id', '!=', null)->get();
                $blogs = Blog::where('title', 'like', '%'.$request->search_input.'%')->get();
                $suppliers = BusinessProfile::with(['user'])->where('business_name', 'like', '%'.$request->search_input.'%')->get();

                $allItems = new \Illuminate\Database\Eloquent\Collection;
                $allItems = $allItems->merge($wholesaler_products);
                $allItems = $allItems->merge($manufacture_products);
                $allItems = $allItems->merge($blogs);
                $allItems = $allItems->merge($suppliers);
                $resultCount = count($allItems);
                return view('system_search',compact('allItems','searchInputValue'));
            }
            else
            {
                return redirect()->back();
            }
        }
        else
        {
            return redirect()->back();
        }

    }

   //filter search
   public function filterSearch(Request $request)
   {

      if($request->search_category_id){
          $home_page_cat_id= explode(",", $request->search_category_id);
          $products=Product::whereIn('product_category_id',$home_page_cat_id)->where('state',1)->where('sold',0)->get();
        }
      else{
          if($request->product_type== 1){
            $product_type=[1];
          }else{
            $product_type=[2,3];
          }

          if($request->product_type_category_id){
            $product_type_cat_id= explode(",", $request->product_type_category_id);
            $products=Product::whereIn('product_type',  $product_type)->whereIn('product_category_id',$product_type_cat_id)->where('state',1)->where('sold',0)->get();
          }
          else{
            $products=Product::whereIn('product_type', $product_type)->where('state',1)->where('sold',0)->get();
          }
      }

      $search_id=[];

      foreach($products as $product)
        {
          if(isset($product->colors_sizes))
            {
              foreach(json_decode($product->colors_sizes) as $color_attr)
                {
                    if(isset($request->color))
                    {
                        if(in_array($color_attr->color, $request->color)){
                            array_push($search_id, $product->id);
                        }
                    }
                    if (isset($request->size))
                    {
                        foreach($color_attr as $key=>$attr)
                        {
                            if(in_array($key, $request->size) && !empty($attr))
                            {
                               array_push($search_id,$product->id);
                            }
                        }
                    }

                }
            }

          if(isset($request->rating))
          {
             foreach($product->productReview as $review)
             {
                 if(in_array($review->average_rating, $request->rating))
                 {
                     array_push($search_id,$product->id);
                 }
             }
          }

          if(!empty($request->minimum_value) && !empty($request->maximum_value))
          {
            foreach(json_decode($product->attribute) as $price)
            {
              if (  $price[2] >= $request->minimum_value && $price[2] <= $request->maximum_value){
                  array_push($search_id,$product->id);
              }
            }
          }


        }

        $productList=Product::whereIn('id',array_unique($search_id))->paginate(12);
        $data=view('product._products_list',['products' => $productList])->with('products', $productList)->render();
        return response()->json([
               'success' => true,
               'data'    => $data,
        ],200);

    }

    public function blogs(){

        $blogs=Blog::latest()->paginate(12);
        return view('blog.index',compact('blogs'));

    }
    public function blogDetails($slug)
    {
        $blogList = Blog::latest()->orderBy('created_at', 'DESC')->paginate(5);

        $blog = Blog::where('slug',$slug)->firstOrFail();
        $data = [];

        $blogs = $blog->source;
        foreach((array)$blogs as $blo)
        {
            if(!is_null($blo['name']) && $blo['name'] != "")
            {
               $data[] = ['name' => $blo['name'],'link' => $blo['link']];
            }
        }

        $blog['sourcedata'] = $data;

        return view('blog.show', compact('blog', 'blogList'));
    }

    //suppliers
    public function suppliers(Request $request)
    {
        $suppliers = BusinessProfile::select('business_profiles.*')
            ->leftJoin('certifications', 'certifications.business_profile_id', '=', 'business_profiles.id')
            ->with(['businessCategory', 'user', 'companyOverview'])->where(function($query) use ($request){
            if($request->business_type){
                $query->whereIn('business_type',$request->business_type)->get();
            }
            // if($request->industry_type){
            //     $query->whereIn('industry_type',$request->industry_type)->get();
            // }
            if($request->factory_type){
                $query->whereIn('factory_type',$request->factory_type)->get();
            }
            // if($request->factory_type){
            //     $query->whereHas('businessCategory', function ($sub_query) use ($request) {
            //         $sub_query->where('id', $request->factory_type);
            //     })->get();
            // }
            if(isset($request->business_name)){
                $query-> where('business_name', 'like', '%'.$request->business_name.'%')->get();
            }
            if(isset($request->location)){
                $query-> where('location', 'like', '%'.$request->location.'%')->get();
            }
            if(isset($request->verified)){
                $query-> whereIn('is_business_profile_verified', $request->verified)->get();
            }
            if(isset($request->standard)){
                $target = array('compliance', 'non_compliance');
                if(count(array_intersect($request->standard, $target)) == count($target)){
                    $query->get();
                }else{

                    if(in_array('compliance', $request->standard)){
                        $query->has('certifications')->get();
                    }
                    if(in_array('non_compliance', $request->standard)){
                        $query->has('certifications', '<', 1)->get();
                    }
                }


            }
        })
        ->groupBy('business_profiles.id')
        ->orderBy('profile_verified_by_admin', 'desc')
        ->orderBy('certifications.created_at', 'desc')
        ->paginate(12);

        $suppliersCount = BusinessProfile::select('business_profiles.*')->get();

        $industry_type_cat= BusinessMappingTree::with('children.children')->where('parent_id', null)->get();
        $factory_type_cat=[];
        foreach($industry_type_cat as $data){
            if($data->children()->exists()){
                foreach($data->children as $data2){
                    if($data2->children()->exists()){
                        foreach($data2->children as $data3){
                            array_push($factory_type_cat, $data3->name);
                        }
                    }
                }
            }
        }
        $factory_type_cat= array_unique($factory_type_cat);
        return view('suppliers.index',compact('suppliers', 'suppliersCount', 'industry_type_cat', 'factory_type_cat'));
    }
    //supplier profile
    public function supplierProfile($alias)
    {
        $business_profile=BusinessProfile::where('alias',$alias)->firstOrFail();
        //manufacture
        // $flag=0;
        // if( $business_profile->companyOverview->about_company == null){
        //     $flag=1;
        // }
        // elseif( $business_profile->companyOverview->address == null ){
        //     $flag=1;
        // }
        // elseif($business_profile->companyOverview->factory_address  == null ){
        //     $flag=1;
        // }
        // else{
        //     foreach (json_decode($business_profile->companyOverview->data) as $company_overview){
        //         if($company_overview->value == null)
        //         {
        //             $flag=1;
        //             break;

        //         }

        //     }

        // }
        if($business_profile->business_type == 'manufacturer' )
        {

            $business_profile=BusinessProfile::with(['companyOverview','manufactureProducts.product_images','machineriesDetails','categoriesProduceds','productionCapacities','productionFlowAndManpowers','certifications','mainbuyers','exportDestinations.country','associationMemberships','pressHighlights','businessTerms','samplings','specialCustomizations','sustainabilityCommitments','walfare','security'])->where('alias',$alias)->firstOrFail();
            $userObj = User::where('id',$business_profile->user_id)->get();
            $companyFactoryTour=CompanyFactoryTour::with('companyFactoryTourImages','companyFactoryTourLargeImages')->where('business_profile_id',$business_profile->id)->first();
            $mainProducts=ManufactureProduct::with('product_images')->where('business_profile_id',$business_profile->id)->inRandomOrder()
            ->limit(4)
            ->get();
            // $businessVerification = BusinessProfileVerification::where('business_profile_id',$id)->first();
            // if($businessVerification){
            //     if( ($businessVerification->company_overview == 1) &&  ($businessVerification->capacity_and_machineries == 1) &&  ($businessVerification->business_terms == 1) &&  ($businessVerification->sampling == 1) &&  ($businessVerification->special_customizations == 1) &&  ($businessVerification->sustainability_commitments == 1) &&  ($businessVerification->production_capacity == 1) ){
            //         $flag = 0;
            //     }
            //     else{
            //         $flag = 1;

            //     }
            // }
            // else{
            //     $flag = 1;

            // }
            if( $business_profile->is_business_profile_verified == 1){
                $flag = 0;
            }
            else{
                $flag = 1;

            }



            return view('manufacture_profile_view_by_user.index',compact('business_profile','mainProducts','companyFactoryTour','userObj','flag'));
        }
        //wholesaler
        if($business_profile->business_type == 'wholesaler' )
        {
            $business_profile=BusinessProfile::with(['companyOverview','wholesalerProducts.images','machineriesDetails','categoriesProduceds','productionCapacities','productionFlowAndManpowers','certifications','mainbuyers','exportDestinations','associationMemberships','pressHighlights','businessTerms','samplings','specialCustomizations','sustainabilityCommitments','walfare','security'])->where('alias',$alias)->firstOrFail();
            $userObj = User::where('id',$business_profile->user_id)->get();
            $mainProducts=Product::with('images')->where('business_profile_id',$business_profile->id)->inRandomOrder()
            ->limit(4)
            ->get();
            // $businessVerification = BusinessProfileVerification::where('business_profile_id',$id)->first();
            // if($businessVerification){
            //     if( $businessVerification->company_overview == 1 ){
            //         $flag=0;
            //     }
            //     else{
            //         $flag=1;
            //     }
            // }
            // else{
            //     $flag=1;
            // }
            if( $business_profile->is_business_profile_verified == 1){
                $flag = 0;
            }
            else{
                $flag = 1;

            }
            return view('wholesaler_profile_view_by_user.index',compact('business_profile','mainProducts','userObj','flag'));
        }
    }
    //low moq
    public function lowMoqData(Request $request)
    {
        // $wholesaler_products=Product::with(['images','businessProfile'])->where('moq','!=', null)->where(['state' => 1, 'sold' => 0,])->where('business_profile_id', '!=', null)->get();
        // $manufacture_products=ManufactureProduct::with(['product_images','businessProfile'])->where('moq','!=', null)->where('business_profile_id', '!=', null)->get();
        // $merged = $wholesaler_products->merge($manufacture_products)->sortBy('moq');
        // $sorted=$merged->sortBy('moq');
        // $sorted_value= $sorted->values()->all();
        // return $sorted_value;
        //return view('product.low_moq',['products' => $sorted_value]);
        // $page=isset($request->page) ? $request->page : 1;
        // $collection=  $sorted->forPage($page,3);
        // return $collection;
    }

    public function lowMoq(Request $request)
    {
        $wholesaler_products=Product::with(['images','businessProfile'])->where('moq','!=', null)->where(['state' => 1, 'sold' => 0,])->where('business_profile_id', '!=', null)->get();
        $manufacture_products=ManufactureProduct::with(['product_images','businessProfile'])->where('moq','!=', null)->where('business_profile_id', '!=', null)->get();
        $merged = $wholesaler_products->mergeRecursive($manufacture_products)->sortBy([ ['priority_level', 'asc'], ['created_at', 'desc'] ])->values();

        if(isset($request->product_name)){
            $search=$request->product_name;
            $merged = $merged->filter(function($item) use ($search) {
                if($item->flag == 'mb'){
                    return stripos($item['title'],$search) !== false;
                }
                return stripos($item['name'],$search) !== false;
            });
        }
        if(isset($request->product_type)){
            $array=$request->product_type;
            if(in_array(2, $request->product_type)){
                array_push($array, '3');
            }
            $merged = $merged->whereIn('product_type', $array);
            $merged->all();
        }

        if(isset($request->location)){
            $search=$request->location;
            $merged = $merged->filter(function($item) use ($search) {
                    return stripos($item->businessProfile->location,$search) !== false;
            });
        }

        if(isset($request->product_category)){
            $merged = $merged->where('flag', 'shop')->where('product_category_id', $request->product_category);
            $merged->all();
        }

        if(isset($request->factory_category)){
            $merged = $merged->where('flag', 'mb')->where('product_category', $request->factory_category);
            $merged->all();
        }

        if(isset($request->lead_minimum_range) &&  isset($request->lead_maximum_range)){

            $merged = $merged->where('flag', 'mb')->whereBetween('lead_time', [$request->lead_minimum_range, $request->lead_maximum_range]);
            $merged->all();
        }

        if(isset($request->price_minimum_range) &&  isset($request->price_maximum_range)){
            $price_id=[];
            foreach($merged as $product){
                if($product->flag == 'shop' && isset($product->attribute)){
                    foreach(json_decode($product->attribute) as $price)
                    {
                        if (  $price[2] >= $request->price_minimum_range && $price[2] <= $request->price_maximum_range){
                            array_push($price_id,$product->id);
                        }
                    }
                }
            }
            $merged = $merged->where('flag', 'shop')->whereIn('id', $price_id);
            $merged->all();

        }

        if(isset($request->gender)){

            $merged = $merged->whereIn('gender', $request->gender);
            $merged->all();
        }

        if(isset($request->sample_availability)){

            $merged = $merged->whereIn('sample_availability', $request->sample_availability);
            $merged->all();
        }

        $page = Paginator::resolveCurrentPage() ?: 1;
        $perPage = 32;
        $low_moq_lists = new \Illuminate\Pagination\LengthAwarePaginator(
            $merged->forPage($page, $perPage),
            $merged->count(),
            $perPage,
            $page,
            ['path' => Paginator::resolveCurrentPath()],
        );
        if(Auth()->check()){
            $wishListShopProductsIds=ProductWishlist::where('user_id' , auth()->user()->id)->where('product_id', '!=', null)->pluck('product_id')->toArray();
            $wishListMfProductsIds=ProductWishlist::where('user_id' , auth()->user()->id)->where('manufacture_product_id', '!=', null)->pluck('manufacture_product_id')->toArray();
        }
        else{
            $wishListShopProductsIds=[];
            $wishListMfProductsIds=[];
        }
        return view('product.low_moq',compact('low_moq_lists','wishListShopProductsIds','wishListMfProductsIds'));
    }
    //low moq details
    public function mixProductDetails($flag, $id)
    {
        if($flag == 'mb'){
            $product = ManufactureProduct::with('product_images','businessProfile','product_video')->findOrFail($id);
            $supplierCompanyInfo = BusinessProfile::with(['companyOverview', 'certifications'])->where('id', $product['businessProfile']->id)->first();
            //dd($supplierCompanyInfo);
            return view('product.manufactrue_product_details',compact('product', 'supplierCompanyInfo'));
        }
        else if($flag == 'shop'){

            $product = Product::with('businessProfile')->where('id',$id)->first();
            //$supplierCompanyInfo = CompanyOverview::where('business_profile_id', $product['businessProfile']->id)->first();
            $supplierCompanyInfo = BusinessProfile::with(['companyOverview', 'certifications'])->where('id', $product['businessProfile']->id)->first();
            //dd($supplierCompanyInfo->certifications);

            $orderModificationRequest=OrderModificationRequest::where(['product_id' => $product->id, 'type' => 2, 'user_id' =>auth()->id() ])->get();
            $productReviews = ProductReview::where('product_id',$product->id)->get();
            $overallRating = 0;
            $communicationRating = 0;
            $ontimeDeliveryRating = 0;
            $sampleSupportRating = 0;
            $productQualityRating = 0;

            foreach($productReviews as $productReview){
                $overallRating = $productReview->overall_rating+$overallRating;
                $communicationRating = $productReview->communication_rating+$communicationRating;
                $ontimeDeliveryRating = $productReview->ontime_delivery_rating+$ontimeDeliveryRating;
                $sampleSupportRating = $productReview->sample_support_rating+$sampleSupportRating;
                $productQualityRating = $productReview->product_quality_rating+$productQualityRating;

            }
            $ratingSum = $overallRating+$communicationRating+$ontimeDeliveryRating+$sampleSupportRating+$productQualityRating;
            if(count($productReviews)==0){
                $averageRating=0;
            }
            else{
                $averageRating = $ratingSum / count($productReviews) ;
            }

            $averageRating = $averageRating/5;

            $productReviewExistsOrNot = ProductReview::where('created_by',auth()->id())->where('product_id',$product->id)->first();
            $colors_sizes = json_decode($product->colors_sizes);
            $attr = json_decode($product->attribute);
            //recommandiation products
            //$product_tag=$product->product_tag ?? [];
            // $recommandProducts=Product::where('state',1)
            // ->where('id','!=',$product->id)
            // ->whereIn('product_tag', $product_tag)

            // ->whereHas('category', function($q) use ($product){
            //      $q->where('id',$product->product_category_id);

            // })
            // ->orWhere(function($query) use ($product){
            //     $query->where('product_type',$product->product_type)
            //           ->where('id', '!=', $product->id);
            // })
            // ->with(['images','businessProfile'])
            // ->limit(10)
            // ->get();
        //    $recommandProducts= Product::where('state',1)
        //    ->where('id','!=',$product->id)
        //    ->cursor()->filter(function($item) use ($product_tag){
        //         if(isset($item->product_tag) && array_intersect($item->product_tag, $product_tag)){
        //             return true;
        //         }
        //         return false;

        //     });
        $recommandProducts=Product::where('state',1)
            ->where('id','!=',$product->id)
            ->where('product_type', $product->product_type)
            ->with(['images','businessProfile'])
            ->inRandomOrder()
            ->limit(5)
            ->get();

            if(Auth()->check()){
                $wishListShopProductsIds=ProductWishlist::where('user_id' , auth()->user()->id)->where('product_id', '!=', null)->pluck('product_id')->toArray();
                $wishListMfProductsIds=ProductWishlist::where('user_id' , auth()->user()->id)->where('manufacture_product_id', '!=', null)->pluck('manufacture_product_id')->toArray();
            }
            else{
                $wishListShopProductsIds=[];
                $wishListMfProductsIds=[];
            }

            return view('product.details',compact('product','colors_sizes','attr','productReviewExistsOrNot','averageRating','orderModificationRequest','recommandProducts','wishListShopProductsIds','wishListMfProductsIds', 'supplierCompanyInfo'));
        }
    }
    //shortest lead time
    public function shortestLeadTime(Request $request)
    {
        $product_category= ManufatureProductCategeory::all();
        $location_id=[];
        if(isset($request->location)){
            $products=ManufactureProduct::latest()->with(['product_images','businessProfile','category'])->where('lead_time','!=', null)->where('business_profile_id', '!=', null)->get();
            foreach($products as $p){
                if($p->businessProfile->location == $request->location){
                    array_push($location_id,$p->id);
                }
            }
         }
        $products=ManufactureProduct::orderBy('priority_level', 'ASC')->orderBy('created_at', 'DESC')->with(['product_images','businessProfile','category'])->where('lead_time','!=', null)->where('business_profile_id', '!=', null)->where(function($query) use ($request, $location_id){

             if(isset($request->product_name)){
                 $query->where('title', 'like', '%'.$request->product_name.'%')->get();
             }
             if(isset($request->location)){
                $query->whereIn('id',$location_id)->get();
             }
             if(isset($request->product_category)){
                 $query->whereHas('category', function ($sub_query) use ($request) {
                     $sub_query->where('id', $request->product_category);
                 })->get();
             }
             if(isset($request->gender)){
                 $query->whereIn('gender', $request->gender)->get();
             }
             if(isset($request->sample_availability)){
                $query->whereIn('sample_availability', $request->sample_availability)->get();
            }
            if(isset($request->price_minimum_range) && isset($request->price_maximum_range)){
                $query->whereBetween('price_per_unit', [$request->price_minimum_range,$request->price_maximum_range])->get();

            }
            if(isset($request->lead_minimum_range) && isset($request->lead_maximum_range)){
                $query->whereBetween('lead_time', [$request->lead_minimum_range,$request->lead_maximum_range])->get();
            }


         })->paginate(32);
         //return $products;
        return view('product.shortest_lead_time',compact('products', 'product_category'));
    }

    public function studio3dPage(){
        return view('studio.index');
    }

    public function toolsLandingPage(){
        return view('tools.index');
    }

    public function policyLandingPage(){
        return view('policy.index');
    }

    public function aboutusLandingPage(){
        return view('aboutus.index');
    }
    public function howweworkLandingPage(){
        return view('howwework.index');
    }

    public function contactusLandingPage(){
        return view('contactus.index');
    }

    public function rfqPostSuccessfulByAnonymous(){
        return view('rfq_post_success_by_anonymous');
    }

    public function faqLandingPage(){
        return view('faq.index');
    }

    public function rfqInfoDetails(){
        return view('new_rfq.index');
    }

    // get supplier location data
    public function getSupplierLocationData(Request $request)
    {
        $data = BusinessProfile::select("location")
        ->where("location","LIKE","%{$request->get('query')}%")
        ->get();
        $modify=[];
        foreach($data as $d){
            $modify[] = $d->location;
        }
        return response()->json($modify);
    }

    public function selectedBuyerDetails(Request $request)
    {
        $userObj = User::where('id', $request->selectedUserId)->get();
        return response()->json(["status" => 1, "message" => "Success", "data" => $userObj]);
    }

    public function productTypeMapping(Request $request, $type, $child)
    {
        switch($type) {
            case('studio'):
                $product_type_mapping_id=1;
                break;
            case('raw_materials'):
                $product_type_mapping_id=2;
                break;
            default:
                $product_type_mapping_id=null;
        }
        $user = auth()->user();

        $product_type_mapping_child_id=ProductTypeMapping::select('id')->where('title',$child)->first();

        if(empty($product_type_mapping_id) || empty($product_type_mapping_child_id)){
            abort(404);
        }

        $product_type_mapping_child_id =  $product_type_mapping_child_id->id;

        if($user && $user->is_request_verified == 1) // show all products for verified user.
        {
            $wholesaler_products=Product::with(['images','businessProfile'])->where('product_type_mapping_id', $product_type_mapping_id)->where(['state' => 1])->where('business_profile_id', '!=', null)->get();
            $manufacture_products=ManufactureProduct::with(['product_images','businessProfile'])->where('product_type_mapping_id', $product_type_mapping_id)->where('business_profile_id', '!=', null)->get();
            $merged = $wholesaler_products->mergeRecursive($manufacture_products)->sortBy([ ['priority_level', 'asc'], ['created_at', 'desc'] ])->values();
        }
        else
        {
            $wholesaler_products=Product::with(['images','businessProfile'])->where('product_type_mapping_id', $product_type_mapping_id)->where(['state' => 1])->where(['free_to_show' => 1])->where('business_profile_id', '!=', null)->get();
            $manufacture_products=ManufactureProduct::with(['product_images','businessProfile'])->where('product_type_mapping_id', $product_type_mapping_id)->where(['free_to_show' => 1])->where('business_profile_id', '!=', null)->get();
            $merged = $wholesaler_products->mergeRecursive($manufacture_products)->sortBy([ ['priority_level', 'asc'], ['created_at', 'desc'] ])->values();
        }

        $merged = $merged->filter(function($item) use ($product_type_mapping_child_id) {
                    $result=array_intersect($item->product_type_mapping_child_id,(array)$product_type_mapping_child_id);
                    if(count($result) > 0){
                        return true;
                    }

        });

        if(isset($request->product_name)){
            $search=$request->product_name;
            $merged = $merged->filter(function($item) use ($search) {
                if($item->flag == 'mb'){
                    return stripos($item['title'],$search) !== false;
                }
                return stripos($item['name'],$search) !== false;
            });
        }
        if(isset($request->product_type)){
            $array=$request->product_type;
            if(in_array(2, $request->product_type)){
                array_push($array, '3');
            }
            $merged = $merged->whereIn('product_type', $array);
            $merged->all();
        }

        if(isset($request->location)){
            $search=$request->location;
            $merged = $merged->filter(function($item) use ($search) {
                    return stripos($item->businessProfile->location,$search) !== false;
            });
        }

        if(isset($request->product_category)){
            $merged = $merged->where('flag', 'shop')->where('product_category_id', $request->product_category);
            $merged->all();
        }

        if(isset($request->factory_category)){
            $merged = $merged->where('flag', 'mb')->where('product_category', $request->factory_category);
            $merged->all();
        }

        if(isset($request->lead_minimum_range) &&  isset($request->lead_maximum_range)){

            $merged = $merged->where('flag', 'mb')->whereBetween('lead_time', [$request->lead_minimum_range, $request->lead_maximum_range]);
            $merged->all();
        }

        if(isset($request->price_minimum_range) &&  isset($request->price_maximum_range)){
            $price_id=[];
            foreach($merged as $product){
                if($product->flag == 'shop' && isset($product->attribute)){
                    foreach(json_decode($product->attribute) as $price)
                    {
                        if (  $price[2] >= $request->price_minimum_range && $price[2] <= $request->price_maximum_range){
                            array_push($price_id,$product->id);
                        }
                    }
                }
            }
            $merged = $merged->where('flag', 'shop')->whereIn('id', $price_id);
            $merged->all();

        }

        if(isset($request->gender)){

            $merged = $merged->whereIn('gender', $request->gender);
            $merged->all();
        }

        if(isset($request->sample_availability)){

            $merged = $merged->whereIn('sample_availability', $request->sample_availability);
            $merged->all();
        }



        $page = Paginator::resolveCurrentPage() ?: 1;
        $perPage = 32;
        $products = new \Illuminate\Pagination\LengthAwarePaginator(
            $merged->forPage($page, $perPage),
            $merged->count(),
            $perPage,
            $page,
            ['path' => Paginator::resolveCurrentPath()],
        );

        if(Auth()->check()){
            $wishListShopProductsIds=ProductWishlist::where('user_id' , auth()->user()->id)->where('product_id', '!=', null)->pluck('product_id')->toArray();
            $wishListMfProductsIds=ProductWishlist::where('user_id' , auth()->user()->id)->where('manufacture_product_id', '!=', null)->pluck('manufacture_product_id')->toArray();
        }
        else{
            $wishListShopProductsIds=[];
            $wishListMfProductsIds=[];
        }
        return view('product.all_products',compact('products','wishListShopProductsIds','wishListMfProductsIds', 'user'));

    }

    public function getRequestFromUserForVerification(Request $request) {

        $user = User::where("id", $request->id)->first();
        $user->is_request_verified = 0;
        $user->save();

        return response()->json(["status"=>1, "message"=>"successful"]);

    }

    public function showSiteMap()
    {
        return view('sitemap.index');
    }

    public function supplyChainLandingPage()
    {
        return view('supply_chain.index');
    }

    public function pricingPlan()
    {
        $trialPeiodStartDate = Carbon::now()->format('F j, Y');
        $trialPeiodEndDate = Carbon::now()->addDays(30)->format('F j, Y');

        $trialPeiodStartDateNonFormate = Carbon::now();
        $trialPeiodEndDateNonFormate = Carbon::now()->addDays(30);

        return view('pricingplan.index', compact('trialPeiodStartDate', 'trialPeiodEndDate', 'trialPeiodStartDateNonFormate', 'trialPeiodEndDateNonFormate'));
    }

    public function pricingPlanForm()
    {
        $trialPeiodStartDate = Carbon::now()->format('F j, Y');
        $trialPeiodEndDate = Carbon::now()->addDays(30)->format('F j, Y');

        $trialPeiodStartDateNonFormate = Carbon::now();
        $trialPeiodEndDateNonFormate = Carbon::now()->addDays(30);

        return view('pricingplan.form', compact('trialPeiodStartDate', 'trialPeiodEndDate', 'trialPeiodStartDateNonFormate', 'trialPeiodEndDateNonFormate'));
    }
}
