<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Certification;
use App\Models\Admin\Certification as CertificationType;

class CertificationController extends Controller
{

    public function certificationTypesList(){
        $certificationTypes = CertificationType::get();
        if(count($certificationTypes)){
            return response()->json([
                'success' => true,
                'certifications'=>$certificationTypes,
            ],200);
        }
        else{
            return response()->json([
                'success' => false,
                'certifications'=>$certificationTypes,
            ],200);
        }


    }
    public function certificationDetailsUpload(Request $request ){
       
        try{

            if(isset($request->certification_id)){
                if(count($request->certification_id)>0){
                    $filename =null;
                    for($i=0; $i<count($request->certification_id) ;$i++){
                        $certification=new Certification();
                        if ($request->hasFile('image'))
                        {
                            if(isset($request->image[$i])){
                                $extension = $request->image[$i]->getClientOriginalExtension();
                                if($extension=='pdf' ||$extension=='PDF' || $extension=='doc'||$extension=='docx'||$extension=='DOC'||$extension=='DOCX'){
                                    $filename = $request->image[$i]->store('images/certificates','public');

                                }else{
                                    $filename = $request->image[$i]->store('images/certificates','public');
                                    $image_resize = Image::make(public_path('storage/'.$filename));
                                    $image_resize->save(public_path('storage/'.$filename));
                                }
                            }

                        }
                        $admin_certification=CertificationType::where('id', $request->certification_id[$i])->first();
                        $certification->title=$admin_certification->certification_programs;
                        $certification->admin_certification_id=$request->certification_id[$i];
                        $certification->issue_date= $request->issue_date[$i];
                        $certification->expiry_date= $request->expiry_date[$i];
                        $certification->image=$filename;
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
    public function deleteCertificate($id){
        $certification=Certification::where('id',$id)->first();
        $businessId=$certification->business_profile_id;
        $result=$certification->delete();
        if($result){
            $certifications = Certification::where('business_profile_id',$businessId)->get();
            return response()->json([
                'success' => true,
                'message' => 'Certification deleted successfully',
                'certifications'=>$certifications,
            ],200);
        }else{
            return response()->json([
                'success' => false,
                'message' => ' delete Certification',
            ],404);
        }

    }
}
