<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Rfq;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use App\Models\RfqImage;
use App\Models\User;
use App\Models\SupplierBid;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use App\Events\NewRfqHasAddedEvent;
use App\Models\BusinessProfile;
use App\Models\supplierQuotationToBuyer;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use App\Models\ProductTag;
use App\Models\Manufacture\ProductCategory;
use App\Models\Proforma;
use App\Models\Product;
use stdClass;

class RFQController extends Controller
{
    public function index()
    {
        $rfqs = Rfq::withCount('bids')->with('images','user')->latest()->paginate(10);
        $rfqIdsWithBid = SupplierBid::where('supplier_id',auth()->user()->id)->pluck('rfq_id')->toArray();
        $newRfqWithNotificationIds = [];
        foreach(auth()->user()->unreadNotifications->where('type','App\Notifications\NewRfqNotification')->where('read_at',null) as $notification){
            array_push($newRfqWithNotificationIds,$notification->data['rfq_data']['id']);
        }

        if(($rfqs->total())>0){
            return response()->json(['rfqIdsWithBid'=>$rfqIdsWithBid,'rfqs'=>$rfqs,'newRfqWithNotificationIds'=>$newRfqWithNotificationIds,"success"=>true],200);
        }
        else{
            return response()->json(['rfqIdsWithBid'=>$rfqIdsWithBid,'rfqs'=>$rfqs,'newRfqWithNotificationIds'=>$newRfqWithNotificationIds,"success"=>false],200);
        }
    }
    public function rfqListforMigration()
    {
        $rfqs = Rfq::with('images','bids.businessProfile','category','user')->get();
        if(count($rfqs) > 0)
        {
            return response()->json(['count'=>count($rfqs),'rfqs'=>$rfqs,'success'=>true],200);
        }
        else
        {
            return response()->json(['count'=>count($rfqs),'rfqs'=>$rfqs,"success"=>false],200);
        }
    }

    public function myRfqList()
    {
        $rfqs=Rfq::withCount('bids')->with('images','user','bids')->where('created_by',auth()->id())->latest()->paginate(5);
        if($rfqs->total()>0){

            return response()->json(['rfqs'=>$rfqs,"success"=>true],200);
        }
        else{

            return response()->json(['rfqs'=> $rfqs,"success"=>false],200);
        }
    }
    public function rfqListByCategoryId($id)
    {
        $rfqs=Rfq::withCount('bids')->with('images','user','bids')->where('category_id',$id)->latest()->paginate(5);
        $rfqIdsWithBid = SupplierBid::where('supplier_id',auth()->user()->id)->pluck('rfq_id')->toArray();
        if($rfqs->total()>0){

            return response()->json(['rfqs'=>$rfqs,'rfqIdsWithBid'=>$rfqIdsWithBid,"success"=>true],200);
        }
        else{

            return response()->json(['rfqs'=> $rfqs, 'rfqIdsWithBid'=>$rfqIdsWithBid ,"success"=>false],200);
        }
    }

    public function searchRfqByTitle(Request $request){

        if(!empty($request->search_input)){
            $rfqs = Rfq::with('images','user','bids')->where('title', 'like', '%'.$request->search_input.'%')->paginate(10);
            if($rfqs->total()>0){
                return response()->json(['rfqs' => $rfqs, 'message' => 'RFQ found','code'=>false], 200);
            }
            else{
                return response()->json(['rfqs' => $rfqs, 'message' => 'RFQ not found','code'=>False], 200);
            }
        }
    }

    public function store(Request $request){

        // $validator = Validator::make($request->all(), [
        //     'category_id' => 'required',
        //     'title'       => 'required',
        //     'quantity'    => 'required',
        //     'unit'        =>  'required',
        //     'unit_price'     => 'required',
        //     'payment_method' => 'required',
        //     'delivery_time'  => 'required',
        //     'destination'   => 'required',
        // ]);
        // if ($validator->fails())
        // {
        //     return response()->json(array(
        //     'success' => false,
        //     'error' => $validator->getMessageBag()),
        //     400);
        // }
        try{

            $rfqData = $request->except(['product_images']);
            $rfqData['created_by']=auth()->id();
            $rfqData['status']='pending';
            $rfqData['link'] = $this->generateUniqueLink();
            $rfq = Rfq::create($rfqData);
            if ($request->hasFile('product_images')){
                foreach ($request->file('product_images') as $index=>$product_image){
                    $extension = $product_image->getClientOriginalExtension();
                    if($extension=='pdf' ||$extension=='PDF' ||$extension=='doc'||$extension=='docx'||$extension=='xlsx'||$extension=='xl'){
                        $path=$product_image->store('images','public');
                    }
                    else{

                        $path=$product_image->store('images','public');
                        $image = Image::make(Storage::get($path))->fit(555, 555)->encode();
                        Storage::put($path, $image);

                    }
                    RfQImage::create(['rfq_id'=>$rfq->id, 'image'=>$path]);
                }
            }
            if(env('APP_ENV') == 'production')
            {
                $selectedUsersToSendMail = User::where('id','<>',auth()->id())->take(10)->get();
                foreach($selectedUsersToSendMail as $selectedUserToSendMail) {
                    event(new NewRfqHasAddedEvent($selectedUserToSendMail,$rfq));
                }

                $selectedUserToSendMail="success@merchantbay.com";
                event(new NewRfqHasAddedEvent($selectedUserToSendMail,$rfq));
            }

            $message = "Congratulations! Your RFQ was posted successfully. Soon you will receive quotation from Merchant Bay verified relevant suppliers.";
            if($rfq){

                return response()->json(['rfq'=>$rfq,'rfqImages'=>$rfq->images,'user'=>$rfq->user,"message"=>$message,"success"=>true],200);
            }
            else{
                return response()->json(["success"=>false],200);
            }
        }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'error'   => ['message' => $e->getMessage()],
            ],500);
        }
    }

    public function storeRfqFromOMD(Request $request){
        // try{
        //     return response()->json()
            $userObj = json_decode($request->user);
            return response()->json(['user'=>$userObj]);
            //user loging credential
            $email = $userObj->email;
            $password = base64_decode($userObj->password);

            //check user exists or not
            $user=User::where('email', $email)->first();
            if(!$user){
                $user_id = IdGenerator::generate(['table' => 'users', 'field' => 'user_id','reset_on_prefix_change' =>true,'length' => 18, 'prefix' => date('ymd').time()]);
                $user = User::create([
                    'user_id'=>$user_id,
                    'name' => $userObj->name,
                    'email' => $email,
                    'password' => bcrypt($password),
                    'user_type' => 'buyer',
                    'sso_reference_id' =>$userObj->id,
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->header('User-Agent'),
                    'phone'     => $userObj->phone,
                    'company_name' => $userObj->company->name,
                    'is_email_verified' => 1,
                ]);
            }

            $rfqData = $request->except(['product_images','user','sso_reference_id']);
            $rfqData['created_by']=$user->id;
            $rfqData['status']='pending';
            $rfqData['link'] = $this->generateUniqueLink();
            $rfq=Rfq::create($rfqData);

            if ($request->hasFile('product_images')){
                foreach ($request->file('product_images') as $index=>$product_image){
                    $path=$product_image->store('images','public');
                    $image = Image::make(Storage::get($path))->fit(555, 555)->encode();
                    Storage::put($path, $image);
                    RfQImage::create(['rfq_id'=>$rfq->id, 'image'=>$path]);
                }
            }
            if(env('APP_ENV') == 'production')
            {
                $selectedUsersToSendMail = User::where('id','<>',auth()->id())->take(5)->get();
                foreach($selectedUsersToSendMail as $selectedUserToSendMail) {
                    event(new NewRfqHasAddedEvent($selectedUserToSendMail,$rfq));
                }

                $selectedUserToSendMail="success@merchantbay.com";
                event(new NewRfqHasAddedEvent($selectedUserToSendMail,$rfq));
            }
            $message = "Congratulations! Your RFQ was posted successfully. Soon you will receive quotation from Merchant Bay verified relevant suppliers.";
            if($rfq){
                return response()->json(['rfq'=>$rfq,'rfqImages'=>$rfq->images,"success"=>true],200);
            }

        // }catch(\Exception $e){
        //     return response()->json([
        //         'success' => false,
        //         'error'   => ['msg' => $e->getMessage()],
        //     ],500);
        // }
    }


    public function  newRfqNotificationMarkAsRead(Request $request){

        foreach(auth()->user()->unreadNotifications->where('type','App\Notifications\NewRfqNotification')->where('read_at',null) as $notification){
            if( $notification->data['notification_data']['id'] == $request->rfq_id)
            {
                $notification->markAsRead();
                $unreadNotifications=auth()->user()->unreadNotifications->where('read_at',null);
                $noOfnotification=count($unreadNotifications);
                $message="Notification mark as read successfully";
                return response()->json(['code'=>true,'message'=>$message,'noOfnotification'=>$noOfnotification]);


            }
            else{
                $unreadNotifications=auth()->user()->unreadNotifications->where('read_at',null);
                $noOfnotification=count($unreadNotifications);
                $message="Notification not found";
                return response()->json(['code'=>false,'message'=>$message,'noOfnotification'=>$noOfnotification]);

            }
        }
    }


    public function getRfqShareableLink($id)
    {
        $rfq=Rfq::where('id',$id)->first();
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

    public function generateUniqueLink()
    {
        do {
            $link = Str::random(20);
        } while (Rfq::where('link', $link)->first());

        return $link;
    }

    public function showMoreQuotation($id, $cat)
    {
        $cat= explode(',',$cat);
        $rfq_with_quotation=supplierQuotationToBuyer::where('rfq_id', $id)->pluck('business_profile_id');
        $business_profile= BusinessProfile::whereIn('business_category_id', $cat)->whereNotIn('id', $rfq_with_quotation)->get();
        return response()->json(['business_profile' => $business_profile], 200);
    }

    public function matchedSuppleirs(Request $request, $rfqid, $link = false)
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
            'rfq' => $rfq,
            'businessProfiles' => $businessProfiles,
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

    public function designProductListForRfq()
    {
        $product_type_mapping_id = 1;
        $design_products_collection = Product::with(['images','businessProfile'])->where('product_type_mapping_id', $product_type_mapping_id)->where(['state' => 1, 'is_featured' => 1])->where('business_profile_id', '!=', null)->inRandomOrder()->limit(4)->get();
        $designProductsArray = [];

        foreach($design_products_collection as $item) {
            $designProducts = new stdClass();
            $designProducts->id = $item->id;
            $designProducts->business_profile_id = $item->business_profile_id;
            $designProducts->name = $item->name;
            $designProducts->product_tag = $item->product_tag;
            $designProducts->sku = $item->sku;
            $designProducts->product_category_id = $item->product_category_id;
            $designProducts->product_type = $item->product_type;
            $designProducts->product_type_mapping_id = $item->product_type_mapping_id;
            $designProducts->product_type_mapping_child_id = $item->product_type_mapping_child_id;
            $designProducts->attribute = json_decode($item->attribute);
            $designProducts->is_featured = $item->is_featured;
            $designProducts->is_new_arrival = $item->is_new_arrival;
            $designProducts->state = $item->state;
            $designProducts->colors_sizes = $item->colors_sizes;
            $designProducts->moq = $item->moq;
            $designProducts->product_unit = $item->product_unit;
            $designProducts->copyright_price = $item->copyright_price;
            $designProducts->description = $item->description;
            $designProducts->additional_description = $item->additional_description;
            $designProducts->availability = $item->availability;
            $designProducts->sold = $item->sold;
            $designProducts->full_stock = $item->full_stock;
            $designProducts->full_stock_price = $item->full_stock_price;
            $designProducts->full_stock_negotiable = $item->full_stock_negotiable;
            $designProducts->customize = $item->customize;
            $designProducts->overlay_small_image = $item->overlay_small_image;
            $designProducts->overlay_original_image = $item->overlay_original_image;
            $designProducts->gender = $item->gender;
            $designProducts->sample_availability = $item->sample_availability;
            $designProducts->priority_level = $item->priority_level;
            $designProducts->free_to_show = $item->free_to_show;
            $designProducts->product_code = $item->product_code;
            $designProducts->ip_address = $item->ip_address;
            $designProducts->user_agent = $item->user_agent;
            $designProducts->created_by = $item->created_by;
            $designProducts->updated_by = $item->updated_by;
            $designProducts->deleted_at = $item->deleted_at;
            $designProducts->created_at = $item->created_at;
            $designProducts->updated_at = $item->updated_at;
            $designProducts->flag = $item->flag;
            $designProducts->images = $item->images;
            $designProducts->business_profile = $item->business_profile;
            array_push($designProductsArray, $designProducts);
        }

        return response()->json([
            'design_products' => $designProductsArray,
        ], 200);
    }

}
