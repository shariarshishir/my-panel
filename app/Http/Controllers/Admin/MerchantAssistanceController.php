<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MerchantAssistance;

class MerchantAssistanceController extends Controller
{
    public function index()
    {
        $merchantAssistances = MerchantAssistance::all();
        return view('admin.merchant_assistance.index',['merchantAssistances' => $merchantAssistances]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $merchantAssistance = new MerchantAssistance();
        return view('admin.merchant_assistance.create',['merchantAssistance' => $merchantAssistance]);
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
            'amount' => 'required',
            'type' => 'required'
        ]);
        $data = array_merge($validData,['description' => $request->description]);
        MerchantAssistance::create($data);
        return redirect()->route('merchant-assistances.index')->with('success','Successfully Created');
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
    public function edit(MerchantAssistance $merchantAssistance)
    {
        return view('admin.merchant_assistance.edit',['merchantAssistance' => $merchantAssistance]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MerchantAssistance $merchantAssistance)
    {
        $validData=$request->validate([
            'name' => 'required',
            'amount' => 'required',
            'type' => 'required'
        ]);
        $data = array_merge($validData,['description' => $request->description]);
        $merchantAssistance->update($data);
        return redirect()->route('merchant-assistances.index')->with('success','Successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(MerchantAssistance $merchantAssistance)
    {
        $merchantAssistance->delete();
        return redirect()->route('merchant-assistances.index')->with('success','Successfully Deleted');
    }
}
