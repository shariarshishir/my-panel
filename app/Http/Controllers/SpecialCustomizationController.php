<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\SpecialCustomization;
use App\Models\BusinessProfileVerification;


class SpecialCustomizationController extends Controller
{
    public function specialCustomizationCreateOrUpdate(Request $request){
        $validator = Validator::make($request->all(), [
            'special_customization_title.*' => 'string|min:1|max:255',
        ]);
        if ($validator->fails())
        {
            return response()->json(array(
            'success' => false,
            'error' => $validator->getMessageBag()),
            400);
        }
        try{

            $result = SpecialCustomization::where('business_profile_id',$request->business_profile_id)->delete();
            if(isset($request->special_customization_title)){
                $noOfSpecialCustomizationTitle=count($request->special_customization_title);
                if($noOfSpecialCustomizationTitle>0){
                    for($i=0;$i<$noOfSpecialCustomizationTitle ;$i++){
                        $specialCustomization  =  new SpecialCustomization();
                        $specialCustomization->title = $request->special_customization_title[$i];
                        $specialCustomization->business_profile_id = $request->business_profile_id;
                        $specialCustomization->status = 0;
                        $specialCustomization->created_by = Auth::user()->id;
                        $specialCustomization->updated_by = NULL;
                        $specialCustomization->save();
                    }
                }
            }

            $specialCustomizations = SpecialCustomization::where('business_profile_id',$request->business_profile_id)->get();
            
            $businessProfileVerification = BusinessProfileVerification::where('business_profile_id',$request->business_profile_id )->first();
            if($businessProfileVerification){
                $businessProfileVerification->special_customizations = 0 ;
                $businessProfileVerification->save();
            }

            return response()->json([
                'success' => true,
                'message' => 'Special Customizations Updated',
                'specialCustomizations'=>$specialCustomizations,
               
            ],200);

        }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'error'   => ['msg' => $e->getLine()],
            ],500);

        }

    }
}
