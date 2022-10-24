<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\ExportDestination;

class ExportDestinationController extends Controller
{
    public function exportDestinationDetailsUpload(Request $request ){
     
        $validator = Validator::make($request->all(), [
            'country_id.*' => 'required',
        ],[
            'country_id.*.required' => 'The name field is required',
        ]);
        if ($validator->fails())
        {
            return response()->json(array(
            'success' => false,
            'error' => $validator->getMessageBag()),
            400);
        }
        try{

            if(count($request->country_id)>0){
                for($i=0; $i<count($request->country_id) ;$i++){
                    $exportDestination=new ExportDestination();
                    $exportDestination->country_id=$request->country_id[$i];
                    $exportDestination->short_description=$request->short_description[$i];
                    $exportDestination->business_profile_id = $request->business_profile_id;
                    $exportDestination->created_by = Auth::user()->id;
                    $exportDestination->updated_by = NULL;
                    $exportDestination->save();

                }

            }
            
            $exportDestinations = ExportDestination::where('business_profile_id',$request->business_profile_id)->get();
            return response()->json([
                'success' => true,
                'message' => 'Export destination Added',
                'exportDestinations'=>$exportDestinations,
            ],200);

        }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'error'   => ['error_line' => $e->getLine()],
            ],500);
        }  
    }
    public function deleteExportDestination($id){

        $exportDestination=ExportDestination::where('id',$id)->first();
        $businessId=$exportDestination->business_profile_id;
        $result=$exportDestination->delete();
        if($result){
            $exportDestinations = ExportDestination::where('business_profile_id',$businessId)->get();
            return response()->json([
                'success' => true,
                'message' => 'Export destination deleted successfully',
                'exportDestinations'=>$exportDestinations,
            ],200);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete export destination',
            ],500);
        }

    }
}
