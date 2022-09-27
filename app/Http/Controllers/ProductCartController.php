<?php

namespace App\Http\Controllers;
use App\Models\ProductCart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\Country;
use App\Models\VendorOrder;
use App\Models\VendorOrderItem;
use Illuminate\Http\Request;
use DB;
use Exception;
use Illuminate\Support\Str;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Session;
use App\Models\UserAddress;
use Illuminate\Support\Facades\Validator;
use App\Events\NewOrderHasPlacedEvent;
use App\Events\ProductAvailabilityEvent;
use App\Models\OrderModification;
use App\Models\OrderModificationRequest;
use Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;
use App\Http\Traits\PushNotificationTrait;


class ProductCartController extends Controller
{


    public function index()
    {

        $addToCartItems = [];
        //Retrieve the list of cat_id's in use.
        $cats = DB::table('cart_items')->where('user_id',auth()->user()->id)->select('business_profile_id')->groupBy('business_profile_id')->get();
        //for each cat_id in use, find the products associated and then add a collection of those products to the relevant array element
        foreach($cats as $key=>$cat)
        {
            //$addToCartItems[$cat->vendor_id] = DB::table('cart_items')->where('vendor_id', $cat->vendor_id)->where('cookie_identifier',$getCookieIdentifier)->get()->toArray();
            $addToCartItems[] = DB::table('cart_items')->where('business_profile_id', $cat->business_profile_id)->where('user_id',auth()->user()->id)->get()->toArray();

        }
        $cartData = DB::table('cart_items')->where('deleted_at', null)->where('user_id',auth()->user()->id)->get();
        $orderedItem=VendorOrderItem::pluck('product_sku')->toArray();
        return view('user.cart.index',compact('addToCartItems','cartData','orderedItem'));
    }


    public function addToCart(Request $request)
    {
        if(Auth::check())
        {
            $product=Product::where('sku',$request->sku)->first();
            if($product->businessProfile->user_id == auth()->id() || $product->businessProfile->representative_user_id == auth()->id()){
                $cartItems=CartItem::Where('user_id',auth()->user()->id)->get();
                $message="you can not order/cart your own product";
                return response()->json([
                    'success' => $message,
                    'message' => 'Sorry',
                    'type' => 'warning',
                    'cartItems'=>count($cartItems)
                ]);
            }
            $cartItems=CartItem::Where('user_id',auth()->user()->id)->get();
            $checkProductExistsOrNot=CartItem::Where('user_id',auth()->user()->id)->where('product_sku',$product->sku)->get();
            foreach( $checkProductExistsOrNot as $checkItem){
                if($checkItem && !isset($checkItem->order_modification_req_id) ){

                    $message="Product already exist";
                    //$cartItems=CartItem::Where('user_id',auth()->user()->id)->get();
                    return response()->json([
                        'success' => $message,
                        'message' => 'Warning!',
                        'type' => 'warning',
                        'cartItems'=>count($cartItems)
                    ]);
                }

                if(isset($checkItem->order_modification_req_id) && $checkItem->order_modification_req_id == $request->order_modification_req_id){
                    $message="Product already exist";
                    //$cartItems=CartItem::Where('user_id',auth()->user()->id)->get();
                    return response()->json([
                        'success' => $message,
                        'message' => 'Warning!',
                        'type' => 'warning',
                        'cartItems'=>count($cartItems)
                    ]);
                }
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
            $cartItem->color_attr=json_encode($request->color_attr);
            $cartItem->total_price= $request->total_price;
            $cartItem->copyright_price= $product->copyright_price;
            $cartItem->order_modification_req_id =isset($request->order_modification_req_id) ? $request->order_modification_req_id : null;
            $cartItem->full_stock = $product->full_stock == 1 ? 1 : 0;
            $cartItem->discount_amount= isset($request->discount_amount) ? $request->discount_amount : null;
            $cartItem->ip_address = $request->ip();
            $cartItem->user_agent = $request->header('User-Agent');
            $cartItem->save();

            $cartItems=CartItem::Where('user_id',auth()->user()->id)->get();
            return response()->json([
                'success' => 'Added to cart successfully!',
                'message' => 'Done!',
                'type' => 'success',
                'cartItems'=>count($cartItems)
            ]);

        }
        else
        {
            return response()->json([
                'success' => 'Plase Login first to add item into cart',
                'message' => 'Warning!',
                'type' => 'warning',
                'cartItems'=>0
            ]);
        }

    }

    public function addToCartbk(Request $request){

        $product=Product::where('sku',$request->sku)->first();
        $getCookieIdentifier=Session::get('cookie_identifier');
        if(isset($getCookieIdentifier)){
            $checkProductExistsOrNot=CartItem::Where('cookie_identifier',$getCookieIdentifier)->where('product_sku',$product->sku)->first();
            if($checkProductExistsOrNot){
                $message="Product already exist";
                $cartItems=Cart::content()->count();
                return response()->json([
                    'success' => $message,
                    'cartItems'=>$cartItems
                ]);
            }
        }
        $cart_data = array();
        $cart_data['qty'] = $request->quantity;
        $cart_data['id']  = $product->sku;
        $cart_data['name'] = $product->name;
        $cart_data['price'] = $request->unit_price;
        $cart_data['weight'] = 0;
        $cart_data['options'] = ['image' => $product->images[0]->image, 'vendor_id' => $product->vendor_id,'color_attr'=>$request->color_attr, 'product_type'=>$product->product_type, 'copyright_price' => $product->copyright_price, 'full_stock' => $request->full_stock];

        Cart::add($cart_data);

        if(isset($getCookieIdentifier)){
            CartItem::where('cookie_identifier',$getCookieIdentifier)->delete();
            $newCookieIdentifier=$getCookieIdentifier;
        }
        else{
            $newCookieIdentifier = IdGenerator::generate(['table' => 'cart_items', 'field' => 'cookie_identifier','reset_on_prefix_change' =>true,'length' => 6, 'prefix' => date('ym')]);
        }

        Session::put('cookie_identifier', $newCookieIdentifier);
        //return Cart::content();
        foreach(Cart::content() as $cartContent){
            $cartItem=new CartItem();
            $cartItem->cart_row_id=$cartContent->rowId;
            $cartItem->cookie_identifier=$newCookieIdentifier;
            $cartItem->product_sku=$cartContent->id;
            $cartItem->name=$cartContent->name;
            $cartItem->quantity=$cartContent->qty;
            $cartItem->unit_price=$cartContent->price;
            $cartItem->vendor_id=$cartContent->options->vendor_id;
            $cartItem->image=$cartContent->options->image;
            $cartItem->product_type=$cartContent->options->product_type;
            $cartItem->color_attr=json_encode($cartContent->options->color_attr);
            $cartItem->total_price= $cartContent->qty * $cartContent->price;
            $cartItem->copyright_price= $cartContent->options->copyright_price;
            $cartItem->order_modification_id =isset($request->order_modification_id) ? $request->order_modification_id : null;
            $cartItem->full_stock = $cartContent->options->full_stock == 1 ? 1 : 0;
            $cartItem->ip_address = $request->ip();
            $cartItem->user_agent = $request->header('User-Agent');
            $cartItem->save();

        }
        $cartItems=Cart::content()->count();
            return response()->json([
            'success' => 'Added to cart successfully!',
            'cartItems'=>$cartItems
        ]);
     }

    public function checkout(){
        // sso verify
        if(env('APP_ENV') == 'production')
        {
            $token=Cookie::get('sso_token');
            $response = Http::withToken($token)->get(env('SSO_URL').'/api/auth/token/verify');
            if(!$response->successful()){
                alert()->error('You are not authorized', 'Error')->persistent("Close this");
                return redirect()->back();
            }
        }

        $countries=Country::all();
        $billing_address=UserAddress::where('user_id',auth()->id())->where('address_type',1)->get();
        $shipping_address=UserAddress::where('user_id',auth()->id())->where('address_type',2)->get();
        $cartData = DB::table('cart_items')->where('deleted_at', null)->where('user_id',auth()->id())->get();
        $cartItems=count($cartData);
        if($cartItems == 0){ alert()->error('Please, re-check the cart page', 'Error')->persistent("Close this"); return redirect()->back();}
        return view('user.cart.checkout',compact('countries','cartItems','billing_address','shipping_address','cartData'));
    }

    public function cartItemDelete($id){
        CartItem::where('id',$id)->forceDelete();
        alert()->success('success','Cart item deleted successfully!!!!')->autoclose(3500);
        // Session::flash('success','Cart item deleted successfully!!!!');
        return redirect()->route('cart.index');
    }
    public function cartItemUpdate(Request $request)
    {

            $colorArray = array();
            foreach($request->color_size as $key => $value)
                {
                    foreach($value as $key2 => $value2 )
                        {
                            if($key=='color'){
                                $colorArray[$key2][$key]=$value2;
                            }else{
                                $colorArray[$key2][$key]=(int)$value2;
                            }

                        }
                }

        $cartItem=CartItem::find($request->rowId);
        $cartItem->quantity=$request->cart_quantity;
        $cartItem->unit_price=$request->unit_price;
        $cartItem->total_price= $request->total_price;
        if($request->copyright_price == 'on' ){
            $cartItem->total_price += $cartItem->copyright_price;
        }
        // $cartItem->color_attr=  $request->product_type==2 ? json_encode($colorArray) : null;
        $cartItem->color_attr=  json_encode($colorArray) ;
        // if($request->product_type==2){

        // }
        $cartItem->ip_address = $request->ip();
        $cartItem->user_agent = $request->header('User-Agent');
        $cartItem->save();
        alert()->success('success','Cart updated successfully!!!!')->autoclose(3500);
        return redirect()->route('cart.index');
    }
    //cart item update modal
    public function cartItemUpdateModal($cart_id)
    {
       $cart_item=CartItem::where('id',$cart_id)->first();
       $product=Product::where('sku',$cart_item->product_sku)->first();
       if(!$cart_item){
            return response()->json(array(
                'success' => false,
                'error' => 'Id Not Exists'),
                500);
       }
       return response()->json(array(
            'success' => true,
            'data' => $cart_item,
            'product' =>$product,
            ), 200);

    }
    public function cartAllItemDelete(){

        CartItem::where('user_id',auth()->user()->id)->forceDelete();
        alert()->success('success','Cart items deleted successfully!!!!')->autoclose(3500);
        return redirect()->back();
    }

    public function order(Request $request)
    {

      // return $request->all();
        DB::beginTransaction();

        if(isset($request->billing_address_id)){
            $billing_address_id=$request->billing_address_id;
        }
        else{
            $request->validate([
               'billing_name'=>'required',
               'billing_company_name'=>'required',
               'billing_email'=>'required|email',
               'billing_phone'=>'required',
               'billing_address'=>'required',
               'billing_zip'=>'required',
               'billing_city'=>'required',
               'b_country'=>'required',
            ]);
            $address_id=UserAddress::create([
                'user_id' =>auth()->id(),
                'address_type' => 1,
                'name'    => $request->billing_name,
                'company_name'    => $request->billing_company_name,
                'email'   => $request->billing_email,
                'phone'   => $request->billing_phone,
                'address' => $request->billing_address,
                'zip'     => $request->billing_zip,
                'city'    => $request->billing_city,
                'country' => $request->b_country,

            ]);
            $billing_address_id=$address_id->id;
        }
        //shipping address
        if(isset($request->same_as_billing_adrs)){
            $shipping_address_id=$billing_address_id;
        }else{
            if(isset($request->shipping_address_id)){
                $shipping_address_id=$request->shipping_address_id;
            }
            else{
                $request->validate([
                    'shipping_name'=>'required',
                    'shipping_company_name'=>'required',
                    'shipping_email'=>'required|email',
                    'shipping_phone'=>'required',
                    'shipping_address'=>'required',
                    'shipping_zip'=>'required',
                    'shipping_city'=>'required',
                    's_country'=>'required',
                ]);
                $address_id=UserAddress::create([
                    'user_id' =>auth()->id(),
                    'address_type' => 2,
                    'name'    => $request->shipping_name,
                    'company_name'   => $request->shipping_company_name,
                    'email'   => $request->shipping_email,
                    'phone'   => $request->shipping_phone,
                    'address' => $request->shipping_address,
                    'zip'     => $request->shipping_zip,
                    'city'    => $request->shipping_city,
                    'country' => $request->s_country,

                ]);
                $shipping_address_id=$address_id->id;
            }
        }


        try {
            $cartItem=CartItem::where('user_id',auth()->user()->id)->get();
            $uniqueVendorId = DB::table('cart_items')->where('user_id',auth()->user()->id)->select([DB::raw("SUM(total_price) as price"), DB::raw("SUM(quantity) as quantity"),'business_profile_id'])->groupBy('business_profile_id')->get();
            $order_number=[];
            foreach($uniqueVendorId as $item){
                $orderNumber = IdGenerator::generate(['table' => 'vendor_orders', 'field' => 'order_number','reset_on_prefix_change' =>true,'length' => 12, 'prefix' => date('ymd')]);
                $order=VendorOrder::create([
                    'user_id'         => auth()->user()->id,
                    'business_profile_id' => $item->business_profile_id,
                    'order_number'    => $orderNumber,
                    'grand_total'     => $item->price,
                    'shipping_id'     => $shipping_address_id,
                    'billing_id'      => $billing_address_id,
                    'payment_id'      => $request->payment_id,
                    'state'           => 'pending',
                    'payment_status'  => 'unpaid',
                    'ip_address'      => $request->ip(),
                    'user_agent'      => $request->header('User-Agent'),
                ]);
                array_push($order_number, $order->order_number);
                foreach($cartItem as $list){
                    if($list->business_profile_id == $item->business_profile_id){
                        $orderItem=VendorOrderItem::create([
                            'order_id'      => $order->id,
                            'product_sku'   => $list->product_sku,
                            'quantity'      => $list->quantity,
                            'unit_price'    => $list->unit_price,
                            'copyright_price' => $list->copyright == true ? $list->copyright_price : null,
                            'price'         => $list->total_price,
                            // 'colors_sizes'  => $list->color_attr != 'null' ? $list->color_attr : NULL,
                            'colors_sizes'  => $list->color_attr,
                            'order_modification_req_id' =>  $list->order_modification_req_id ?? null,
                            'full_stock'     => $list->full_stock,
                            'discount'       => $list->discount_amount,
                        ]);
                        if(isset($list->order_modification_req_id)){
                           OrderModificationRequest::where('id',$list->order_modification_req_id)->update(['state' => config('constants.order_query_status.ordered')]);
                        }
                        if(isset($orderItem->copyright_price))
                        {
                            $updateSoldCopyright=Product::where('sku',$list->product_sku )->update(['sold' => 1]);
                        }
                        //manage store
                        // product type = 2 = ready stock, 3 =non clothing
                        if($list->product_type == 2 || $list->product_type == 3){
                            $this->updateAndNofiyProductAvailability($list->product_sku, $list->color_attr);
                        }

                    }
                }
              
                    event(new NewOrderHasPlacedEvent($order));
            }


            CartItem::where('user_id',auth()->user()->id)->forceDelete();
            DB::commit();
            alert()->success('Your Order has been successfully done')->autoclose(3500);
            //alert()->success('Your Order has been successfully done')->autoclose(3500);
            return view('order_success',compact('order_number'))->with('success', 'Your Order has been successfully done');
        }catch(Exception $e){
            DB::rollback();
            return redirect()->back()->withErrors($e->getMessage());
        }


    }

    public function orderSuccess()
    {
        return view('order_success');
    }

    //copyright price change
    public function copyRightPrice(Request $request)
    {

        $cartItem=CartItem::where('id',$request->cart_row_id)->where('user_id',auth()->user()->id)->first();
        if($request->checked == 1)
        {
           $cartItem->update(['total_price' => $cartItem->total_price + $cartItem->copyright_price, 'copyright' => true ]);
        }
        else{
            $cartItem->update(['total_price' => $cartItem->total_price - $cartItem->copyright_price, 'copyright' => false]);
        }
        return 'Ok';
    }

   //check product availability
   public function updateAndNofiyProductAvailability($productSku, $cartColorsSizes)
   {
       $colorArray=[];
       $total_colors_sizes=[];
       $cart_colors_sizes=json_decode($cartColorsSizes);
       $product=Product::where('sku',$productSku)->first();
      //reduce stock calculating
       $product_colors_sizes=json_decode($product->colors_sizes);
       if($product->product_type == 2){
            foreach($product_colors_sizes as $p_key => $p_value){
                foreach($cart_colors_sizes as $c_key => $c_value){
                    if($p_key == $c_key){
                        $colorArray[$p_key]['color']= $p_value->color;
                        $colorArray[$p_key]['xxs']= $p_value->xxs - $c_value->xxs;
                        $colorArray[$p_key]['xs']= $p_value->xs - $c_value->xs;
                        $colorArray[$p_key]['small']= $p_value->small - $c_value->small;
                        $colorArray[$p_key]['medium']= $p_value->medium - $c_value->medium;
                        $colorArray[$p_key]['large']= $p_value->large - $c_value->large;
                        $colorArray[$p_key]['extra_large']= $p_value->extra_large - $c_value->extra_large;
                        $colorArray[$p_key]['xxl']= $p_value->xxl - $c_value->xxl;
                        $colorArray[$p_key]['xxxl']= $p_value->xxxl - $c_value->xxxl;
                        $colorArray[$p_key]['four_xxl']= $p_value->four_xxl - $c_value->four_xxl;
                        $colorArray[$p_key]['one_size']= $p_value->one_size - $c_value->one_size;
                        array_push($total_colors_sizes, $colorArray[$p_key]['xxs'] + $colorArray[$p_key]['xs'] +  $colorArray[$p_key]['small'] + $colorArray[$p_key]['medium'] +  $colorArray[$p_key]['large'] +  $colorArray[$p_key]['extra_large'] +  $colorArray[$p_key]['xxl'] +  $colorArray[$p_key]['xxxl'] +  $colorArray[$p_key]['four_xxl'] +  $colorArray[$p_key]['one_size']);
                    }
                }
            }
        }else{
            foreach($product_colors_sizes as $p_key => $p_value){
                foreach($cart_colors_sizes as $c_key => $c_value){
                    if($p_key == $c_key){
                        $colorArray[$p_key]['color']= $p_value->color;
                        $colorArray[$p_key]['quantity']= $p_value->quantity - $c_value->quantity;
                        array_push($total_colors_sizes, $colorArray[$p_key]['quantity'] );
                    }
                }
            }

        }

       $product->update(['colors_sizes' => json_encode($colorArray), 'availability' => array_sum($total_colors_sizes)]);
       //checking if less than moq
       $alert_array=[];
       if($product->full_stock == false)
       {
            if($product->product_type == 2)
            {
                foreach(json_decode($product->colors_sizes) as $key => $value)
                {

                    if($value->xxs < $product->moq){
                        $alert_array[$key]['color']= $value->color;
                        $alert_array[$key]['xxs']= $value->xxs;
                    }
                    if($value->xs < $product->moq){
                        $alert_array[$key]['color']= $value->color;
                        $alert_array[$key]['xs']= $value->xs;
                    }
                    if($value->small < $product->moq){
                        $alert_array[$key]['color']= $value->color;
                        $alert_array[$key]['small']= $value->small;
                    }
                    if($value->medium < $product->moq){
                        $alert_array[$key]['color']= $value->color;
                        $alert_array[$key]['medium']= $value->medium;
                    }
                    if($value->large < $product->moq){
                        $alert_array[$key]['color']= $value->color;
                        $alert_array[$key]['large']= $value->large;
                    }
                    if($value->extra_large < $product->moq){
                        $alert_array[$key]['color']= $value->color;
                        $alert_array[$key]['extra_large']= $value->extra_large;
                    }
                    if($value->xxl < $product->moq){
                        $alert_array[$key]['color']= $value->color;
                        $alert_array[$key]['xxl']= $value->xxl;
                    }
                    if($value->xxxl < $product->moq){
                        $alert_array[$key]['color']= $value->color;
                        $alert_array[$key]['xxxl']= $value->xxxl;
                    }
                    if($value->four_xxl < $product->moq){
                        $alert_array[$key]['color']= $value->color;
                        $alert_array[$key]['four_xxl']= $value->four_xxl;
                    }
                    if($value->one_size < $product->moq){
                        $alert_array[$key]['color']= $value->color;
                        $alert_array[$key]['one_size']= $value->one_size;
                    }

                    //    foreach($value as $key2 => $value2){
                    //      if($key2 != 'color'){
                    //          if($value2 < $product->moq){
                    //              echo $key2.'value2'.$value2.'<br>';
                    //          }
                    //      };
                    //    }

                }
            }else
            {
                foreach(json_decode($product->colors_sizes) as $key => $value)
                {
                    if($value->quantity < $product->moq){
                        $alert_array[$key]['color']= $value->color;
                        $alert_array[$key]['quantity']= $value->quantity;
                    }
                }
            }
        }
       //end checking moq
    // if($product->availability == 0 ){
    //     event(new ProductAvailabilityEvent($product));
    // }else{
    //     if(!empty($alert_array)){

    //         event(new ProductAvailabilityEvent($product, $alert_array));
    //     }
    // }

    //    if(array_sum($total_colors_sizes) < $product->moq ){
    //        event(new ProductAvailabilityEvent($product));
    //    }
   }

}
