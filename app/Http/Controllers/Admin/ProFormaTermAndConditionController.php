<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\ProFormaTermAndCondition;

class ProFormaTermAndConditionController extends Controller
{
    public function index()
    {
        $proFormaTermAndConditions = ProFormaTermAndCondition::all();
        return view('admin.proforma_term_condition.index',compact('proFormaTermAndConditions'));
    }

    /**
     * Show the form for creating a new reproductCategories.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $proFormaTermAndCondition = new ProFormaTermAndCondition();
        return view('admin.proforma_term_condition.create',compact('proFormaTermAndCondition'));
    }

    /**
     * Store a newly created reproductCategories in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'term_and_condition' => 'required|unique:pro_forma_term_and_conditions,term_and_condition',
        ]);

        $proFormaTermAndCondition = new ProFormaTermAndCondition();
        $proFormaTermAndCondition->term_and_condition = $request->term_and_condition;
        $proFormaTermAndCondition->created_by = Auth::guard('admin')->user()->id;
        $proFormaTermAndCondition->updated_by = NULL;
        $result = $proFormaTermAndCondition->save();
        if($result){
           Session::flash('success','Proforma Term And Condition Added Successfully!!!!');
        }
        return redirect()->route('proforma-terms-and-conditions.index');

    }

    /**
     * Display the specified reproductCategories.
     *
     * @param  \App\Models\ProductCategory  $ProductCategory
     * @return \Illuminate\Http\Response
     */
    
    /**
     * Show the form for editing the specified reproductCategories.
     *
     * @param  \App\Models\ProductCategory  $ProductCategory
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $proFormaTermAndCondition = ProFormaTermAndCondition::find($id);
        return view('admin.proforma_term_condition.edit',compact('proFormaTermAndCondition'));
    }

    /**
     * Update the specified reproductCategories in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductCategory  $ProductCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'term_and_condition' => 'required|unique:pro_forma_term_and_conditions,term_and_condition,'.$id,
        ]);

        $proFormaTermAndCondition = ProFormaTermAndCondition::find($id);
        $proFormaTermAndCondition->term_and_condition = $request->term_and_condition;
        $proFormaTermAndCondition->created_by = $proFormaTermAndCondition->created_by;
        $proFormaTermAndCondition->updated_by = Auth::guard('admin')->user()->id;
        $result = $proFormaTermAndCondition->save();
        if($result){
           Session::flash('success','Proforma Term And Condition Updated Successfully!!!!');
        }
        return redirect()->route('proforma-terms-and-conditions.index');
    }

    /**
     * Remove the specified reproductCategories from storage.
     *
     * @param  \App\Models\ProductCategory  $ProductCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $proFormaTermAndCondition = ProFormaTermAndCondition::find($id);
        $result = $proFormaTermAndCondition->delete();
        if($result){
            Session::flash('success','Proforma Term And Condition deleted successfully!!!!');
        }
        return redirect()->route('proforma-terms-and-conditions.index');

    }
}
