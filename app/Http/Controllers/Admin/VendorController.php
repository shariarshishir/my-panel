<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Vendor;
use App\Models\Product;
use App\Models\VendorOrder;
use Illuminate\Http\Request;

class VendorController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users= User::with('vendor')->where('user_type','wholesaler')->get();
        return view('admin.vendor.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($vendorId)
    {
        $vendor = Vendor::find($vendorId);
        $products = Product::where('vendor_id', $vendorId)->get();
        $storeOrders = VendorOrder::Where('vendor_id',$vendorId)->get();
        return view('admin.vendor.show',compact('vendor','vendorId','products','storeOrders'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $vendor = Vendor::findOrFail($id);
        if($vendor->cartItems()->exists()){
            $vendor->cartItems()->delete();
        }
        $vendor->delete();
        return redirect()->back()->withSuccess('Vendor Delete Successfully');
    }

    public function inactive()
    {
        $users= User::with('inactiveVendor')->where('user_type','wholesaler')->onlyTrashed()->get();
        return view('admin.vendor.inactive',compact('users'));
    }

    public function restore($id)
    {

        $resource=Vendor::onlyTrashed()
        ->where('id', $id)
        ->first();
        $resource->restore();
        // $relations_to_cascade=['user','products'];
        // foreach ($relations_to_cascade as $relation) {
        //     foreach ($resource->{$relation}()->withTrashed()->get() as $item) {
        //         $item->withTrashed()->restore();
        //         if($relation=="products"){
        //             $item->images()->withTrashed()->restore();
        //         }
        //     }
        // }

        return redirect()->route('vendor.index')->withSuccess('Restore successfully done');

    }


}
