<?php

namespace App\Http\Controllers\Api\User;

use DB;
use Image;
use Helper;
use stdClass;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Product;
use App\Rules\MoqUnitRule;
use Illuminate\Support\Str;
use App\Models\ProductImage;
use App\Models\ProductVideo;
use Illuminate\Http\Request;
use App\Models\RelatedProduct;
use App\Models\BusinessProfile;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use App\Rules\ReadyStockFullStockRule;
use App\Rules\NonClothingFullStockRule;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Rules\ReadyStockPriceBreakDownRule;
use App\Rules\NonClothingPriceBreakDownRule;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Manufacture\Product as ManufactureProduct;
use App\Models\ProductTag;


class ProductController extends Controller
{
    public function index($businessProfileId){

        $products=Product::with('images','productReview')->where('business_profile_id',$businessProfileId)->where('state',1)->where('sold',0)->paginate(20);
        $productsArray=[];
        if($products->total()>0){
            foreach($products as $product){

                if($product->product_type==1 ){
                    foreach(json_decode($product->attribute) as $attribute){
                        $attribute_array[] = (object) array('quantity_min' =>$attribute[0], 'quantity_max' => $attribute[1],'price'=>$attribute[2],'lead_time'=>$attribute[3]);
                    }
                }else{
                    foreach(json_decode($product->attribute) as $attribute){
                        $attribute_array[] = (object) array('ready_quantity_min' =>$attribute[0], 'ready_quantity_max' => $attribute[1],'ready_price'=>$attribute[2]);
                    }
                }

                $newFormatedProduct= new stdClass();
                $newFormatedProduct->id=$product->id;
                $newFormatedProduct->name=$product->name;
                $newFormatedProduct->business_profile_id=$product->business_profile_id;
                $newFormatedProduct->business_name=$product->businessProfile->business_name;
                $newFormatedProduct->sku=$product->sku;
                $newFormatedProduct->copyright_price=$product->copyright_price;
                $newFormatedProduct->full_stock= $product->full_stock;
                $newFormatedProduct->full_stock_price= $product->full_stock_price;
                $newFormatedProduct->attribute=  $attribute_array;
                $newFormatedProduct->colors_sizes=$product->product_type==1 ? [] : json_decode($product->colors_sizes);
                $newFormatedProduct->product_category_id=$product->product_category_id;
                $newFormatedProduct->product_type=$product->product_type;
                $newFormatedProduct->moq=$product->moq;
                $newFormatedProduct->product_unit=$product->product_unit;
                $newFormatedProduct->is_new_arrival=$product->is_new_arrival;
                $newFormatedProduct->is_featured=$product->is_featured;
                $newFormatedProduct->description=$product->description;
                $newFormatedProduct->state= $product->state;
                $newFormatedProduct->sold= $product->sold;
                $newFormatedProduct->additional_description=$product->additional_description;
                $newFormatedProduct->availability=$product->availability;
                $newFormatedProduct->images=$product->images;
                $newFormatedProduct->gender=$product->gender;
                $newFormatedProduct->sample_availability=$product->sample_availability;
                $newFormatedProduct->overlay_small_image=$product->overlay_small_image;
                $newFormatedProduct->overlay_original_image=$product->overlay_original_image;
                $newFormatedProduct->productReviews=$product->productReview;
                $newFormatedProduct->productTotalAverageRating=productRating($product->id);
                array_push($productsArray,$newFormatedProduct);
                $attribute_array=[];

            }


        }
        if(count($productsArray)>0){
            return response()->json(array('success' => true, 'product' => $productsArray),200);

        }
        else{
            return response()->json(array('success' => false, 'product' => $productsArray,'message' => "No products found"),200);
        }
    }

    public function productList($storeId){

        $products=Product::where('vendor_id',$storeId)->where('state',1)->where('sold',0)->get();
        $productsArray=[];
        if(count($products)>0){
            foreach($products as $product){

                $newFormatedProduct= new stdClass();
                $newFormatedProduct->id=$product->id;
                $newFormatedProduct->name=$product->name;
                array_push($productsArray,$newFormatedProduct);

            }

        }
        if(count($productsArray)>0){
            return response()->json(array('success' => true, 'products' => $productsArray),200);
        }
        else{
            return response()->json(array('success' => false, 'products' => $productsArray,'message' => "No products found"),200);
        }

    }

    public function readyStockProducts(){

        $readyStockProducts=Product::with('images','productReview')->where('business_profile_id', '!=', null)->whereIn('product_type',[2,3])->where('state',1)->where('sold',0)->paginate(9);
        $readyStockProductsArray=[];
        if($readyStockProducts->total()>0){
            foreach($readyStockProducts as $product){
                if($product->product_type==2){

                    foreach(json_decode($product->attribute) as $attribute){
                        $attribute_array[] = (object) array('ready_quantity_min' =>$attribute[0], 'ready_quantity_max' => $attribute[1],'ready_price'=>$attribute[2]);
                    }

                }
                else{

                    foreach(json_decode($product->attribute) as $attribute){

                        $attribute_array[] = (object) array('non_clothing_quantity_min' =>$attribute[0], 'non_clothing_quantity_max' => $attribute[1],'non_clothing_price'=>$attribute[2]);
                    }
                }

                $newFormatedProduct= new stdClass();
                $newFormatedProduct->id=$product->id;
                $newFormatedProduct->name=$product->name;
                $newFormatedProduct->business_profile_id=$product->business_profile_id;
                $newFormatedProduct->business_name=$product->businessProfile->business_name;
                $newFormatedProduct->sku=$product->sku;
                $newFormatedProduct->copyright_price=$product->copyright_price;
                $newFormatedProduct->full_stock= $product->full_stock;
                $newFormatedProduct->full_stock_price= $product->full_stock_price;
                $newFormatedProduct->attribute=  $attribute_array;
                $newFormatedProduct->colors_sizes=json_decode($product->colors_sizes);
                $newFormatedProduct->product_category_id=$product->product_category_id;
                $newFormatedProduct->product_type=$product->product_type;
                $newFormatedProduct->moq=$product->moq;
                $newFormatedProduct->product_unit=$product->product_unit;
                $newFormatedProduct->is_new_arrival=$product->is_new_arrival;
                $newFormatedProduct->is_featured=$product->is_featured;
                $newFormatedProduct->description=$product->description;
                $newFormatedProduct->state= $product->state;
                $newFormatedProduct->sold= $product->sold;
                $newFormatedProduct->additional_description=$product->additional_description;
                $newFormatedProduct->availability=$product->availability;
                $newFormatedProduct->images=$product->images;
                $newFormatedProduct->productReviews=$product->productReview;
                $newFormatedProduct->productTotalAverageRating=productRating($product->id);
                array_push($readyStockProductsArray,$newFormatedProduct);
                $attribute_array=[];

            }

        }
        if(count($readyStockProductsArray)>0){
            return response()->json(array('success' => true, 'products' => $readyStockProductsArray),200);
        }
        else{
            return response()->json(array('success' => false,'products' => $readyStockProductsArray, 'message' => "No products found"),200);
        }
    }

    public function buyDesignProducts(){

        $buyDesignProducts=Product::with('images','productReview')->where('business_profile_id', '!=', null)->where('product_type',1)->where('state',1)->where('sold',0)->paginate(9);
        $buyDesignProductsArray=[];
        if($buyDesignProducts->total()>0){
            foreach($buyDesignProducts as $product){

                foreach(json_decode($product->attribute) as $attribute){
                    $attribute_array[] = (object) array('quantity_min' =>$attribute[0], 'quantity_max' => $attribute[1],'price'=>$attribute[2],'lead_time'=>$attribute[3]);
                }
                $newFormatedProduct= new stdClass();

                $newFormatedProduct->id=$product->id;
                $newFormatedProduct->name=$product->name;
                $newFormatedProduct->business_profile_id=$product->business_profile_id;
                $newFormatedProduct->business_name=$product->businessProfile->business_name;
                $newFormatedProduct->sku=$product->sku;
                $newFormatedProduct->copyright_price=$product->copyright_price;
                $newFormatedProduct->full_stock= $product->full_stock;
                $newFormatedProduct->full_stock_price= $product->full_stock_price;
                $newFormatedProduct->attribute=  $attribute_array;
                $newFormatedProduct->colors_sizes=$product->product_type==1 ? [] :json_decode($product->colors_sizes);
                $newFormatedProduct->product_category_id=$product->product_category_id;
                $newFormatedProduct->product_type=$product->product_type;
                $newFormatedProduct->moq=$product->moq;
                $newFormatedProduct->product_unit=$product->product_unit;
                $newFormatedProduct->is_new_arrival=$product->is_new_arrival;
                $newFormatedProduct->is_featured=$product->is_featured;
                $newFormatedProduct->description=$product->description;
                $newFormatedProduct->state= $product->state;
                $newFormatedProduct->sold= $product->sold;
                $newFormatedProduct->additional_description=$product->additional_description;
                $newFormatedProduct->availability=$product->availability;
                $newFormatedProduct->images=$product->images;
                $newFormatedProduct->productReviews=$product->productReview;
                $newFormatedProduct->productTotalAverageRating=productRating($product->id);
                array_push($buyDesignProductsArray,$newFormatedProduct);
                $attribute_array=[];

            }
        }

        if(count($buyDesignProductsArray)>0){
            return response()->json(array('success' => true, 'products' => $buyDesignProductsArray),200);
        }
        else{
            return response()->json(array('success' => false, 'products' => $buyDesignProductsArray,'message' => "No products found"),200);
        }
    }


    public function nonClothingProducts(){

        $nonClothingProducts=Product::with('images','productReview')->where('business_profile_id', '!=', null)->where('product_type',3)->where('state',1)->where('sold',0)->paginate(9);
        $nonClothingProductsArray=[];
        if($nonClothingProducts->total()>0){
            foreach($nonClothingProducts as $product){

                foreach(json_decode($product->attribute) as $attribute){
                    $attribute_array[] = (object) array('non_clothing_quantity_min' =>$attribute[0], 'non_clothing_quantity_max' => $attribute[1],'non_clothing_price'=>$attribute[2]);
                }
                $newFormatedProduct= new stdClass();

                $newFormatedProduct->id=$product->id;
                $newFormatedProduct->name=$product->name;
                $newFormatedProduct->business_profile_id=$product->business_profile_id;
                $newFormatedProduct->business_name=$product->businessProfile->business_name;
                $newFormatedProduct->sku=$product->sku;
                $newFormatedProduct->copyright_price=$product->copyright_price;
                $newFormatedProduct->full_stock= $product->full_stock;
                $newFormatedProduct->full_stock_price= $product->full_stock_price;
                $newFormatedProduct->attribute=  $attribute_array;
                $newFormatedProduct->colors_sizes=$product->product_type==1 ? [] :json_decode($product->colors_sizes);
                $newFormatedProduct->product_category_id=$product->product_category_id;
                $newFormatedProduct->product_type=$product->product_type;
                $newFormatedProduct->moq=$product->moq;
                $newFormatedProduct->product_unit=$product->product_unit;
                $newFormatedProduct->is_new_arrival=$product->is_new_arrival;
                $newFormatedProduct->is_featured=$product->is_featured;
                $newFormatedProduct->description=$product->description;
                $newFormatedProduct->state= $product->state;
                $newFormatedProduct->sold= $product->sold;
                $newFormatedProduct->additional_description=$product->additional_description;
                $newFormatedProduct->availability=$product->availability;
                $newFormatedProduct->images=$product->images;
                $newFormatedProduct->productReviews=$product->productReview;
                $newFormatedProduct->productTotalAverageRating=productRating($product->id);
                array_push($nonClothingProductsArray,$newFormatedProduct);
                $attribute_array=[];
            }
        }

        if(count($nonClothingProductsArray)>0){
            return response()->json(array('success' => true, 'products' => $nonClothingProductsArray),200);
        }
        else{
            return response()->json(array('success' => false, 'products' => $nonClothingProductsArray,'message' => "No products found"),200);
        }
    }

    public function show($storeId,$productId){

        $product = Product::with('images','productReview')->where('id',$productId)->where('vendor_id',$storeId)->where('state',1)->where('sold',0)->first();

        if($product){

            if($product->product_type==1 ){
                foreach(json_decode($product->attribute) as $attribute){
                    $attribute_array[] = (object) array('quantity_min' =>$attribute[0], 'quantity_max' => $attribute[1],'price'=>$attribute[2],'lead_time'=>$attribute[3]);
                }
            }
            else if($product->product_type==2){
                foreach(json_decode($product->attribute) as $attribute){
                    $attribute_array[] = (object) array('ready_quantity_min' =>$attribute[0], 'ready_quantity_max' => $attribute[1],'ready_price'=>$attribute[2]);
                }
            }
            else{
                foreach(json_decode($product->attribute) as $attribute){
                    $attribute_array[] = (object) array('non_clothing_quantity_min' =>$attribute[0], 'non_clothing_quantity_max' => $attribute[1],'non_clothing_price'=>$attribute[2]);
                }

            }


            $newFormatedProduct= new stdClass();
            $newFormatedProduct->id=$product->id;
            $newFormatedProduct->name=$product->name;
            $newFormatedProduct->business_profile_id=$product->business_profile_id;
            $newFormatedProduct->business_name=$product->businessProfile->business_name;
            $newFormatedProduct->sku=$product->sku;
            $newFormatedProduct->copyright_price=$product->copyright_price;
            $newFormatedProduct->full_stock= $product->full_stock;
            $newFormatedProduct->full_stock_price= $product->full_stock_price;
            $newFormatedProduct->attribute=  $attribute_array;
            $newFormatedProduct->colors_sizes=$product->product_type==1 ? [] :json_decode($product->colors_sizes);
            $newFormatedProduct->product_category_id=$product->product_category_id;
            $newFormatedProduct->product_type=$product->product_type;
            $newFormatedProduct->moq=$product->moq;
            $newFormatedProduct->product_unit=$product->product_unit;
            $newFormatedProduct->is_new_arrival=$product->is_new_arrival;
            $newFormatedProduct->is_featured=$product->is_featured;
            $newFormatedProduct->description=$product->description;
            $newFormatedProduct->state= $product->state;
            $newFormatedProduct->sold= $product->sold;
            $newFormatedProduct->additional_description=$product->additional_description;
            $newFormatedProduct->availability=$product->availability;
            $newFormatedProduct->productReview=$product->productReview;
            $newFormatedProduct->productTotalAverageRating=productRating($product->id);
            $newFormatedProduct->images=$product->images;


        }


        if(isset($newFormatedProduct)){
            return response()->json(array('success' => true, 'product' => $newFormatedProduct),200);
        }
        else{
            return response()->json(array('success' => false, 'message' => "No products found"),200);
        }

    }



    public function productById($productId){

        $product = Product::with('images','productReview')->where('business_profile_id', '!=', null)->where('id',$productId)->where('state',1)->where('sold',0)->first();

        if($product){

            if($product->product_type==1 ){
                foreach(json_decode($product->attribute) as $attribute){
                    $attribute_array[] = (object) array('quantity_min' =>$attribute[0], 'quantity_max' => $attribute[1],'price'=>$attribute[2],'lead_time'=>$attribute[3]);
                }
            }else if($product->product_type==2 ){
                foreach(json_decode($product->attribute) as $attribute){
                    $attribute_array[] = (object) array('ready_quantity_min' =>$attribute[0], 'ready_quantity_max' => $attribute[1],'ready_price'=>$attribute[2]);
                }
            }
             else{
                foreach(json_decode($product->attribute) as $attribute){
                    $attribute_array[] = (object) array('non_clothing_quantity_min' =>$attribute[0], 'non_clothing_quantity_max' => $attribute[1],'non_clothing_price'=>$attribute[2]);
                }

            }


            $newFormatedProduct= new stdClass();
            $newFormatedProduct->id=$product->id;
            $newFormatedProduct->name=$product->name;
            $newFormatedProduct->business_profile_id=$product->business_profile_id;
            $newFormatedProduct->business_name=$product->businessProfile->business_name;
            $newFormatedProduct->sku=$product->sku;
            $newFormatedProduct->copyright_price=$product->copyright_price;
            $newFormatedProduct->full_stock= $product->full_stock;
            $newFormatedProduct->full_stock_price= $product->full_stock_price;
            $newFormatedProduct->attribute=  $attribute_array;
            $newFormatedProduct->colors_sizes=$product->product_type==1 ? [] :json_decode($product->colors_sizes);
            $newFormatedProduct->product_category_id=$product->product_category_id;
            $newFormatedProduct->product_category_name=$product->category->name;
            $newFormatedProduct->product_type=$product->product_type;
            $newFormatedProduct->moq=$product->moq;
            $newFormatedProduct->product_unit=$product->product_unit;
            $newFormatedProduct->is_new_arrival=$product->is_new_arrival;
            $newFormatedProduct->is_featured=$product->is_featured;
            $newFormatedProduct->description=$product->description;
            $newFormatedProduct->state= $product->state;
            $newFormatedProduct->sold= $product->sold;
            $newFormatedProduct->additional_description=$product->additional_description;
            $newFormatedProduct->availability=$product->availability;
            $newFormatedProduct->productReview=$product->productReview;
            $newFormatedProduct->productTotalAverageRating=productRating($product->id);
            $newFormatedProduct->images=$product->images;
            $newFormatedProduct->gender=$product->gender;
            $newFormatedProduct->sample_availability=$product->sample_availability;
            $newFormatedProduct->overlay_small_image=$product->overlay_small_image;
            $newFormatedProduct->overlay_original_image=$product->overlay_original_image;
            $newFormatedProduct->userId=$product->businessProfile->user->id;
            $newFormatedProduct->userName=$product->businessProfile->user->name;
            $newFormatedProduct->userImage=$product->businessProfile->user->image;


        }


        if(isset($newFormatedProduct)){
            return response()->json(array('success' => true, 'product' => $newFormatedProduct),200);
        }
        else{
            return response()->json(array('success' => false, 'message' => "No products found"),200);
        }

    }

    //customizable products
    public function customizableProducts()
    {
        $products = Product::with('images')->where('business_profile_id', '!=', null)->where('customize', true)->where('state',1)->where('sold',0)->inRandomOrder()->paginate(9);
        $customizableProductsArray=[];
        if($products->total()>0){
            foreach($products as $product){

                foreach(json_decode($product->attribute) as $attribute){
                    $attribute_array[] = (object) array('quantity_min' =>$attribute[0], 'quantity_max' => $attribute[1],'price'=>$attribute[2],'lead_time'=>$attribute[3]);
                }
                $newFormatedProduct= new stdClass();

                $newFormatedProduct->id=$product->id;
                $newFormatedProduct->name=$product->name;
                $newFormatedProduct->business_profile_id=$product->business_profile_id;
                $newFormatedProduct->business_name=$product->businessProfile->business_name;
                $newFormatedProduct->sku=$product->sku;
                $newFormatedProduct->copyright_price=$product->copyright_price;
                $newFormatedProduct->full_stock= $product->full_stock;
                $newFormatedProduct->full_stock_price= $product->full_stock_price;
                $newFormatedProduct->attribute=  $attribute_array;
                $newFormatedProduct->colors_sizes=$product->product_type==1 ? [] :json_decode($product->colors_sizes);
                $newFormatedProduct->product_category_id=$product->product_category_id;
                $newFormatedProduct->product_type=$product->product_type;
                $newFormatedProduct->moq=$product->moq;
                $newFormatedProduct->product_unit=$product->product_unit;
                $newFormatedProduct->is_new_arrival=$product->is_new_arrival;
                $newFormatedProduct->is_featured=$product->is_featured;
                $newFormatedProduct->description=$product->description;
                $newFormatedProduct->state= $product->state;
                $newFormatedProduct->sold= $product->sold;
                $newFormatedProduct->additional_description=$product->additional_description;
                $newFormatedProduct->availability=$product->availability;
                $newFormatedProduct->images=$product->images;
                $newFormatedProduct->productReviews=$product->productReview;
                $newFormatedProduct->productTotalAverageRating=productRating($product->id);
                array_push($customizableProductsArray,$newFormatedProduct);
                $attribute_array=[];

            }
        }

        if(count($customizableProductsArray)>0){
            return response()->json(array('success' => true, 'products' => $customizableProductsArray),200);
        }
        else{
            return response()->json(array('success' => false, 'products' => $customizableProductsArray,'message' => "No products found"),200);
        }
    }



    public function showProductByCategoryId($categoryId){

        $products = Product::with('images','productReview')->where('product_category_id',$categoryId)->where('state',1)->where('sold',0)->paginate(9);
        $productsArray=[];
        if($products->total()>0){
            foreach($products as $product){

                    if($product->product_type==1 ){
                        foreach(json_decode($product->attribute) as $attribute){
                            $attribute_array[] = (object) array('quantity_min' =>$attribute[0], 'quantity_max' => $attribute[1],'price'=>$attribute[2] ,'lead_time'=>$attribute[3]);
                        }
                    }else if($product->product_type==2 ){
                        foreach(json_decode($product->attribute) as $attribute){
                            $attribute_array[] = (object) array('ready_quantity_min' =>$attribute[0], 'ready_quantity_max' => $attribute[1],'ready_price'=>$attribute[2]);
                        }
                    }
                    else{
                        foreach(json_decode($product->attribute) as $attribute){
                            $attribute_array[] = (object) array('non_clothing_quantity_min' =>$attribute[0], 'non_clothing_quantity_max' => $attribute[1],'non_clothing_price'=>$attribute[2]);
                        }

                    }


                    $newFormatedProduct= new stdClass();
                    $newFormatedProduct->id=$product->id;
                    $newFormatedProduct->name=$product->name;
                    $newFormatedProduct->business_profile_id=$product->business_profile_id;
                    $newFormatedProduct->business_name=$product->businessProfile->business_name;
                    $newFormatedProduct->sku=$product->sku;
                    $newFormatedProduct->copyright_price=$product->copyright_price;
                    $newFormatedProduct->full_stock= $product->full_stock;
                    $newFormatedProduct->full_stock_price= $product->full_stock_price;
                    $newFormatedProduct->attribute=  $attribute_array;
                    $newFormatedProduct->colors_sizes=$product->product_type==1 ? [] :json_decode($product->colors_sizes);
                    $newFormatedProduct->product_category_id=$product->product_category_id;
                    $newFormatedProduct->product_type=$product->product_type;
                    $newFormatedProduct->moq=$product->moq;
                    $newFormatedProduct->product_unit=$product->product_unit;
                    $newFormatedProduct->is_new_arrival=$product->is_new_arrival;
                    $newFormatedProduct->is_featured=$product->is_featured;
                    $newFormatedProduct->description=$product->description;
                    $newFormatedProduct->state= $product->state;
                    $newFormatedProduct->sold= $product->sold;
                    $newFormatedProduct->additional_description=$product->additional_description;
                    $newFormatedProduct->availability=$product->availability;
                    $newFormatedProduct->images=$product->images;
                    $newFormatedProduct->productReviews=$product->productReview;
                    $newFormatedProduct->productTotalAverageRating=productRating($product->id);
                    array_push($productsArray,$newFormatedProduct);
                    $attribute_array=[];

            }

        }
        if(count($productsArray)>0){
            return response()->json(array('success' => true, 'product' => $productsArray),200);

        }
        else{
            return response()->json(array('success' => false, 'product' => $productsArray,'message' => "No products found"),200);
        }


    }


    public function publishOrUnpublishProduct($productId)
    {
        $product=Product::where('id',$productId)->first();
        if($product->state==1){
            $product->update(['state' => 0]);
            return response()->json(array('success' => true, 'msg' => 'Product Unpublish Successfully'),200);
            }
        else{
            $product->update(['state' => 1]);
            return response()->json(array('success' => true, 'msg' => 'Product Publish Successfully'),200);
        }
    }

    public function store(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'business_profile_id' => 'required',
            'images'  => 'required',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg,JPEG,PNG,JPG,GIF,SVG|max:5120',
            'name'      => 'required',
            'product_category_id' => 'required',
            'product_type' => 'required',
            'description'  => 'required',
            'moq'         => [new MoqUnitRule($request, $request->product_type)],
            'product_unit'  =>[new MoqUnitRule($request, $request->product_type)],
            'ready_stock_availability'  => 'required_if:product_type,2',
            'non_clothing_availability'  => 'required_if:product_type,3',
            'quantity_min.*' => 'required_if:product_type,1',
            'quantity_max.*' => 'required_if:product_type,1',
            'price.*' => 'required_if:product_type,1',
            'lead_time.*' => 'required_if:product_type,1',
            'ready_quantity_min.*' => [new ReadyStockPriceBreakDownRule($request, $request->product_type)],
            'ready_quantity_max.*' => [new ReadyStockPriceBreakDownRule($request, $request->product_type)],
            'ready_price.*' => [new ReadyStockPriceBreakDownRule($request, $request->product_type)],
            'non_clothing_min.*' => [new NonClothingPriceBreakDownRule($request, $request->product_type)],
            'non_clothing_max.*' => [new NonClothingPriceBreakDownRule($request, $request->product_type)],
            'non_clothing_price.*' => [new NonClothingPriceBreakDownRule($request, $request->product_type)],
            'full_stock_price' => [new ReadyStockFullStockRule($request, $request->product_type)],
            'non_clothing_full_stock_price' => [new NonClothingFullStockRule($request, $request->product_type)],
            'video' => 'mimes:mp4,3gp,mkv,mov|max:150000',
            'gender' => 'required',
            'sample_availability' => 'required',

        ]);

        if ($validator->fails())
        {
            return response()->json(array(
            'success' => false,
            'error' => $validator->getMessageBag()),
            400);
        }



         DB::beginTransaction();

         try {
            $date=Carbon::now()->timestamp;
            $number=mt_rand(0,9999);
            $remove[] = "'";
            $remove[] = '"';
            $remove[] = "-";
            $FileName = str_replace($remove, "", $request->name);
            $name= explode(' ',strtolower($FileName));
            $sku=$name[0].$date.$number;

            $full_stock_negotiable=false;
            $full_stock = false;
            $full_stock_price = null;
            $availability=null;

            if($request->product_type==1){
                $price_break_down=[];
                for($i=0; $i < count($request->quantity_min); $i++){
                    array_push($price_break_down,[(int)$request->quantity_min[$i],(int)$request->quantity_max[$i],is_numeric($request->price[$i]) ? $request->price[$i] : 'Negotiable',$request->lead_time[$i]]);
                }

            }

            if($request->product_type==2){
                $colors_sizes=[];
                if(isset($request->color_size)){

                    for($i=0; $i < count($request->color_size); $i++){
                        array_push($colors_sizes,$request->color_size[$i]);

                    }
                }

                $price_break_down=[];
                for($i=0; $i < count($request->ready_quantity_min); $i++){
                    array_push($price_break_down,[(int)$request->ready_quantity_min[$i],(int)$request->ready_quantity_max[$i],is_numeric($request->ready_price[$i]) ? $request->ready_price[$i] : 'Negotiable']);
                }

                $full_stock= isset($request->full_stock) ? true : false;
                $full_stock_price = isset($request->full_stock_price) ? $request->full_stock_price : null;
                $availability=$request->ready_stock_availability;
                $full_stock_negotiable= isset($request->ready_full_stock_negotiable) ? true : false;
            }

            if($request->product_type==3)
            {
                $colors_sizes=[];
                if(isset($request->color_size)){

                    for($i=0; $i < count($request->color_size); $i++){
                        array_push($colors_sizes,$request->color_size[$i]);
                    }
                }

                $price_break_down=[];
                for($i=0; $i < count($request->non_clothing_quantity_min); $i++){
                    array_push($price_break_down,[(int)$request->non_clothing_quantity_min[$i],(int)$request->non_clothing_quantity_max[$i],is_numeric($request->non_clothing_price[$i]) ? $request->non_clothing_price[$i] : 'Negotiable']);
                }

                $full_stock= isset($request->non_clothing_full_stock) ? true : false;
                $full_stock_price = isset($request->non_clothing_full_stock_price) ? $request->non_clothing_full_stock_price : null;
                $availability=$request->non_clothing_availability;
                $full_stock_negotiable= isset($request->non_clothing_full_stock_negotiable) ? true : false;
            }

            $business_profile=BusinessProfile::where('id', $request->business_profile_id)->first();
            $business_profile_name=$business_profile->business_name;

            //overlay image
            if($request->overlay_image){

                $filename = $request->overlay_image->store('images/'.$business_profile_name.'/products/overlay_small','public');
                $image_resize = Image::make(public_path('storage/'.$filename));
                $image_resize->fit(300, 300);
                $image_resize->save(public_path('storage/'.$filename));
                $original = $request->overlay_image->store('images/'.$business_profile_name.'/products/overlay_original','public');

            }

            $product=Product::create([
                'business_profile_id' => $request->business_profile_id,
                'name'      => $request->name,
                'sku'       => $sku,
                'product_category_id' => $request->product_category_id,
                'product_type'  => $request->product_type,
                'attribute' => json_encode($price_break_down) ?? null,
                'is_featured' => $request->is_featured=='on'? 1:0,
                'is_new_arrival' => $request->is_new_arrival=='on'? 1:0,
                'state'   => $request->published=='on'? 1:0,
                'description' => $request->description,
                'additional_description' => $request->additional_description,
                'colors_sizes'  => isset($colors_sizes)  ? json_encode($colors_sizes): null,
                'moq'         => $request->moq,
                'product_unit'     => $request->product_unit,
                'availability'     => $availability,
                'ip_address' => $request->ip(),
                'user_agent' => $request->header('User-Agent'),
                'copyright_price'  => $request->product_type==1 ? $request->copyright_price : null,
                'full_stock'     => $full_stock,
                'full_stock_price' =>  $full_stock_price,
                'full_stock_negotiable' => $full_stock_negotiable,
                'customize'      => isset($request->customize) ? true : false,
                'gender'     => $request->gender,
                'sample_availability' =>$request->sample_availability,
                'overlay_small_image' =>$filename,
                'overlay_original_image' =>$original,
                'created_by'  => auth()->id(),

            ]);

            // $user=User::where('id',auth()->id())->first();
            // $vendorName=Str::slug($user->vendor->vendor_name,'-');
            foreach ($request->images as $image) {
                $filename = $image->store('images/'.$business_profile_name.'/products/small','public');
                $image_resize = Image::make(public_path('storage/'.$filename));
                $image_resize->fit(300, 300);
                $image_resize->save(public_path('storage/'.$filename));
                $original=$image->store('images/'.$business_profile_name.'/products/original','public');
                $product_image = ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $filename,
                    'original' => $original,
                ]);
            }
             //related products
            if($request->related_products)
            {
                foreach($request->related_products as $item){
                    RelatedProduct::create([
                        'business_profile_id'  => $request->business_profile_id,
                        'product_id' => $product->id,
                        'related_product_id' => $item,
                    ]);
                }

            }

            //upload video
            if($request->hasFile('video')){
                $folder='video/'.$business_profile_name;
                $filename = $request->video->store($folder,'public');
                $product_video = ProductVideo::create([
                    'product_id' => $product->id,
                    'video' => $filename,
                    ]);
            }
            DB::commit();
            // all good
            return response()->json(array('success' => true, 'message' => 'Product Created Successfully','product'=>$product),200);
        }catch (\Exception $e) {
            DB::rollback();
            return response()->json(array(
                'success' => false,
                'error' => $e->getMessage(),
                'line'=>$e->getLine(),),
                500);
        }

    }



    public function storeBk(Request $request,$storeId)
    {



        $request->validate([

            'images'  => 'required',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'name'      => 'required',
            'product_category_id' => 'required',
            'product_type' => 'required',
            'description'  => 'required',
            'additional_description'  => 'required',
            'moq'         => 'required',
            'product_unit'         => 'required',
            'availability'  => 'required_if:product_type,[2,3]',
            'quantity_min.*' => 'required_if:product_type,1',
            'quantity_max.*' => 'required_if:product_type,1',
            'price.*' => 'required_if:product_type,1',
            'lead_time.*' => 'required_if:product_type,1',
            'full_stock_price' => 'required_if:full_stock,on',
         ]);



         DB::beginTransaction();

         try {
            $date=Carbon::now()->timestamp;
            $number=mt_rand(0,9999);
            $remove[] = "'";
            $remove[] = '"';
            $remove[] = "-";
            $FileName = str_replace($remove, "", $request->name);
            $name= explode(' ',strtolower($FileName));
            $sku=$name[0].$date.$number;
            if($request->product_type==1){
                $price_break_down=[];
                for($i=0; $i < count($request->quantity_min); $i++){
                    array_push($price_break_down,[(int)$request->quantity_min[$i],(int)$request->quantity_max[$i],is_numeric($request->price[$i]) ? $request->price[$i] : 'Negotiable',$request->lead_time[$i]]);
                }

                $full_stock = false;
                $full_stock_price = null;
                $availability=null;
            }

            if($request->product_type==2){
                $colors_sizes=[];
                if(isset($request->color_size)){

                    for($i=0; $i < count($request->color_size); $i++){
                        array_push($colors_sizes,$request->color_size[$i]);

                    }
                }

                $price_break_down=[];
                for($i=0; $i < count($request->ready_quantity_min); $i++){
                    array_push($price_break_down,[(int)$request->ready_quantity_min[$i],(int)$request->ready_quantity_max[$i],is_numeric($request->ready_price[$i]) ? $request->ready_price[$i] : 'Negotiable']);
                }

                $full_stock= isset($request->full_stock) ? true : false;
                $full_stock_price = isset($request->full_stock_price) ? $request->full_stock_price : null;
                $availability=$request->availability;
            }

            if($request->product_type==3)
            {
                $colors_sizes=[];
                if(isset($request->color_size)){

                    for($i=0; $i < count($request->color_size); $i++){
                        array_push($colors_sizes,$request->color_size[$i]);
                    }
                }

                $price_break_down=[];
                for($i=0; $i < count($request->non_clothing_quantity_min); $i++){
                    array_push($price_break_down,[(int)$request->non_clothing_quantity_min[$i],(int)$request->non_clothing_quantity_max[$i],is_numeric($request->non_clothing_price[$i]) ? $request->non_clothing_price[$i] : 'Negotiable']);
                }

                $full_stock= isset($request->full_stock) ? true : false;
                $full_stock_price = isset($request->full_stock_price) ? $request->full_stock_price : null;
                $availability=$request->availability;
            }


            $product=Product::create([
                'vendor_id' => $storeId,
                'name'      => $request->name,
                'sku'       => $sku,
                'product_category_id' => $request->product_category_id,
                'product_type'  => $request->product_type,
                'attribute' => json_encode($price_break_down) ?? null,
                'is_featured' => $request->is_featured=='on'? 1:0,
                'is_new_arrival' => $request->is_new_arrival=='on'? 1:0,
                'state'   => $request->published=='on'? 1:0,
                'description' => $request->description,
                'additional_description' => $request->additional_description,
                'colors_sizes'  => isset($colors_sizes)  ? json_encode($colors_sizes): null,
                'moq'         => $request->moq,
                'product_unit'     => $request->product_unit,
                'availability'     => $availability,
                'ip_address' => $request->ip(),
                'user_agent' => $request->header('User-Agent'),
                'copyright_price'  => $request->product_type==1 ? $request->copyright_price : null,
                'full_stock'     => $full_stock,
                'full_stock_price' =>  $full_stock_price,
                'created_by'  => auth()->id(),

            ]);

            $user=User::where('id',auth()->id())->first();
            $vendorName=Str::slug($user->vendor->vendor_name,'-');
            foreach ($request->images as $image) {
                 $filename = $image->store('images/'.$vendorName.'/products/small','public');
                 $image_resize = Image::make(public_path('storage/'.$filename));
                 $image_resize->fit(300, 300);
                 $image_resize->save(public_path('storage/'.$filename));
                 $original=$image->store('images/'.$vendorName.'/products/original','public');
                 $product_image = ProductImage::create([
                     'product_id' => $product->id,
                     'image' => $filename,
                     'original' => $original,
                 ]);
             }
             //related products
            if($request->related_products)
            {
                foreach($request->related_products as $item){
                    RelatedProduct::create([
                        'vendor_id'  => auth()->user()->vendor->id,
                        'product_id' => $product->id,
                        'related_product_id' => $item,
                    ]);
                }

            }
            DB::commit();
            // all good
            return response()->json(array('success' => true, 'message' => 'Product Created Successfully','product'=>$product),200);
        }catch (\Exception $e) {
            DB::rollback();
            return response()->json(array(
                'success' => false,
                'error' => $e->getMessage(),
                'line'=>$e->getLine(),),
                500);
        }

    }

    public function update(Request $request,$productId)
    {

        $validator = Validator::make($request->all(), [
            'business_profile_id' => 'required',
            'name'      => 'required',
            'product_category_id' => 'required',
            'product_type' => 'required',
            'description'  => 'required',
            'moq'         => [new MoqUnitRule($request, $request->product_type)],
            'product_unit'  =>[new MoqUnitRule($request, $request->product_type)],
            'ready_stock_availability'  => 'required_if:product_type,2',
            'non_clothing_availability'  => 'required_if:product_type,3',
            'quantity_min.*' => 'required_if:product_type,1',
            'quantity_max.*' => 'required_if:product_type,1',
            'price.*' => 'required_if:product_type,1',
            'lead_time.*' => 'required_if:product_type,1',
            'ready_quantity_min.*' => [new ReadyStockPriceBreakDownRule($request, $request->product_type)],
            'ready_quantity_max.*' => [new ReadyStockPriceBreakDownRule($request, $request->product_type)],
            'ready_price.*' => [new ReadyStockPriceBreakDownRule($request, $request->product_type)],
            'non_clothing_min.*' => [new NonClothingPriceBreakDownRule($request, $request->product_type)],
            'non_clothing_max.*' => [new NonClothingPriceBreakDownRule($request, $request->product_type)],
            'non_clothing_price.*' => [new NonClothingPriceBreakDownRule($request, $request->product_type)],
            'full_stock_price' => [new ReadyStockFullStockRule($request, $request->product_type)],
            'non_clothing_full_stock_price' => [new NonClothingFullStockRule($request, $request->product_type)],
            'overlay-image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,JPEG,PNG,JPG,GIF,SVG|max:5120',
            'video' => 'mimes:mp4,3gp,mkv,mov|max:150000',
            'gender' => 'required',
            'sample_availability' => 'required',

        ]);

        if ($validator->fails())
        {
            return response()->json(array(
            'success' => false,
            'error' => $validator->getMessageBag()),
            400);
        }
        DB::beginTransaction();
        try {

            $full_stock_negotiable=false;
            $full_stock = false;
            $full_stock_price = null;
            $availability=null;

            //buy design products
            if($request->product_type==1){
                $price_break_down=[];
                for($i=0; $i < count($request->quantity_min); $i++){
                    array_push($price_break_down,[(int)$request->quantity_min[$i],(int)$request->quantity_max[$i],is_numeric($request->price[$i]) ? $request->price[$i] : 'Negotiable',$request->lead_time[$i]]);
                }
            }

            //ready stock products
            if($request->product_type==2){
                $colors_sizes=[];
                if(isset($request->color_size)){

                    for($i=0; $i < count($request->color_size); $i++){
                        array_push($colors_sizes,$request->color_size[$i]);

                    }
                }

                $price_break_down=[];
                for($i=0; $i < count($request->ready_quantity_min); $i++){
                    array_push($price_break_down,[(int)$request->ready_quantity_min[$i],(int)$request->ready_quantity_max[$i],is_numeric($request->ready_price[$i]) ? $request->ready_price[$i] : 'Negotiable']);
                }

                $full_stock= isset($request->full_stock) ? true : false;
                $full_stock_price = isset($request->full_stock_price) ? $request->full_stock_price : null;
                $full_stock_negotiable= isset($request->ready_full_stock_negotiable) ? true : false;
                $availability=$request->availability;
            }


            //non-clothing products
            if($request->product_type==3)
            {
                $colors_sizes=[];
                if(isset($request->color_size)){

                    for($i=0; $i < count($request->color_size); $i++){
                        array_push($colors_sizes,$request->color_size[$i]);
                    }
                }

                $price_break_down=[];
                for($i=0; $i < count($request->non_clothing_quantity_min); $i++){
                    array_push($price_break_down,[(int)$request->non_clothing_quantity_min[$i],(int)$request->non_clothing_quantity_max[$i],is_numeric($request->non_clothing_price[$i]) ? $request->non_clothing_price[$i] : 'Negotiable']);
                }

                $full_stock= isset($request->full_stock) ? true : false;
                $full_stock_price = isset($request->full_stock_price) ? $request->full_stock_price : null;
                $full_stock_negotiable= isset($request->non_clothing_full_stock_negotiable) ? true : false;
                $availability=$request->availability;
            }

            $product=Product::where('id',$productId)->first();
            $business_profile=BusinessProfile::where('id', $product->business_profile_id)->first();
            $business_profile_name=$business_profile->business_name;

            //overlay image
            if($request->overlay_image){

                if($product->overlay_original_image){
                    if(Storage::exists($product->overlay_original_image) ){
                        Storage::delete($product->overlay_original_image);
                        Storage::delete($product->overlay_small_image);
                    }
                }
                $filename = $request->overlay_image->store('images/'.$business_profile_name.'/products/overlay_small','public');
                $image_resize = Image::make(public_path('storage/'.$filename));
                $image_resize->fit(300, 300);
                $image_resize->save(public_path('storage/'.$filename));
                $original = $request->overlay_image->store('images/'.$business_profile_name.'/products/overlay_original','public');

            }

            Product::where('id',$productId)->update([
                'name'      => $request->name,
                'product_category_id' => $request->product_category_id,
                'is_featured' => $request->is_featured=='on'? 1:0,
                'is_new_arrival' => $request->is_new_arrival=='on'? 1:0,
                'state'   => $request->published=='on'? 1:0,
                'description' => $request->description,
                'additional_description' => $request->additional_description,
                'attribute' => json_encode($price_break_down) ?? null,
                'colors_sizes'  =>  isset($colors_sizes)  ? json_encode($colors_sizes): null,
                'moq'         => $request->moq,
                'product_unit'     => $request->product_unit,
                'availability'     =>  $availability,
                'ip_address' => $request->ip(),
                'user_agent' => $request->header('User-Agent'),
                'copyright_price'  => $request->product_type==1 ? $request->copyright_price : null,
                'full_stock'     => $full_stock,
                'full_stock_price' =>  $full_stock_price,
                'customize'      => isset($request->customize) ? true : false,
                'full_stock_negotiable' => $full_stock_negotiable,
                'gender'     => $request->gender,
                'sample_availability' =>$request->sample_availability,
                'overlay_small_image' =>$filename ?? $product->overlay_original_image,
                'overlay_original_image' =>$original ?? $product->overlay_small_image,
                'updated_by'  => auth()->id(),
            ]);
            $product=Product::where('id',$productId)->first();
            $user=User::where('id',auth()->id())->first();
            $productImages = ProductImage::whereIn('id',$request->product_images_id)->get();
            if(isset($productImages)){
                foreach($productImages as $productImage){
                    if(Storage::exists('public/'.$productImage->image) && Storage::exists('public/'.$productImage->original)){
                        Storage::delete('public/'.$productImage->image);
                        Storage::delete('public/'.$productImage->original);
                    }
                    $productImage->delete();
                }
            }
            if(isset($request->images))
            {
                foreach ($request->images as $image) {
                    $filename = $image->store('images/'.$business_profile_name.'/products/small','public');
                    $image_resize = Image::make(public_path('storage/'.$filename));
                    $image_resize->fit(300, 300);
                    $image_resize->save(public_path('storage/'.$filename));
                    $original=$image->store('images/'.$business_profile_name.'/products/original','public');
                    $product_image = ProductImage::create([
                        'product_id' => $product->id,
                        'image' => $filename,
                        'original' => $original,
                    ]);
                }
            }

            //video
            if(isset($request->remove_video_id)){
                if( count(json_decode($request->remove_video_id)) > 0 ){
                    $productVideo=ProductVideo::where('id',json_decode($request->remove_video_id))->first();
                    if($productVideo){
                        if(Storage::exists($productVideo->video)){
                            Storage::delete($productVideo->video);
                        }
                        $productVideo->delete();
                    }
                }
            }

            if($request->hasFile('video')){
                $folder='video/'.$business_profile_name;
                $filename = $request->video->store($folder,'public');
                $product_video = ProductVideo::create([
                    'product_id' => $product->id,
                    'video' => $filename,
                ]);
            }


            //related products
            if(!isset($request->related_products))
            {
                $relatedProduct=RelatedProduct::where('business_profile_id',$product->business_profile_id)->where('product_id',$product->id)->get();
                if($relatedProduct){
                    foreach($relatedProduct as $rel_product)
                    {
                        $rel_product->delete();
                    }
                }
            }
            if($request->related_products)
            {
                $relatedProduct=RelatedProduct::where('business_profile_id',$product->business_profile_id)->where('product_id',$product->id)->get();
                if($relatedProduct){
                    foreach($relatedProduct as $rel_product)
                        {
                            $rel_product->delete();
                        }
                }
                foreach($request->related_products as $item){
                    RelatedProduct::create([
                        'business_profile_id' => $product->business_profile_id,
                        'product_id' => $product->id,
                        'related_product_id' => $item,
                    ]);
                }

            }
            DB::commit();
            $product=Product::where('id',$productId)->first();

        return response()->json(array('success' => true, 'message' => 'Product Updated Successfully','product'=>$product),200);
        }catch (\Exception $e) {
            DB::rollback();
            return response()->json(array(
                'success' => false,
                'error' => $e->getMessage(),
                'line'=>$e->getLine(),),
                500);
        }
    }



    public function searchByProductName(Request $request){

        if(!empty($request->search_input) && $request->type=="wholesaler"){
            $products=Product::with('images','businessProfile','productReview')->where('business_profile_id', '!=', null)->where('name', 'like', '%'.$request->search_input.'%')->paginate(20);
                if($products->total()>0){
                    return response()->json(['products' => $products, 'message' => 'Products found','code'=>false], 200);
                }
                else{
                    return response()->json(['products' => $products, 'message' => 'Products not found','code'=>False], 200);
                }
        }
        elseif(!empty($request->search_input) && $request->type=="manufacture"){
            $products = ManufactureProduct::with(['product_images','businessProfile'])->where('business_profile_id', '!=', null)->where('title', 'like', '%'.$request->search_input.'%')->paginate(20);
            if($products->total()>0){
                return response()->json(['products' => $products, 'message' => 'Products found','code'=>false], 200);
            }
            else{
                return response()->json(['products' => $products, 'message' => 'Products not found','code'=>False], 200);
            }
        }
        else{
            return response()->json(['products' => [], 'message' => 'Search key is empty','code'=>False], 200);
        }

    }





   public function filterSearch(Request $request)
   {

      if($request->search_category_id){
          $home_page_cat_id= explode(",", $request->search_category_id);
          $products=Product::whereIn('product_category_id',$home_page_cat_id)->where('state',1)->where('sold',0)->get();
        }
      else{
          if($request->product_type_category_id){
            $product_type_cat_id= explode(",", $request->product_type_category_id);
            $products=Product::where('product_type', $request->product_type)->whereIn('product_category_id',$product_type_cat_id)->where('state',1)->where('sold',0)->get();
          }
          else{
            $products=Product::where('product_type',$request->product_type)->where('state',1)->where('sold',0)->get();
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

        $productList=Product::whereIn('id',array_unique($search_id))->paginate(9);
        $data=view('product._products_list',['products' => $productList])->with('products', $productList)->render();
        return response()->json([
               'success' => true,
               'data'    => $data,
        ],200);

    }

    public function recommandedProducts($id){

        $product=Product::where('id',$id)->first();
        $recommandProducts=Product::where('state',1)
        ->where('id','!=',$product->id)
        ->whereHas('category', function($q) use ($product){
             $q->where('id',$product->product_category_id);

        })
        ->orWhere(function($query) use ($product){
            $query->where('product_type',$product->product_type)
                  ->where('id', '!=', $product->id);
        })
        ->with(['images','vendor'])
        ->get();


        if(count($recommandProducts)>0){
            return response()->json([
                'success' => true,
                'recommandProducts' => $recommandProducts,
         ],200);

        }
        else{
            return response()->json([
                'success' => false,
                'recommandProducts' => $recommandProducts,
         ],200);

        }
    }


    public function relatedProducts($businessProfileId)
    {
        $relatedProducts=Product::where('business_profile_id',$businessProfileId)->get();
        if(count($relatedProducts)>0){
            return response()->json([
                'success' => true,
                'relatedProducts' => $relatedProducts,
         ],200);

        }
        else{
            return response()->json([
                'success' => false,
                'relatedProducts' => $relatedProducts,
         ],200);

        }
    }


    // public function destroy($storeId,$productId)
    // {

    //     try {
    //         $product=Product::with('images')->where('id',$productId)->first();
    //         $productImages=ProductImage::where('product_id',$productId)->get();

    //         $relatedProduct=RelatedProduct::where('product_id',$product->id)->get();
    //         if($relatedProduct){
    //             foreach($relatedProduct as $product)
    //                 {
    //                     $product->delete();
    //                 }
    //         }
    //         $result=$product->delete();
    //         if($result)
    //         {
    //             if(isset($productImages))
    //             {
    //                 foreach($productImages as $productImage)
    //                 {
    //                     if(Storage::exists('public/'.$productImage->image) && Storage::exists('public/'.$productImage->original) )
    //                     {
    //                         Storage::delete('public/'.$productImage->image);
    //                         Storage::delete('public/'.$productImage->original);

    //                     }
    //                     $productImage->delete();
    //                 }
    //             }

    //             return response()->json(array('success' => true, 'msg' => 'Product Deteted Successfully'),200);
    //         }
    //     }catch (\Exception $e) {
    //         return response()->json(array(
    //             'success' => false,
    //             'error' => $e->getMessage(),),
    //             500);
    //     }
    // }

    public function studio(Request $request)
    {

        $manufacture_products=ManufactureProduct::with(['product_images:product_id,product_image as image','category'])->where(['product_type_mapping_id' => 1])->get();
        $wholesaler_products= Product::with(['images:product_id,image','category'])->where(['product_type_mapping_id' => 1, 'state' => 1, 'sold' => 0])->get();

        $collection = $manufacture_products->mergeRecursive($wholesaler_products)->sortBy([ ['priority_level', 'asc'], ['created_at', 'desc'] ])->values();
        $merged=collect();
        foreach($collection as $item){
            $attribute_array=[];
            if($item->flag == 'shop')
            {
                if($item->product_type==1 ){
                    foreach(json_decode($item->attribute) as $attribute){
                        $attribute_array[] = (object) array('quantity_min' =>$attribute[0], 'quantity_max' => $attribute[1],'price'=>$attribute[2],'lead_time'=>$attribute[3]);
                    }
                }else if($item->product_type==2 ){
                    foreach(json_decode($item->attribute) as $attribute){
                        $attribute_array[] = (object) array('ready_quantity_min' =>$attribute[0], 'ready_quantity_max' => $attribute[1],'ready_price'=>$attribute[2]);
                    }
                }
                else{
                    foreach(json_decode($item->attribute) as $attribute){
                        $attribute_array[] = (object) array('non_clothing_quantity_min' =>$attribute[0], 'non_clothing_quantity_max' => $attribute[1],'non_clothing_price'=>$attribute[2]);
                    }

                }

            }
            $product_tag=ProductTag::whereIn('name',$item->product_tag)->get();
            $product_tag_id=[];
            $product_tag_name=[];
            foreach($product_tag as $tag){
                array_push($product_tag_id,$tag->id);
                array_push($product_tag_name,$tag->name);
            }
            $product_tag_id= implode(',',$product_tag_id);
            $product_tag_name= implode(',',$product_tag_name);

            $merged->push(
                [
                'id' => $item->id,
                'title' => $item->name ?? $item->title,
                'flag' => $item->flag,
                'category' => $product_tag_name,
                'category_id' => (string) $product_tag_id,
                'moq' => (int)$item->moq ?? null,
                'price' => $item->price_per_unit ?? null,
                'quantity_unit' => $item->product_unit ?? $item->qty_unit,
                'image' => $item->images ?? $item->product_images,
                'attribute' => $item->flag == 'shop' ? $attribute_array : null,
                'product_type' => $item->product_type ?? null ,
                'created_at' => $item->created_at,
                'priority_level' => $item->priority_level,
                'product_type_mapping_id' => $item->product_type_mapping_id,
                'product_type_mapping_child_id' => $item->product_type_mapping_child_id,
                'lead_time' => $item->flag == 'mb' ? $item->lead_time : null,
            ]);
        }

        if(isset($request->product_type_mapping_child_id)){
            $merged = $merged->filter(function ($value, $key) use ($request) {
                    $result=array_intersect($value['product_type_mapping_child_id'],$request->product_type_mapping_child_id);
                    if(count($result) > 0){
                        return true;
                    }
                return false;
            });

            $merged->all();

        }

        if(isset($request->search)){
            $search=$request->search;
            $merged = $merged->filter(function($item) use ($search) {
                return stripos($item['title'],$search) !== false;
            });
        }


        $items_per_page = 6;
        $current_page = LengthAwarePaginator::resolveCurrentPage();
        $products = new LengthAwarePaginator(
            collect($merged)->forPage($current_page, $items_per_page)->values(),
            count($merged),
            $items_per_page,
            $current_page,
            ['path' =>  Paginator::resolveCurrentPath()]
        );

        return response()->json(['products' => $products], 200);
    }

    public function rawMaterials(Request $request)
    {
        $manufacture_products=ManufactureProduct::with(['product_images:product_id,product_image as image', 'category'])->where(['product_type_mapping_id' => 2])->get();
        $wholesaler_products= Product::with(['images:product_id,image', 'category'])->where(['product_type_mapping_id' => 2, 'state' => 1, 'sold' => 0])->get();

        $collection = $manufacture_products->mergeRecursive($wholesaler_products)->sortBy([ ['priority_level', 'asc'], ['created_at', 'desc'] ])->values();
        $merged=collect();
        foreach($collection as $item){
            $attribute_array=[];
            if($item->flag == 'shop')
            {
                if($item->product_type==1 ){
                    foreach(json_decode($item->attribute) as $attribute){
                        $attribute_array[] = (object) array('quantity_min' =>$attribute[0], 'quantity_max' => $attribute[1],'price'=>$attribute[2],'lead_time'=>$attribute[3]);
                    }
                }else if($item->product_type==2 ){
                    foreach(json_decode($item->attribute) as $attribute){
                        $attribute_array[] = (object) array('ready_quantity_min' =>$attribute[0], 'ready_quantity_max' => $attribute[1],'ready_price'=>$attribute[2]);
                    }
                }
                else{
                    foreach(json_decode($item->attribute) as $attribute){
                        $attribute_array[] = (object) array('non_clothing_quantity_min' =>$attribute[0], 'non_clothing_quantity_max' => $attribute[1],'non_clothing_price'=>$attribute[2]);
                    }

                }

            }
            $product_tag=ProductTag::whereIn('name',$item->product_tag)->get();
            $product_tag_id=[];
            foreach($product_tag as $tag){
                array_push($product_tag_id,$tag->id);
            }
            $product_tag_id= implode(',',$product_tag_id);

            $merged->push(
                [
                'id' => $item->id,
                'title' => $item->name ?? $item->title,
                'flag' => $item->flag,
                'category' => null,
                'category_id' => (string) $product_tag_id,
                'moq' =>  (int)$item->moq ?? null,
                'price' => $item->price_per_unit ?? null,
                'quantity_unit' => $item->product_unit ?? $item->qty_unit,
                'image' => $item->images ?? $item->product_images,
                'attribute' => $item->flag == 'shop' ? $attribute_array : null,
                'product_type' => $item->product_type ?? null ,
                'created_at' => $item->created_at,
                'priority_level' => $item->priority_level,
                'product_type_mapping_id' => $item->product_type_mapping_id,
                'product_type_mapping_child_id' => $item->product_type_mapping_child_id,
                'lead_time' => $item->flag == 'mb' ? $item->lead_time : null,
            ]);
        }


        if(isset($request->product_type_mapping_child_id)){
            $merged = $merged->filter(function ($value, $key) use ($request) {
                    $result=array_intersect($value['product_type_mapping_child_id'],$request->product_type_mapping_child_id);
                    if(count($result) > 0){
                        return true;
                    }
                return false;
            });

            $merged->all();

        }

        if(isset($request->search)){
            $search=$request->search;
            $merged = $merged->filter(function($item) use ($search) {
                return stripos($item['title'],$search) !== false;
            });
        }

        $items_per_page = 6;
        $current_page = LengthAwarePaginator::resolveCurrentPage();
        $products = new LengthAwarePaginator(
            collect($merged)->forPage($current_page, $items_per_page)->values(),
            count($merged),
            $items_per_page,
            $current_page,
            ['path' =>  Paginator::resolveCurrentPath()]
        );


        return response()->json(['products' => $products], 200);
    }


    public function productDetails($flag,$id)
    {
        if($flag == 'shop')
        {
            $product = Product::with('images','productReview')->where('business_profile_id', '!=', null)->where('id',$id)->where('state',1)->where('sold',0)->first();

            if($product)
            {

                if($product->product_type==1 ){
                    foreach(json_decode($product->attribute) as $attribute){
                        $attribute_array[] = (object) array('quantity_min' =>$attribute[0], 'quantity_max' => $attribute[1],'price'=>$attribute[2],'lead_time'=>$attribute[3]);
                    }
                }else if($product->product_type==2 ){
                    foreach(json_decode($product->attribute) as $attribute){
                        $attribute_array[] = (object) array('ready_quantity_min' =>$attribute[0], 'ready_quantity_max' => $attribute[1],'ready_price'=>$attribute[2]);
                    }
                }
                else{
                    foreach(json_decode($product->attribute) as $attribute){
                        $attribute_array[] = (object) array('non_clothing_quantity_min' =>$attribute[0], 'non_clothing_quantity_max' => $attribute[1],'non_clothing_price'=>$attribute[2]);
                    }

                }

                $product_tag=ProductTag::whereIn('name',$product->product_tag)->get();
                $product_tag_id=[];
                $product_tag_name=[];
                foreach($product_tag as $tag){
                    array_push($product_tag_id,$tag->id);
                    array_push($product_tag_name,$tag->name);
                }
                $product_tag_id= implode(',',$product_tag_id);
                $product_tag_name= implode(',',$product_tag_name);


                $newFormatedProduct= new stdClass();
                $newFormatedProduct->id=$product->id;
                $newFormatedProduct->name=$product->name;
                $newFormatedProduct->business_profile_id=$product->business_profile_id;
                $newFormatedProduct->product_mapping=$product->product_mapping;
                $newFormatedProduct->product_mapping_child_id=$product->product_mapping_child_id;
                $newFormatedProduct->business_name=$product->businessProfile->business_name;
                $newFormatedProduct->sku=$product->sku;
                $newFormatedProduct->copyright_price=$product->copyright_price;
                $newFormatedProduct->full_stock= $product->full_stock;
                $newFormatedProduct->full_stock_price= $product->full_stock_price;
                $newFormatedProduct->attribute=  $attribute_array;
                $newFormatedProduct->colors_sizes=$product->product_type==1 ? [] :json_decode($product->colors_sizes);
                $newFormatedProduct->product_category_id=$product_tag_id;
                $newFormatedProduct->product_category_name=$product_tag_name;
                $newFormatedProduct->product_type=$product->product_type;
                $newFormatedProduct->moq=$product->moq;
                $newFormatedProduct->product_unit=$product->product_unit;
                $newFormatedProduct->is_new_arrival=$product->is_new_arrival;
                $newFormatedProduct->is_featured=$product->is_featured;
                $newFormatedProduct->description=$product->description;
                $newFormatedProduct->state= $product->state;
                $newFormatedProduct->sold= $product->sold;
                $newFormatedProduct->additional_description=$product->additional_description;
                $newFormatedProduct->availability=$product->availability;
                $newFormatedProduct->productReview=$product->productReview;
                $newFormatedProduct->productTotalAverageRating=productRating($product->id);
                $newFormatedProduct->images=$product->images;
                $newFormatedProduct->gender=$product->gender;
                $newFormatedProduct->sample_availability=$product->sample_availability;
                $newFormatedProduct->overlay_small_image=$product->overlay_small_image;
                $newFormatedProduct->overlay_original_image=$product->overlay_original_image;
                $newFormatedProduct->userId=$product->businessProfile->user->id;
                $newFormatedProduct->userName=$product->businessProfile->user->name;
                $newFormatedProduct->userImage=$product->businessProfile->user->image;

                if(isset($newFormatedProduct)){
                    return response()->json(array('success' => true, 'product' => $newFormatedProduct),200);
                }
                else{
                    return response()->json(array('success' => false, 'message' => "No products found"),200);
                }

            }

            return response()->json(array('success' => false, 'message' => "No products found"),200);

        }

        if($flag == 'mb')
        {
            $product=ManufactureProduct::with('product_images','category','businessProfile.user')->where('id',$id)->first();
            if($product){
                return response()->json([
                    'success' => true,
                    'product' => $product,
                    ],200);
            }
            else{
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found',
                    ],404);
            }
        }


    }


}
