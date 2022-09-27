<?php

namespace App\Http\Controllers\Admin;


use PDF;
use Carbon\Carbon;
use App\Models\UOM;
use App\Models\User;
use App\Models\Proforma;
use App\Models\PaymentTerm;
use App\Models\ShipmentTerm;
use App\Models\ShipmentType;
use Illuminate\Http\Request;
use App\Models\ShippingMethod;
use App\Models\BusinessProfile;
use App\Models\ProformaProduct;
use App\Models\ProFormaSignature;
use Illuminate\Support\Facades\DB;
use App\Models\Manufacture\Product;
use App\Http\Controllers\Controller;
use App\Models\ProFormaAdvisingBank;
use App\Models\ProFormaShippingFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Intervention\Image\Facades\Image;
use App\Models\ProFormaShippingDetails;
use Illuminate\Support\Facades\Storage;
use App\Models\ProFormaTermAndCondition;
use App\Models\Manufacture\ProductCategory;
use App\Events\NewProfromaInvoiceHasCreatedEvent;
use App\Models\SupplierCheckedProFormaTermAndCondition;

class AdminPoController extends Controller
{
    public function create($buyerId,$rfqId){

        $buyer=User::findOrFail($buyerId);

        $proformaInvoices = new Proforma();
        $paymentTerms = PaymentTerm::get();
        $shipmentTerms = ShipmentTerm::get();
        $shippingMethods = ShippingMethod::latest()->get();
        $shipmentTypes = ShipmentType::latest()->get();
        $uoms = UOM::latest()->get();
        $proFormaTermAndConditions = ProFormaTermAndCondition::latest()->get();

        return view('admin.proforma_invoice.create',compact('buyer','proformaInvoices', 'paymentTerms', 'shipmentTerms', 'shippingMethods', 'shipmentTypes', 'uoms', 'proFormaTermAndConditions','rfqId'));
    }

    public function edit($buyerId,$rfqId,$proformaId){

        $buyer = User::findOrFail($buyerId);

        //$proformaInvoices = Proforma::findOrFail($proformaId);
        $proformaInvoices = Proforma::with('performa_items','checkedMerchantAssistances','proFormaShippingDetails','proFormaAdvisingBank','proFormaShippingFiles','proFormaSignature','paymentTerm','shipmentTerm','businessProfile','supplierCheckedProFormaTermAndConditions')->where('id', $proformaId)->first();
        $totalInvoice = ProformaProduct::where('performa_id',$proformaId)->sum('tax_total_price');
        //dd($proformaInvoices);

        $checkedTermsAndConditions = [];
        foreach($proformaInvoices->supplierCheckedProFormaTermAndConditions as $termsandcondition) {
            array_push($checkedTermsAndConditions, $termsandcondition['pro_forma_term_and_condition_id']);
        }

        $paymentTerms = PaymentTerm::get();
        $shipmentTerms = ShipmentTerm::get();
        $shippingMethods = ShippingMethod::latest()->get();
        $shipmentTypes = ShipmentType::latest()->get();
        $uoms = UOM::latest()->get();
        $proFormaTermAndConditions = ProFormaTermAndCondition::latest()->get();

        return view('admin.proforma_invoice.edit',compact('buyer','proformaInvoices', 'paymentTerms', 'shipmentTerms', 'shippingMethods', 'shipmentTypes', 'uoms', 'proFormaTermAndConditions','rfqId','totalInvoice','checkedTermsAndConditions'));
    }

    public function updateBuyerInfo(Request $request)
    {
        //dd($request->all());
        $proformaInvoices = Proforma::where('id', $request->updated_proforma_id)->first();

        if($proformaInvoices) {
            $proformaInvoices->update(['updated_buyer_name' => $request->updated_buyer_name]);
            $proformaInvoices->update(['updated_buyer_email' => $request->updated_buyer_email]);
            $proformaInvoices->update(['updated_buyer_shipping_address' => $request->updated_buyer_shipping_address]);
        }

        return response()->json(['message'=>'successfully updated'], 200);
    }

    public function index ()
    {
        //$proformaInvoices = Proforma::with('performa_items','buyer','businessProfile')->latest()->get();

        // $response = Http::get(env('RFQ_APP_URL').'/api/quotation/status/all/filter/null/page/1/limit/1000');
        // $data = $response->json();
        // $rfqs = $data['data'];
        // $rfqIds = [];
        // foreach($rfqs as $rfq) {
        //     array_push($rfqIds, $rfq['id']);
        // }
        // dd($rfqIds);

        //$proformaInvoices = Proforma::with('performa_items','buyer','businessProfile')->latest()->get()->groupBy('rfq_title');

        $proformaInvoices = Proforma::with('performa_items','buyer','businessProfile')->orderBy('created_at', 'DESC')->get();

        if( env('APP_ENV') == 'production')
        {
            $merchantbayUserInfo = User::where("id", 5771)->first();
        }
        else
        {
            $merchantbayUserInfo = User::where("id", 5552)->first();
        }
        //dd($merchantbayUserInfo);
        return view('admin.proforma_invoice.index',compact('proformaInvoices', 'merchantbayUserInfo'));
    }

    public function show($id)
    {
        $users[] = auth()->id();
        $po = Proforma::with('performa_items','checkedMerchantAssistances','proFormaShippingDetails','proFormaAdvisingBank','proFormaShippingFiles','proFormaSignature','paymentTerm','shipmentTerm','businessProfile','supplierCheckedProFormaTermAndConditions')->where('id', $id)->first();
        $totalInvoice = ProformaProduct::where('performa_id',$id)->sum('tax_total_price');
        $supplierInfo = User::where('id', $po->created_by)->first();
        if( env('APP_ENV') == 'production')
        {
            $merchantbayUserInfo = User::where("id", 5771)->first();
        }
        else
        {
            $merchantbayUserInfo = User::where("id", 5552)->first();
        }
        if($po){
            return view('admin.proforma_invoice.show',compact('po','users','supplierInfo','totalInvoice','merchantbayUserInfo'));
        }

    }

    public function store(Request $request)
	{
        //dd($request->all());
        //DB::beginTransaction();

            $response = Http::get(env('RFQ_APP_URL').'/api/quotation/'.$request->input('generated_po_from_rfq'));
            $rfqdata = $response->json();
            $rfqInfo = $rfqdata['data']['data'];

        // try {
            $data = new Proforma;
            $data->buyer_id = $request->input('selected_buyer_id');
            $data->business_profile_id = $request->input('business_profile_id');
            $data->generated_po_from_rfq = $request->input('generated_po_from_rfq');
            $data->rfq_title = $rfqInfo['title'];
            $data->proforma_id = $request->input('po_id');
            $data->proforma_date = $request->input('po_date');
            $data->shipping_date = $request->input('shipping_date');
            $data->payment_within = $request->input('payment_within');
            $data->payment_term_id= $request->input('payment_term');
            $data->shipment_term_id = $request->input('shipment_term');
            $data->shipping_address = $request->input('shipping_address');
            $data->forwarder_name = $request->input('forwarder_name');
            $data->forwarder_address = $request->input('forwarder_address');
            $data->payable_party = $request->input('payable_party');

            $data->po_no = '';

            $data->condition = $request->input('terms_conditions') ? json_encode($request->input('terms_conditions')) : json_encode(array());

            $data->status = 0;
            if(env('APP_ENV') == 'local'){
                //$adminUser = User::Find('5552');
                $data->created_by = 5552;
            }else{
                //$adminUser = User::Find('5771');
                $data->created_by = 5771;
            }
            $data->save();
            $performa_id = $data->id;

            $noOfProducts = count($request->input('unit'));
            // $products = Product::where('business_profile_id',$request->business_profile_id)->where('price_unit','USD')->inRandomOrder()->limit($noOfProducts)->get();
            foreach($request->input('unit') as $i => $sup)
            {

                $dataitem = new ProformaProduct;
                $dataitem->performa_id = $performa_id;
                if(env('APP_ENV') == 'local'){
                    //$adminUser = User::Find('5552');
                    $data->supplier_id = 5552;
                }else{
                    //$adminUser = User::Find('5771');
                    $data->supplier_id = 5771;
                }
                $dataitem->product_id = NULL;
                $dataitem->item_title = $request->input('item_title')[$i];
                $dataitem->unit = $request->input('unit')[$i];
                $dataitem->unit_price = $request->input('unit_price')[$i];
                $dataitem->tax = $request->input('tax')[$i];
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

            if ($request->input('fixed_terms_conditions'))
            {
                foreach($request->input('fixed_terms_conditions') as $key => $value)
                {
                    $supplierCheckedProFormaTermAndCondition = new SupplierCheckedProFormaTermAndCondition;
                    $supplierCheckedProFormaTermAndCondition->proforma_id = $data->id;
                    $supplierCheckedProFormaTermAndCondition->pro_forma_term_and_condition_id = $request->input('fixed_terms_conditions')[$key];
                    $supplierCheckedProFormaTermAndCondition->save();
                }
            }

            if($request->hasFile('shipping_details_files'))
            {

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

            $response = Http::put(env('RFQ_APP_URL').'/api/quotation/'.$request->input('generated_po_from_rfq'), [
                'pi_status' => 0,
            ]);

            if( $response->status()  == 200)
            {
                event(new NewProfromaInvoiceHasCreatedEvent($data, $rfqInfo));
            }


        // } catch (\Exception $e) {
        //     DB::rollback();
        // }


        //return back()->withSuccess('Created Successfully');


		//return redirect()->route('po.all');

        return redirect()->route('admin.rfq.show',[$request->input('generated_po_from_rfq'), true]);


     	//return redirect()->route('proforma_invoices.index');

	}





}
