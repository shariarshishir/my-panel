<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\AssociationMembership;

class AssociationMembershipController extends Controller
{
    public function associationMembershipDetailsUpload(Request $request){
     
        $validator = Validator::make($request->all(), [
            'title.*' => 'string|min:1|max:50',
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
                        if ($request->hasFile('image'))
                        {
                            $filename = $request->image[$i]->store('images/association-memberships','public');
                            $image_resize = Image::make(public_path('storage/'.$filename));
                            $image_resize->save(public_path('storage/'.$filename));
                        }
                      
                        $associationMembership->title=$request->title[$i];
                        $associationMembership->image=$filename;
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
                'message' => ' Failed to delete association membership',
            ],404);
        }

        

    }
}
