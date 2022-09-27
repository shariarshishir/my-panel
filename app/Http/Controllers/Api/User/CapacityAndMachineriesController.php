<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\CategoriesProduced;
use App\Models\MachineriesDetail;
use App\Models\BusinessProfileVerification;
use App\Models\ProductionCapacity;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use stdClass;

class CapacityAndMachineriesController extends Controller
{
    public function capacityAndMachineriesCreateOrUpdate(Request $request){


        $validator = Validator::make($request->all(), [
            'machine_type.*' => 'required_with:annual_capacity|string|min:1|max:50',
            'annual_capacity.*' => 'required_with:machine_type|integer',
            'type.*' => 'required_with:percentage|string|min:1|max:50',
            'percentage.*' => 'required_with:type|integer',
            'machine_name.*' =>'required_with:quantity|string|min:1|max:50',
            'quantity.*' => 'required_with:machine_name|integer'

        ]);
        if ($validator->fails())
        {
            return response()->json(array(
            'success' => false,
            'error' => $validator->getMessageBag()),
            400);
        }
        try{

            $machineriesDetails = MachineriesDetail::where('business_profile_id',$request->business_profile_id)->delete();
            $categoriesProduceds = CategoriesProduced::where('business_profile_id',$request->business_profile_id)->delete();
            $productionCapacities = ProductionCapacity::where('business_profile_id',$request->business_profile_id)->delete();
            if(isset($request->machine_type)){
                $noOfMachineType=count($request->machine_type);
                if($noOfMachineType>0){
                    for($i=0;$i<$noOfMachineType ;$i++){
                        $productionCapacity  =  new ProductionCapacity();
                        $productionCapacity->machine_type = $request->machine_type[$i];
                        $productionCapacity->annual_capacity = $request->annual_capacity[$i];
                        $productionCapacity->business_profile_id = $request->business_profile_id;
                        $productionCapacity->status = 0;
                        $productionCapacity->created_by = Auth::user()->id;
                        $productionCapacity->updated_by = NULL;
                        $productionCapacity->save();
                    }
                }
            }


            if(isset($request->type)){
                $noOftype=count($request->type);
                if($noOftype>0){
                    for($i=0;$i<$noOftype; $i++){
                        $categoriesProduced  =  new CategoriesProduced();
                        $categoriesProduced->type = $request->type[$i];
                        $categoriesProduced->percentage = $request->percentage[$i];
                        $categoriesProduced->business_profile_id = $request->business_profile_id;
                        $categoriesProduced->status = 0;
                        $categoriesProduced->created_by = Auth::user()->id;
                        $categoriesProduced->updated_by = NULL;
                        $categoriesProduced->save();
                    }
                }

            }

            if(isset($request->machine_name)){
                $noOfMachineName=count($request->machine_name);
                if($noOfMachineName>0){
                    for($i=0; $i<$noOfMachineName ;$i++){

                        $machineriesDetail   =  new MachineriesDetail();
                        $machineriesDetail->machine_name = $request->machine_name[$i];
                        $machineriesDetail->quantity = $request->quantity[$i];
                        $machineriesDetail->business_profile_id = $request->business_profile_id;
                        $machineriesDetail->status = 0;
                        $machineriesDetail->created_by = Auth::user()->id;
                        $machineriesDetail->updated_by = NULL;
                        $machineriesDetail->save();
                    }

                }
            }

            $machineriesDetails = MachineriesDetail::where('business_profile_id',$request->business_profile_id)->get();
            $categoriesProduceds = CategoriesProduced::where('business_profile_id',$request->business_profile_id)->get();
            $productionCapacities = ProductionCapacity::where('business_profile_id',$request->business_profile_id)->get();
            
            $businessProfileVerification = BusinessProfileVerification::where('business_profile_id',$request->business_profile_id)->first();
            if($businessProfileVerification){
                $businessProfileVerification->capacity_and_machineries = 0 ;
                $businessProfileVerification->save();

            }
            return response()->json([
                'success' => true,
                'message' => 'Company information Updated',
                'machineriesDetails'=>$machineriesDetails,
                'categoriesProduceds'=>$categoriesProduceds,
                'productionCapacities'=>$productionCapacities

            ],201);

        }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'error'   => ['msg' => $e->getLine()],
            ],500);

        }


    }
}
