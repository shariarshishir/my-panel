<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class ProductCategoryController extends Controller
{

    public function index()
    {
        $productCategories = ProductCategory::select('id', 'name', 'parent_id', 'slug','image')->where('parent_id', NULL)->get();
        $total_row = $productCategories->count();

        if($total_row > 0)
        {
            foreach($productCategories as $item){

                $category = ProductCategory::where('id', $item->id)->first();
                $total_cat_id[] = $category->id;
                if($category->children()->exists()){
                    foreach($category->children as $child){
                        array_push($total_cat_id, $child->id);
                        $category = ProductCategory::where('id',$child->id)->first();
                        foreach($category->children as $child){
                            array_push($total_cat_id, $child->id);
                        }

                    }
                    $products = Product::with('images')->whereIn('product_category_id', $total_cat_id)->where('state',1)->where('sold',0)->get();
                    $item['products'] = $products;
                }
                else
                {
                    $item['products'] = array();
                }

                if($item->children()->exists()) {
                    $item['hasChild'] = 1;
                }
                else
                {
                    $item['hasChild'] = 0;
                }
                $total_cat_id=[];
            }
            return response()->json(['message'=>'Categories found','outArray'=>$productCategories, 'total_row'=>$total_row,'code'=>'True'],200);
        }
        else
        {
            return response()->json(['message'=>'No categories found','code'=>'False'],200);
        }
    }

    public function subCategoryList($id){
        $productCategories = ProductCategory::select('id', 'name', 'parent_id', 'slug')->where('parent_id', $id)->get();
        $category=ProductCategory::where('parent_id', $id)->first();
        $total_row = $productCategories->count();

        if($total_row > 0)
        {
            foreach($productCategories as $item){

                $category = ProductCategory::where('id', $item->id)->first();
                if($item->children()->exists()) {
                    $item['hasChild'] = 1;
                }
                else
                {
                    $item['hasChild'] = 0;
                }

            }
            return response()->json(['subcategoryArray'=>$productCategories, 'total_row'=>$total_row, 'message'=>'Categories found','code'=>'True'],200);
        }
        else
        {

            return response()->json(['subcategoryArray'=>$productCategories, 'message'=>'No categories found','code'=>'False'],200);
        }
    }



    public function categoryList()
    {
        $productCategories = ProductCategory::all();
        $source = ProductCategory::select('id', 'name', 'parent_id', 'slug')->get()->toArray();
        $inArray = array();
        foreach($source as $key => $value)
        {
            $inArray[$key] = $value;
        }

        $outArray = array();
        $this->makeParentChildRelations($inArray, $outArray);

        $total_row = $productCategories->count();
        return response()->json(['outArray'=>$outArray, 'total_row'=>$total_row,'code'=>'True'],200);
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
