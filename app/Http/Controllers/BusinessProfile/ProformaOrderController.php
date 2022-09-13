<?php

namespace App\Http\Controllers\BusinessProfile;

//use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Proforma;
use App\Models\BusinessProfile;
use Illuminate\Support\Facades\Http;
use App\Events\ProfromaInvoiceHasRejectedEvent;
use App\Events\ProfromaInvoiceHasAcceptedEvent;

class ProformaOrderController extends Controller
{
    public function profomaPendingOrders($alias)
    {
        $business_profile = BusinessProfile::with('user')->where('alias',$alias)->firstOrFail();
        $proformas = Proforma::with('performa_items','checkedMerchantAssistances','proFormaShippingDetails','proFormaAdvisingBank','proFormaShippingFiles','proFormaSignature','paymentTerm','shipmentTerm','businessProfile','supplierCheckedProFormaTermAndConditions')->where('buyer_id',auth()->id())->whereIn('status',[0, -1])->get();
        $status = 0;
        return view('new_business_profile.proforma_orders',compact('proformas','alias','status','business_profile'));
    }

    public function profomaOngoingOrders($alias)
    {
        $business_profile = BusinessProfile::with('user')->where('alias',$alias)->firstOrFail();
        $proformas = Proforma::with('performa_items','checkedMerchantAssistances','proFormaShippingDetails','proFormaAdvisingBank','proFormaShippingFiles','proFormaSignature','paymentTerm','shipmentTerm','businessProfile','supplierCheckedProFormaTermAndConditions')->where('status',1)->where('buyer_id',auth()->id())->get();
        $status = 1;
        return view('new_business_profile.proforma_orders',compact('proformas','alias','status','business_profile'));
    }

    public function profomaShippedOrders($alias)
    {
        $business_profile = BusinessProfile::with('user')->where('alias',$alias)->firstOrFail();
        $proformas = Proforma::with('performa_items','checkedMerchantAssistances','proFormaShippingDetails','proFormaAdvisingBank','proFormaShippingFiles','proFormaSignature','paymentTerm','shipmentTerm','businessProfile','supplierCheckedProFormaTermAndConditions')->where('status',2)->where('buyer_id',auth()->id())->get();
        $status = 2;
        return view('new_business_profile.proforma_orders',compact('proformas','alias','status','business_profile'));
    }

    public function acceptProformaOrder($alias,$proformaId)
    {
        $proformaOrder = Proforma::where('id',$proformaId)->first();
        $proformaOrder->status = 1;
        $proformaOrder->save();

        $response = Http::get(env('RFQ_APP_URL').'/api/quotation/'.$proformaOrder->generated_po_from_rfq);
        $rfqdata = $response->json();
        $rfqInfo = $rfqdata['data']['data'];

        $rfqStatusResponse = Http::put(env('RFQ_APP_URL').'/api/quotation/'.$proformaOrder->generated_po_from_rfq, [
            'pi_status' => 1,
        ]);

        event(new ProfromaInvoiceHasAcceptedEvent($proformaOrder, $rfqInfo));

        return redirect()->route('new.profile.profoma_orders.ongoing',$alias);
    }

    public function rejectProformaOrder(Request $request,$alias,$proformaId)
    {
        $proformaOrder = Proforma::where('id',$proformaId)->first();
        $proformaOrder->reject_message = $request->reject_message;
        $proformaOrder->status = -1;
        $proformaOrder->save();

        $response = Http::get(env('RFQ_APP_URL').'/api/quotation/'.$proformaOrder->generated_po_from_rfq);
        $rfqdata = $response->json();
        $rfqInfo = $rfqdata['data']['data'];

        $rfqStatusResponse = Http::put(env('RFQ_APP_URL').'/api/quotation/'.$proformaOrder->generated_po_from_rfq, [
            'pi_status' => -1,
        ]);

        event(new ProfromaInvoiceHasRejectedEvent($proformaOrder, $rfqInfo));

        return redirect()->route('new.profile.profoma_orders.pending',$alias);
    }

    public function proformaSearchByTitle(Request $request, $alias)
    {
        $business_profile = BusinessProfile::with('user')->where('alias',$alias)->firstOrFail();
        $proformas = Proforma::with('performa_items','checkedMerchantAssistances','proFormaShippingDetails','proFormaAdvisingBank','proFormaShippingFiles','proFormaSignature','paymentTerm','shipmentTerm','businessProfile','supplierCheckedProFormaTermAndConditions')->where('buyer_id',auth()->id())->where('proforma_id', 'like', '%'.$request->poSearchInput.'%')->get();
        $status = 4;
        return view('new_business_profile.proforma_orders',compact('proformas','alias', 'status', 'business_profile'));
    }
}
