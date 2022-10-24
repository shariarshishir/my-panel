<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Vendor;
use App\Models\Product;
use App\Models\VendorOrder;
use App\Models\VendorOrderItem;

class VendorController extends Controller
{

    public function index()
    {
        $stores = Vendor::all();
        if(isset($stores)){
            return response()->json(['stores'=>$stores,'code'=>'True'],200);
        }
        else{
            return response()->json(['message'=>'No store found','code'=>'False'],200);
        }

    }

    public function show($vendorUId)
    {
        $store = Vendor::where('vendor_uid', $vendorUId)->first();
        $storeProducts = Product::where('vendor_id', $store->id)->with(['images', 'productReview', 'productWishLists'])->where('state',1)->where('sold',0)->get();
        $storeOrders = VendorOrder::where('vendor_id', $store->id)->with('orderItems')->get();
        if($store){
            return response()->json(['store_details' => $store, 'store_products' => $storeProducts, 'store_orders' => $storeOrders, 'message' => 'Store found','code'=>'True'], 200);
        }
        else{
            return response()->json([ 'message' => 'Store Not found','code'=>'False'], 200);
        }

    }

    public function update(Request $request,$vendorUId)
    {

        $request->validate([
            'vendor_name' => 'required',
            'vendor_ownername'  => 'required',
            'vendor_address' => 'required',
            'vendor_country' => 'required',
            'vendor_type'       => 'required',
           ]);


        try {
            $vendor=Vendor::where('vendor_uid',$vendorUId)->first();
            Vendor::where('id',$vendor->id)->update([
                'vendor_name' => $request->vendor_name,
                'vendor_ownername'  => $request->vendor_ownername,
                'vendor_address' => $request->vendor_address,
                'vendor_country' => $request->vendor_country,
                'vendor_type'       => $request->vendor_type,
                'vendor_mainproduct' => $request->vendor_mainproduct,
                'vendor_totalemployees' => $request->vendor_totalemployees,
                'vendor_yearest'       => $request->vendor_yearest,
                'vendor_certification'  => $request->vendor_certification,
            ]);
            $vendor=Vendor::where('id',$vendor->id)->first();
            return response()->json(['code' =>'True', 'message'=>'Store updated successfully','vendor'=> $vendor],200);
        } catch (\Exception $e) {
            return response()->json(['code' =>'False', 'message' => $e->getMessage()],204);
        }

    }


    public function searchByVendorName(Request $request){

        if(!empty($request->search_input)) {

                $vendors=Vendor::with('user')->where('vendor_name', 'like', '%'.$request->search_input.'%')->paginate(10);
                if($vendors->total()>0){
                    return response()->json(['vendors' => $vendors, 'message' => 'Store found','code'=>false], 200);
                }
                else{
                    return response()->json(['vendors' => $vendors, 'message' => 'Store not found','code'=>False], 200);
                }

        }
        else
        {
            return response()->json(['vendors' => [], 'message' => 'Search key is empty','code'=>False], 200);
        }

    }

}
