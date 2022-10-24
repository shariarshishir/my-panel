<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use File;
use Illuminate\Support\Facades\Storage;
use App\Models\BusinessProfile;

class TinyMcController extends Controller
{
     // tinymc file upload

     public function tinyMcFileUpload(Request $request)
     {
        if($request->hasFile('tiny_mc_file')){
            $file = $request->hasFile('tiny_mc_file');
            //file original name
            $originalFileName=$request->file('tiny_mc_file')->getClientOriginalName();
            $business_profile=BusinessProfile::where('id', $request->business_profile_id)->first();
            $business_profile_name=$business_profile->business_name;
            $s3 = \Storage::disk('s3');
            $uniqueStringForFile = generateUniqueString();
            $tiny_mc_file_unique_name = uniqid().$uniqueStringForFile.'.'.$request->file('tiny_mc_file')->getClientOriginalExtension();
            $s3TinymceFilePath='temp/'.$business_profile_name.'/pdf/';
            //temprary file full path in s3 
            $s3TinymceFullFilePath = '/public/'.$s3TinymceFilePath.'/'.$tiny_mc_file_unique_name;
            //store tinymce file into temp folder
            $s3->put($s3TinymceFullFilePath, file_get_contents($request->file('tiny_mc_file')));
            //tinymce file final path after product upload
            $finalPath = Storage::disk('s3')->url('public/images/'.$business_profile_name.'/pdf'.'/'.$tiny_mc_file_unique_name);
            
            return response()->json(['fileName' => $finalPath, 'originalFileName' => $originalFileName], 200);


        }
     }

     //tinymc untracked file deleted
     public function tinyMcUntrackedFileDelete($business_profile_id)
     {
        $business_profile=BusinessProfile::where('id', $business_profile_id)->first();
        $business_profile_name=$business_profile->business_name;
        $files = Storage::disk('s3')->allFiles('/public/temp/'.$business_profile_name.'/pdf/');
        // if($files){
        //     foreach($files as $file){
        //         $file = str_replace('public/temp/','',$file);
        //         Storage::disk('s3')->delete($file);
        //     }
        //     return response()->json(['msg' => 'success'], 200);
        // }
        return response()->json(['msg' => 'not exists'], 200);

     }

}
