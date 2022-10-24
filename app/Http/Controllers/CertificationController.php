<?php

namespace App\Http\Controllers;

use App\Models\Admin\Certification as AdminCertification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Certification;
use App\Http\Requests\CertificationRequest;
class CertificationController extends Controller
{
    public function certificationDetailsUpload(CertificationRequest $request ){

        try{
            if(isset($request->certification_id)){
                if(count($request->certification_id)>0){
                    $filename =null;
                    for($i=0; $i<count($request->certification_id) ;$i++){
                        $certification=new Certification();
                        if ($request->hasFile('image')){
                            if(isset($request->image[$i])){
                                $s3 = \Storage::disk('s3');
                                $uniqueString = generateUniqueString();
                                $image_unique_file_name = uniqid().$uniqueString.'.'.$request->image[$i]->getClientOriginalExtension();
                                $image_path_saved_in_db = 'images/certificates/'.$image_unique_file_name;
                                $s3filePath = '/public/images/certificates/'.$image_unique_file_name;
                                $s3->put($s3filePath, file_get_contents($request->image[$i]));
                            }
                        }
                        $admin_certification = AdminCertification::where('id', $request->certification_id[$i])->first();
                        $certification->title =$admin_certification->certification_programs;
                        $certification->admin_certification_id=$request->certification_id[$i];
                        $certification->issue_date= $request->issue_date[$i];
                        $certification->expiry_date= $request->expiry_date[$i];
                        $certification->image=$image_path_saved_in_db;
                        $certification->short_description=$request->short_description[$i];
                        $certification->business_profile_id = $request->business_profile_id;
                        $certification->created_by = Auth::user()->id;
                        $certification->updated_by = NULL;
                        $certification->save();

                    }

                }
            }

            $certifications = Certification::where('business_profile_id',$request->business_profile_id)->with('default_certification')->get();
            return response()->json([
                'success' => true,
                'message' => 'Certification Added',
                'certifications'=>$certifications,
            ],200);

        }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'error'   => ['error_line' => $e->getLine(), 'error' => $e->getMessage()],
            ],500);
        }
    }
    public function deleteCertificate(Request $request){
        $certification=Certification::where('id',$request->id)->first();
        $businessId=$certification->business_profile_id;
        $result=$certification->delete();
        if($result){
            $certifications = Certification::where('business_profile_id',$businessId)->with('default_certification')->get();
            return response()->json([
                'success' => true,
                'message' => 'Certification deleted successfully',
                'certifications'=>$certifications,
            ],200);
        }else{
            return response()->json([
                'success' => false,
            ],500);
        }

    }
}
