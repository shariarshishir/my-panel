<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Security;
use Illuminate\Support\Facades\Validator;
use stdClass;

class SecurityController extends Controller
{
    public function securityCreateOrUpdate(Request $request){

        
        try{
            $security = Security::where('business_profile_id',$request->business_profile_id)->delete();
            
            $securityArray=[];
            $fireExit = new stdClass();
            $fireExit->name='fire_exit';
            $fireExit->checked=$request->fire_exit;
            $fireExit->status=0;
            
            $fireHydrant = new stdClass();
            $fireHydrant->name='fire_hydrant';
            $fireHydrant->checked=$request->fire_hydrant;
            $fireHydrant->status=0;

            $waterSource = new stdClass();
            $waterSource->name='water_source';
            $waterSource->checked=$request->water_source;
            $waterSource->status=0;

            $protocols = new stdClass();
            $protocols->name='protocols';
            $protocols->checked=$request->protocols;
            $protocols->status=0;

            array_push($securityArray,$fireExit,$fireHydrant,$waterSource,$protocols);
            
            $security = new Security();
            $security->security_and_others=json_encode($securityArray);
            $security->business_profile_id = $request->business_profile_id;
            $security->created_by = Auth::user()->id;
            $security->updated_by = NULL;
            $security->save();

            $security = Security::where('business_profile_id',$request->business_profile_id)->first();
            
            
            $securityObject = new stdClass();
            $securityObject->id= $security->id;
            $securityObject->walfare_and_csr=json_decode($security->security_and_others);
            $securityObject->business_profile_id=$security->business_profile_id;

            return response()->json([
                'success' => true,
                'message' => 'Security information Updated',
                'security'=>$securityObject,
            ],200);

        }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'error'   => ['msg' => $e->getLine()],
            ],500);
        }

    }
}
