<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\CompanyFactoryTour;
use App\Models\CompanyFactoryTourImage;
use App\Models\CompanyFactoryTourLargeImage;
use DB;

class FactoryTourController extends Controller
{
    public function factoryTourDetails($businessProfileID){
        $companyFactoryTour = CompanyFactoryTour::with('companyFactoryTourImages','companyFactoryTourLargeImages')->where('business_profile_id',$businessProfileID)->first();
        if($companyFactoryTour){
            return response()->json([
                'success' => true,
                'companyFactoryTour'=>$companyFactoryTour,
            ],200);
        }
        else{
            return response()->json([
                'success' => false,
                'companyFactoryTour'=>$companyFactoryTour,
            ],200);
        }
    }
    public function createFactoryTour(Request $request){
       
        $validator = Validator::make($request->all(), [
            'virtual_tour.*' => 'string|min:1|max:255',
            'factory_images.*' => 'image',
            'factory_large_images.*' => 'image',
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
        
                $companyFactoryTour=new CompanyFactoryTour();
                $companyFactoryTour->business_profile_id = $request->business_profile_id;
                $companyFactoryTour->virtual_tour = $request->virtual_tour;
                $companyFactoryTour->save();
                
                if ($request->hasFile('factory_images')){
                
                    foreach($request->factory_images as $image){
                        $companyFactoryTourImage = new CompanyFactoryTourImage();
                        $companyFactoryTourImage->company_factory_tour_id = $companyFactoryTour->id;
                        $filename = $image->store('images/factory','public');
                        $image = Image::make(public_path('storage/'.$filename));
                        $image->save(public_path('storage/'.$filename));
                        $companyFactoryTourImage->factory_image = $filename;
                        $companyFactoryTourImage->save();
                    }
                } 
                if ($request->hasFile('factory_large_images')){
                   
                    foreach($request->factory_large_images as $image){
                        $companyFactoryTourLargeImage = new CompanyFactoryTourLargeImage();
                        $companyFactoryTourLargeImage->company_factory_tour_id = $companyFactoryTour->id;
                        $filename = $image->store('images/factory','public');
                        $image = Image::make(public_path('storage/'.$filename));
                        $image->save(public_path('storage/'.$filename));
                        $companyFactoryTourLargeImage->factory_large_image = $filename;
                        $companyFactoryTourLargeImage->save();
                    }
                } 
                DB::commit();
                $companyFactoyrTour = CompanyFactoryTour::where('id',$companyFactoryTour->id)->first();
                return response()->json([
                    'success' => true,
                    'message' => 'Factory tour created',
                    'companyFactoryTour'=>$companyFactoryTour,
                ],200);

        }catch(\Exception $e){
            DB::rollback();
            return response()->json([
                'success' => false,
                'error'   => ['error_line' => $e->getMessage()],
            ],500);
        }  
        
    }



    public function updateFactoryTour(Request $request){
       
        $validator = Validator::make($request->all(), [
            'virtual_tour.*' => 'string|min:1|max:255',
            'factory_images.*' => 'image',
            'factory_large_images.*' => 'image',
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
        
                $companyFactoryTour = CompanyFactoryTour::where('id',$request->company_factory_tour_id)->first();
                $companyFactoryTour->business_profile_id = $request->business_profile_id;
                $companyFactoryTour->virtual_tour = $request->virtual_tour;
                $companyFactoryTour->save();
                $factoryTourImages = CompanyFactoryTourImage::whereIn('id',$request->factory_image_ids)->get();
               
                
                if(count($factoryTourImages)>0){
                    foreach($factoryTourImages as $factoryTourImage){
                        if(Storage::exists('public/'.$factoryTourImage->factory_image)){
                            Storage::delete('public/'.$factoryTourImage->factory_image);
                        }
                        $factoryTourImage->delete();
                    }
                }
           
                if ($request->hasFile('factory_images')){
                
                    foreach($request->factory_images as $image){
                        $companyFactoryTourImage = new CompanyFactoryTourImage();
                        $companyFactoryTourImage->company_factory_tour_id = $companyFactoryTour->id;
                        $filename = $image->store('images/factory','public');
                        $image = Image::make(public_path('storage/'.$filename));
                        $image->save(public_path('storage/'.$filename));
                        $companyFactoryTourImage->factory_image = $filename;
                        $companyFactoryTourImage->save();
                    }
                }
                $factoryTourLargeImages = CompanyFactoryTourLargeImage::whereIn('id',$request->factory_large_image_ids)->get();
                if(count($factoryTourLargeImages)){
                    foreach($factoryTourLargeImages as $factoryTourLargeImage){
                        if(Storage::exists('public/'.$factoryTourLargeImage->factory_large_image)){
                            Storage::delete('public/'.$factoryTourLargeImage->factory_large_image);
                        }
                        $factoryTourLargeImage->delete();
                    }
                }
           
               
                if ($request->hasFile('factory_large_images')){
                   
                    foreach($request->factory_large_images as $image){
                        $companyFactoryTourLargeImage = new CompanyFactoryTourLargeImage();
                        $companyFactoryTourLargeImage->company_factory_tour_id = $companyFactoryTour->id;
                        $filename = $image->store('images/factory','public');
                        $image = Image::make(public_path('storage/'.$filename));
                        $image->save(public_path('storage/'.$filename));
                        $companyFactoryTourLargeImage->factory_large_image = $filename;
                        $companyFactoryTourLargeImage->save();
                    }
                } 
                DB::commit();
            
                $companyFactoyrTour = CompanyFactoryTour::where('id',$companyFactoryTour->id)->first();
                return response()->json([
                    'success' => true,
                    'message' => 'Factory tour updated',
                    'companyFactoryTour'=>$companyFactoryTour,
                ],200);

        }catch(\Exception $e){
            DB::rollback();
            return response()->json([
                'success' => false,
                'error'   => ['error_message' => $e->getMessage(),'error_line' => $e->getLine()],
            ],500);
        }  
        
    }

    
}
