<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\VendorReview;
use App\Models\Vendor;
use App\Models\VendorOrder;
use Illuminate\Support\Facades\Auth;
use Session;

class VendorReviewController extends Controller
{


    public function __construct()
    {
      $this->middleware(['auth','sso.verified']);
    }

    public function index(){

        $notifications = auth()->user()->unreadNotifications;
        $orderIds=[];
        $orderModificationRequestIds=[];
        $orderApprovedNotificationIds=[];
        $orderModificationRequestNotificationIds=[];
        $orderQueryProcessedIds=[];
        foreach($notifications as $notification)
        {
            if($notification->type == "App\Notifications\NewOrderHasApprovedNotification"){
                array_push($orderIds,$notification->data['notification_data']);
            }
            else if($notification->type == "QueryWithModificationToUserNotification"){
                array_push($orderModificationRequestIds,$notification->data['notification_data']);

            }
            else if($notification->type == "App\Notifications\OrderQueryFromAdminNotification"){
                array_push($orderQueryProcessedIds,$notification->data['notification_data']['order_modification_request_id']);
            }
            else if($notification->type == "App\Notifications\QueryCommuncationNotification"){
                array_push($orderModificationRequestIds,$notification->data['notification_data']);

            }
        }

        $vendorReviews = VendorReview::where('vendor_id', auth()->user()->vendor->id)->get();

        return view('user.profile.reviews._partial_index',compact('vendorReviews','orderIds','orderModificationRequestIds','orderQueryProcessedIds'));


    }

    public function showReviewForm($orderNumber,$vendorUid){

        $order=VendorOrder::where('order_number',$orderNumber)->first();
        $vendor=Vendor::where('vendor_uid',$vendorUid)->first();
        $vendorReviewExistOrNot=VendorReview::where('order_id',$order->id)->where('vendor_id',$vendor->id)->first();

        return view('user.review.vendor_review_form',compact('vendor','order','vendorReviewExistOrNot'));
    }

    public function createVendorReview(Request $request,$orderNumber,$vendorUid){

        $order=VendorOrder::where('order_number',$orderNumber)->first();
        $vendor=Vendor::where('vendor_uid',$vendorUid)->first();
        $vendorReviewExistOrNot=VendorReview::where('order_id',$order->id)->where('vendor_id',$vendor->id)->first();

        if($vendorReviewExistOrNot){
            return redirect()->back()->with('vendorReviewExistOrNot',$vendorReviewExistOrNot);
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
            $vendorReview->ip_address = $request->ip();
            $vendorReview->user_agent = $request->header('User-Agent');
            $vendorReview->state=1;
            $vendorReview->created_by = auth()->id();
            $total_rating= $vendorReview->overall_rating+$vendorReview->communication_rating+ $vendorReview->ontime_delivery_rating+  $vendorReview->sample_support_rating+$vendorReview->product_quality_rating;
            $average_rating= $total_rating/ 5;
            $vendorReview->average_rating= $average_rating;
            $vendorReview->save();
            if($vendorReview){
                alert()->success('Store reviewed successfully')->autoclose(3500);
                return redirect()->route('users.profile');
            }
        }
    }

}
