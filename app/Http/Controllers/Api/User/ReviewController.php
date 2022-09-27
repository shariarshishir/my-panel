<?php

namespace App\Http\Controllers\Api\User;
use App\Models\ProductReview;
use App\Models\VendorReview;
use App\Models\Vendor;
use App\Models\VendorOrder;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use stdClass;

class ReviewController extends Controller
{
    public function createProductReview(Request $request){

        $productReviewExistOrNot=ProductReview::where('product_id',$request->product_id)->where('created_by',auth()->id())->first();
        $user=User::where('id',auth()->id())->first();
        if($productReviewExistOrNot){
            return response()->json(['productReviewExistOrNot'=>1,'message'=>"Already you have a review for the product",'code'=>true],201);
        }
        else{

            $productReview = new ProductReview();
            $productReview->product_id = $request->product_id;
            $productReview->business_profile_id = $request->business_profile_id;
            $productReview->overall_rating = isset($request->overall_rating) ? $request->overall_rating : 0;
            $productReview->communication_rating = isset($request->communication_rating) ? $request->communication_rating : 0 ;
            $productReview->ontime_delivery_rating = isset($request->ontime_delivery_rating) ? $request->ontime_delivery_rating : 0;
            $productReview->sample_support_rating = isset($request->sample_support_rating) ? $request->sample_support_rating : 0;
            $productReview->product_quality_rating = isset($request->product_quality_rating) ? $request->product_quality_rating : 0;
            $productReview->experience = $request->experience;
            $productReview->ip_address = $request->ip??"127.0.0.1";
            $productReview->user_agent = $request->user_agent??"opera";
            $productReview->state=1;
            $productReview->created_by = auth()->id();
            $total_rating= $productReview->overall_rating+$productReview->communication_rating+ $productReview->ontime_delivery_rating+  $productReview->sample_support_rating+$productReview->product_quality_rating;
            $average_rating= $total_rating/ 5.0;
            $productReview->average_rating= $average_rating;
            $productReview->save();

            if(isset($productReview)){
            return response()->json(['user'=>$user,'productReview'=>$productReview,'message'=>"product reviewed successfully",'code'=>true],201);

            }
            else{
                return response()->json(['user'=>$user,'productReview'=>$productReview,'message'=>"product reviewed failed",'code'=>false],200);
            }
        }
    }

    public function createVendorReview(Request $request){

        $order=VendorOrder::where('order_number',$request->orderNumber)->first();
        $vendorReviewExistOrNot=VendorReview::where('order_id',$request->order_id)->where('created_by',auth()->id())->first();
        $user=User::where('id',auth()->id())->first();
        if($vendorReviewExistOrNot){
            return response()->json(['vendorReviewExistOrNot'=>1,'message'=>"Already you have a review for the store on this order",'code'=>true],201);
        }
        else{

            $vendorReview = new VendorReview();
            $vendorReview->order_id = $request->order_id;
            $vendorReview->vendor_id = $request->vendor_id;
            $vendorReview->overall_rating = $request->overall_rating??0;
            $vendorReview->communication_rating = $request->communication_rating??0;
            $vendorReview->ontime_delivery_rating = $request->ontime_delivery_rating??0;
            $vendorReview->sample_support_rating = $request->sample_support_rating??0;
            $vendorReview->product_quality_rating = $request->product_quality_rating??0;
            $vendorReview->experience = $request->experience;
            $vendorReview->ip_address = $request->ip()??"127.0.0.1";
            $vendorReview->user_agent = $request->header('User-Agent')??"uc browser";
            $vendorReview->state=1;
            $vendorReview->created_by = auth()->id();
            $total_rating= $vendorReview->overall_rating+$vendorReview->communication_rating+ $vendorReview->ontime_delivery_rating+  $vendorReview->sample_support_rating+$vendorReview->product_quality_rating;
            $average_rating= $total_rating/ 5;
            $vendorReview->average_rating= $average_rating;
            $vendorReview->save();
            if(isset($vendorReview)){
                return response()->json(['user'=>$user,'vendorReviewExistOrNot'=>0,'vendorReview'=>$vendorReview,'message'=>"store reviewed successfully",'code'=>true],201);
             }
             else{
                 return response()->json(['user'=>$user,'vendorReviewExistOrNot'=>0,'vendorReview'=>$vendorReview,'message'=>"store reviewed failed",'code'=>false],200);
             }
        }
    }


    public function vendorReviews($vendorId){

        $vendorReviews = VendorReview::with('user')->where('vendor_id', $vendorId)->get();
        $vendorReviewsForAuthUser = VendorReview::where('vendor_id',$vendorId)->where('created_by',auth()->id())->get();
        $vendorReviewsArray=[];
        foreach($vendorReviews as $vendorReview){
            $newFormatedVendorReview=new stdClass;
            $newFormatedVendorReview->order_id = $vendorReview->order_id;
            $newFormatedVendorReview->vendor_id = $vendorReview->vendor_id;
            $newFormatedVendorReview->overall_rating = $vendorReview->overall_rating;
            $newFormatedVendorReview->communication_rating = $vendorReview->communication_rating;
            $newFormatedVendorReview->ontime_delivery_rating = $vendorReview->ontime_delivery_rating;
            $newFormatedVendorReview->sample_support_rating = $vendorReview->sample_support_rating;
            $newFormatedVendorReview->product_quality_rating = $vendorReview->product_quality_rating;
            $newFormatedVendorReview->experience = $vendorReview->experience;
            $newFormatedVendorReview->average_rating= $vendorReview->average_rating;
            $newFormatedVendorReview->created_by= $vendorReview->user->name;
            array_push($vendorReviewsArray,$newFormatedVendorReview);
        }


        if(count($vendorReviews)>0){
            return response()->json(['totalReviewForAuthUser'=>count($vendorReviewsForAuthUser),'vendorReview'=>$vendorReviewsArray,'message'=>"store reviews found",'code'=>true],200);
        }
        else{
             return response()->json(['totalReviewForAuthUser'=>count($vendorReviewsForAuthUser),'vendorReview'=>$vendorReviewsArray,'message'=>"store reviews  not found",'code'=>false],200);
        }

    }
    public function productReviews($productId){

        $productReviews = ProductReview::with('user')->where('product_id',$productId)->get();
        $productReviewsForAuthUser = ProductReview::where('product_id',$productId)->where('created_by',auth()->id())->get();
        $productReviewsArray=[];
        foreach($productReviews as $productReview){
            $newFormatedProductReview=new stdClass;
            $newFormatedProductReview->order_id = $productReview->order_id;
            $newFormatedProductReview->product_id = $productReview->product_id;
            $newFormatedProductReview->overall_rating = $productReview->overall_rating;
            $newFormatedProductReview->communication_rating = $productReview->communication_rating;
            $newFormatedProductReview->ontime_delivery_rating = $productReview->ontime_delivery_rating;
            $newFormatedProductReview->sample_support_rating = $productReview->sample_support_rating;
            $newFormatedProductReview->product_quality_rating = $productReview->product_quality_rating;
            $newFormatedProductReview->experience = $productReview->experience;
            $newFormatedProductReview->average_rating= $productReview->average_rating;
            $newFormatedProductReview->user_id= $productReview->user->id;
            $newFormatedProductReview->created_by= $productReview->user->name;
            $newFormatedProductReview->user_image= $productReview->user->image;
            $newFormatedProductReview->created_at= $productReview->created_at;
            $newFormatedProductReview->updated_at= $productReview->updated_at;
            array_push($productReviewsArray,$newFormatedProductReview);
        }

        if(count($productReviews)>0){
                return response()->json(['totalReviewForAuthUser'=>count($productReviewsForAuthUser),'productReviews'=>$productReviewsArray,'message'=>"product reviews found",'code'=>true],200);
        }
        else{
            return response()->json(['totalReviewForAuthUser'=>count($productReviewsForAuthUser),'productReviews'=>$productReviewsArray,'message'=>"product reviews not found",'code'=>false],200);
        }
    }


}
