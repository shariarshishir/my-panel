<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\AssociationMembership;

class AssociationMembershipController extends Controller
{
    public function associationMembershipDetailsUpload(Request $request ){
     
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
                        $associationMembership=new AssociationMembership();
                        if ($request->hasFile('image')){
                            $s3 = \Storage::disk('s3');
                            $uniqueString = generateUniqueString();
                            $image_unique_file_name = uniqid().$uniqueString.'.'.$request->image[$i]->getClientOriginalExtension();
                            $image_path_saved_in_db = 'images/association-memberships/'.$image_unique_file_name;
                            $s3filePath = '/public/images/association-memberships/'.$image_unique_file_name;
                            $s3->put($s3filePath, file_get_contents($request->image[$i]));
                        }
                      
                        $associationMembership->title=$request->title[$i];
                        $associationMembership->image=$image_path_saved_in_db;
                        $associationMembership->short_description=$request->short_description[$i];
                        $associationMembership->business_profile_id = $request->business_profile_id;
                        $associationMembership->created_by = Auth::user()->id;
                        $associationMembership->updated_by = NULL;
                        $associationMembership->save();
                        
                    }

                }
            }
            
            $associationMemberships = AssociationMembership::where('business_profile_id',$request->business_profile_id)->get();
            return response()->json([
                'success' => true,
                'message' => 'Export destination Added',
                'associationMemberships'=>$associationMemberships,
            ],200);

        }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'error'   => ['error_line' => $e->getLine()],
            ],500);
        }  
    }
    public function deleteAssociationMembership(Request $request){
        $associationMembership=AssociationMembership::where('id',$request->id)->first();
        $businessId=$associationMembership->business_profile_id;
        $result=$associationMembership->delete();
        if($result){
            $associationMemberships = AssociationMembership::where('business_profile_id',$businessId)->get();
            return response()->json([
                'success' => true,
                'message' => 'Association membership deleted successfully',
                'associationMemberships'=>$associationMemberships,
            ],200);
        }else{
            return response()->json([
                'success' => false,
            ],500);
        }

    }
}
