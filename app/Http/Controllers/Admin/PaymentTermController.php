<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PaymentTerm;

class PaymentTermController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $collection = PaymentTerm::latest()->get();
        return view('admin.payment_term.index',['collection' => $collection]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $collection = new PaymentTerm();
        return view('admin.payment_term.create',['collection' => $collection]);
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
        PaymentTerm::create($data);
        return redirect()->route('payment-term.index')->with('success','Successfully Created');
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
    public function edit(PaymentTerm $PaymentTerm)
    {
        return view('admin.payment_term.edit',['collection' => $PaymentTerm]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PaymentTerm $PaymentTerm)
    {
        $validData=$request->validate([
            'name' => 'required',
        ]);
        $data = array_merge($validData,['description' => $request->description]);
        $PaymentTerm->update($data);
        return redirect()->route('payment-term.index')->with('success','Successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(PaymentTerm $PaymentTerm)
    {
        $PaymentTerm->delete();
        return redirect()->route('payment-term.index')->with('success','Successfully Deleted');
    }
}
