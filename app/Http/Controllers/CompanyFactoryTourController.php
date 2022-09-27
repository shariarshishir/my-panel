<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\CompanyFactoryTour;
use App\Models\CompanyFactoryTourImage;
use App\Models\CompanyFactoryTourLargeImage;

class CompanyFactoryTourController extends Controller
{
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
        try{
        
                $companyFactoryTour=new CompanyFactoryTour();
                $companyFactoryTour->business_profile_id = $request->business_profile_id;
                $companyFactoryTour->virtual_tour = $request->virtual_tour;
                $companyFactoryTour->save();
                
                if ($request->hasFile('factory_images')){
                
                    foreach($request->factory_images as $image){
                        $companyFactoryTourImage = new CompanyFactoryTourImage();
                        $companyFactoryTourImage->company_factory_tour_id = $companyFactoryTour->id;
                        $s3 = \Storage::disk('s3');
                        $uniqueString = generateUniqueString();
                        $image_unique_file_name = uniqid().$uniqueString.'.'.$image->getClientOriginalExtension();
                        $image_path_saved_in_db = 'images/factory/'.$image_unique_file_name;
                        $s3filePath = '/public/images/factory/'.$image_unique_file_name;
                        $s3->put($s3filePath, file_get_contents($image));
                        $companyFactoryTourImage->factory_image = $image_path_saved_in_db;
                        $companyFactoryTourImage->save();
                    }
                } 
                if ($request->hasFile('factory_large_images')){
                   
                    foreach($request->factory_large_images as $image){
                        $companyFactoryTourLargeImage = new CompanyFactoryTourLargeImage();
                        $companyFactoryTourLargeImage->company_factory_tour_id = $companyFactoryTour->id;
                        $s3 = \Storage::disk('s3');
                        $uniqueString = generateUniqueString();
                        $image_unique_file_name = uniqid().$uniqueString.'.'.$image->getClientOriginalExtension();
                        $image_path_saved_in_db = 'images/factory/'.$image_unique_file_name;
                        $s3filePath = '/public/images/factory/'.$image_unique_file_name;
                        $s3->put($s3filePath, file_get_contents($image));
                        $companyFactoryTourLargeImage->factory_large_image = $image_path_saved_in_db;
                        $companyFactoryTourLargeImage->save();
                    }
                } 
            
                $companyFactoyrTour = CompanyFactoryTour::where('id',$companyFactoryTour->id)->first();
                return response()->json([
                    'success' => true,
                    'message' => 'Factory tour created',
                    'companyFactoryTour'=>$companyFactoryTour,
                ],200);

        }catch(\Exception $e){
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
        try{
        
                $companyFactoryTour = CompanyFactoryTour::where('id',$request->company_factory_tour_id)->first();
                // dd($companyFactoryTour);
                $companyFactoryTour->business_profile_id = $request->business_profile_id;
                $companyFactoryTour->virtual_tour = $request->virtual_tour;
                $companyFactoryTour->save();
                if(isset($request->company_factory_tour_image_ids)){
                    if(count(json_decode($request->company_factory_tour_image_ids))>0){
                            CompanyFactoryTourImage::whereIn('id', json_decode($request->company_factory_tour_image_ids))->delete();
                    }
                }
                if ($request->hasFile('factory_images')){
                
                    foreach($request->factory_images as $image){
                        $companyFactoryTourImage = new CompanyFactoryTourImage();
                        $companyFactoryTourImage->company_factory_tour_id = $companyFactoryTour->id;
                        $s3 = \Storage::disk('s3');
                        $uniqueString = generateUniqueString();
                        $image_unique_file_name = uniqid().$uniqueString.'.'.$image->getClientOriginalExtension();
                        $image_path_saved_in_db = 'images/factory/'.$image_unique_file_name;
                        $s3filePath = '/public/images/factory/'.$image_unique_file_name;
                        $s3->put($s3filePath, file_get_contents($image));
                        $companyFactoryTourImage->factory_image = $image_path_saved_in_db;
                        $companyFactoryTourImage->save();
                    }
                }
                if(isset($request->company_factory_tour_large_image_ids)){
                    if( count(json_decode($request->company_factory_tour_large_image_ids))>0){
                        CompanyFactoryTourLargeImage::whereIn('id', json_decode($request->company_factory_tour_large_image_ids))->delete();
                    }
                }
               
                if ($request->hasFile('factory_large_images')){
                   
                    foreach($request->factory_large_images as $image){
                        $companyFactoryTourLargeImage = new CompanyFactoryTourLargeImage();
                        $companyFactoryTourLargeImage->company_factory_tour_id = $companyFactoryTour->id;
                        $s3 = \Storage::disk('s3');
                        $uniqueString = generateUniqueString();
                        $image_unique_file_name = uniqid().$uniqueString.'.'.$image->getClientOriginalExtension();
                        $image_path_saved_in_db = 'images/factory/'.$image_unique_file_name;
                        $s3filePath = '/public/images/factory/'.$image_unique_file_name;
                        $s3->put($s3filePath, file_get_contents($image));
                        $companyFactoryTourLargeImage->factory_large_image = $image_path_saved_in_db;
                        $companyFactoryTourLargeImage->save();
                    }
                } 
            
                $companyFactoyrTour = CompanyFactoryTour::where('id',$companyFactoryTour->id)->first();
                return response()->json([
                    'success' => true,
                    'message' => 'Factory tour updated',
                    'companyFactoryTour'=>$companyFactoryTour,
                ],200);

        }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'error'   => ['error_message' => $e->getMessage(),'error_line' => $e->getLine()],
            ],500);
        }  
        
    }

    public function factoryTourImageDelete(Request $request){
        
        $companyFactoryTourImage = CompanyFactoryTourImage::where('id',$request->id)->first();
        $companyFactoryTourId = $companyFactoryTourImage->company_factory_tour_id;
        $result = $companyFactoryTourImage->delete();
        if($result){
            $companyFactoryTourImages = CompanyFactoryTourImage::where('company_factory_tour_id',$companyFactoryTourId)->get();
            return response()->json([
                'success' => true,
                'message' => 'Image deleted successfully',
                'companyFactoryTourImages'=>$companyFactoryTourImages,
            ],200);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Failed to  delete image',
            ],200);
        }

    }

    public function factoryTourLargeImageDelete(Request $request){
        $companyFactoryTourLargeImage = CompanyFactoryTourLargeImage::where('id',$request->id)->first();
        $companyFactoryTourId = $companyFactoryTourLargeImage->company_factory_tour_id;
        $result=$companyFactoryTourLargeImage->delete();
        if($result){
            $companyFactoryTourLargeImages = CompanyFactoryTourLargeImage::where('company_factory_tour_id',$companyFactoryTourId)->get();
            return response()->json([
                'success' => true,
                'message' => 'Image deleted successfully',
                'companyFactoryTourLargeImages'=>$companyFactoryTourLargeImages,
            ],200);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Failed to  delete image',
            ],200);
        }

    }
  
  
}
