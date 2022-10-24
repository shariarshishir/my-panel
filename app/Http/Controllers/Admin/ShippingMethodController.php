<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ShippingMethod;

class ShippingMethodController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $collection=ShippingMethod::latest()->get();
        return view('admin.shipping_method.index',['collection' => $collection]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $collection=new ShippingMethod();
        return view('admin.shipping_method.create',['collection' => $collection]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validData=$request->validate([
            'name' => 'required',
        ]);
        $data=array_merge($validData,['description' => $request->description]);
        ShippingMethod::create($data);
        return redirect()->route('shipping-method.index')->with('success','Successfully Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(ShippingMethod $ShippingMethod)
    {
        return view('admin.shipping_method.edit',['collection' => $ShippingMethod]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ShippingMethod $ShippingMethod)
    {
        $validData=$request->validate([
            'name' => 'required',
        ]);
        $data=array_merge($validData,['description' => $request->description]);
        $ShippingMethod->update($data);
        return redirect()->route('shipping-method.index')->with('success','Successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ShippingMethod $ShippingMethod)
    {
        $ShippingMethod->delete();
        return redirect()->route('shipping-method.index')->with('success','Successfully Deleted');
    }
}
