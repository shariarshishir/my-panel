<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\ShippingChargeMailToAdmin;
use App\Mail\ShippingChargeMailToBuyer;
use App\Models\ShippingCharge;
use App\Models\VendorOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;


class ShippingChargeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $request->validate([
            'order_id' => 'required',
            // 'shipping.shipping_method.*' => 'required',
            // 'shipping.shipment_type.*'   =>  'required',
            // 'shipping.uom.*' => 'required',
            // 'shipping.uom_per_unit_price.*'   =>  'required',
            // 'shipping.qty.*' => 'required',
            // 'shipping.total.*'   =>  'required',
        ]);

        if ($request->hasFile('file'))
        {
            $filename = $request->file->store('images/shipping_attachment','public');
        }
        $details=[];
        foreach($request->shipping as $key => $value)
        {
            foreach($value as $key2 => $value2 )
                {
                    $details[$key2][$key]=$value2;
                }
        }
        $list = ShippingCharge::create([
                'order_id' => $request->order_id,
                'forwarder_name' => $request->forwarder_name,
                'forwarder_address' => $request->forwarder_address,
                'details'  => json_encode($details),
                'grand_total'   =>  $request->grand_total,
                'file'    =>   $filename ?? null,
                'status'  => 1,
                'ip_address' => $request->ip(),
                'user_agent' => $request->header('User-Agent'),
                ]);
        //return 'ok';
        $order=VendorOrder::where('id',$request->order_id)->with(['user','shippingCharge'])->first();
        //mail to buyer
        Mail::to($order->user->email)->send(new ShippingChargeMailToBuyer($order));
        //mail to admin
        Mail::to('success@merchantbay.com')->send(new ShippingChargeMailToAdmin($order));
        return redirect()->back()->with('success', 'successfull');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function update(Request $request, ShippingCharge $shippingCharge)
    {
        $request->validate([
            'order_id' => 'required',
            // 'shipping.shipping_method.*' => 'required',
            // 'shipping.shipment_type.*'   =>  'required',
            // 'shipping.uom.*' => 'required',
            // 'shipping.uom_per_unit_price.*'   =>  'required',
            // 'shipping.qty.*' => 'required',
            // 'shipping.total.*'   =>  'required',
        ]);

        if ($request->hasFile('file'))
        {
            $filename = $request->file->store('images/shipping_attachment','public');
        }
        $details=[];
        foreach($request->shipping as $key => $value)
        {
            foreach($value as $key2 => $value2 )
                {
                    $details[$key2][$key]=$value2;
                }
        }

        $shippingCharge->update([
            'forwarder_name' => $request->forwarder_name,
            'forwarder_address' => $request->forwarder_address,
            'details'  => json_encode($details),
            'grand_total'   =>  $request->grand_total,
            'file'    =>   $filename ?? null,
            'status'  => 1,
            'ip_address' => $request->ip(),
            'user_agent' => $request->header('User-Agent'),
        ]);

        $order=VendorOrder::where('id',$request->order_id)->with(['user','shippingCharge'])->first();
        //mail to buyer
        Mail::to($order->user->email)->send(new ShippingChargeMailToBuyer($order));
        //mail to admin
        Mail::to('success@merchantbay.com')->send(new ShippingChargeMailToAdmin($order));
        return redirect()->back()->with('success', 'successfull');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function changeStatus($id){
        $order=VendorOrder::where('id',$id)->with(['user','shippingCharge'])->first();
        $order->shippingCharge->update(['status' =>  2,  'ip_address' => request()->ip(),
        'user_agent' => request()->header('User-Agent'),]);
       //mail to buyer
       Mail::to($order->user->email)->send(new ShippingChargeMailToBuyer($order));
       //mail to admin
       Mail::to('success@merchantbay.com')->send(new ShippingChargeMailToAdmin($order));
       return redirect()->back()->with('success', 'successfull');

       return redirect()->back()->with('success', 'successfull');
    }
}
