<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ShipmentTerm;

class ShipmentTermController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $collection=ShipmentTerm::latest()->get();
        return view('admin.shipment_term.index',['collection' => $collection]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $collection=new ShipmentTerm();
        return view('admin.shipment_term.create',['collection' => $collection]);
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
        ShipmentTerm::create($data);
        return redirect()->route('shipment-term.index')->with('success','Successfully Created');
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
    public function edit(ShipmentTerm $ShipmentTerm)
    {
        return view('admin.shipment_term.edit',['collection' => $ShipmentTerm]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ShipmentTerm $ShipmentTerm)
    {
        $validData=$request->validate([
            'name' => 'required',
        ]);
        $data=array_merge($validData,['description' => $request->description]);
        $ShipmentTerm->update($data);
        return redirect()->route('shipment-term.index')->with('success','Successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ShipmentTerm $ShipmentTerm)
    {
        $ShipmentTerm->delete();
        return redirect()->route('shipment-term.index')->with('success','Successfully Deleted');
    }
}
