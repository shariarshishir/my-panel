<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Exception;
use Illuminate\Support\Str;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Session;
use App\Models\CartItem;
use App\Models\Product;
use stdClass;
use Illuminate\Support\Facades\Validator;
use App\Events\NewOrderHasPlacedEvent;
use App\Events\ProductAvailabilityEvent;
use App\Models\OrderModification;


class CartController extends Controller
{

    public function index()
    {
        $cartItems=CartItem::Where('user_id',auth()->user()->id)->get();
        $cartItemsArray=[];
        if(count($cartItems)>0){
            foreach($cartItems as $cartItem){

                $newFormatedCart= new stdClass();
                $newFormatedCart->id=$cartItem->id;
                $newFormatedCart->business_profile_id=$cartItem->business_profile_id;
                $newFormatedCart->user_id= $cartItem->user_id;
                $newFormatedCart->sku=$cartItem->product_sku;
                $newFormatedCart->name= $cartItem->name;
                $newFormatedCart->product_type=$cartItem->product_type;
                $newFormatedCart->unit_price=$cartItem->unit_price;
                $newFormatedCart->quantity=$cartItem->quantity;
                $newFormatedCart->total_price=$cartItem->total_price;
                $newFormatedCart->copyright_price=$cartItem->copyright_price;
                $newFormatedCart->image=  $cartItem->image;
                $newFormatedCart->color_attr= json_decode($cartItem->color_attr);
                $newFormatedCart->order_modification_req_id=$cartItem->order_modification_req_id;
                $newFormatedCart->full_stock= $cartItem->full_stock;
                array_push($cartItemsArray,$newFormatedCart);

            }
            return response()->json([
                'code'=>true,
                'noOfCartItems'=>count($cartItems),
                'cartItems'=>$cartItemsArray
            ]);

        }
        else{
            return response()->json([
                'code'=>false,
                'noOfCartItems'=>count($cartItems),
                'cartItems'=>$cartItemsArray
            ]);
        }
    }

    public function addToCart(Request $request){
        $product=Product::where('id',$request->product_id)->first();
        $checkProductExistsOrNot=CartItem::Where('user_id',auth()->user()->id)->where('product_sku',$product->sku)->first();
        if($checkProductExistsOrNot){
            $message="Product already exist";
            $cartItems=CartItem::Where('user_id',auth()->user()->id)->get();
            return response()->json([
                'success' => $message,
                'noOfCartItems'=>count($cartItems),
            ]);
        }

        $cartItem=new CartItem();
        $cartItem->user_id=auth()->user()->id;
        $cartItem->product_sku=$product->sku;
        $cartItem->name=$product->name;
        $cartItem->quantity=$request->quantity;
        $cartItem->unit_price=$request->unit_price;
        $cartItem->business_profile_id=$product->business_profile_id;
        $cartItem->image= $product->images[0]->image;
        $cartItem->product_type=$product->product_type;
        $cartItem->color_attr=json_encode($request->color_attribute);
        $cartItem->total_price= $request->quantity * $request->unit_price;
        $cartItem->copyright_price= $product->copyright_price;
        $cartItem->order_modification_req_id =isset($request->order_modification_req_id) ? $request->order_modification_req_id : null;
        $cartItem->full_stock = $product->full_stock == 1 ? 1 : 0;
        $cartItem->ip_address = $request->ip();
        $cartItem->user_agent = $request->header('User-Agent');
        $cartItem->save();

        $cartItems=CartItem::Where('user_id',auth()->user()->id)->get();
        $cartItemsArray=[];
        if(count($cartItems)>0){
            foreach($cartItems as $cartItem){

                $newFormatedCart= new stdClass();
                $newFormatedCart->id=$cartItem->id;
                $newFormatedCart->business_profile_id=$cartItem->business_profile_id;
                $newFormatedCart->user_id= $cartItem->user_id;
                $newFormatedCart->sku=$cartItem->sku;
                $newFormatedCart->name= $cartItem->name;
                $newFormatedCart->product_type=$cartItem->product_type;
                $newFormatedCart->unit_price=$cartItem->unit_price;
                $newFormatedCart->quantity=$cartItem->quantity;
                $newFormatedCart->total_price=$cartItem->total_price;
                $newFormatedCart->copyright_price=$product->copyright_price;
                $newFormatedCart->image=  $cartItem->image;
                $newFormatedCart->color_attr= json_decode($cartItem->color_attr);
                $newFormatedCart->order_modification_req_id=$cartItem->order_modification_req_id;
                $newFormatedCart->full_stock= $cartItem->full_stock;
                array_push($cartItemsArray,$newFormatedCart);

            }
            return response()->json([
                'success' => 'Added to cart successfully!',
                'noOfCartItems'=>count($cartItems),
                'cartItems'=>$cartItemsArray,
                'code'=>true

            ]);

        }else{
            return response()->json([
                'success' => 'Failed to add to cart!',
                'noOfCartItems'=>count($cartItems),
                'cartItems'=>$cartItemsArray,
                'code'=>false
            ]);
        }
    }

    public function noOfCartItems()
    {
        $noOfCartItems=CartItem::Where('user_id',auth()->user()->id)->count();
        if($noOfCartItems){
           
            return response()->json([
                'code'=>true,
                'noOfCartItems'=>$noOfCartItems,
            ]);

        }
        else{
            return response()->json([
                'code'=>false,
                'noOfCartItems'=>$noOfCartItems,
            ]);
        }
    }

    public function cartItemUpdate(Request $request)
    {
        $cartItem=CartItem::find($request->id);
        $cartItem->quantity=$request->quantity;
        $cartItem->unit_price=$request->unit_price;
        $cartItem->total_price= $request->quantity * $request->unit_price;
        if($request->copyright_price == 'on' ){
            $cartItem->total_price += $cartItem->copyright_price;
        }
        // $cartItem->color_attr=  $request->product_type==2 ? json_encode($colorArray) : null;
        $cartItem->color_attr=  json_encode($request->color_attribute) ;
        // if($request->product_type==2){

        // }
        $cartItem->ip_address = $request->ip();
        $cartItem->user_agent = $request->header('User-Agent');
        $cartItem->save();

        $cartItems=CartItem::Where('user_id',auth()->user()->id)->get();
        $cartItemsArray=[];
        if(count($cartItems)>0){
            foreach($cartItems as $cartItem){

                $newFormatedCart= new stdClass();
                $newFormatedCart->id=$cartItem->id;
                $newFormatedCart->business_profile_id=$cartItem->business_profile_id;
                $newFormatedCart->user_id= $cartItem->user_id;
                $newFormatedCart->product_sku=$cartItem->sku;
                $newFormatedCart->name= $cartItem->name;
                $newFormatedCart->product_type=$cartItem->product_type;
                $newFormatedCart->unit_price=$cartItem->unit_price;
                $newFormatedCart->quantity=$cartItem->quantity;
                $newFormatedCart->total_price=$cartItem->total_price;
                $newFormatedCart->copyright_price=$request->copyright_price;
                $newFormatedCart->image=  $cartItem->image;
                $newFormatedCart->color_attr= json_decode($cartItem->color_attr);
                $newFormatedCart->order_modification_req_id=$cartItem->order_modification_req_id;
                $newFormatedCart->full_stock= $cartItem->full_stock;
                array_push($cartItemsArray,$newFormatedCart);

            }
            return response()->json([
                'success' => 'Cart updated successfully!',
                'noOfCartItems'=>count($cartItems),
                'cartItems'=>$cartItemsArray,
                'code'=>true
            ]);

        }else{
            return response()->json([
                'success' => 'Failed to update Cart!',
                'noOfCartItems'=>count($cartItems),
                'cartItems'=>$cartItemsArray,
                'code'=>false
            ]);

        }

    }


    public function cartAllItemDelete(){

        $cartItem=CartItem::where('user_id',auth()->user()->id)->delete();
        if($cartItem){
            return response()->json([
                'success' => 'Cart Deleted successfully!',
                'code'=>true
            ]);

        }else{
            return response()->json([
                'success' => 'Failed to delete Cart Items!',
                'code'=>false
            ]);

        }
    }


    public function cartItemDelete($id){
        $cartItem=CartItem::where('id',$id)->delete();
        if($cartItem){
            return response()->json([
                'success' => 'Cart Item Deleted successfully!',
                'code'=>true
            ]);

        }else{
            return response()->json([
                'success' => 'Failed to delete item!',
                'code'=>false
            ]);

        }
    }
}
