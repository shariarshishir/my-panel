<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BusinessProfile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Manufacture\Product;
use App\Models\Proforma;
use App\Models\PaymentTerm;
use App\Models\ShipmentTerm;
use App\Models\ShippingMethod;
use App\Models\ProFormaShippingDetails;
use App\Models\ProFormaShippingFile;
use App\Models\ProFormaAdvisingBank;
use App\Models\ProFormaSignature;
use App\Models\ShipmentType;
use App\Models\UOM;
use App\Models\ProformaProduct;
use App\Models\MerchantAssistance;
use App\Models\ProFormaTermAndCondition;
use App\Models\ProformaCheckedMerchantAssistance;
use App\Models\SupplierCheckedProFormaTermAndCondition;
use Carbon\Carbon;
use App\Events\NewProfromaInvoiceHasCreatedEvent;
use PDF;

class ProformaInvoiceController extends Controller
{
    public function createdProformaByAuthUser()
    {
        $proformaInvoices = Proforma::with('performa_items')->whereHas('performa_items', function($q){
                    $q->where('supplier_id', Auth::id());
                })
                ->latest()->get();
        if(count($proformaInvoices)>0){
            return response()->json([
                'success'=>True,
                'proformaInvoices'=>$proformaInvoices
                
            ],200);

        }
        else{
            return response()->json([
                'proformaInvoices'=>$proformaInvoices,
                'success'=>false
            ],200);
        }
          
    }

    public function receivedProformaByAuthUser()
    {
        $proformaInvoices = Proforma::with('performa_items')->where('buyer_id', auth()->id())->latest()->get();
        
        if(count($proformaInvoices)>0){
            return response()->json([
                'proformaInvoices'=>$proformaInvoices,
                'success'=>True
            ],200);

        }
        else{
            return response()->json([
                'proformaInvoices'=>$proformaInvoices,
                'success'=>false
            ],200);
        }
          
    }

    public function searchProformaCreatedByAuthUser(Request $request)
    {
        $proformaInvoices = Proforma::with('performa_items')->where('proforma_id','like','%'.$request->search_input.'%')->whereHas('performa_items', function($q){
                    $q->where('supplier_id', Auth::id());
                })
                ->latest()->get();
        if(count($proformaInvoices)>0){
            return response()->json([
                'success'=>True,
                'proformaInvoices'=>$proformaInvoices
                
            ],200);

        }
        else{
            return response()->json([
                'proformaInvoices'=>$proformaInvoices,
                'success'=>false
            ],200);
        }
          
    }

    public function searchProformaReceivedByAuthUser(Request $request)
    {
        $proformaInvoices = Proforma::with('performa_items')->where('proforma_id','like','%'.$request->search_input.'%')->where('buyer_id', auth()->id())->latest()->get();
        
        if(count($proformaInvoices)>0){
            return response()->json([
                'proformaInvoices'=>$proformaInvoices,
                'success'=>True
            ],200);

        }
        else{
            return response()->json([
                'proformaInvoices'=>$proformaInvoices,
                'success'=>false
            ],200);
        }
          
    }


    public function allInformationNeededToCreateProFormaInvoice()
	{
		$user = Auth::user();
        $paymentTerms = PaymentTerm::get();
        $shipmentTerms = ShipmentTerm::get();
        $shippingMethods = ShippingMethod::latest()->get();
        $shipmentTypes = ShipmentType::latest()->get();
        $uoms = UOM::latest()->get();
        $proFormaTermAndConditions = ProFormaTermAndCondition::latest()->get();

        $businessProfileIds=[];
        if($user->businessProfile()->exists()){
            foreach($user->businessProfile as $profile){
                array_push($businessProfileIds, $profile->id);
            }
        }
        if($user->businessProfileForRepresentative()->exists()){
            array_push($businessProfileIds, $user->businessProfileForRepresentative->id);
        }

        $businessProfileList = BusinessProfile::select('id','business_name')->whereIn('id', $businessProfileIds )->where('business_type',1)->get();
        return response()->json([
                'user'=>$user,
                'paymentTerms'=> $paymentTerms,
                'shipmentTerms'=>$shipmentTerms,
                'shippingMethods'=>$shippingMethods,
                'uoms'=>$uoms,
                'shipmentTypes'=>$shipmentTypes,
                'proFormaTermAndConditions'=>$proFormaTermAndConditions,
                'businessProfileList'=>$businessProfileList,
                'success'=>True
            ],200);
	}

    public function getProductListByBuisnessProfileId($id){
        
        $products = Product::select('id','title','price_per_unit','price_unit','created_by')->where('business_profile_id', $id)->latest()->get();
        
        if(count($products)>0){
            return response()->json([
                'success' => true,
                'products' => $products
            ],200);
        }
        else{
            return response()->json([
                'success' => false,
                'products' => $products
            ],200);
        }
    }

    
    public function store(Request $request)
	{ 
        // return response()->json($request->all());
        $data = new Proforma;
        $data->buyer_id = $request->input('selected_buyer_id');
        $data->business_profile_id = $request->input('business_profile_id');
        $data->proforma_id = $request->input('po_id');
        $data->proforma_date = $request->input('po_date');
        $data->payment_within = $request->input('payment_within');
        $data->payment_term_id= $request->input('payment_term');
        $data->shipment_term_id = $request->input('shipment_term');
        $data->shipping_address = $request->input('shipping_address');
        $data->forwarder_name = $request->input('forwarder_name');
        $data->forwarder_address = $request->input('forwarder_address');
        $data->payable_party = $request->input('payable_party');
        
        $data->po_no = '';
        $data->condition = $data->condition = $request->input('terms_conditions') ? json_encode($request->input('terms_conditions')) : json_encode(array());
        $data->status = 0;
        $data->created_by= auth()->id();
        $data->save();
        $performa_id = $data->id;

        foreach($request->input('unit') as $i => $sup)
        {
                $dataitem = new ProformaProduct;
                $dataitem->performa_id = $performa_id;
                $dataitem->supplier_id = auth()->id();
                $dataitem->product_id = NULL;
                $dataitem->item_title = $request->input('item_title')[$i];
                $dataitem->unit = $request->input('unit')[$i];
                $dataitem->unit_price = $request->input('unit_price')[$i];
                $dataitem->tax = 0.0;
                $dataitem->total_price = $request->input('total_price')[$i];
                $dataitem->tax_total_price = $request->input('tax_total_price')[$i];
                $dataitem->price_unit = 'USD';
                $dataitem->save();
            
        }

        foreach($request->input('shipping_details_method') as $i => $sup)
        {
            $proFormaShippingDetails = new ProFormaShippingDetails;
            $proFormaShippingDetails->proforma_id = $data->id;
            $proFormaShippingDetails->shipping_details_method = $request->input('shipping_details_method')[$i];
            $proFormaShippingDetails->shipping_details_type = $request->input('shipping_details_type')[$i];
            $proFormaShippingDetails->shipping_details_uom = $request->input('shipping_details_uom')[$i];
            $proFormaShippingDetails->shipping_details_per_uom_price = $request->input('shipping_details_per_uom_price')[$i];
            $proFormaShippingDetails->shipping_details_qty = $request->input('shipping_details_qty')[$i];
            $proFormaShippingDetails->shipping_details_total = $request->input('shipping_details_total')[$i];
            $proFormaShippingDetails->save();
        }

        foreach($request->input('fixed_terms_conditions') as $key => $value)
        {
            $supplierCheckedProFormaTermAndCondition = new SupplierCheckedProFormaTermAndCondition;
            $supplierCheckedProFormaTermAndCondition->proforma_id = $data->id;
            $supplierCheckedProFormaTermAndCondition->pro_forma_term_and_condition_id = $request->input('fixed_terms_conditions')[$key];
            $supplierCheckedProFormaTermAndCondition->save();
        }

        if($request->hasFile('shipping_details_files')){

            foreach( $request->file('shipping_details_files')  as $key => $file)
            {
                $proFormaShippingFile = new ProFormaShippingFile;
                $proFormaShippingFile->proforma_id = $data->id;
                $proFormaShippingFile->shipping_details_file_names = $request->shipping_details_file_names[$key];
                $extension = $file->getClientOriginalExtension();
                    if($extension=='pdf' ||$extension=='PDF' ||$extension=='doc'||$extension=='docx'|| $extension=='xlsx' || $extension=='ZIP'||$extension=='zip'|| $extension=='TAR' ||$extension=='tar'||$extension=='rar' ||$extension=='RAR'  ){

                        $path = $file->store('images','public');
                    }
                    else{
                        $path = $file->store('images','public');
                    }
                $proFormaShippingFile->shipping_details_files = $path;
                $proFormaShippingFile->save();

            }

        }
        
        $proFormaSignature = new ProFormaSignature;
        $proFormaSignature->proforma_id = $data->id;
        $proFormaSignature->buyer_singature_name = $request->input('buyer_singature_name');
        $proFormaSignature->buyer_singature_designation = $request->input('buyer_singature_designation');
        $proFormaSignature->beneficiar_singature_name = $request->input('beneficiar_singature_name');
        $proFormaSignature->beneficiar_singature_designation = $request->input('beneficiar_singature_designation');
        $proFormaSignature->save();

        $proFormaAdvisingBank = new ProFormaAdvisingBank;
        $proFormaAdvisingBank->proforma_id = $data->id;
        $proFormaAdvisingBank->bank_name = $request->input('bank_name');
        $proFormaAdvisingBank->branch_name = $request->input('branch_name');
        $proFormaAdvisingBank->bank_address = $request->input('bank_address');
        $proFormaAdvisingBank->swift_code = $request->input('swift_code');
        $proFormaAdvisingBank->save();

        event(new NewProfromaInvoiceHasCreatedEvent($data));

        return response()->json([
            'success' => true,
            'proformaInvoice' => $data
        ],200);

	}

    
    public function proformaInvoiceDetails($id)
    {
        $users[] = auth()->id();
        $po = Proforma::with('performa_items','proFormaShippingDetails.uom','proFormaShippingDetails.shippingMethod','proFormaShippingDetails.shipmentType','proFormaAdvisingBank','proFormaShippingFiles','proFormaSignature','paymentTerm','shipmentTerm','businessProfile','supplierCheckedProFormaTermAndConditions')->where('id', $id)->first();
        $totalInvoice = ProformaProduct::where('performa_id',$id)->sum('tax_total_price');
        $supplierInfo = User::where('id', $po->created_by)->first();
        if($po){
            return response()->json([
                        'po'=>$po,
                        'users'=>$users,
                        'supplierInfo'=>$supplierInfo,
                        'totalInvoice'=>$totalInvoice,
                        'success'=>true
                    ],200);
        }
        else{
            return response()->json([
                'po'=>$po,
                'users'=>$users,
                'supplierInfo'=>$supplierInfo,
                'totalInvoice'=>$totalInvoice,
                'success'=>false
            ],200);
        }
    }

    public function merchantAssistances(){
        $merchantAssistances = MerchantAssistance::all();
        return response()->json([
            'success' => true,
            'merchantAssistances' => $merchantAssistances,
            'message'=>'Proforma updated successfully'
        ],200);

    }
    public function acceptProformaInvoice(Request $request)
    {
        $merchantAssistances = MerchantAssistance::whereIn('id',$request->merchantAssistances)->get();
        $total_merchant_assistant = 0;
        foreach( $merchantAssistances as $checkedMerchantAssistance ){
            if($checkedMerchantAssistance->type == 'USD' ){
                $total_merchant_assistant = $total_merchant_assistant + $checkedMerchantAssistance->amount;
            }
            else{
                $total_merchant_assistant = $total_merchant_assistant + ( $request->tax_total_price * $checkedMerchantAssistance->amount )/100;
            }
        }
        $invoice_amount_with_merchant_assistant = $request->tax_total_price +  $total_merchant_assistant ;
      
        $proforma = Proforma::where('id' , $request->po_id)->first();
        $proforma->po_no = $request->po_id;
        $proforma->total_invoice_amount_with_merchant_assistant = $invoice_amount_with_merchant_assistant;
        $proforma->status = 1;
        $proforma->save();
        $proforma = Proforma::where('id' , $request->po_id)->first();
        
        foreach( $request->merchantAssistances as $checkedMerchantAssistance ){
            $proformaCheckedMerchantAssistance = new ProformaCheckedMerchantAssistance();
            $proformaCheckedMerchantAssistance->proforma_id = $request->po_id;
            $proformaCheckedMerchantAssistance->merchant_assistance_id = $checkedMerchantAssistance;
            $proformaCheckedMerchantAssistance->save();
        }
        if($proforma){
            return response()->json([
                'success' => true,
                'message'=>'Proforma updated successfully',
                'proforma' => $proforma
            ],200);

        }
        else{
            return response()->json([
                'success' => false,
                'message'=>'Failed to update proforma'
            ]);
        }
        
    }

    public function rejectProformaInvoice(Request $request)
    {
        $result = Proforma::where([ 'id' => $request->po_id ])->update(['po_no' => $request->po_id, 'reject_message' => $request->reject_message, 'status' => -1]);
        if($result){
            return response()->json([
                'success' => true,
                'message'=>'Proforma rejected successfully'
            ]);
        }
        else{
            return response()->json([
                'success' => false,
                'message'=>'Failed to rejection proforma'
            ]);
        }
        
    }
}
