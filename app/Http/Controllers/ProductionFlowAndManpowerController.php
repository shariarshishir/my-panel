<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\ProductionFlowAndManpower;
use Illuminate\Support\Facades\Validator;
use stdClass;
use App\Models\BusinessProfileVerification;

use Illuminate\Http\Request;

class ProductionFlowAndManpowerController extends Controller
{
    public function productionFlowAndManpowerCreateOrUpdate(Request $request){

        $validator = Validator::make($request->all(), [
            'production_type.*' => 'string|min:1|max:255',
            'manpower.*' => 'integer',
            'no_of_jacquard_machines.*' => 'integer',
            'daily_capacity.*' => 'integer'

        ]);
        if ($validator->fails())
        {
            return response()->json(array(
            'success' => false,
            'error' => $validator->getMessageBag()),
            400);
        }
        try{
            $productionFlowAndManpowers = ProductionFlowAndManpower::where('business_profile_id',$request->business_profile_id)->delete();
            if(isset($request->production_type)){
                if(count($request->production_type)>0){
                    for($i=0; $i < count($request->production_type); $i++){
                
                        $flowAndManpowerArray=[];
                        $jacquardMachines = new stdClass();
                        $jacquardMachines->name='No of Machines';
                        $jacquardMachines->value=$request->no_of_jacquard_machines[$i];
                        $jacquardMachines->status=0;
        
                        $manpower = new stdClass();
                        $manpower->name='Manpower';
                        $manpower->value=$request->manpower[$i];
                        $manpower->status=0;
        
                        $dailyCapacity = new stdClass();
                        $dailyCapacity->name='Capacity Daily';
                        $dailyCapacity->value=$request->daily_capacity[$i];
                        $dailyCapacity->status=0;
        
                        array_push($flowAndManpowerArray,$jacquardMachines,$manpower,$dailyCapacity);
        
                        $productionFlowAndManpower=new ProductionFlowAndManpower;
                        $productionFlowAndManpower->production_type=$request->production_type[$i];
                        $productionFlowAndManpower->flow_and_manpower=json_encode($flowAndManpowerArray);
                        $productionFlowAndManpower->business_profile_id = $request->business_profile_id;
                        $productionFlowAndManpower->created_by = Auth::user()->id;
                        $productionFlowAndManpower->updated_by = NULL;
                        $productionFlowAndManpower->save();
                        
                    }

                }
            }
            
            $productionFlowAndManpowers = ProductionFlowAndManpower::where('business_profile_id',$request->business_profile_id)->get();
           
            $businessProfileVerification = BusinessProfileVerification::where('business_profile_id',$request->business_profile_id )->first();
            if($businessProfileVerification){
                $businessProfileVerification->production_capacity = 0 ;
                $businessProfileVerification->save();

            }
            

            return response()->json([
                'success' => true,
                'message' => 'Company information Updated',
                'productionFlowAndManpowers'=>$productionFlowAndManpowers,
            ],200);

        }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'error'   => ['msg' => $e->getLine()],
            ],500);
        }

    }
}
