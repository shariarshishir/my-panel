<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BusinessProfile;

class ManageBusinessProfileController extends Controller
{
    public function delete($id)
    {
        $business_profile=BusinessProfile::where('id',$id)->first();
        if(!$business_profile){
            return response()->json([
                'success' => false,
                'msg'     => 'Record not found'
            ],404);
        }
        $business_profile_rel_auth_id=[];
        array_push($business_profile_rel_auth_id, $business_profile->user_id,$business_profile->representative_user_id);

        if(!in_array(auth()->id(), $business_profile_rel_auth_id)){
            return response()->json([
                'success' => false,
                'msg'     => 'You are not authorized'
            ],401);
        }

        $business_profile->delete();
        return response()->json([
            'success' => true,
            'msg'     => 'Business profile deactivated successfully.'
        ],200);

    }

    public function restore($id)
    {
        $business_profile=BusinessProfile::onlyTrashed()
        ->where('id', $id)
        ->first();

        if(!$business_profile){
            return response()->json([
                'success' => false,
                'msg'     => 'Record not found'
            ],404);
        }
        $business_profile_rel_auth_id=[];
        array_push($business_profile_rel_auth_id, $business_profile->user_id,$business_profile->representative_user_id);

        if(!in_array(auth()->id(), $business_profile_rel_auth_id)){
            return response()->json([
                'success' => false,
                'msg'     => 'You are not authorized'
            ],401);
        }

        $business_profile->restore();
        return response()->json([
            'success' => true,
            'msg'     => 'Business profile restored successfully.'
        ],200);
       // return redirect()->back()->with('success', 'Business profile restored successfull.');
    }

}
