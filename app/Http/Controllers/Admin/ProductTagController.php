<?php

namespace App\Http\Controllers\Admin;

use App\Models\ProductTag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BusinessMappingTree;
use Illuminate\Support\Facades\Session;

class ProductTagController extends Controller
{
    public function index()
    {
        $product_tag = ProductTag::with('tagMapping')->select('id', 'name')->get();
        return view('admin.product_tag.index',compact('product_tag'));
    }

    /**
     * Show the form for creating a new reproductCategories.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $product_tag = new ProductTag();
        $parent=$this->getBusinessMappingTreeThirdLayer();
        $business_mapping_tree=BusinessMappingTree::where('id',1)->with('children.children')->get(['id','name']);
        return view('admin.product_tag.create',compact('product_tag','parent','business_mapping_tree'));

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
            'name' => 'required|unique:product_tags,name',
            'parent' => 'required',
            'parent.*' => 'required',
        ]);

        $product_tag=new ProductTag();
        $product_tag->name=strtolower($request->name);
        $product_tag->save();
        $product_tag->tagMapping()->sync($request->parent);
        Session::flash('success','Added successfully!!!!');

        return redirect()->route('admin.product-tag.index');

    }

    /**
     * Show the form for editing the specified reproductCategories.
     *
     * @param  \App\Models\ProductTag  $ProductTag
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product_tag = ProductTag::with('tagMapping')->find($id);
        $parent=$this->getBusinessMappingTreeThirdLayer();
        $business_mapping_tree=BusinessMappingTree::where('id',1)->with('children.children')->get(['id','name']);
        return view('admin.product_tag.edit',compact('product_tag','business_mapping_tree'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:product_tags,name,'.$id,
            'parent' => 'required',
            'parent.*' => 'required',
        ]);
        $product_tag = ProductTag::find($id);
        $product_tag->name=strtolower($request->name);
        $product_tag->save();
        $product_tag->tagMapping()->sync($request->parent);
        Session::flash('success','Updated successfully!!!!');
        return redirect()->route('admin.product-tag.index');
    }


    public function destroy($id)
    {
        $productTypeMapping=ProductTag::find($id);
        $productTypeMapping->delete();
        Session::flash('success','ProductTag deleted successfully!!!!');
        return redirect()->route('admin.product-tag.index');

    }

    public function getBusinessMappingTreeThirdLayer(){
        $parent=[];
        $business_mapping_tree=BusinessMappingTree::with('children.children')->get(['id','name']);
        foreach($business_mapping_tree as $data){
            if($data->children()->exists()){
                foreach($data->children as $data2){
                    if($data2->children()->exists()){
                        foreach($data2->children as $data3){
                            array_push($parent,['id' => $data3->id, 'name' => $data3->name]);
                        }
                    }
                }
            }
        }

        return $parent;
    }




}
