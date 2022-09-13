<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\SustainabilityCommitment;
use App\Models\BusinessProfileVerification;


class SustainabilityCommitmentController extends Controller
{
    public function sustainabilityCommitmentCreateOrUpdate(Request $request){
        $validator = Validator::make($request->all(), [
            'sustainability_commitment_title.*' => 'string|min:1|max:500',
        ]);
        if ($validator->fails())
        {
            return response()->json(array(
            'success' => false,
            'error' => $validator->getMessageBag()),
            400);
        }
        try{

            $result = SustainabilityCommitment::where('business_profile_id',$request->business_profile_id)->delete();
            if(isset($request->sustainability_commitment_title)){
                $noOfSustainabilityCommitmentTitle=count($request->sustainability_commitment_title);
                if($noOfSustainabilityCommitmentTitle>0){
                    for($i=0;$i<$noOfSustainabilityCommitmentTitle ;$i++){
                        $sustainabilityCommitment  =  new SustainabilityCommitment();
                        $sustainabilityCommitment->title = $request->sustainability_commitment_title[$i];
                        $sustainabilityCommitment->business_profile_id = $request->business_profile_id;
                        $sustainabilityCommitment->status = 0;
                        $sustainabilityCommitment->created_by = Auth::user()->id;
                        $sustainabilityCommitment->updated_by = NULL;
                        $sustainabilityCommitment->save();
                    }
                }
            }

            $sustainabilityCommitments = SustainabilityCommitment::where('business_profile_id',$request->business_profile_id)->get();
            
            $businessProfileVerification = BusinessProfileVerification::where('business_profile_id',$request->business_profile_id )->first();
            if($businessProfileVerification){
                $businessProfileVerification->sustainability_commitments = 0 ;
                $businessProfileVerification->save();

            }
            return response()->json([
                'success' => true,
                'message' => 'Sustainability Commitment Updated',
                'sustainabilityCommitments'=>$sustainabilityCommitments,
               
            ],200);

        }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'error'   => ['msg' => $e->getLine()],
            ],500);

        }

    }
}

