<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use Carbon\Carbon;
use File;
use Image;
use Illuminate\Support\Str;
use App\Models\ProductImage;
use DB;
use App\Models\ProductCategory;
use App\Models\Vendor;
use DataTables;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use stdClass;
use App\Models\RelatedProduct;
use App\Rules\MoqUnitRule;
use App\Rules\ReadyStockPriceBreakDownRule;
use App\Rules\NonClothingPriceBreakDownRule;
use App\Rules\NonClothingFullStockRule;
use App\Rules\ReadyStockFullStockRule;



class SellerProductController extends Controller
{

   public function index(Request $request)
   {
       if ($request->ajax())
        {
            $data =Product::latest()->where('vendor_id',auth()->user()->vendor->id)->with('images');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('image',function($row){
                    if($row->images->isEmpty()){return '';}
                    // foreach($row->images as $key => $image)
                    // {
                        $source=asset('storage/'.$row->images[0]->image);
                        if($row->availability==0 && ($row->product_type == 2 || $row->product_type == 3)){
                            return $image='<span class="new badge red" data-badge-caption="sold"></span><img src="'.$source.'" class="responsive-img" alt="" width="150" height="80"/> ';
                        }
                        return $image='<img src="'.$source.'" class="responsive-img" alt="" width="150" height="80"/>';

                    // }
                })
                ->addColumn('action', function($row){
                    //$actionBtn = '<a href="javascript:void(0)" class="seller-edit-product btn waves-effect waves-light green" id="'.$row->sku.'"><i class="material-icons dp48">edit</i></a> <a href="javascript:void(0)" class="seller-delete-prodcut seller-publish-unpublish-prodcut btn waves-effect waves-light green" id="'.$row->sku.'"><i class="material-icons dp48">close</i></a>';
                    $actionBtn = '<a href="javascript:void(0)" class="seller-edit-product btn waves-effect waves-light green" id="'.$row->sku.'">';
                    $actionBtn .= '<i class="material-icons dp48">edit</i>';
                    $actionBtn .= '</a>';
                    if($row->state==1)
                    {
                        $actionBtn .= '&nbsp; <a href="javascript:void(0)" data-status="1" class="seller-delete-prodcut seller-publish-unpublish-prodcut btn waves-effect waves-light red" id="'.$row->sku.'">';
                        $actionBtn .= '<i class="material-icons dp48">close</i>';
                        $actionBtn .= '</a>';
                    }
                    else
                    {
                        $actionBtn .= '&nbsp; <a href="javascript:void(0)" data-status="0" class="seller-delete-prodcut seller-publish-unpublish-prodcut btn waves-effect waves-light green" id="'.$row->sku.'">';
                        $actionBtn .= '<i class="material-icons dp48">check</i>';
                        $actionBtn .= '</a>';
                    }
                    return $actionBtn;
                })
                ->editColumn('state', function($row) {
                    if($row->state==1) return 'Published';
                    else return 'Not Published';
                })
                ->editColumn('is_featured', function($row) {
                    if($row->is_featured==1) return 'YES';
                    else return 'NO';
                })
                ->editColumn('is_new_arrival', function($row) {
                    if($row->is_new_arrival==1) return 'YES';
                    else return 'NO';
                })
                ->filter(function ($instance) use ($request) {
                    if ($request->get('state') == '0' || $request->get('state') == '1') {
                        $instance->where('state', $request->get('state'));
                    }
                    if ($request->get('product_type')!= null) {
                        $instance->where('product_type', $request->get('product_type'));
                    }
                    // if ($request->get('arrival') == '0' || $request->get('arrival') == '1') {
                    //     $instance->where('is_new_arrival', $request->get('arrival'));
                    // }
                    // if ($request->get('featured') == '0' || $request->get('featured') == '1') {
                    //     $instance->where('is_featured', $request->get('featured'));
                    // }
                    if (!empty($request->get('search'))) {
                        $instance->where('name', 'like', "%{$request->get('search')}%");
                    }

                })
                ->rawColumns(['action','image'])
                ->make(true);
        }



         $notifications = auth()->user()->unreadNotifications;
         $orderIds=[];
         $orderModificationRequestIds=[];
         $orderApprovedNotificationIds=[];
         $orderModificationRequestNotificationIds=[];
         $orderQueryProcessedIds=[];
         foreach($notifications as $notification)
         {
            if($notification->type == "App\Notifications\NewOrderHasApprovedNotification"){
                array_push($orderIds,$notification->data['notification_data']);
            }
            else if($notification->type == "QueryWithModificationToUserNotification"){
                array_push($orderModificationRequestIds,$notification->data['notification_data']);

            }
            else if($notification->type == "App\Notifications\OrderQueryFromAdminNotification"){
                array_push($orderQueryProcessedIds,$notification->data['notification_data']['order_modification_request_id']);
            }
            else if($notification->type == "App\Notifications\QueryCommuncationNotification"){
                if($notification->data['order_qurey_type'] == 2){
                    array_push($orderModificationRequestIds,$notification->data['notification_data']);
                }
                if($notification->data['order_qurey_type'] == 1){
                    array_push($orderQueryProcessedIds,$notification->data['notification_data']);
                }
            }
            elseif($notification->type == "App\Notifications\PaymentSuccessNotification"){
                array_push($orderIds,$notification->data['notification_data']);
            }
         }

        return view('user.profile.products._partial_index',compact('orderIds','orderModificationRequestIds','orderQueryProcessedIds'));

   }


   public function store(Request $request)
   {
        $validator = Validator::make($request->all(), [
            'images'  => 'required',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg,JPEG,PNG,JPG,GIF,SVG|max:5120',
            'name'      => 'required',
            'category_id' => 'required',
            'product_type' => 'required',
            'description'  => 'required',
            'moq'         => [new MoqUnitRule($request, $request->product_type)],
            'product_unit'  =>[new MoqUnitRule($request, $request->product_type)],
            'ready_stock_availability'  => 'required_if:product_type,2',
            'non_clothing_availability'  => 'required_if:product_type,3',
            'quantity_min.*' => 'required_if:product_type,1',
            'quantity_max.*' => 'required_if:product_type,1',
            'price.*' => 'required_if:product_type,1',
            'lead_time.*' => 'required_if:product_type,1',
            'ready_quantity_min.*' => [new ReadyStockPriceBreakDownRule($request, $request->product_type)],
            'ready_quantity_max.*' => [new ReadyStockPriceBreakDownRule($request, $request->product_type)],
            'ready_price.*' => [new ReadyStockPriceBreakDownRule($request, $request->product_type)],
            'non_clothing_min.*' => [new NonClothingPriceBreakDownRule($request, $request->product_type)],
            'non_clothing_max.*' => [new NonClothingPriceBreakDownRule($request, $request->product_type)],
            'non_clothing_price.*' => [new NonClothingPriceBreakDownRule($request, $request->product_type)],
            'full_stock_price' => [new ReadyStockFullStockRule($request, $request->product_type)],
            'non_clothing_full_stock_price' => [new NonClothingFullStockRule($request, $request->product_type)],

        ]);

        // return $request->all();
        if ($validator->fails())
        {
            return response()->json(array(
            'success' => false,
            'error' => $validator->getMessageBag()),
            400);
        }

        DB::beginTransaction();

        try {
            $date=Carbon::now()->timestamp;
            $number=mt_rand(0,9999);
            $remove[] = "'";
            $remove[] = '"';
            $remove[] = "-";
            $remove[] = "#";
            $FileName = str_replace($remove, "", $request->name);
            $name= explode(' ',strtolower($FileName));
            $sku=$name[0].$date.$number;

            $full_stock_negotiable=false;
            $full_stock = false;
            $full_stock_price = null;
            $availability=null;
            if($request->product_type==1){
                $price_break_down=[];
                for($i=0; $i < count($request->quantity_min); $i++){
                    // $price= is_numeric($request->price[$i]) ? $request->price[$i] :  'negotiable';
                    array_push($price_break_down,[(int)$request->quantity_min[$i],(int)$request->quantity_max[$i],is_numeric($request->price[$i]) ? $request->price[$i] : 'Negotiable',$request->lead_time[$i]]);
                }
            }

            if($request->product_type==2){
                $colors_sizes=[];
                if(isset($request->color_size['color'])){
                    // for($i=0; $i < count($request->color_size['color']); $i++){
                    //     array_push($colors_sizes, ['color' => $request->color_size['color'][$i], 'small' => $request->color_size['small'][$i],'medium' => $request->color_size['medium'][$i], 'large' => $request->color_size['large'][$i], 'extra_large' => $request->color_size['extra_large'][$i]]);
                    // }
                    foreach($request->color_size as $key => $value)
                    {
                        foreach($value as $key2 => $value2 )
                            {
                                if($key=='color'){
                                    $colors_sizes[$key2][$key]=$value2;
                                }else{
                                    $colors_sizes[$key2][$key]=(int)$value2;
                                }

                            }
                    }

                }

                $price_break_down=[];
                for($i=0; $i < count($request->ready_quantity_min); $i++){
                    array_push($price_break_down,[(int)$request->ready_quantity_min[$i],(int)$request->ready_quantity_max[$i],is_numeric($request->ready_price[$i]) ? $request->ready_price[$i] : 'Negotiable']);
                }
                $full_stock= isset($request->full_stock) ? true : false;
                $full_stock_price = isset($request->full_stock_price) ? $request->full_stock_price : null;
                $availability=$request->ready_stock_availability;
                $full_stock_negotiable= isset($request->ready_full_stock_negotiable) ? true : false;

            }

            //non clothing item
            if($request->product_type==3)
            {
                $colors_sizes=[];
                if(isset($request->non_clothing_attr)){
                    foreach($request->non_clothing_attr as $key => $value)
                    {
                        foreach($value as $key2 => $value2 )
                            {
                                if($key=='color'){
                                    $colors_sizes[$key2][$key]=$value2;
                                }else{
                                    $colors_sizes[$key2][$key]=(int)$value2;
                                }

                            }
                    }

                }

                $price_break_down=[];
                for($i=0; $i < count($request->non_clothing_min); $i++){
                    array_push($price_break_down,[(int)$request->non_clothing_min[$i],(int)$request->non_clothing_max[$i],is_numeric($request->non_clothing_price[$i]) ? $request->non_clothing_price[$i] : 'Negotiable']);
                }
                $full_stock= isset($request->non_clothing_full_stock) ? true : false;
                $full_stock_price = isset($request->non_clothing_full_stock_price) ? $request->non_clothing_full_stock_price : null;
                $availability=$request->non_clothing_availability;
                $full_stock_negotiable= isset($request->non_clothing_full_stock_negotiable) ? true : false;
            }

            //tiny mc text editor file upload
            $temporary_folder= public_path('storage/temp').'/'.auth()->user()->vendor->vendor_name.'/'.'pdf/';
            if (!file_exists($temporary_folder)) {
                mkdir($temporary_folder, 0777, true);
            }
            $pdfFolder= File::files(public_path('storage/temp').'/'.auth()->user()->vendor->vendor_name.'/'.'pdf/');
            if($pdfFolder){
                foreach($pdfFolder as $path) {
                    $file = pathinfo($path);
                    $full_path=$file['dirname'].'/'.$file['basename'];
                    $destination_folder=public_path('storage/images/').auth()->user()->vendor->vendor_name.'/'.'pdf/';
                    if (!file_exists($destination_folder)) {
                        mkdir($destination_folder, 0777, true);
                    }
                    $destination=$destination_folder.$file['basename'];
                    File::move($full_path, $destination);
                }
            }


            $product=Product::create([
                'vendor_id' => auth()->user()->vendor->id,
                'name'      => $request->name,
                'sku'       => $sku,
                'product_category_id' => $request->category_id,
                'product_type'  => $request->product_type,
                'attribute' => json_encode($price_break_down) ?? null,
                'is_featured' => $request->is_featured=='on'? 1:0,
                'is_new_arrival' => $request->is_new_arrival=='on'? 1:0,
                'state'   => $request->published=='on'? 1:0,
                'description' => $request->description,
                'additional_description' => $request->additional_description ?? null,
                'colors_sizes'  => isset($colors_sizes)  ?  json_encode($colors_sizes) : null,
                'moq'         => $request->moq ?? null,
                'product_unit'         => $request->product_unit ?? null,
                'availability'     => $availability,
                'ip_address' => $request->ip(),
                'user_agent' => $request->header('User-Agent'),
                'copyright_price'  => $request->product_type==1 ? $request->copyright_price : null,
                'full_stock'     => $full_stock,
                'full_stock_price' =>  $full_stock_price,
                'full_stock_negotiable' => $full_stock_negotiable,
                'customize'      => isset($request->customize) ? true : false,
                'created_by'  => auth()->id(),

           ]);

           $user=User::where('id',auth()->id())->first();
           $vendorName=Str::slug($user->vendor->vendor_name,'-');
           foreach ($request->images as $image) {
                $filename = $image->store('images/'.$vendorName.'/products/small','public');
                $image_resize = Image::make(public_path('storage/'.$filename));
                $image_resize->fit(300, 300);
                $image_resize->save(public_path('storage/'.$filename));
                $original=$image->store('images/'.$vendorName.'/products/original','public');
                $product_image = ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $filename,
                    'original' => $original,
                ]);
            }
            //related products
            if($request->related_products)
            {
                foreach($request->related_products as $item){
                    RelatedProduct::create([
                        'vendor_id'  => auth()->user()->vendor->id,
                        'product_id' => $product->id,
                        'related_product_id' => $item,
                    ]);
                }

            }
            DB::commit();

            return response()->json(array('success' => true, 'msg' => 'Product Created Successfully'),200);
        }catch (\Exception $e) {
            DB::rollback();
            return response()->json(array(
                'success' => false,
                'error' => $e->getMessage(),),
                500);
        }

    }

    public function edit($sku)
    {
       try{
            $product=Product::where('sku',$sku)->first();
            $colors_sizes=json_decode($product->colors_sizes);
            $attr=json_decode($product->attribute);
            $preloaded=array();
            foreach($product->images as $key=>$image){
                $obj[$key] = new stdClass;
                $obj[$key]->id = $image->id;
                $obj[$key]->src = asset('storage/'.$image->image);
                $preloaded[]=$obj[$key];
            }
            $related_products=RelatedProduct::where('vendor_id',auth()->user()->vendor->id)->where('product_id',$product->id)->pluck('related_product_id');
            return response()->json(array(
                'success' => true,
                'product' => $product,
                'attr'    => $attr,
                'colors_sizes' => $colors_sizes,
                'product_image'  => $preloaded,
                'related_products' => $related_products,
            ), 200);
       }catch(\Exception $e){
            return response()->json(array(
                'success' => false,
                'error' => $e->getMessage(),),
                500);
       }

    }


    public function update(Request $request, $sku)
    {
       // return $request->all();
        $validator = Validator::make($request->all(), [
            'name'      => 'required',
            'category_id' => 'required',
            'description'  => 'required',
            'moq'         => [new MoqUnitRule($request, $request->p_type)],
            'product_unit'  =>[new MoqUnitRule($request, $request->p_type)],
            'p_type'      => 'required',
            'ready_stock_availability'  => 'required_if:p_type,2',
            'non_clothing_availability'  => 'required_if:p_type,3',
            'quantity_min.*' => 'required_if:p_type,1',
            'quantity_max.*' => 'required_if:p_type,1',
            'price.*' => 'required_if:p_type,1',
            'lead_time.*' => 'required_if:p_type,1',
            'ready_quantity_min.*' => [new ReadyStockPriceBreakDownRule($request, $request->p_type)],
            'ready_quantity_max.*' => [new ReadyStockPriceBreakDownRule($request,$request->p_type)],
            'ready_price.*' => [new ReadyStockPriceBreakDownRule($request, $request->p_type)],
            'non_clothing_min.*' => [new NonClothingPriceBreakDownRule($request, $request->p_type)],
            'non_clothing_max.*' => [new NonClothingPriceBreakDownRule($request, $request->p_type)],
            'non_clothing_price.*' => [new NonClothingPriceBreakDownRule($request, $request->p_type)],
            'full_stock_price' => [new ReadyStockFullStockRule($request, $request->p_type)],
            'non_clothing_full_stock_price' => [new NonClothingFullStockRule($request, $request->p_type)],

        ]);

        if ($validator->fails())
        {
            return response()->json(array(
            'success' => false,
            'error' => $validator->getMessageBag()->toArray()),
            400);
        }

        DB::beginTransaction();
            try {

                $full_stock_negotiable=false;
                $full_stock = false;
                $full_stock_price = null;
                $availability=null;
                if($request->p_type==1)
                {
                    $price_break_down=[];
                    for($i=0; $i < count($request->quantity_min); $i++){
                        array_push($price_break_down,[(int)$request->quantity_min[$i],(int)$request->quantity_max[$i],is_numeric($request->price[$i]) ? $request->price[$i] : 'Negotiable',$request->lead_time[$i]]);
                    }

                }

                if($request->p_type==2)
                {
                    $colors_sizes=[];
                    if(isset($request->color_size['color'])){
                        foreach($request->color_size as $key => $value)
                        {
                            foreach($value as $key2 => $value2 )
                                {   if($key=='color'){
                                        $colors_sizes[$key2][$key]=$value2;
                                    }else{
                                        $colors_sizes[$key2][$key]=(int)$value2;
                                    }

                                }
                        }
                    }
                    $price_break_down=[];
                    for($i=0; $i < count($request->ready_quantity_min); $i++){
                        array_push($price_break_down,[(int)$request->ready_quantity_min[$i],(int)$request->ready_quantity_max[$i],is_numeric($request->ready_price[$i]) ? $request->ready_price[$i] : 'Negotiable']);
                    }
                    $full_stock= isset($request->full_stock) ? true : false;
                    $full_stock_price = isset($request->full_stock_price) ? $request->full_stock_price : null;
                    $availability=$request->ready_stock_availability;
                    $full_stock_negotiable= isset($request->ready_full_stock_negotiable) ? true : false;
                }
                //non clothing item
                if($request->p_type==3)
                {
                    $colors_sizes=[];
                    if(isset($request->non_clothing_attr)){
                        foreach($request->non_clothing_attr as $key => $value)
                        {
                            foreach($value as $key2 => $value2 )
                                {
                                    if($key=='color'){
                                        $colors_sizes[$key2][$key]=$value2;
                                    }else{
                                        $colors_sizes[$key2][$key]=(int)$value2;
                                    }

                                }
                        }

                    }

                    $price_break_down=[];
                    for($i=0; $i < count($request->non_clothing_min); $i++){
                        array_push($price_break_down,[(int)$request->non_clothing_min[$i],(int)$request->non_clothing_max[$i],is_numeric($request->non_clothing_price[$i]) ? $request->non_clothing_price[$i] : 'Negotiable']);
                    }
                    $full_stock= isset($request->non_clothing_full_stock) ? true : false;
                    $full_stock_price = isset($request->non_clothing_full_stock_price) ? $request->non_clothing_full_stock_price : null;
                    $availability=$request->non_clothing_availability;
                    $full_stock_negotiable= isset($request->non_clothing_full_stock_negotiable) ? true : false;

                }

                //tiny mc text editor file upload
                $temporary_folder= public_path('storage/temp').'/'.auth()->user()->vendor->vendor_name.'/'.'pdf/';
                if (!file_exists($temporary_folder)) {
                    mkdir($temporary_folder, 0777, true);
                }
                $pdfFolder= File::files(public_path('storage/temp').'/'.auth()->user()->vendor->vendor_name.'/'.'pdf/');
                if($pdfFolder){
                    foreach($pdfFolder as $path) {
                        $file = pathinfo($path);
                        $full_path=$file['dirname'].'/'.$file['basename'];
                        $destination_folder=public_path('storage/images/').auth()->user()->vendor->vendor_name.'/'.'pdf/';
                        if (!file_exists($destination_folder)) {
                            mkdir($destination_folder, 0777, true);
                        }
                        $destination=$destination_folder.$file['basename'];
                        File::move($full_path, $destination);
                    }
                }


                Product::where('sku',$sku)->update([
                    'name'      => $request->name,
                    'product_category_id' => $request->category_id,
                    'is_featured' => $request->is_featured=='on'? 1:0,
                    'is_new_arrival' => $request->is_new_arrival=='on'? 1:0,
                    'state'   => $request->published=='on'? 1:0,
                    'description' => $request->description,
                    'additional_description' => $request->additional_description ?? null,
                    'attribute' => json_encode($price_break_down) ?? null,
                    'colors_sizes'  => isset($colors_sizes)  ?  json_encode($colors_sizes) : null,
                    'moq'         => $request->moq ?? null,
                    'product_unit'     => $request->product_unit ?? null,
                    'availability'     =>  $availability,
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->header('User-Agent'),
                    'copyright_price'  => $request->p_type==1 ? $request->copyright_price : null,
                    'full_stock'     => $full_stock,
                    'full_stock_price' =>  $full_stock_price,
                    'full_stock_negotiable' => $full_stock_negotiable,
                    'customize'      => isset($request->customize) ? true : false,
                    'updated_by'  => auth()->id(),
            ]);
            $product=Product::where('sku',$sku)->first();
            $user=User::where('id',auth()->id())->first();
            $vendorName=Str::slug($user->vendor->vendor_name,'-');
            if(isset($request->preloaded)){
                $productImages=ProductImage::where('product_id',$product->id)->whereNotIn('id',$request->preloaded)->get();
            }
            else{
                $productImages=ProductImage::where('product_id',$product->id)->get();
            }
            if($productImages->isNotEmpty()){
                foreach($productImages as $productImage){
                    if(Storage::exists('public/'.$productImage->image) && Storage::exists('public/'.$productImage->original)){
                        Storage::delete('public/'.$productImage->image);
                        Storage::delete('public/'.$productImage->original);
                    }
                    $productImage->delete();
                }
            }
            if(isset($request->images))
            {
                foreach ($request->images as $image) {
                    $filename = $image->store('images/'.$vendorName.'/products/small','public');
                    $image_resize = Image::make(public_path('storage/'.$filename));
                    $image_resize->fit(300, 300);
                    $image_resize->save(public_path('storage/'.$filename));
                    $original=$image->store('images/'.$vendorName.'/products/original','public');
                    $product_image = ProductImage::create([
                        'product_id' => $product->id,
                        'image' => $filename,
                        'original' => $original,
                    ]);
                }
            }
            //related products
            if(!isset($request->related_products))
            {
                $relatedProduct=RelatedProduct::where('vendor_id',auth()->user()->vendor->id)->where('product_id',$product->id)->get();
                if($relatedProduct){
                    foreach($relatedProduct as $rel_product)
                    {
                        $rel_product->delete();
                    }
                }
            }
            if($request->related_products)
            {
                $relatedProduct=RelatedProduct::where('vendor_id',auth()->user()->vendor->id)->where('product_id',$product->id)->get();
                if($relatedProduct){
                    foreach($relatedProduct as $rel_product)
                        {
                            $rel_product->delete();
                        }
                }
                foreach($request->related_products as $item){
                    RelatedProduct::create([
                        'vendor_id'  => auth()->user()->vendor->id,
                        'product_id' => $product->id,
                        'related_product_id' => $item,
                    ]);
                }

            }
            DB::commit();
            // all good
            return response()->json(array('success' => true, 'msg' => 'Product Updated Successfully'),200);
            }catch (\Exception $e) {
                DB::rollback();
                return response()->json(array(
                    'success' => false,
                    'error' => $e->getMessage(),),
                    500);
            }
    }

    public function destroy($sku)
    {

        try {
            $product=Product::where('sku',$sku)->first();
            $productImages=ProductImage::where('product_id',$product->id)->get();
            $relatedProduct=RelatedProduct::where('vendor_id',auth()->user()->vendor->id)->where('product_id',$product->id)->get();
            if($relatedProduct){
                foreach($relatedProduct as $product)
                    {
                        $product->delete();
                    }
            }
            $result=$product->delete();
            if($result)
            {
                if(isset($productImages))
                {
                    foreach($productImages as $productImage)
                    {
                        if(Storage::exists('public/'.$productImage->image) && Storage::exists('public/'.$productImage->original) )
                        {
                            Storage::delete('public/'.$productImage->image);
                            Storage::delete('public/'.$productImage->original);

                        }
                        $productImage->delete();
                    }
                }

                return response()->json(array('success' => true, 'msg' => 'Product Deteted Successfully'),200);
            }
        }catch (\Exception $e) {
            return response()->json(array(
                'success' => false,
                'error' => $e->getMessage(),),
                500);
        }
    }

    public function publishUnpublish($sku)
    {
      $product=Product::where('sku',$sku)->first();
      if($product->state==1){
          $product->update(['state' => 0]);
          return response()->json(array('success' => true, 'msg' => 'Product Unpublished Successfully'),200);
        }
      else{
        $product->update(['state' => 1]);
        return response()->json(array('success' => true, 'msg' => 'Product Published Successfully'),200);
      }
    }

    public function freshOrderCalculate(Request $request)
    {

        $input_value=$request->value;
        $product=Product::where('sku',$request->product_sku)->first();
        //full stock
        if($product->full_stock== 1){
            if($product->full_stock_negotiable == true){
                return response()->json(['flag'=>1,'total_price'=>"Negotiable", 'unit_price' => "Negotiable" ]);
            }
            $unit_price=$product->full_stock_price / $input_value;
            $total_price= $product->full_stock_price;
            return response()->json(['total_price'=> number_format($total_price, 2, '.', ''), 'unit_price' =>   number_format($unit_price, 2, '.', '') ]);
        }
        $attribute=json_decode($product->attribute);
        $count_list=count($attribute);

        if ($input_value < $product->moq) {
            return response()->json(['flag'=>0,'total_price' => 'You must add Mimium order quantity '.$product->moq]);
         }
        foreach($attribute as $key => $list){

            if($input_value >= $list[0] && $input_value <= $list[1]){
                if($list[2] == "Negotiable"){
                    return response()->json(['flag'=>1,'total_price'=>"Negotiable", 'unit_price' => "Negotiable" ]);
                }
                return response()->json(['total_price'=>number_format($input_value*$list[2], 2, '.', ''), 'unit_price' => $list[2] ]);
            }
            //if cross the range
            if( ++$key==$count_list){
                if($list[1] < $input_value){
                     if($list[2] == "Negotiable"){
                         return response()->json(['flag'=>1,'total_price'=>"Negotiable", 'unit_price' => "Negotiable" ]);
                     }
                  return response()->json(['total_price'=>number_format($input_value*$list[2], 2, '.', ''), 'unit_price' => $list[2] ]);
                }
             }


        }
        return response()->json(['flag'=>0,'total_price' => 'out of range']);

    }

    public function storeUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'vendor_name' => 'required|unique:vendors',
            'vendor_ownername'  => 'required',
            'vendor_address' => 'required',
            'vendor_country' => 'required',
            'vendor_type'       => 'required',
           ]);
           if ($validator->fails()) return response()->json(['code' =>401 , 'msg'=>$validator->errors()->all()]);
            try {
                Vendor::where('user_id',auth()->id())->update([
                    'vendor_name' => $request->vendor_name,
                    'vendor_ownername'  => $request->vendor_ownername,
                    'vendor_address' => $request->vendor_address,
                    'vendor_country' => $request->vendor_country,
                    'vendor_type'       => $request->vendor_type,
                    'vendor_mainproduct' => $request->vendor_mainproduct,
                    'vendor_totalemployees' => $request->vendor_totalemployees,
                    'vendor_yearest'       => $request->vendor_yearest,
                    // 'vendor_certification'       => $request->vendor_certification,
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->header('User-Agent'),

                ]);
                $vendor_info=Vendor::with('user')->where('user_id', auth()->id())->first();
               if($vendor_info->vendor_mainproduct==NULL){
                   $main_product=new stdClass;
                   $main_product->name="No product";

               }
               else{
                $main_product=Product::where('id',$vendor_info->vendor_mainproduct)->first();

               }

                return response()->json(['code' =>200, 'msg'=> $vendor_info,'success'=>'Store updated successfully', 'main_product' => $main_product]);
            } catch (\Exception $e) {
                return response()->json(['code' =>500, 'msg' => $e->getMessage()]);
            }

    }



    public function uploadSubmit(Request $request)
    {
        $user=User::where('id' , auth()->id())->first();
        $vendorName=Str::slug($user->vendor->vendor_name,'-');
        $images = [];
        foreach ($request->images as $image) {
            $filename = $image->store('images/'.$vendorName.'/products','public');
            $product_image = ProductImage::create([
                'image' => $filename
            ]);
            $image_object = new \stdClass();
            $image_object->name = $image->getClientOriginalName();
            $image_object->size = round(Storage::size('public/'.$filename) / 1024, 2);
            $image_object->fileID = $product_image->id;
            $images[] = $image_object;
        }
        return response()->json(array('files' => $images), 200);
    }

public function deleteSingleImage(Request $request)
    {
        $productImage=ProductImage::find($request->id);
        if(Storage::exists('public/'.$productImage->image)){
            Storage::delete('public/'.$productImage->image);
        }
        $productImage->delete();
        return response()->json([
            'success' => 'Image Deleted successfully!'
        ]);
    }

    public function makeParentChildRelations(&$inArray, &$outArray, $currentParentId = 0)
    {
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

    // tinymc file upload

    public function tinyMcFileUpload(Request $request)
    {
       if($request->hasFile('tiny_mc_file')){
           $vendorName=auth()->user()->vendor->vendor_name;
           $filename=$request->tiny_mc_file->store('temp/'.$vendorName.'/pdf','public');
           $basename=basename($filename);
           $finalPath=asset('storage/images/'.$vendorName.'/pdf'.'/'.$basename);
           $originalFileName=$request->file('tiny_mc_file')->getClientOriginalName();
           return response()->json(['fileName' => $finalPath, 'originalFileName' => $originalFileName], 200);

       }
    }

    //tinymc untracked file deleted
    public function tinyMcUntrackedFileDelete()
    {
        $pdfFolder= File::files(public_path('storage/temp').'/'.auth()->user()->vendor->vendor_name.'/'.'pdf/');
        if($pdfFolder){
            foreach($pdfFolder as $file){
                $path_info=pathinfo($file);
                $file_path='public/temp/'.auth()->user()->vendor->vendor_name.'/'.'pdf/'.$path_info['basename'];
                Storage::delete($file_path);
            }
            return response()->json(['msg' => 'success'], 200);
        }
        return response()->json(['msg' => 'not exists'], 200);

    }



}
