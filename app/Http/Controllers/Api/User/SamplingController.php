<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Sampling;
use App\Models\BusinessProfileVerification;

class SamplingController extends Controller
{
    public function samplingCreateOrUpdate(Request $request){
        $validator = Validator::make($request->all(), [
            'sampling_title.*' => 'string|min:1|max:500',
            'sampling_quantity.*' => 'integer'
        ]);
        if ($validator->fails())
        {
            return response()->json(array(
            'success' => false,
            'error' => $validator->getMessageBag()),
            400);
        }
        try{

            $result = Sampling::where('business_profile_id',$request->business_profile_id)->delete();
            if(isset($request->sampling_title)){
                $noOfSamplingTitle=count($request->sampling_title);
                if($noOfSamplingTitle>0){
                    for($i=0;$i<$noOfSamplingTitle ;$i++){
                        $sampling  =  new Sampling();
                        $sampling->title = $request->sampling_title[$i];
                        $sampling->quantity = $request->sampling_quantity[$i];
                        $sampling->business_profile_id = $request->business_profile_id;
                        $sampling->status = 0;
                        $sampling->created_by = Auth::user()->id;
                        $sampling->updated_by = NULL;
                        $sampling->save();
                    }
                }
            }
           

            $samplings = Sampling::where('business_profile_id',$request->business_profile_id)->get();
            
            $businessProfileVerification = BusinessProfileVerification::where('business_profile_id',$request->business_profile_id )->first();
            if($businessProfileVerification){
                $businessProfileVerification->sampling = 0 ;
                $businessProfileVerification->save();

            }
            return response()->json([
                'success' => true,
                'message' => 'Sampling  information Updated',
                'samplings'=>$samplings,
               
            ],200);

        }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'error'   => ['msg' => $e->getLine()],
            ],500);

        }

    }
}
