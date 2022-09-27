<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\MainBuyer;

class MainBuyerController extends Controller
{
    public function mainBuyerDetailsUpload(Request $request ){
     
        $validator = Validator::make($request->all(), [
            'title.*' => 'string|min:1|max:255',
            'image.*' => 'image',
            'short_description.*' => 'string|max:500',
        ]);
        if ($validator->fails())
        {
            return response()->json(array(
            'success' => false,
            'error' => $validator->getMessageBag()),
            400);
        }
        try{
        
            if(isset($request->title)){
                if(count($request->title)>0){
                    for($i=0; $i<count($request->title) ;$i++){
                        $mainBuyer=new MainBuyer();
                        if ($request->hasFile('image'))
                        {
                            $s3 = \Storage::disk('s3');
                            $uniqueString = generateUniqueString();
                            $image_unique_file_name = uniqid().$uniqueString.'.'.$request->image[$i]->getClientOriginalExtension();
                            $image_path_saved_in_db = 'images/mainbuyers/'.$image_unique_file_name;
                            $s3filePath = '/public/images/mainbuyers/'.$image_unique_file_name;
                            $s3->put($s3filePath, file_get_contents($request->image[$i]));
                        }
                      
                        $mainBuyer->title=$request->title[$i];
                        $mainBuyer->image=$image_path_saved_in_db;
                        $mainBuyer->short_description=$request->short_description[$i];
                        $mainBuyer->business_profile_id = $request->business_profile_id;
                        $mainBuyer->created_by = Auth::user()->id;
                        $mainBuyer->updated_by = NULL;
                        $mainBuyer->save();
                        
                    }

                }
            }
            
            $mainBuyers = MainBuyer::where('business_profile_id',$request->business_profile_id)->get();
            return response()->json([
                'success' => true,
                'message' => 'Main Buyer Added',
                'mainBuyers'=>$mainBuyers,
            ],200);

        }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'error'   => ['error_line' => $e->getLine()],
            ],500);
        }  
    }
    public function deleteMainBuyer(Request $request){
        $mainBuyer=MainBuyer::where('id',$request->id)->first();
        $businessId=$mainBuyer->business_profile_id;
        $result=$mainBuyer->delete();
        if($result){
            $mainBuyers = MainBuyer::where('business_profile_id',$businessId)->get();
            return response()->json([
                'success' => true,
                'message' => 'Main Buyer deleted successfully',
                'mainBuyers'=>$mainBuyers,
            ],200);
        }else{
            return response()->json([
                'success' => false,
            ],500);
        }

    }
}
