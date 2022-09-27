<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Image;
use Illuminate\Support\Facades\Storage;


class ProductCategoryController extends Controller
{

    public function index()
    {
        $productCategories = ProductCategory::all();
        $source = ProductCategory::select('id', 'name', 'parent_id', 'status','image')->get()->toArray();
        $inArray = array();
        foreach($source as $key => $value)
        {
            $inArray[$key] = $value;
        }

        $outArray = array();
        $this->makeParentChildRelations($inArray, $outArray);

        $total_row = $productCategories->count();
        return view('admin.productcategory.index',compact('outArray','total_row'));
    }

    /**
     * Show the form for creating a new reproductCategories.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $source = ProductCategory::select('id', 'name','parent_id','image')->get()->toArray();
        $inArray = array();
        foreach($source as $key => $value)
        {
            $inArray[$key] = $value;
        }

        $outArray = array();
        $this->makeParentChildRelations($inArray, $outArray);
        //dd($outArray);

        $productCategory = new ProductCategory();
        //$categoryList = ProductCategory::select('name','id')->get();
        return view('admin.productcategory.create',compact('productCategory', 'outArray'));

    }

    /**
     * Store a newly created reproductCategories in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       // dd($request);
        $request->validate([
            'name' => 'required|unique:product_categories,name',
            'status' => 'required',
            'parent_id'=>'nullable|integer'
        ]);

        if ($request->hasFile('image'))
        {
            $filename = $request->image->store('images/category','public');
            $image_resize = Image::make(public_path('storage/'.$filename));
            $image_resize->fit(250, 250);
            $image_resize->save(public_path('storage/'.$filename));
        }

        $productCategory=new ProductCategory();
        $productCategory->name=$request->name;
        $productCategory->image=$filename??NULL;
        $productCategory->slug=Str::slug($request->name,'-');
        $productCategory->status=$request->status;
        $productCategory->parent_id=$request->parent_id;
        $productCategory->ip_address = $request->ip();
        $productCategory->user_agent = $request->header('User-Agent');
        $productCategory->created_by=Auth::guard('admin')->user()->id;
        $productCategory->updated_by=NULL;
        $result=$productCategory->save();
        if($result){
           Session::flash('success','Product Category Added successfully!!!!');
        }
        return redirect()->route('product-categories.index');

    }

    /**
     * Display the specified reproductCategories.
     *
     * @param  \App\Models\ProductCategory  $ProductCategory
     * @return \Illuminate\Http\Response
     */
    public function show(ProductCategory $ProductCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified reproductCategories.
     *
     * @param  \App\Models\ProductCategory  $ProductCategory
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $source = ProductCategory::select('id', 'name', 'parent_id','image')->get()->toArray();
        $inArray = array();
        foreach($source as $key => $value)
        {
            $inArray[$key] = $value;
        }

        $outArray = array();
        $this->makeParentChildRelations($inArray, $outArray);
        //dd($outArray);

        $productCategory = ProductCategory::find($id);
        //$categoryList = ProductCategory::select('name','id')->get();
        return view('admin.productcategory.edit',compact('productCategory', 'outArray'));
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
            'name' => 'required|unique:product_categories,name,'.$id,
            'status' => 'required',
            'parent_id'=>'nullable|integer'
        ]);

        if ($request->hasFile('image'))
        {
            $filename = $request->image->store('images/category','public');
            $image_resize = Image::make(public_path('storage/'.$filename));
            $image_resize->fit(250, 250);
            $image_resize->save(public_path('storage/'.$filename));
        }

        $productCategory = ProductCategory::find($id);
        $productCategory->name=$request->name;
        $productCategory->image=$filename??NULL;
        $productCategory->slug=Str::slug($request->name,'-');
        $productCategory->status=$request->status;
        $productCategory->parent_id=$request->parent_id;
        $productCategory->ip_address = $request->ip();
        $productCategory->user_agent = $request->header('User-Agent');
        $productCategory->created_by=$productCategory->created_by;
        $productCategory->updated_by=Auth::guard('admin')->user()->id;
        $result=$productCategory->save();
        if($result){
           Session::flash('success','ProductCategory Updated successfully!!!!');
        }
        return redirect()->route('product-categories.index');
    }

    /**
     * Remove the specified reproductCategories from storage.
     *
     * @param  \App\Models\ProductCategory  $ProductCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $productCategory=ProductCategory::find($id);
        if($productCategory->products()->exists()){
            Session::flash('success','Category Can not  Delete ,This Category Has Product');
            return redirect()->route('product-categories.index');

        }
        if($productCategory->children()->exists()){
            foreach($productCategory->children as $child){
                if($child->children()->exists()){
                    Session::flash('success','Category Can not  Delete ,This Category child child Has Product');
                    return redirect()->route('product-categories.index');
                }
            }
            Session::flash('success','Category Can not  Delete ,This Category child Has Product');
            return redirect()->route('product-categories.index');

        }
        $result=$productCategory->delete();
        if($result){
            Session::flash('success','Product Category deleted successfully!!!!');
        }
        return redirect()->route('product-categories.index');

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
