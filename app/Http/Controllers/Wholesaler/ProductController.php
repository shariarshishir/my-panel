<?php

namespace App\Http\Controllers\Wholesaler;

use App\Http\Controllers\Controller;
use App\Models\BusinessProfile;
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
use App\Models\ProductTypeMapping;
use App\Models\ProductVideo;
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

class ProductController extends Controller
{
    public function index(Request $request, $alias)
   {

        $business_profile=BusinessProfile::withTrashed()->where('alias', $alias)->first();
        if((auth()->id() == $business_profile->user_id) || (auth()->id() == $business_profile->representative_user_id))
        {
            if ($request->ajax())
            {
                $data =Product::withTrashed()->latest()->where('business_profile_id',$business_profile->id)->with('images');
                return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('image',function($row){
                        if($row->images->isEmpty()){return '';}
                            $source=Storage::disk('s3')->url('public/'.$row->images[0]->image);
                            if($row->availability==0 && ($row->product_type == 2 || $row->product_type == 3)){
                                return $image='<span class="new badge red" data-badge-caption="sold"></span><img src="'.$source.'" class="responsive-img" alt="" width="150" height="80"/> ';
                            }
                            return $image='<img src="'.$source.'" class="responsive-img" alt="" width="150" height="80"/>';

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
                        if (!empty($request->get('search'))) {
                            $instance->where('name', 'like', "%{$request->get('search')}%");
                        }

                    })
                    ->rawColumns(['action','image'])
                    ->make(true);
            }

            return view('wholesaler_profile.products.index', compact('business_profile'));
        }

        abort(401);

   }

   public function store(Request $request)
   {
 //dd($request->all());
        $validator = Validator::make($request->all(), [
            'business_profile_id' => 'required',
            //'images'  => 'required',
            //'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg,JPEG,PNG,JPG,GIF,SVG|max:25600',
            'overlay_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,JPEG,PNG,JPG,GIF,SVG|max:25600',
            'name'      => 'required',
            'product_tag' => 'required',
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
            'video' => 'mimes:mp4,3gp,mkv,mov|max:150000',
            'gender' => 'required',
            'sample_availability' => 'required',
            'product_type_mapping' => 'required',
            'studio_id'         => 'required_if:product_type_mapping,1',
            'raw_materials_id'  => 'required_if:product_type_mapping,2',
        ],[
            'non_clothing_availability.required_if' => 'The  availability field is required when product type is Non Clothing.',
            'ready_stock_availability.required_if' => 'The  availability field is required when product type is Ready Stock.',
            'quantity_min.*.required_if' => 'the :attribute are required',
            'quantity_max.*.required_if' => 'the :attribute are required',
            'price.*.required_if' => 'the :attribute are required',
            'lead_time.*.required_if' => 'the :attribute are required',
            'studio_id.required_if' => 'the studio type is required when studio selected',
            'raw_materials_id.required_if' => 'the raw materials type is required when raw materials selected',
        ]);



        if ($validator->fails())
        {
            return response()->json(array(
            'success' => false,
            'error' => $validator->getMessageBag()),
            400);
        }


        DB::beginTransaction();


        try {

            $productArray =[];
            if(isset($request->productImg['product_add_image'])) {
                for($i=0; $i < count($request->productImg['product_add_image']); $i++){
                    array_push($productArray, [$request->productImg['product_add_image'][$i], $request->productImg['product_image_label'][$i],$request->productImg['product_image_is_accessories'][$i]]);
                }
            }

            // dd($request->productImg['product_image_label'][0]);

            $date=Carbon::now()->timestamp;
            $number=mt_rand(0,9999);
            $pattern= '/[^A-Za-z0-9\-]/';
            $FileName= preg_replace($pattern, '', $request->name);
            $name= explode(' ',strtolower($FileName));
            $sku=$name[0].$date.$number;

            $full_stock_negotiable=false;
            $full_stock = false;
            $full_stock_price = null;
            $availability=null;
            if($request->product_type==1){
                $price_break_down=[];
                for($i=0; $i < count($request->quantity_min); $i++){
                    array_push($price_break_down,[(int)$request->quantity_min[$i],(int)$request->quantity_max[$i],is_numeric($request->price[$i]) ? $request->price[$i] : 'Negotiable',$request->lead_time[$i]]);
                }
            }

            if($request->product_type==2){
                $colors_sizes=[];
                if(isset($request->color_size['color'])){
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
                $availability = $request->ready_stock_availability;
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

            $business_profile=BusinessProfile::withTrashed()->where('id', $request->business_profile_id)->first();
            $business_profile_name=$business_profile->business_name;
            //tiny mc text editor file upload

            $files = Storage::disk('s3')->allFiles('/public/temp/'.$business_profile_name.'/pdf/');

            if($files){
                foreach($files as $path) {
                    $pdfFile = Storage::disk('s3')->get($path);
                    $file = pathinfo($path);
                    $s3TinymceFullFilePath = 'public/images/'.$business_profile_name.'/pdf'.'/'.$file['basename'];
                    Storage::disk('s3')->put($s3TinymceFullFilePath, $pdfFile);
                }
            }
            //overlay image
            if($request->overlay_image){

                $image = $request->file('overlay_image');
                $s3 = \Storage::disk('s3');
                $uniqueStringForOverlaySmallImage = generateUniqueString();
                $small_overlay_image_file_unique_name = uniqid().$uniqueStringForOverlaySmallImage.'.'. $image->getClientOriginalExtension();
                $small_overlay_image_file_unique_name_with_database_path = 'images/'.$business_profile_name.'/products/overlay_small/'.$small_overlay_image_file_unique_name;
                $s3SmallOverLayImageFilePath = '/public/'.$small_overlay_image_file_unique_name_with_database_path;
                $s3->put($s3SmallOverLayImageFilePath, file_get_contents($image));

                $uniqueStringForOverlayOriginalImage = generateUniqueString();
                $original_overlay_image_file_unique_name = uniqid().$uniqueStringForOverlayOriginalImage.'.'. $image->getClientOriginalExtension();
                $original_overlay_image_file_unique_name_with_database_path = 'images/'.$business_profile_name.'/products/overlay_original/'.$original_overlay_image_file_unique_name;
                $s3OriginalImageFilePath = '/public/'.$original_overlay_image_file_unique_name_with_database_path;
                $s3->put($s3OriginalImageFilePath, file_get_contents($image));
            }


            $product=Product::create([
                'business_profile_id' => $business_profile->id,
                'name'      => $request->name,
                'sku'       => $sku,
                'product_tag' => $request->product_tag,
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
                'gender'     => $request->gender,
                'sample_availability' =>$request->sample_availability,
                'free_to_show' =>$request->free_to_show,
                'overlay_small_image' => $small_overlay_image_file_unique_name_with_database_path ?? null,
                'overlay_original_image' => $original_overlay_image_file_unique_name_with_database_path ?? null,
                'created_by'  => auth()->id(),
                'product_type_mapping_id' => $request->product_type_mapping,
                'product_type_mapping_child_id' => $request->product_type_mapping == 1 ? $request->studio_id : $request->raw_materials_id,

           ]);


           if(isset($productArray)) {
            foreach ($productArray as $image) {
                $s3 = \Storage::disk('s3');
                $uniqueStringForSmallImage = generateUniqueString();
                $small_image_file_unique_name = uniqid().$uniqueStringForSmallImage.'.'.$image[0]->getClientOriginalExtension();
                $small_image_file_unique_name_with_database_path = 'images/'.$business_profile_name.'/products/small/'.$small_image_file_unique_name;
                $small_image = Image::make($image[0])->fit(300,300);
                $s3SmallImageFilePath = '/public/'.$small_image_file_unique_name_with_database_path;
                $s3->put($s3SmallImageFilePath, file_get_contents($image[0]));

                $uniqueStringForSmallImage = generateUniqueString();
                $original_image_file_unique_name = uniqid().$uniqueStringForSmallImage.'.'. $image[0]->getClientOriginalExtension();
                $original_image_file_unique_name_with_database_path = 'images/'.$business_profile_name.'/products/original/'.$original_image_file_unique_name;
                $s3OriginalImageFilePath = '/public/images/'.$business_profile_name.'/products/original/'.$original_image_file_unique_name;
                $s3->put($s3OriginalImageFilePath, file_get_contents($image[0]));

                if($image[2] == "yes") {
                    $is_raw_material = 1;
                } else {
                    $is_raw_material = 0;
                }
                $product_image = ProductImage::create([
                    'product_id' => $product->id,
                    'image_label' => $image[1],
                    'is_raw_materials' => $is_raw_material,
                    'image' => $small_image_file_unique_name_with_database_path,
                    'original' => $original_image_file_unique_name_with_database_path,
                ]);
            }
           }
            // foreach ($request->images as $image) {
            //     $s3 = \Storage::disk('s3');
            //     $uniqueStringForSmallImage = generateUniqueString();
            //     $small_image_file_unique_name = uniqid().$uniqueStringForSmallImage.'.'.$image->getClientOriginalExtension();
            //     $small_image_file_unique_name_with_database_path = 'images/'.$business_profile_name.'/products/small/'.$small_image_file_unique_name;
            //     $small_image = Image::make($image)->fit(300,300);
            //     $s3SmallImageFilePath = '/public/'.$small_image_file_unique_name_with_database_path;
            //     $s3->put($s3SmallImageFilePath, file_get_contents($image));

            //     $uniqueStringForSmallImage = generateUniqueString();
            //     $original_image_file_unique_name = uniqid().$uniqueStringForSmallImage.'.'. $image->getClientOriginalExtension();
            //     $original_image_file_unique_name_with_database_path = 'images/'.$business_profile_name.'/products/original/'.$original_image_file_unique_name;
            //     $s3OriginalImageFilePath = '/public/images/'.$business_profile_name.'/products/original/'.$original_image_file_unique_name;
            //     $s3->put($s3OriginalImageFilePath, file_get_contents($image));

            //     $product_image = ProductImage::create([
            //         'product_id' => $product->id,
            //         'image' => $small_image_file_unique_name_with_database_path,
            //         'original' => $original_image_file_unique_name_with_database_path,
            //     ]);
            // }

            //related products
            if($request->related_products)
            {
                foreach($request->related_products as $item){
                    RelatedProduct::create([
                        'business_profile_id'  => $business_profile->id,
                        'product_id' => $product->id,
                        'related_product_id' => $item,
                    ]);
                }

            }

            //upload video
            if($request->hasFile('video')){
                $uniqueStringForSmallImage = generateUniqueString();
                $original_image_file_unique_name = uniqid().$uniqueStringForSmallImage.'.'. $request->video->getClientOriginalExtension();
                $s3FilePath='public/video/'.$business_profile_name.'/'.$original_image_file_unique_name;
                $filePathForDB = 'video/'.$business_profile_name.'/'.$original_image_file_unique_name;
                Storage::disk('s3')->put($s3FilePath, file_get_contents($request->video));
                $product_video = ProductVideo::create([
                    'product_id' => $product->id,
                    'video' => $filePathForDB,
                ]);
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
            $product = Product::withTrashed()->with('video', 'images')->where('sku',$sku)->first();
            //dd($product);
            $colors_sizes=json_decode($product->colors_sizes);
            $attr=json_decode($product->attribute);
            $preloaded=array();
            foreach($product->images as $key=>$image){
                $obj[$key] = new stdClass;
                $obj[$key]->id = $image->id;
                $obj[$key]->src = Storage::disk('s3')->url('public/'.$image->image);
                $preloaded[]=$obj[$key];
            }
            $related_products=RelatedProduct::withTrashed()->where('business_profile_id',$product->business_profile_id)->where('product_id',$product->id)->pluck('related_product_id');
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

        $validator = Validator::make($request->all(), [
            'name'      => 'required',
            'product_tag' => 'required',
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
            'overlay_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,JPEG,PNG,JPG,GIF,SVG|max:25600',
            'video' => 'mimes:mp4,3gp,mkv,mov|max:150000',
            'gender' => 'required',
            'sample_availability' => 'required',
            'product_type_mapping' => 'required',
            'studio_id'         => 'required_if:product_type_mapping,1',
            'raw_materials_id'  => 'required_if:product_type_mapping,2',

        ],[
            'non_clothing_availability.required_if' => 'The  availability field is required when product type is Non Clothing.',
            'ready_stock_availability.required_if' => 'The  availability field is required when product type is Ready Stock.',
            'quantity_min.*.required_if' => 'the :attribute are required',
            'quantity_max.*.required_if' => 'the :attribute are required',
            'price.*.required_if' => 'the :attribute are required',
            'lead_time.*.required_if' => 'the :attribute are required',
            'studio_id.required_if' => 'the studio type is required when studio selected',
            'raw_materials_id.required_if' => 'the raw materials type is required when raw materials selected',

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

            // dd($request->all());


            $productArray =[];
            if(isset($request->productImg['product_image_label'])) {
                for($i=0; $i < count($request->productImg['product_image_label']); $i++){
                    // if(isset($request->productImg['product_add_image'][$i])){
                        array_push($productArray, [isset($request->productImg['product_add_image'][$i])?$request->productImg['product_add_image'][$i]:null, $request->productImg['product_image_label'][$i],$request->productImg['product_image_is_accessories'][$i],$request->productImg['product_image_id'][$i]]);
                    // }

                }
            }


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
                // dd($sku);
                $product = Product::withTrashed()->where('sku',$sku)->first();
                $business_profile=BusinessProfile::withTrashed()->where('id', $product->business_profile_id)->first();
                $business_profile_name=$business_profile->business_name;

                //overlay image
                if($request->overlay_image){

                    if($product->overlay_original_image){
                        if(Storage::disk('s3')->exists('public/'.$product->overlay_original_image) ){
                            Storage::disk('s3')->delete('public/'.$product->overlay_original_image);
                            Storage::disk('s3')->delete('public/'.$product->overlay_small_image);
                        }
                    }

                    $image = $request->file('overlay_image');
                    $s3 = \Storage::disk('s3');
                    $uniqueStringForOverlaySmallImage = generateUniqueString();
                    $small_overlay_image_file_unique_name = uniqid().$uniqueStringForOverlaySmallImage.'.'. $image->getClientOriginalExtension();
                    $small_overlay_image_file_unique_name_with_database_path = 'images/'.$business_profile_name.'/products/overlay_small/'.$small_overlay_image_file_unique_name;
                    $s3SmallOverLayImageFilePath = '/public/'.$small_overlay_image_file_unique_name_with_database_path;
                    $s3->put($s3SmallOverLayImageFilePath, file_get_contents($image));

                    $uniqueStringForOverlayOriginalImage = generateUniqueString();
                    $original_overlay_image_file_unique_name = uniqid().$uniqueStringForOverlayOriginalImage.'.'. $image->getClientOriginalExtension();
                    $original_overlay_image_file_unique_name_with_database_path = 'images/'.$business_profile_name.'/products/overlay_original/'.$original_overlay_image_file_unique_name;
                    $s3OriginalImageFilePath = '/public/'.$original_overlay_image_file_unique_name_with_database_path;
                    $s3->put($s3OriginalImageFilePath, file_get_contents($image));
                }

                Product::withTrashed()->where('sku',$sku)->update([
                    'name'      => $request->name,
                    'product_tag' => $request->product_tag,
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

                    // 'overlay_small_image' => $filename ?? $product->overlay_original_image,
                    // 'overlay_original_image' => $original ?? $product->overlay_small_image,

                    'overlay_small_image' => $small_overlay_image_file_unique_name_with_database_path ?? $product->overlay_original_image,
                    'overlay_original_image' => $original_overlay_image_file_unique_name_with_database_path ?? $product->overlay_small_image,

                    'updated_by'  => auth()->id(),
                    'gender'     => $request->gender,
                    'sample_availability' =>$request->sample_availability,
                    'free_to_show' =>$request->free_to_show,
                    'product_type_mapping_id' => $request->product_type_mapping,
                    'product_type_mapping_child_id' => $request->product_type_mapping == 1 ? $request->studio_id : $request->raw_materials_id,
            ]);
            $product=Product::withTrashed()->where('sku',$sku)->first();

             //tiny mc text editor file upload
            $files = Storage::disk('s3')->allFiles('/public/temp/'.$business_profile_name.'/pdf/');

            if($files){
                foreach($files as $path) {
                    $pdfFile = Storage::disk('s3')->get($path);
                    $file = pathinfo($path);
                    $s3TinymceFullFilePath = 'public/images/'.$business_profile_name.'/pdf'.'/'.$file['basename'];
                    Storage::disk('s3')->put($s3TinymceFullFilePath, $pdfFile);
                }
            }


            // if(isset($request->preloaded)){
            //     $productImages=ProductImage::where('product_id',$product->id)->whereNotIn('id',$request->preloaded)->get();
            // }
            // else{
            //     $productImages=ProductImage::where('product_id',$product->id)->get();
            // }
            // if($productImages->isNotEmpty()){
            //     foreach($productImages as $productImage){
            //         if(Storage::disk('s3')->exists('public/'.$productImage->image) && Storage::disk('s3')->exists('public/'.$productImage->original)){
            //             Storage::disk('s3')->delete('public/'.$productImage->image);
            //             Storage::disk('s3')->delete('public/'.$productImage->original);
            //         }
            //         $productImage->delete();
            //     }
            // }
            // dd($productArray);
            // new image upload code will be here start.

            $product_image_ids = [];
            $product_image_db_ids = [];
            if(isset($productArray))
            {
                foreach ($productArray as $image) {
                    if($image[3] != null){
                        array_push($product_image_ids,(int)$image[3]);
                    }
                }
                $productImages=ProductImage::where('product_id',$product->id)->get();
                if($productImages->isNotEmpty()){
                    foreach($productImages as $productImage){
                        array_push($product_image_db_ids,(int)$productImage->id);
                    }
                }
            }
            // here here
            foreach($product_image_db_ids as $id){
                if(!in_array($id,$product_image_ids)){
                    ProductImage::where('id',$id)->delete();
                }
            }
            if(isset($productArray))
            {

            foreach ($productArray as $image) {
                $small_image_file_unique_name_with_database_path = null;
                $original_image_file_unique_name_with_database_path = null;

                if(isset($image[0]) && $image[0] != null){
                    $s3 = \Storage::disk('s3');
                    $uniqueStringForSmallImage = generateUniqueString();
                    $small_image_file_unique_name = uniqid().$uniqueStringForSmallImage.'.'.$image[0]->getClientOriginalExtension();
                    $small_image_file_unique_name_with_database_path = 'images/'.$business_profile_name.'/products/small/'.$small_image_file_unique_name;
                    $small_image = Image::make($image[0])->fit(300,300);
                    $s3SmallImageFilePath = '/public/'.$small_image_file_unique_name_with_database_path;
                    $s3->put($s3SmallImageFilePath, file_get_contents($image[0]));

                    $uniqueStringForSmallImage = generateUniqueString();
                    $original_image_file_unique_name = uniqid().$uniqueStringForSmallImage.'.'. $image[0]->getClientOriginalExtension();
                    $original_image_file_unique_name_with_database_path = 'images/'.$business_profile_name.'/products/original/'.$original_image_file_unique_name;
                    $s3OriginalImageFilePath = '/public/images/'.$business_profile_name.'/products/original/'.$original_image_file_unique_name;
                    $s3->put($s3OriginalImageFilePath, file_get_contents($image[0]));
                }

                // dd($small_image_file_unique_name_with_database_path,$original_image_file_unique_name_with_database_path);
                if($image[2] == "yes") {
                    $is_raw_material = 1;
                } else {
                    $is_raw_material = 0;
                }

                if($image[3] == null){
                    // dd($original_image_file_unique_name_with_database_path!=null);
                    if(isset($small_image_file_unique_name_with_database_path)
                    && $small_image_file_unique_name_with_database_path!=null
                    && isset($original_image_file_unique_name_with_database_path)
                    && $original_image_file_unique_name_with_database_path!=null
                    ){

                        $product_image = ProductImage::create([
                        'product_id' => $product->id,
                        'image_label' => $image[1],
                        'is_raw_materials' => $is_raw_material,
                        'image' => $small_image_file_unique_name_with_database_path,
                        'original' => $original_image_file_unique_name_with_database_path,
                        ]);
                    }
                } else {
                    $data = [];
                    $data['product_id'] = $product->id;
                    $data['image_label'] = $image[1];
                    $data['is_raw_materials'] = $is_raw_material;
                    if(isset($small_image_file_unique_name_with_database_path) && $small_image_file_unique_name_with_database_path!=null){
                        $data['image'] = $small_image_file_unique_name_with_database_path;
                    }
                    if(isset($original_image_file_unique_name_with_database_path) && $original_image_file_unique_name_with_database_path!=null){
                        $data['original'] = $original_image_file_unique_name_with_database_path;
                    }

                    ProductImage::where('id',$image[3])->update($data);
                }
            }
 
            // [1,2,3,4] [1,3,4] = [2]
            
            // dd($product_image_db_ids, $product_image_ids, $ids_to_delete);//db array
            // dd($product_image_ids);//frontend array
                // foreach ($request->images as $image) {
                //     $s3 = \Storage::disk('s3');
                //     $uniqueStringForSmallImage = generateUniqueString();
                //     $small_image_file_unique_name = uniqid().$uniqueStringForSmallImage.'.'.$image->getClientOriginalExtension();
                //     $small_image_file_unique_name_with_database_path = 'images/'.$business_profile_name.'/products/small/'.$small_image_file_unique_name;
                //     $s3SmallImageFilePath = 'public/'.$small_image_file_unique_name_with_database_path;
                //     $s3->put($s3SmallImageFilePath, file_get_contents($image));

                //     $uniqueStringForSmallImage = generateUniqueString();
                //     $original_image_file_unique_name = uniqid().$uniqueStringForSmallImage.'.'. $image->getClientOriginalExtension();
                //     $original_image_file_unique_name_with_database_path = 'images/'.$business_profile_name.'/products/original/'.$original_image_file_unique_name;
                //     $s3OriginalImageFilePath = 'public/'.$original_image_file_unique_name_with_database_path;
                //     $s3->put($s3OriginalImageFilePath, file_get_contents($image));

                //     $product_image = ProductImage::create([
                //         'product_id' => $product->id,
                //         'image' => $small_image_file_unique_name_with_database_path,
                //         'original' => $original_image_file_unique_name_with_database_path,
                //     ]);
                // }
            }
            // new image upload code will be here end.


            //video
            if(isset($request->remove_video_id)){
               if( count(json_decode($request->remove_video_id)) > 0 )
               {
                    $productVideo=ProductVideo::where('id',json_decode($request->remove_video_id))->first();
                    if($productVideo){
                        if(Storage::disk('s3')->exists('public/'.$productVideo->video)){
                            Storage::disk('s3')->delete('public/'.$productVideo->video);
                        }
                        $productVideo->delete();
                    }
               }
            }

            //upload video
            if($request->hasFile('video')){
                $uniqueStringForSmallImage = generateUniqueString();
                $original_image_file_unique_name = uniqid().$uniqueStringForSmallImage.'.'. $request->video->getClientOriginalExtension();
                $s3FilePath='public/video/'.$business_profile_name.'/'.$original_image_file_unique_name;
                $filePathForDB = 'video/'.$business_profile_name.'/'.$original_image_file_unique_name;
                Storage::disk('s3')->put($s3FilePath, file_get_contents($request->video));
                $product_video = ProductVideo::create([
                    'product_id' => $product->id,
                    'video' => $filePathForDB,
                ]);
            }

            //related products
            if(!isset($request->related_products))
            {
                $relatedProduct=RelatedProduct::withTrashed()->where('business_profile_id',$product->business_profile_id)->where('product_id',$product->id)->get();
                if($relatedProduct){
                    foreach($relatedProduct as $rel_product)
                    {
                        $rel_product->delete();
                    }
                }
            }
            if($request->related_products)
            {
                $relatedProduct=RelatedProduct::withTrashed()->where('business_profile_id',$product->business_profile_id)->where('product_id',$product->id)->get();
                if($relatedProduct){
                    foreach($relatedProduct as $rel_product)
                        {
                            $rel_product->delete();
                        }
                }
                foreach($request->related_products as $item){
                    RelatedProduct::create([
                        'business_profile_id' => $product->business_profile_id,
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

    public function publishUnpublish($sku)
    {
      $product=Product::withTrashed()->where('sku',$sku)->first();
      if($product->state==1){
          $product->update(['state' => 0]);
          return response()->json(array('success' => true, 'msg' => 'Product Unpublished Successfully'),200);
        }
      else{
        $product->update(['state' => 1]);
        return response()->json(array('success' => true, 'msg' => 'Product Published Successfully'),200);
      }
    }

    public function removeOverlayImage($id)
    {
        $product=Product::where('id',$id)->first();
        if(!$product){
            return response()->json(['msg' => 'product not found'], 404);
        }
        if(Storage::disk('s3')->exists('public/'.$product->overlay_small_image) && Storage::disk('s3')->exists('public/'.$product->overlay_original_image)){
            Storage::disk('s3')->delete('public/'.$product->overlay_small_image);
            Storage::disk('s3')->delete('public/'.$product->overlay_original_image);
            $product->update(['overlay_original_image' => null, 'overlay_small_image' => null]);
            return response()->json(['msg' => 'overlay image removed'], 200);
        }
        return response()->json(['msg' => 'folder not exists'], 500);
    }

    public function removeFeaturedVideo($id)
    {
        $productVideo = ProductVideo::where('product_id',$id)->first();
        //return $productVideo->video;
        if(!$productVideo){
            return response()->json(['msg' => 'product video not found'], 404);
        }
        if(Storage::disk('s3')->exists('public/'.$productVideo->video) && Storage::disk('s3')->exists('public/'.$productVideo->video)){
            Storage::disk('s3')->delete('public/'.$productVideo->video);
            $productVideo->delete();
            return response()->json(['msg' => 'Featured Video removed'], 200);
        }
        return response()->json(['msg' => 'folder not exists'], 500);
    }

}
