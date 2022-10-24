<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ShipmentType;

class ShipmentTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $collection=ShipmentType::latest()->get();
        return view('admin.shipment_type.index',['collection' => $collection]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $collection=new ShipmentType();
        return view('admin.shipment_type.create',['collection' => $collection]);
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
        ShipmentType::create($data);
        return redirect()->route('shipment-type.index')->with('success','Successfully Created');
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
    public function edit(ShipmentType $ShipmentType)
    {
        return view('admin.shipment_type.edit',['collection' => $ShipmentType]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ShipmentType $ShipmentType)
    {
        $validData=$request->validate([
            'name' => 'required',
        ]);
        $data=array_merge($validData,['description' => $request->description]);
        $ShipmentType->update($data);
        return redirect()->route('shipment-type.index')->with('success','Successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ShipmentType $ShipmentType)
    {
        $ShipmentType->delete();
        return redirect()->route('shipment-type.index')->with('success','Successfully Deleted');
    }
}
