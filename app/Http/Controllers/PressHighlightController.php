<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\PressHighlight;

class PressHighlightController extends Controller
{
    public function pressHighlightDetailsUpload(Request $request ){
     
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
                        $pressHighlight=new PressHighlight();
                        if ($request->hasFile('image')){
                            $s3 = \Storage::disk('s3');
                            $uniqueString = generateUniqueString();
                            $image_unique_file_name = uniqid().$uniqueString.'.'.$request->image[$i]->getClientOriginalExtension();
                            $image_path_saved_in_db = 'images/press-highlight/'.$image_unique_file_name;
                            $s3filePath = '/public/images/press-highlight/'.$image_unique_file_name;
                            $s3->put($s3filePath, file_get_contents($request->image[$i]));
                            
                        }
                        
                        $pressHighlight->title=$request->title[$i];
                        $pressHighlight->image=$image_path_saved_in_db;
                        $pressHighlight->short_description=$request->short_description[$i];
                        $pressHighlight->business_profile_id = $request->business_profile_id;
                        $pressHighlight->created_by = Auth::user()->id;
                        $pressHighlight->updated_by = NULL;
                        $pressHighlight->save();
                        
                    }

                }
            }
            
            $pressHighlights = PressHighlight::where('business_profile_id',$request->business_profile_id)->get();
            return response()->json([
                'success' => true,
                'message' => 'PR highlight Added',
                'pressHighlights'=>$pressHighlights,
            ],200);

        }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'error'   => ['error_line' => $e->getLine()],
            ],500);
        }  
    }
    public function deletePressHighlight(Request $request){
        $pressHighlight=PressHighlight::where('id',$request->id)->first();
        $businessId=$pressHighlight->business_profile_id;
        $result=$pressHighlight->delete();
        if($result){
            $pressHighlights = PressHighlight::where('business_profile_id',$businessId)->get();
            return response()->json([
                'success' => true,
                'message' => 'PR highlight deleted successfully',
                'pressHighlights'=>$pressHighlights,
            ],200);
        }else{
            return response()->json([
                'success' => false,
            ],500);
        }

    }
}

