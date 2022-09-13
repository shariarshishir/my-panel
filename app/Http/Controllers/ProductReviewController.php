<?php

namespace App\Http\Controllers;
use App\Models\ProductReview;
use Illuminate\Http\Request;
use Session;
use Alert;

class ProductReviewController extends Controller
{



    public function storeProductReview(Request $request,$sku){
        $productReviewExistOrNot=ProductReview::where('product_id',$request->product_id)->where('created_by',auth()->id())->first();

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
            $productReview->ip_address = $request->ip();
            $productReview->user_agent = $request->header('User-Agent');
            $productReview->state=1;
            $productReview->created_by = auth()->id();

            $total_rating= $productReview->overall_rating+$productReview->communication_rating+ $productReview->ontime_delivery_rating+  $productReview->sample_support_rating+$productReview->product_quality_rating;
            $average_rating= $total_rating/ 5;
            $productReview->average_rating= $average_rating;
            $productReview->save();
            if($productReview){
                alert()->success('Product reviewed successfully')->autoclose(3500);
                return redirect()->back();

            }
        }



    }

}
