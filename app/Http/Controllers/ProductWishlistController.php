<?php

namespace App\Http\Controllers;

use App\Models\Manufacture\Product as ManufactureProduct;
use App\Models\Product;
use App\Models\ProductWishlist;
use Auth;
use Illuminate\Http\Request;

class ProductWishlistController extends Controller
{
    public function  addToWishlist(Request $request){

        if (Auth::check()) {
            $flag= $request->flag;
            $id= $request->id;
            if($flag == 'shop'){
                $product=Product::where('id',$id)->first();
                $result=ProductWishlist::where('user_id',Auth::user()->id)->where('product_id',$product->id)->first();
            }
            else if($flag == 'mb'){
                $product=ManufactureProduct::where('id',$id)->first();
                $result=ProductWishlist::where('user_id',Auth::user()->id)->where('manufacture_product_id',$product->id)->first();
            }
            // $productSku=$request->id;
            // $product=Product::where('sku',$productSku)->first();
            // $result=ProductWishlist::where('user_id',Auth::user()->id)->where('product_id',$product->id)->first();
            if(!$result){
                $productWishlist=new ProductWishlist;
                $flag == 'shop' ?  $productWishlist->product_id=$product->id : $productWishlist->manufacture_product_id=$product->id;
                // $productWishlist->product_id=$product->id;
                $productWishlist->user_id=Auth::user()->id;
                $productWishlist->ip_address = $request->ip();
                $productWishlist->user_agent = $request->header('User-Agent');
                $productWishlist->save();
                if($productWishlist){
                    return response()->json(
                        ['message' => 'Added to Wishlist ..'],
                    200);
                }

            }
            else{
                return response()->json(
                    ['message' => 'Product already added in wishlist !!'],
                409);
            }

        }
        else{
            return response()->json(
                ['message' => 'Please login first !!'],
            401);
        }
    }


    public function  index(){
        $wishListItems=ProductWishlist::with('product','manufacture_product.product_images')->where('user_id',Auth::user()->id)->paginate(6);
        foreach($wishListItems as $item){
            $item['flag'] = $item->product ? 'shop' : 'mb';
        }
        return view('user.wishlist.index',compact('wishListItems'));

    }

    public function wishListItemDelete(Request $request){
        $wishListItem=ProductWishlist::where('id',$request->id)->first();
        $wishListItem->forceDelete();
        if($wishListItem){
            return response()->json(
                ['message' => 'Deleted From Wishlist ..']
            );
        }
    }

}
