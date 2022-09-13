<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\ProductTypeMapping;
use App\Http\Controllers\Controller;
use App\Models\Manufacture\Product as ManufactureProduct;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ProductTypeMappingController extends Controller
{
    public function index()
    {
        $all_collection = ProductTypeMapping::all();
        $source = ProductTypeMapping::select('id', 'title', 'parent_id')->get()->toArray();
        $inArray = array();
        foreach($source as $key => $value)
        {
            $inArray[$key] = $value;
        }

        $outArray = array();
        $this->makeParentChildRelations($inArray, $outArray);

        $total_row = $all_collection->count();
        return view('admin.product_type_mapping.index',compact('outArray','total_row'));
    }

    /**
     * Show the form for creating a new reproductCategories.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $source = ProductTypeMapping::with('parent')->select('id', 'title','parent_id')->get()->toArray();
        $inArray = array();
        foreach($source as $key => $value)
        {
            $inArray[$key] = $value;
        }

        $outArray = array();
        $this->makeParentChildRelations($inArray, $outArray);

        $productTypeMapping = new ProductTypeMapping();
        return view('admin.product_type_mapping.create',compact('productTypeMapping', 'outArray'));

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
            'title' => 'required|unique:product_type_mappings,title',
            'parent_id'=>'nullable|integer'
        ]);

        $productTypeMapping=new ProductTypeMapping();
        $productTypeMapping->title=strtolower($request->title);
        $productTypeMapping->parent_id=$request->parent_id ;
        $productTypeMapping->save();
        Session::flash('success','Added successfully!!!!');

        return redirect()->route('admin.product-type-mapping.index');

    }

    /**
     * Display the specified reproductCategories.
     *
     * @param  \App\Models\ProductTypeMapping  $ProductTypeMapping
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified reproductCategories.
     *
     * @param  \App\Models\ProductTypeMapping  $ProductTypeMapping
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $source = ProductTypeMapping::with('parent')->select('id', 'title', 'parent_id')->get()->toArray();
        $inArray = array();
        foreach($source as $key => $value)
        {
            $inArray[$key] = $value;
        }

        $outArray = array();
        $this->makeParentChildRelations($inArray, $outArray);
        $productTypeMapping = ProductTypeMapping::find($id);

        return view('admin.product_type_mapping.edit',compact('productTypeMapping', 'outArray'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|unique:product_type_mappings,title,'.$id,
            'parent_id'=>'nullable|integer'
        ]);


        $productTypeMapping = ProductTypeMapping::find($id);
        $productTypeMapping->title=strtolower($request->title);
        $productTypeMapping->parent_id=$request->parent_id;
        $productTypeMapping->save();
        Session::flash('success','Updated successfully!!!!');

        return redirect()->route('admin.product-type-mapping.index');
    }


    public function destroy($id)
    {
        $productTypeMapping=ProductTypeMapping::find($id);
        if($productTypeMapping->children()->exists()){
            Session::flash('success','ProductTypeMapping Can not  Delete ,This ProductTypeMapping Has child');
            return redirect()->route('admin.product-type-mapping.index');

        }
        if(Product::where('product_type_mapping_id', $id)->first() || ManufactureProduct::where('product_type_mapping_id', $id)->first()){
            Session::flash('success','ProductTypeMapping Can not  Delete ,This Has Product');
            return redirect()->route('admin.product-type-mapping.index');
        }
        if(Product::whereJsonContains('product_type_mapping_child_id', $id)->first() || ManufactureProduct::whereJsonContains('product_type_mapping_child_id', $id)->first()){
            Session::flash('success','ProductTypeMapping Can not  Delete ,This Has Product');
            return redirect()->route('admin.product-type-mapping.index');
        }

        $productTypeMapping->delete();
        Session::flash('success','ProductTypeMapping deleted successfully!!!!');

        return redirect()->route('admin.product-type-mapping.index');

    }

    public function makeParentChildRelations(&$inArray, &$outArray, $currentParentId = 0) {
        if(!is_array($inArray)) {
            return;
        }

        if(!is_array($outArray)) {
            return;
        }

        foreach($inArray as $key => $tuple) {
            if($tuple['parent_id'] == $currentParentId) {
                $tuple['children'] = array();
                $this->makeParentChildRelations($inArray, $tuple['children'], $tuple['id']);
                $outArray[] = $tuple;
            }
        }
    }
}
