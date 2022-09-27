<?php

namespace App\Http\Controllers\BusinessProfile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use App\Models\supplierQuotationToBuyer;
use App\Models\Rfq;
//use App\Models\BusinessProfile;

class QuerybidController extends Controller
{
    public function store(Request $request)
    {
        //dd($request->all());

        $user = Auth::user();
        $token = Cookie::get('sso_token');

        $allData = $request->only('rfq_id','business_profile_id','offer_price','offer_price_unit');
        $allData['from_backend'] = false;
        $postBidApi= env('RFQ_APP_URL').'/api/supplier-quotation-to-buyer';
        $response = Http::withToken($token)->post($postBidApi, $allData);

        $supplierQuotationToBuyer = new supplierQuotationToBuyer();
        $supplierQuotationToBuyer->rfq_id = $request->rfq_id;
        $supplierQuotationToBuyer->business_profile_id = $request->business_profile_id;
        $supplierQuotationToBuyer->offer_price = $request->offer_price;
        $supplierQuotationToBuyer->offer_price_unit = $request->offer_price_unit;
        $supplierQuotationToBuyer->from_backend = false;
        $supplierQuotationToBuyer->save();

        return $response;

        return response()->json([
            'success' => true,
            'msg'    => 'Congratulations!!! Your Quotation has been successfully submitted.'
        ]);
    }


}
