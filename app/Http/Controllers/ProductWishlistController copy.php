<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\ProductWishlist;
use Auth;
use Illuminate\Http\Request;

class ProductWishlistController extends Controller
{
    public function  addToWishlist(Request $request){

        if (Auth::check()) {
            $productSku=$request->id;
            $product=Product::where('sku',$productSku)->first();
            $result=ProductWishlist::where('user_id',Auth::user()->id)->where('product_id',$product->id)->first();
            if(!$result){
                $productWishlist=new ProductWishlist;
                $productWishlist->product_id=$product->id;
                $productWishlist->user_id=Auth::user()->id;
                $productWishlist->ip_address = $request->ip();
                $productWishlist->user_agent = $request->header('User-Agent');
                $productWishlist->save();
                if($productWishlist){
                    return response()->json(
                        ['message' => 'Added to Wishlist ..']
                    );
                }

            }
            else{
                return response()->json(
                    ['message' => 'Product already added in wishlist !!']
                );
            }

        }
        else{
            return response()->json(
                ['message' => 'Please login first !!']
            );
        }
    }


    public function  index(){
        $wishListItems=ProductWishlist::with('product')->where('user_id',Auth::user()->id)->get();
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
