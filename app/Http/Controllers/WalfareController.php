<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Walfare;
use Illuminate\Support\Facades\Validator;
use stdClass;

use Illuminate\Http\Request;

class WalfareController extends Controller
{
    public function walfareCreateOrUpdate(Request $request){

        
        try{
            $walfare = Walfare::where('business_profile_id',$request->business_profile_id)->delete();
            
            $walfareArray=[];
            $healthcareFacility = new stdClass();
            $healthcareFacility->name='healthcare_facility';
            $healthcareFacility->checked=$request->healthcare_facility;
            $healthcareFacility->status=0;
            
            $dayCare = new stdClass();
            $dayCare->name='day_care';
            $dayCare->checked=$request->day_care;
            $dayCare->status=0;

            $doctor = new stdClass();
            $doctor->name='doctor';
            $doctor->checked=$request->doctor;
            $doctor->status=0;

            $maternityLeave = new stdClass();
            $maternityLeave->name='maternity_leave';
            $maternityLeave->checked=$request->maternity_leave;
            $maternityLeave->status=0;

            $playground = new stdClass();
            $playground->name='playground';
            $playground->checked=$request->playground;
            $playground->status=0;

            $socialWork = new stdClass();
            $socialWork->name='social_work';
            $socialWork->checked=$request->social_work;
            $socialWork->status=0;

            array_push($walfareArray,$healthcareFacility,$dayCare,$doctor,$maternityLeave,$playground,$socialWork);
            
            $walfare = new Walfare();
            $walfare->walfare_and_csr=json_encode($walfareArray);
            $walfare->business_profile_id = $request->business_profile_id;
            $walfare->created_by = Auth::user()->id;
            $walfare->updated_by = NULL;
            $walfare->save();
            
            $walfare = Walfare::where('business_profile_id',$request->business_profile_id)->first();
           
            return response()->json([
                'success' => true,
                'message' => 'Walfare information Updated',
                'walfare'=>$walfare,
            ],200);

        }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'error'   => ['msg' => $e->getLine()],
            ],500);
        }

    }
}

