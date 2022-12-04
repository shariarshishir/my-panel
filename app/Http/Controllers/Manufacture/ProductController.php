<?php

namespace App\Http\Controllers\Manufacture;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Manufacture\Product;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Models\Manufacture\ProductImage;
use Illuminate\Support\Facades\Validator;
use DB;
use stdClass;
use App\Models\BusinessProfile;
use App\Models\Manufacture\ProductVideo;

class ProductController extends Controller
{
     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'product_tag' => 'required',
            'business_profile_id' => 'required',
            'title'=>'required',
            //'price_per_unit'=>'required|numeric',
            'moq'=>'required|numeric',
            'product_details'=>'required',
            'product_specification'=>'nullable',
            'lead_time'=>'required',
            'industry' => 'required',
            'video' => 'mimes:mp4,3gp,mkv,mov|max:150000',
            'price_unit' => 'required',
            'qty_unit'   => 'required',
            // 'colors'  => 'required',
            // 'sizes'  => 'required',
            // 'product_images' =>'required',
            // 'product_images.*' =>'image|mimes:jpeg,png,jpg,gif,svg,JPEG,PNG,JPG,GIF,SVG|max:25600',

            // 'images'  => 'required',
            // 'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg,JPEG,PNG,JPG,GIF,SVG|max:25600',

            'overlay_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,JPEG,PNG,JPG,GIF,SVG|max:25600',
            'price_per_unit'=> 'required',
            'gender' => 'required',
            'sample_availability' => 'required',
            'product_type_mapping' => 'required',
            'studio_id'         => 'required_if:product_type_mapping,1',
            'raw_materials_id'  => 'required_if:product_type_mapping,2',
        ],[
            'price_per_unit.required' => 'The price range field is required.',
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

        try{

            //dd($request->all());

            $productArray =[];
            if(isset($request->productImg['product_add_image'])) {
                for($i=0; $i < count($request->productImg['product_add_image']); $i++){
                    array_push($productArray, [$request->productImg['product_add_image'][$i], $request->productImg['product_image_label'][$i],$request->productImg['product_image_is_accessories'][$i]]);
                }
            }



            $path=null;
            if ($request->hasFile('overlay_image')){
                $image = $request->file('overlay_image');
                $s3 = \Storage::disk('s3');
                $uniqueString = generateUniqueString();
                $overlay_image_file_name = 'images/'.uniqid().$uniqueString.'.'. $image->getClientOriginalExtension();
                $s3filePath = '/public'.'/'.$overlay_image_file_name;
                $s3->put($s3filePath, file_get_contents($image));
            }

            // Mostafiz
            $business_profile=BusinessProfile::withTrashed()->where('id', $request->business_profile_id)->first();
            $business_profile_name=$business_profile->business_name;


            $colorExp = [];
            if(isset($request->colors)) {
                $colorImp = implode($request->colors);
                $colorExp = explode(",", $colorImp);
            }

            $Data=[
                'business_profile_id' => $request->business_profile_id,
                'product_tag' => $request->product_tag,
                'title'=> $request->title,
                'product_code'=> $request->product_code,
                'moq'=> $request->moq,
                'product_details'=>$request->product_details,
                'product_specification'=>$request->product_specification,
                'lead_time'=>$request->lead_time,
                'colors'=>$colorExp?? [],
                'sizes'=>$request->sizes?? [],
                'industry' => $request->industry== 'apparel' ? 'apparel' : 'non-apparel',
                'price_per_unit' => $request->price_per_unit,
                'price_unit'   => $request->price_unit,
                'qty_unit'    =>$request->qty_unit,
                'created_by' => auth()->id(),
                'gender'     => $request->gender,
                'sample_availability' =>$request->sample_availability,
                'free_to_show' =>$request->free_to_show,
                'overlay_image' => $overlay_image_file_name ?? NULL,
                'product_type_mapping_id' => $request->product_type_mapping,
                'product_type_mapping_child_id' => $request->product_type_mapping == 1 ? $request->studio_id : $request->raw_materials_id,

            ];


            $product=Product::create($Data);

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
                        'product_image' => $small_image_file_unique_name_with_database_path,
                        // 'original' => $original_image_file_unique_name_with_database_path,
                    ]);
                }
            }



            // if ($request->hasFile('product_images')){
            //     foreach ($request->file('product_images') as $index=>$product_image){
            //         $image = $product_image;
            //         $s3 = \Storage::disk('s3');
            //         $uniqueString = generateUniqueString();
            //         $product_images_file_name ='images/'.uniqid().$uniqueString.'.'. $image->getClientOriginalExtension();
            //         $s3filePath = '/public'.'/'. $product_images_file_name;
            //         $s3->put($s3filePath, file_get_contents($image));
            //         ProductImage::create(['product_id'=>$product->id, 'product_image'=>$product_images_file_name]);
            //     }
            // }

            // Mostafiz
            // foreach ($request->images as $image) {
            //     $s3 = \Storage::disk('s3');
            //     $uniqueString = generateUniqueString();
            //     $product_images_file_name ='images/'.uniqid().$uniqueString.'.'. $image->getClientOriginalExtension();
            //     $s3filePath = '/public'.'/'. $product_images_file_name;
            //     $s3->put($s3filePath, file_get_contents($image));
            //     ProductImage::create(['product_id'=>$product->id, 'product_image'=>$product_images_file_name]);
            // }

            //upload video

            if($request->hasFile('video')){
                $business_profile=BusinessProfile::where('id', $request->business_profile_id)->first();
                $business_profile_name=$business_profile->business_name;

                $video = $request->file('video');
                $s3 = \Storage::disk('s3');
                $uniqueString = generateUniqueString();
                $video_file_name_in_db = 'video/'.$business_profile_name.'/'.uniqid().$uniqueString.'.'. $video->getClientOriginalExtension();
                $s3filePath = '/public/'. $video_file_name_in_db;
                $s3->put($s3filePath, file_get_contents($video));
                $product_video = ProductVideo::create([
                    'product_id' => $product->id,
                    'video' => $video_file_name_in_db,
                ]);

            }


            DB::commit();
            // $products=Product::where('business_profile_id',$product->business_profile_id)->latest()->with(['product_images','category'])->get();
            // $data=view('business_profile._product_table_data', compact('products'))->render();
            $data=$product;

            // Mostafiz
            $image= $product->product_images[0]->product_image;
            $source=Storage::disk('s3')->url('public/'. $image);
            return response()->json([
                'success' => true,
                'msg' => 'Profile Created Successfully',
                'data' => $data,
                'image' => $source,
            ],200);


        }catch(\Exception $e){
            DB::rollback();
            return response()->json([
                'success' => false,
                //'error'   => ['msg' => 'Something Went Worng'],
                'error'   => ['msg' => $e->getMessage().$e->getLine()],
            ],500);

        }
    }


//get business type by industy type
public function edit($product_id)
{
    $product = Product::withTrashed()->where('id', $product_id)->with('product_images','product_video')->first();
//dd($product->product_images);
    $preloaded=array();
    foreach($product->product_images as $key=>$image){
        $obj[$key] = new stdClass;
        $obj[$key]->id = $image->id;
        $obj[$key]->src = Storage::disk('s3')->url('public/'.$image->product_image);
        $preloaded[] = $obj[$key];
    }

    if(!$product){
        return response()->json([
            'success' => false,
            'error'   => 'Product Not Found',
        ],401);
    }
    // $colors=['Red','Blue','Green','Black','Brown','Pink','Yellow','Orange','Lightblue','Multicolor'];
    // $sizes=['S','M','L','XL','XXL','XXXL'];
    // $data=view('business_profile._edit_modal_data',compact('product','colors','sizes'))->render();
    return response()->json([
        'success' => true,
        'product_images'  => $preloaded,
        'product'    => $product,
    ],200);
}

public function update(Request $request, $product_id)
{
    $validator = Validator::make($request->all(), [
        'product_tag' => 'required',
        'business_profile_id' => 'required',
        'title'=>'required',
        'price_per_unit'=>'required',
        'price_unit' => 'required',
        'moq'=>'required|numeric',
        'qty_unit'   => 'required',
        'overlay_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,JPEG,PNG,JPG,GIF,SVG|max:25600',
        // 'colors'  => 'required',
        // 'sizes'  => 'required',
        'product_details'=>'required',
        'product_specification'=>'nullable',
        'lead_time'=>'required',
        'video' => 'mimes:mp4,3gp,mkv,mov|max:150000',
        'gender' => 'required',
        'sample_availability' => 'required',
        'product_type_mapping' => 'required',
        'studio_id'         => 'required_if:product_type_mapping,1',
        'raw_materials_id'  => 'required_if:product_type_mapping,2',
    ],[
        'price_per_unit.required' => 'The price range field is required.',
        'studio_id.required_if' => 'the studio type is required when studio selected',
        'raw_materials_id.required_if' => 'the raw materials type is required when raw materials selected',
    ]);

    // dd($request->all());

    //Image Update
    $productArray =[];
    if(isset($request->productImg['product_image_label'])) {
        for($i=0; $i < count($request->productImg['product_image_label']); $i++){
            // if(isset($request->productImg['product_add_image'][$i])){
                array_push($productArray, [isset($request->productImg['product_add_image'][$i])?$request->productImg['product_add_image'][$i]:null, $request->productImg['product_image_label'][$i],$request->productImg['product_image_is_accessories'][$i],$request->productImg['product_image_id'][$i]]);
            // }
        }
    }

    // Mostafiz
    $business_profile=BusinessProfile::withTrashed()->where('id', $request->business_profile_id)->first();
    $business_profile_name=$business_profile->business_name;

    if ($validator->fails())
    {
        return response()->json(array(
        'success' => false,
        'error' => $validator->getMessageBag()),
        400);
    }
    $product=Product::withTrashed()->with('product_images')->find($product_id);
    if ($request->hasFile('overlay_image')){

        if($product->overlay_image){
            if(Storage::disk('s3')->exists('public/'.$product->overlay_image) ){
                Storage::disk('s3')->delete('public/'.$product->overlay_image);
            }
        }
        $image = $request->file('overlay_image');
        $s3 = \Storage::disk('s3');
        $uniqueString = generateUniqueString();
        $overlay_image_file_name = 'images/'.uniqid().$uniqueString.'.'. $image->getClientOriginalExtension();
        $s3filePath = '/public'.'/'.$overlay_image_file_name;
        $s3->put($s3filePath, file_get_contents($image));
    }

    $colorExp = [];
    if(isset($request->colors)) {
        $colorImp = implode($request->colors);
        $colorExp = explode(",", $colorImp);
    }
    //dd($colorExp);
    $product->created_by=auth()->id();
    $product->title=$request->title;
    $product->product_code=$request->product_code;
    $product->price_per_unit=$request->price_per_unit;
    $product->price_unit=$request->price_unit;
    $product->moq=$request->moq;
    $product->qty_unit=$request->qty_unit;
    $product->product_tag=$request->product_tag;
    $product->product_details=$request->product_details;
    $product->product_specification=$request->product_specification;
    $product->colors=$colorExp ?? [];
    $product->sizes=$request->sizes ?? [];
    $product->lead_time=$request->lead_time;
    $product->gender=$request->gender;
    $product->sample_availability=$request->sample_availability;
    $product->free_to_show=$request->free_to_show;
    $product->overlay_image = $overlay_image_file_name ?? $product->overlay_image;
    $product->product_type_mapping_id = $request->product_type_mapping;
    $product->product_type_mapping_child_id = $request->product_type_mapping == 1 ? $request->studio_id : $request->raw_materials_id;
    $product->save();



    // if ($request->hasFile('product_images')){
    //     foreach ($request->file('product_images') as $index=>$product_image){
    //         $image = $product_image;
    //         $s3 = \Storage::disk('s3');
    //         $uniqueString = generateUniqueString();
    //         $product_images_file_name ='images/'.uniqid().$uniqueString.'.'. $image->getClientOriginalExtension();
    //         $s3filePath = '/public'.'/'. $product_images_file_name;
    //         $s3->put($s3filePath, file_get_contents($image));
    //         ProductImage::create(['product_id'=>$product->id, 'product_image'=>$product_images_file_name]);
    //     }
    // }

    if(isset($request->preloaded))
    {
        $productImages = ProductImage::where('product_id',$product->id)->whereNotIn('id',$request->preloaded)->get();
    }
    else
    {
        $productImages = ProductImage::where('product_id',$product->id)->get();
    }
    // if($productImages->isNotEmpty())
    // {
    //     foreach($productImages as $productImage){
    //         if(Storage::disk('s3')->exists('public/'.$productImage->product_image)){
    //             Storage::disk('s3')->delete('public/'.$productImage->product_image);
    //             //Storage::disk('s3')->delete('public/'.$productImage->original);
    //         }
    //         $productImage->delete();
    //     }
    // }
    if(isset($request->images))
    {
        foreach ($request->images as $image) {
            $s3 = \Storage::disk('s3');
            $uniqueString = generateUniqueString();
            $product_images_file_name ='images/'.uniqid().$uniqueString.'.'. $image->getClientOriginalExtension();
            $s3filePath = '/public'.'/'. $product_images_file_name;
            $s3->put($s3filePath, file_get_contents($image));
            ProductImage::create(['product_id'=>$product->id, 'product_image'=>$product_images_file_name]);
        }
    }



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

        // dd('>>>>>>>>>>>>>>', $image[3]);
        if($image[3] == null){
            // dd($original_image_file_unique_name_with_database_path!=null);
            if(isset($small_image_file_unique_name_with_database_path)
            && $small_image_file_unique_name_with_database_path!=null
            ){

                $product_image = ProductImage::create([
                'product_id' => $product->id,
                'image_label' => $image[1],
                'is_raw_materials' => $is_raw_material,
                'product_image' => $small_image_file_unique_name_with_database_path,
                //'original' => $original_image_file_unique_name_with_database_path,
                ]);
            }
        } else {
            $data = [];
            $data['product_id'] = $product->id;
            $data['image_label'] = $image[1];
            $data['is_raw_materials'] = $is_raw_material;
            if(isset($small_image_file_unique_name_with_database_path) && $small_image_file_unique_name_with_database_path!=null){
                $data['product_image'] = $small_image_file_unique_name_with_database_path;
            }
            // if(isset($original_image_file_unique_name_with_database_path) && $original_image_file_unique_name_with_database_path!=null){
            //     $data['original'] = $original_image_file_unique_name_with_database_path;
            // }

            array_push($product_image_ids,(int)$image[3]);
            ProductImage::where('id',$image[3])->update($data);
        }
    }
    }
    //upload video


    //video
    if(isset($request->remove_video_id)){
        if( count(json_decode($request->remove_video_id)) > 0 ){
            $productVideo=ProductVideo::where('id',json_decode($request->remove_video_id))->first();
            if($productVideo){
                if(Storage::disk('s3')->exists('/public/'.$productVideo->video)){
                    Storage::disk('s3')->delete('/public/'.$productVideo->video);
                }
                $productVideo->delete();
            }
        }
    }

    if($request->hasFile('video')){
        $business_profile = BusinessProfile::where('id', $product->business_profile_id)->first();
        $business_profile_name = $business_profile->business_name;
        $video = $request->file('video');
        $s3 = \Storage::disk('s3');
        $uniqueString = generateUniqueString();
        $video_file_name_in_db = 'video/'.$business_profile_name.'/'.uniqid().$uniqueString.'.'. $video->getClientOriginalExtension();
        $s3filePath = '/public/'. $video_file_name_in_db;
        $s3->put($s3filePath, file_get_contents($video));
        $product_video = ProductVideo::create([
            'product_id' => $product->id,
            'video' => $video_file_name_in_db,
        ]);

    }
    // $products=Product::withTrashed()->where('business_profile_id',$product->business_profile_id)->latest()->with(['product_images','category'])->get();
    // $data=view('business_profile._product_table_data', compact('products'))->render();
    return response()->json([
        'success' => true,
        'msg' => 'Profile Updated Successfully',
        'data' => $product,
    ],200);

}

public function delete($product_id, $business_profile_id){
    $product=Product::where('id',$product_id)->first();
    $product->delete();
    $products=Product::whereNotIn('id',[$product_id])->where('business_profile_id',$business_profile_id)->latest()->with(['product_images','category'])->get();
    $data=view('business_profile._product_table_data', compact('products'))->render();

        return response()->json([
            'success' => true,
            'msg' => 'Profile Deleted Successfully',
            'data' => $data,
        ],200);
}

public function publishUnpublish($pid, $bid)
    {
      $product=Product::withTrashed()->where('id',$pid)->first();
      if($product->deleted_at){
          $product->restore();
          $products=Product::withTrashed()->where('business_profile_id',$bid)->latest()->with(['product_images','category'])->get();
          $data=view('business_profile._product_table_data', compact('products'))->render();
          return response()->json(array('success' => true, 'msg' => 'Product Published Successfully','data' => $data),200);
        }
      else{
        $product->delete();
        $products=Product::withTrashed()->where('business_profile_id',$bid)->latest()->with(['product_images','category'])->get();
        $data=view('business_profile._product_table_data', compact('products'))->render();
        return response()->json(array('success' => true, 'msg' => 'Product Unpublished Successfully', 'data' => $data),200);
      }
    }

    public function removeOverlayImage($id)
    {
        $product=Product::where('id',$id)->first();
        if(!$product){
            return response()->json(['msg' => 'product not found'], 404);
        }
        if(Storage::disk('s3')->exists('/public'.'/'.$product->overlay_image) ){
            Storage::disk('s3')->delete('/public'.'/'.$product->overlay_image);
            $product->update(['overlay_image' => null]);
            return response()->json(['msg' => 'overlay image removed'], 200);
        }
        return response()->json(['msg' => 'folder not exists'], 500);
    }

    public function removeSingleImage($id)
    {
        $product_image=ProductImage::where('id',$id)->first();
        if(!$product_image){
            return response()->json(['msg' => 'record not found'], 404);
        }
        if(Storage::disk('s3')->exists('/public'.'/'.$product_image->product_image)){
            Storage::disk('s3')->delete('/public'.'/'.$product_image->product_image);
            $product_image->delete();
            return response()->json(['msg' => 'image removed'], 200);
        }
        return response()->json(['msg' => 'folder not exists'], 500);
    }


    public function manufactureFeaturedVideo($id)
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
