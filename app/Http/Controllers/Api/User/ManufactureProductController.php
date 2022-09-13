<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Manufacture\Product;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Models\Manufacture\ProductImage;
use App\Models\Manufacture\ProductVideo;
use Illuminate\Support\Facades\Validator;
use DB;

class ManufactureProductController extends Controller
{
    public function index($businessProfileID){
        $products=Product::with('product_images','category')->where('business_profile_id',$businessProfileID)->latest()->paginate(20);
        if($products->total()>0){
            return response()->json([
                'success' => true,
                'message' => 'Product Uploaded Successfully',
                'products' => $products,
            ],200);
        }
        else{
            return response()->json([
                'success' => false,
                'products' => $products,
            ],200);
        }
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'category_id' => 'required',
            'business_profile_id' => 'required',
            'title'=>'required',
            //'price_per_unit'=>'required|numeric',
            'moq'=>'required|numeric',
            'product_details'=>'required',
            'product_specification'=>'required',
            'lead_time'=>'required',
            'industry' => 'required',
            'video' => 'mimes:mp4,3gp,mkv,mov|max:150000',
            'price_unit' => 'required',
            'qty_unit'   => 'required',
            'colors'  => 'required',
            'sizes'  => 'required',
            'product_images' => 'required',
            'price_per_unit'=> 'required',
            'gender' => 'required',
            'sample_availability' => 'required',
        ],[
            'price_per_unit.required' => 'The price range field is required.',
            'category_id.required' => 'The product category field is required',
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

            if ($request->hasFile('overlay_image')){
                $path = $request->overlay_image->store('images','public');
                $small_image = Image::make(Storage::get($path))->fit(370, 370)->encode();
                Storage::put('overlay_large_image/'.$path, $path);
                Storage::put('overlay_small_image/'.$path, $small_image);
            }

            $Data=[
                'business_profile_id' => $request->business_profile_id,
                'product_category' => $request->category_id,
                'title'=> $request->title,
                'moq'=> $request->moq,
                'product_details'=>$request->product_details,
                'product_specification'=>$request->product_specification,
                'lead_time'=>$request->lead_time,
                'colors'=>$request->colors ?? [],
                'sizes'=>$request->sizes ?? [],
                'industry' => $request->industry== 'apparel' ? 'apparel' : 'non-apparel',
                'price_per_unit' => $request->price_per_unit,
                'price_unit'   => $request->price_unit,
                'qty_unit'    =>$request->qty_unit,
                'created_by' => auth()->id(),
                'gender'     => $request->gender,
                'sample_availability' =>$request->sample_availability,
                'overlay_image' => $path

            ];
            
            $product=Product::create($Data);

            if($request->hasFile('product_images')){
                foreach ($request->file('product_images') as $index=>$product_image){
                    $path=$product_image->store('images','public');

                    $large_image = Image::make(Storage::get($path))->fit(1600, 1061)->encode();
                    $image = Image::make(Storage::get($path))->fit(370, 370)->encode();
                    $medium_image = Image::make(Storage::get($path))->fit(350, 231)->encode();
                    $small_image = Image::make(Storage::get($path))->fit(66, 43)->encode();

                    Storage::put($path, $image);
                    Storage::put('large/'.$path, $large_image);
                    Storage::put('medium/'.$path, $medium_image);
                    Storage::put('small/'.$path, $small_image);

                    ProductImage::create(['product_id'=>$product->id, 'product_image'=>$path]);
                }
            }

            if($request->hasFile('video')){
                $business_profile=BusinessProfile::where('id', $request->business_profile_id)->first();
                $business_profile_name=$business_profile->business_name;
                $folder='video/'.$business_profile_name;
                $filename = $request->video->store($folder,'public');
                $product_video = ProductVideo::create([
                    'product_id' => $product->id,
                    'video' => $filename,
                ]);

            }
            DB::commit();
            $products=Product::where('business_profile_id',$product->business_profile_id)->latest()->with(['product_images','category'])->get();
            return response()->json([
                'success' => true,
                'message' => 'Product Uploaded Successfully',
                'products' => $products,
            ],200);


        }catch(\Exception $e){
            DB::rollback();
            return response()->json([
                'success' => false,
                'error'   => ['message' => $e->getMessage().$e->getLine()],
            ],500);

        }
    }


    public function update(Request $request,$productId)
    {
        
        $validator = Validator::make($request->all(), [
            'category_id' => 'required',
            'title'=>'required',
            'price_per_unit'=>'required',
            'price_unit' => 'required',
            'moq'=>'required|numeric',
            'qty_unit'   => 'required',
            'colors'  => 'required',
            'sizes'  => 'required',
            'product_details'=>'required',
            'product_specification'=>'required',
            'lead_time'=>'required',
            'video' => 'mimes:mp4,3gp,mkv,mov|max:150000',
            'gender' => 'required',
            'sample_availability' => 'required',
           
        ]); 

        if ($validator->fails()){
            return response()->json(array(
            'success' => false,
            'error' => $validator->getMessageBag()),
            400);
        }

        DB::beginTransaction();

        try{
            $product = Product::find($productId);

            if ($request->hasFile('overlay_image')){
                if($product->overlay_image){

                    if(Storage::exists($product->overlay_image)){
                        Storage::delete($product->overlay_image);
                    }
                }
                $path = $request->overlay_image->store('images','public');
                $small_image = Image::make(Storage::get($path))->fit(370, 370)->encode();
                Storage::put('overlay_large_image/'.$path, $path);
                Storage::put('overlay_small_image/'.$path, $small_image);
            }
            $product->created_by=auth()->id();
            $product->title=$request->title;
            $product->price_per_unit=$request->price_per_unit;
            $product->price_unit=$request->price_unit;
            $product->moq=$request->moq;
            $product->qty_unit=$request->qty_unit;
            $product->product_category=$request->category_id;
            $product->product_details=$request->product_details;
            $product->product_specification=$request->product_specification;
            $product->colors=$request->colors ?? [];
            $product->sizes=$request->sizes ?? [];
            $product->lead_time=$request->lead_time;
            $product->gender=$request->gender;
            $product->sample_availability=$request->sample_availability;
            $product->overlay_image = $path?? $product->overlay_image;

            $product->save();

            $productImages=ProductImage::whereIn('id',$request->product_images_id)->get();
            if(isset($productImages)){
                foreach($productImages as $productImage){
                    if(Storage::exists('public/'.$productImage->product_image)){
                        Storage::delete('public/'.$productImage->product_image);
                    }
                    $productImage->delete();
                }
            }

            if ($request->hasFile('product_images')){
                if(Storage::exists('upload/test.png')){
                    Storage::delete('upload/test.png');
                }
                foreach ($request->file('product_images') as $index=>$product_image){
                    $path=$product_image->store('images','public');

                    $large_image = Image::make(Storage::get($path))->fit(1600, 1061)->encode();
                    $image = Image::make(Storage::get($path))->fit(370, 370)->encode();
                    $medium_image = Image::make(Storage::get($path))->fit(350, 231)->encode();
                    $small_image = Image::make(Storage::get($path))->fit(66, 43)->encode();

                    Storage::put($path, $image);
                    Storage::put('large/'.$path, $large_image);
                    Storage::put('medium/'.$path, $medium_image);
                    Storage::put('small/'.$path, $small_image);

                    ProductImage::create(['product_id'=>$product->id, 'product_image'=>$path]);
                }
            }

            if(isset($request->remove_video_id)){
                if( count(json_decode($request->remove_video_id)) > 0 )
                {
                    $productVideo=ProductVideo::where('id',json_decode($request->remove_video_id))->first();
                    if($productVideo){
        
                        if(Storage::exists($productVideo->video)){
                            Storage::delete($productVideo->video);
                        }
                        $productVideo->delete();
                    }
                }
            }
    
            if($request->hasFile('video')){
                $business_profile=BusinessProfile::where('id', $product->businessProfile->id)->first();
                $business_profile_name=$business_profile->business_name;
                $folder='video/'.$business_profile_name;
                $filename = $request->video->store($folder,'public');
                $product_video = ProductVideo::create([
                    'product_id' => $product->id,
                    'video' => $filename,
                ]);
            }
            $product=Product::with(['product_images','category'])->where('id',$productId)->first();
            return response()->json([
                'success' => true,
                'message' => 'Product Updated Successfully',
                'product' => $product,
            ],200);

        }catch(\Exception $e){
            DB::rollback();
            return response()->json([
                'success' => false,
                'error'   => ['message' => $e->getMessage().$e->getLine()],
            ],500);
        }
    }
    public function show($productId){
       
        $product=Product::with('product_images','category','businessProfile.user')->where('id',$productId)->first();
        if($product){
            return response()->json([
                'success' => true,
                'product' => $product,
                ],200);
        }
        else{
            return response()->json([
                'success' => false,
                'message' => 'Product not found',
                ],404);
        }
       
    } 

    public function delete($businessProfileId,$productId)
    {

        try{
            $product=Product::where('id',$productId)->first();
            $result=$product->delete();
            $products=Product::whereNotIn('id',[$productId])->where('business_profile_id',$businessProfileId)->latest()->with(['product_images','category'])->get();
            return response()->json([
                'success' => true,
                'message' => 'Product deleted Successfully',
                'products' => $products,
                ],200);
        }catch(\Exception $e){
            DB::rollback();
            return response()->json([
                'success' => false,
                'error'   => ['message' => $e->getMessage().$e->getLine()],
            ],500);

        }
            

    }
}
