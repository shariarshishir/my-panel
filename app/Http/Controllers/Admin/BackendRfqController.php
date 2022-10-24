<?php

namespace App\Http\Controllers\Admin;

use DataTables;
use App\Models\Rfq;
use App\Models\BusinessProfile;
use App\Models\supplierQuotationToBuyer;
use App\Models\User;
use Illuminate\Http\Request;
use App\Events\NewRfqHasAddedEvent;
use App\Http\Controllers\Controller;
use App\Userchat;
use App\Models\Proforma;
use App\Models\Manufacture\ProductCategory;
use Illuminate\Support\Facades\Http;
use App\Http\Traits\PushNotificationTrait;
use App\Models\ProductTag;
use Illuminate\Support\Facades\Auth;
use App\Events\NewQuotationHasPostedEvent;

class BackendRfqController extends Controller
{
    use PushNotificationTrait;
    public function index(Request $request){
        $page = isset($request->page) ? $request->page : 1;
        //all published or unpublished rfqs
        $response = Http::get(env('RFQ_APP_URL').'/api/quotation/status/all/filter/null/page/'.$page.'/limit/10');
        $data = $response->json();
        $rfqs = $data['data'];
        $rfqsCount = $data['count'];
        $noOfPages = ceil($data['count']/10);
        $proformas = Proforma::select('generated_po_from_rfq')->get();
        return view('admin.rfq.index',compact('rfqs','rfqsCount','noOfPages','proformas'));
    }

    public function fetchRFQsByQueryStringOrPagination(Request $request){
        // $limit = $request->limit;
        // $filter = $request->filter??'null';
        // $page = $request->page??'1';
        // $response = Http::get(env('RFQ_APP_URL').'/api/quotation/status/all/filter/'.$filter.'/page/'.$page.'/limit/'.$limit);
        // $data = $response->json();
        // $rfqs = $data['data'];
        // $rfqsCount = $data['count'];
        // $noOfPages = ceil($data['count']/10);
        // return view('admin.rfq.table',compact('rfqs'))->render();

        $limit = $request->limit;
        $filter = $request->filter ?? 'null';
        $page = isset($request->page) ? $request->page : 1;
        //all published or unpublished rfqs
        //$response = Http::get(env('RFQ_APP_URL').'/api/quotation/status/all/filter/null/page/'.$page.'/limit/10');
        $response = Http::get(env('RFQ_APP_URL').'/api/quotation/status/all/filter/'.$filter.'/page/'.$page.'/limit/'.$limit);
        $data = $response->json();
        $rfqs = $data['data'];
        $rfqsCount = $data['count'];
        $noOfPages = ceil($data['count']/10);
        $proformas = Proforma::select('generated_po_from_rfq')->get();
        //return view('admin.rfq.index',compact('rfqs','rfqsCount','noOfPages','proformas'));
        return view('admin.rfq.table',compact('rfqs','rfqsCount','noOfPages','proformas'))->render();
    }

    public function show($id, $link = false, $type = false){
        //rfq details
        $response = Http::get(env('RFQ_APP_URL').'/api/quotation/'.$id);
        $data = $response->json();
        $rfq = $data['data']['data'];
        $businessProfilesShortListed = 0;
        $businessProfilesSelectedListed = 0;

        if( isset($rfq['short_listed_profiles']) ) {

            // $shortListedProfiles = [];
            // foreach($rfq['short_listed_profiles'] as $bid) {
            //     if($bid) {
            //         array_push($shortListedProfiles, $bid);
            //     }
            // }
            // $businessProfilesShortListed = BusinessProfile::whereIn('id', $shortListedProfiles)->get();
            // $businessProfilesShortListed = count($businessProfilesShortListed);

            $rfq['short_listed_profiles'] = $rfq['short_listed_profiles'];
            $rfq['short_listed_profiles'] = implode("," , $rfq['short_listed_profiles']);

        } else {
            $rfq['short_listed_profiles'] = "";
        }

        if( isset($rfq['selected_profile']) ) {

            // $selectedListedProfiles = [];
            // foreach($rfq['selected_profile'] as $bid) {
            //     if($bid) {
            //         array_push($selectedListedProfiles, $bid);
            //     }
            // }
            // $businessProfilesSelectedListed = BusinessProfile::whereIn('id', $selectedListedProfiles)->get();
            // $businessProfilesSelectedListed = count($businessProfilesSelectedListed);

            $rfq['selected_profile'] = $rfq['selected_profile'];
            $rfq['selected_profile'] = implode("," , $rfq['selected_profile']);
        } else {
            $rfq['selected_profile'] = "";
        }
        //dd($rfq['short_listed_profiles']);

        $factory_type_value = [];
        foreach($rfq['category'] as $category) {
            array_push($factory_type_value, $category['name']);
        }

        $product_tag = ProductTag::get();

        // $product_tag=ProductTag::with('tagMapping')->whereIn('id',$rfq['category_id'])->get();
        // $factory_type=[];
        // $industry_type=[];
        // foreach($product_tag as $tag){
        //     foreach($tag->tagMapping as $mapping){
        //         array_push($factory_type,$mapping->name);
        //         array_push($industry_type,$mapping->parent->name);
        //     }
        // }
        // $factroy_unique= array_unique($factory_type);
        // $factory_values= array_values($factroy_unique);
        // $industry_unique= array_unique($industry_type);
        // $industry_values= array_values($industry_unique);

        $product_tag_for_parent_id = ProductTag::with('tagMapping')->whereIn('id',$rfq['category_id'])->get();
        $factory_type_as_tag_parent = [];
        foreach($product_tag_for_parent_id as $tag){
            foreach($tag->tagMapping as $mapping){
                array_push($factory_type_as_tag_parent,$mapping->name);
            }
        }

        $businessProfiles = BusinessProfile::select('business_profiles.*')
        ->leftJoin('rfq_quotation_sent_supplier_to_buyer_rel', 'rfq_quotation_sent_supplier_to_buyer_rel.business_profile_id', '=', 'business_profiles.id')
        ->with(['user','supplierQuotationToBuyer'=> function($q) use ($id){
            $q->where('rfq_id', $id);}])
        ->whereIn('factory_type',$factory_type_value)
        ->orWhereIn('factory_type',$factory_type_as_tag_parent)
        //->whereIn('industry_type',$industry_values)
        //->where('business_type', 'manufacturer')
        ->where('profile_verified_by_admin', '!=', 0)
        ->groupBy('business_profiles.id')
        ->orderBy('rfq_quotation_sent_supplier_to_buyer_rel.created_at', 'desc')
        ->get()
        ->toArray();

        // Data fetching for tags parents start
        /*
        $product_tag_for_parent_id = ProductTag::with('tagMapping')->whereIn('id',$rfq['category_id'])->get();
        $factory_type_as_tag_parent = [];
        foreach($product_tag_for_parent_id as $tag){
            foreach($tag->tagMapping as $mapping){
                array_push($factory_type_as_tag_parent,$mapping->name);
            }
        }

        $businessProfilesForTagsParent = BusinessProfile::select('business_profiles.*')
        ->leftJoin('rfq_quotation_sent_supplier_to_buyer_rel', 'rfq_quotation_sent_supplier_to_buyer_rel.business_profile_id', '=', 'business_profiles.id')
        ->with(['user','supplierQuotationToBuyer'=> function($q) use ($id){
            $q->where('rfq_id', $id);}])
        ->whereIn('factory_type',$factory_type_as_tag_parent)
        ->where('profile_verified_by_admin', '!=', 0)
        ->groupBy('business_profiles.id')
        ->orderBy('rfq_quotation_sent_supplier_to_buyer_rel.created_at', 'desc')
        ->get()
        ->toArray();
        */
        // Data fetching for tags parents end

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
        $profromaInvoice = Proforma::where('generated_po_from_rfq',$id)->latest()->first();

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
        $response = Http::get(env('RFQ_APP_URL').'/api/rfq/'.$id.'/users/'.$commaSeparatedStringOfSsoId.'/conversations');
        $data = $response->json();
        $usersWithMessageUnseen = $data['data'] ?? [];
        $associativeArrayUsingIDandCount = [];
        foreach($usersWithMessageUnseen as $user){
            $associativeArrayUsingIDandCount[$user['user_id']]  = $user;
        }
        $proforma_invoice_url_for_buyer =$profromaInvoice ? route('open.proforma.single.html', $profromaInvoice->id) : '';
        $url_exists=$link;
        return view('admin.rfq.show', compact('rfq','businessProfiles','businessProfilesShortListed','businessProfilesSelectedListed','buyerBusinessProfile','chatdata','from_user_image','to_user_image','user','buyer','productCategories','userNameShortForm','profromaInvoice','associativeArrayUsingIDandCount','proforma_invoice_url_for_buyer','url_exists', 'product_tag', 'factory_type_as_tag_parent'));
    }

    public function sendFireBasePushNotificationToAdminForNewMessage(Request $request){
        $admin = Auth::guard('admin')->user();
        $response = Http::get(env('RFQ_APP_URL').'/api/quotation/'.$request->rfq_id);
        $data = $response->json();
        $rfq = $data['data']['data'];
        $fcmToken = $admin->fcm_token;
        $title = "New message arrived";
        $message = "A new message has arrived for rfq:".$rfq['title'];
        $action_url = route('admin.rfq.show',$request->rfq_id);
        $this->pushNotificationSend($fcmToken,$title,$message,$action_url);
        return response()->json(['message'=>'successfully send push notification'],200);
    }

    public function sendFireBasePushNotificationToAllAdminForNewMessage(Request $request){
        $allAdmins = Admin::all();
        foreach($allAdmins as $admin) {
            $response = Http::get(env('RFQ_APP_URL').'/api/quotation/'.$request->rfq_id);
            $data = $response->json();
            $rfq = $data['data']['data'];
            $fcmToken = $admin->fcm_token;
            $title = "New message arrived";
            $message = "A new message has arrived for rfq:".$rfq['title'];
            $action_url = route('admin.rfq.show',$request->rfq_id);
            $this->pushNotificationSend($fcmToken,$title,$message,$action_url);
        }
        return response()->json(['message'=>'successfully send push notification'],200);
    }

    public function businessProfilesWithUnseenMessageCount(Request $request){
        $response = Http::get(env('RFQ_APP_URL').'/api/conversations/unseen/rfq/'.$request->rfq_id);
        $data = $response->json();
        $suppliersWithMessageCount = $data['data'];
        $supplierSsoIds = [];
        foreach($suppliersWithMessageCount as $supplierWithMessageCount){
            array_push($supplierSsoIds,$supplierWithMessageCount['user_id']);
        }
        $userIds = User::whereIn('sso_reference_id',$supplierSsoIds)->pluck('id')->toArray();
        $businessProfiles = BusinessProfile::with(['user','supplierQuotationToBuyer' => function ($q) use ($request){
            $q->where('rfq_id', 'LIKE',"%$request->rfq_id%");
        } ])->whereIn('user_id',$userIds)->where('profile_verified_by_admin', '!=', 0)->orderBy('profile_rating', 'DESC')->get();
        $associativeArrayUsingIDandCount = [];
        foreach($suppliersWithMessageCount as $supplierWithMessageCount){
            $associativeArrayUsingIDandCount[$supplierWithMessageCount['user_id']]  = $supplierWithMessageCount;
        }
        return response()->json(['businessProfiles'=>$businessProfiles, 'associativeArrayUsingIDandCount' => $associativeArrayUsingIDandCount],200);
    }

    public function getChatDataBySupplierId(Request $request){
        $supplier = User::where('sso_reference_id',$request->sso_reference_id)->first();
        if( env('APP_ENV') == 'production') {
            $user = "5771";
        }
        else{
            $user = "5552";
        }
        $adminUser = User::find($user);
        $adminUserImage = isset($adminUser->image) ? asset($adminUser->image) : asset('images/frontendimages/no-image.png');

        if(isset($supplier->image)){
            $supplierImage = asset($supplier->image);
            $supplierNameShortForm = "";
        }else{
            $nameWordArray = explode(" ", $request->business_name);
            $firstWordFirstLetter = $nameWordArray[0][0];
            $secondWordFirstLetter = $nameWordArray[1][0] ??'';
            $supplierNameShortForm = $firstWordFirstLetter.$secondWordFirstLetter;
            $supplierImage = "";
        }


        $response =   Http::get(env('RFQ_APP_URL').'/api/messages/'.$request->rfq_id.'/admin/'.$user.'/user/'.$request->supplier_id);
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

        return response()->json([
            'chatdata' => $chatdata,
            'supplierImage' => $supplierImage,
            'supplierNameShortForm'=>$supplierNameShortForm,
            'adminUserImage' => $adminUserImage
        ],200);

    }

    public function status(Request $request,$id){

        if($request->publish_type == "only_on_tags") {
            $publisheType = $request->publish_type.','.$request->rfq_selected_tag_type;
        } elseif($request->publish_type == "only_on_factories") {
            $publisheType = $request->publish_type.','.$request->rfq_selected_factory_type;
        } else {
            $publisheType = $request->publish_type.','.$request->rfq_selected_tag_type.','.$request->rfq_selected_factory_type;
        }

        $response = Http::put(env('RFQ_APP_URL').'/api/quotation/'.$id, [
            'status' => ( $request->status == 'pending' ) ? 'approved' : 'pending',
            'publish_type' => $publisheType,
        ]);
        if( $response->status()  == 200){

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

                //$selectedUserToSendMail="success@merchantbay.com";
                //event(new NewRfqHasAddedEvent($selectedUserToSendMail,$rfq));

            // }


            return redirect()->back()->withSuccess('Rfq status updated successfully');
        }else{
            return redirect()->back()->withSuccess('Something went wrong!!');
        }

    }

    public function profileShortList( Request $request )
    {
        //dd($request->all());
        $rfqId = $request->rfqId;
        $requestForm = $request->requestForm;
//dd($shortList);

        if($requestForm == "from_selected") {
            $selectedList = explode("," , $request->selectedList);
            $removeSelectedList = explode("," , $request->removeSelectedList);

            $response = Http::put(env('RFQ_APP_URL').'/api/quotation/'.$rfqId, [
                'selected_profile' => $selectedList,
            ]);

            foreach($selectedList as $id) {
                if($id) {
                    $business_profile = BusinessProfile::where('id', $id)->update(['profile_selected' => 1]);
                }
            }
            foreach($removeSelectedList as $id) {
                if($id) {
                    $business_profile = BusinessProfile::where('id', $id)->update(['profile_selected' => 0]);
                }
            }

        } else {
            $shortList = explode("," , $request->shortList);
            $removeShortList = explode("," , $request->removeShortList);
            $response = Http::put(env('RFQ_APP_URL').'/api/quotation/'.$rfqId, [
                'short_listed_profiles' => $shortList,
            ]);

            foreach($shortList as $id) {
                if($id) {
                    $business_profile = BusinessProfile::where('id', $id)->update(['profile_shortlisted' => 1]);
                }
            }
            foreach($removeShortList as $id) {
                if($id) {
                    $business_profile = BusinessProfile::where('id', $id)->update(['profile_shortlisted' => 0]);
                }
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

    public function businessProfileFilter(Request $request){
        // if($request->category_id && $request->profile_rating !=0)
        // {
        //     //$businessProfiles = BusinessProfile::select('id','business_name','alias','business_type')->where('business_category_id',$request->category_id)->where('profile_rating',$request->profile_rating)->where('profile_verified_by_admin', '!=', 0)->get();
        //     $businessProfiles = BusinessProfile::with(['user','supplierQuotationToBuyer' => function ($q) use ($request){
        //         $q->where('rfq_id', 'LIKE',"%$request->rfq_id%");
        //     } ])->where('business_category_id',$request->category_id)->where('profile_rating','<=',$request->profile_rating)->where('profile_verified_by_admin', '!=', 0)->orderBy('profile_rating', 'DESC')->get();

        // }
        // elseif($request->category_id && $request->profile_rating ==0)
        // {
        //     //$businessProfiles = BusinessProfile::select('id','business_name','alias','business_type')->where('business_category_id',$request->category_id)->where('profile_verified_by_admin', '!=', 0)->get();
        //     $businessProfiles = BusinessProfile::with(['user','supplierQuotationToBuyer' => function ($q) use ($request){
        //         $q->where('rfq_id', 'LIKE',"%$request->rfq_id%");
        //     } ])->where('business_category_id',$request->category_id)->where('profile_verified_by_admin', '!=', 0)->get();
        // }

        $businessProfiles = BusinessProfile::with(['user','supplierQuotationToBuyer' => function ($q) use ($request){
            $q->where('rfq_id', 'LIKE',"%$request->rfq_id%");
        } ])->where('factory_type',$request->category_id)->where('profile_rating','<=',$request->profile_rating)->where('profile_verified_by_admin', '!=', 0)->where('business_type', 'manufacturer')->orderBy('profile_rating', 'DESC')->get();

        $userSsoIds = [];
        foreach($businessProfiles as $profile){
            array_push($userSsoIds, $profile['user']['sso_reference_id']);
        }
        //suppliers with unseen message for a specific rfq
        $commaSeparatedStringOfSsoId = implode(",",$userSsoIds);
        $response = Http::get(env('RFQ_APP_URL').'/api/conversations/unseen/rfq/'.$request->rfq_id.'/users/'.$commaSeparatedStringOfSsoId);
        $data = $response->json();
        $usersWithMessageUnseen = $data['data'] ?? [];
        $associativeArrayUsingIDandCount = [];
        foreach($usersWithMessageUnseen as $user){
            $associativeArrayUsingIDandCount[$user['user_id']]  = $user;
        }
        return response()->json(['businessProfiles'=>$businessProfiles, 'associativeArrayUsingIDandCount' => $associativeArrayUsingIDandCount],200);
    }

    public function businessProfileFilterByTitle(Request $request){
        if($request->search_title)
        {
            //$businessProfiles = BusinessProfile::select('id','business_name','alias','business_type')->where('business_category_id',$request->category_id)->where('profile_rating',$request->profile_rating)->where('profile_verified_by_admin', '!=', 0)->get();
            $businessProfiles = BusinessProfile::with(['user','supplierQuotationToBuyer' => function ($q) use ($request){
                $q->where('rfq_id', 'LIKE',"%$request->rfq_id%");
            } ])->where('business_name', 'LIKE',"%$request->search_title%")->get();

        }
        $userSsoIds = [];
        foreach($businessProfiles as $profile){
            array_push($userSsoIds, $profile['user']['sso_reference_id']);
        }
        //suppliers with unseen message for a specific rfq
        $commaSeparatedStringOfSsoId = implode(",",$userSsoIds);
        $response = Http::get(env('RFQ_APP_URL').'/api/conversations/unseen/rfq/'.$request->rfq_id.'/users/'.$commaSeparatedStringOfSsoId);
        $data = $response->json();
        $usersWithMessageUnseen = $data['data'] ?? [];
        $associativeArrayUsingIDandCount = [];
        foreach($usersWithMessageUnseen as $user){
            $associativeArrayUsingIDandCount[$user['user_id']]  = $user;
        }
        return response()->json(['businessProfiles'=>$businessProfiles, 'associativeArrayUsingIDandCount' => $associativeArrayUsingIDandCount],200);
    }

    public function supplierQuotationToBuyer(Request $request){

        //dd($request->all());

        $quotation = supplierQuotationToBuyer::where('business_profile_id',$request->business_profile_id)->where('rfq_id',$request->rfq_id)->where('from_backend',1)->first();
        $to_user = User::with('businessProfile')->where('email',$request['rfq_owner_email'])->first();

        if($quotation)
        {
            $quotation->update(['offer_price_unit'=> $request->offer_price_unit]);
            $quotation->update(['offer_price'=> $request->offer_price]);
        }
        else
        {
            $supplierQuotationToBuyer = new supplierQuotationToBuyer();
            $supplierQuotationToBuyer->rfq_id = $request->rfq_id;
            $supplierQuotationToBuyer->business_profile_id = $request->business_profile_id;
            $supplierQuotationToBuyer->offer_price = $request->offer_price;
            $supplierQuotationToBuyer->offer_price_unit = $request->offer_price_unit;
            $supplierQuotationToBuyer->save();
        }

        event(new NewQuotationHasPostedEvent($to_user));

        return response()->json(["status" => 1, "message" => "successful"]);
    }
}
