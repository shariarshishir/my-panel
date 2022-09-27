<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\BusinessTerm;
use App\Models\BusinessProfileVerification;

class BusinessTermController extends Controller
{
    public function businessTermsCreateOrUpdate(Request $request){
        $validator = Validator::make($request->all(), [
            'business_term_title.*' => 'string|min:1|max:500',
            'business_term_quantity.*' => 'integer'
        ]);
        if ($validator->fails())
        {
            return response()->json(array(
            'success' => false,
            'error' => $validator->getMessageBag()),
            400);
        }
        try{

            $result = BusinessTerm::where('business_profile_id',$request->business_profile_id)->delete();
            if(isset($request->business_term_title)){
                $noOfBusinessTermTitle=count($request->business_term_title);
                if($noOfBusinessTermTitle>0){
                    for($i=0;$i<$noOfBusinessTermTitle ;$i++){
                        $businessTerm  =  new BusinessTerm();
                        $businessTerm->title = $request->business_term_title[$i];
                        $businessTerm->quantity = $request->business_term_quantity[$i];
                        $businessTerm->business_profile_id = $request->business_profile_id;
                        $businessTerm->status = 0;
                        $businessTerm->created_by = Auth::user()->id;
                        $businessTerm->updated_by = NULL;
                        $businessTerm->save();
                    }
                }
            }

            $businessTerms = BusinessTerm::where('business_profile_id',$businessTerm->business_profile_id)->get();
            
            $businessProfileVerification = BusinessProfileVerification::where('business_profile_id',$request->business_profile_id )->first();
            if($businessProfileVerification){
                $businessProfileVerification->business_terms = 0 ;
                $businessProfileVerification->save();

            }
            return response()->json([
                'success' => true,
                'message' => 'Business term information Updated',
                'businessTerms'=>$businessTerms,
               
            ],200);

        }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'error'   => ['msg' => $e->getLine()],
            ],500);

        }

    }
}
