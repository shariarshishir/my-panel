<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Designers;
use stdClass;

class DesignersController extends Controller
{
    public function designers(Request $request)
    {
        $users = User::where("user_type", "designer")->get();

        return view('designers.index', compact('users'));
    }

    public function singleDesignerDetails(Request $request)
    {
        $user = User::where("id", $request->id)->first();
        $designer = Designers::where("user_id", $request->id)->first();
        $preloaded_image = [];

        if($designer) {
            $page_mode = 1;
            if(isset($designer->designer_certifications))
            {
                $i = 0;
                foreach(json_decode($designer->designer_certifications) as $key =>  $image) {
                    $obj[$key] = new stdClass;
                    $obj[$key]->id = $i;
                    $obj[$key]->src = Storage::disk('s3')->url('public/designers/'.auth()->user()->id.'/certificates/'.$image);
                    $preloaded_image[] = $obj[$key];
                    $i++;
                }
            }
        } else {
            $page_mode = 0;
        }

        return view('designer.index', compact('user', 'designer', 'page_mode', 'preloaded_image'));
    }

    public function singleDesignerDetailsUpdate(Request $request)
    {
        //dd($request->all());

        if($request->page_mode == 0)
        {
            // upload certificate images to s3
            $certificateImg = [];
            if(isset($request->designer_certifications)) {
                foreach ($request->designer_certifications as $designer_certificate) {
                    $s3 = \Storage::disk('s3');
                    $uniqueString = generateUniqueString();
                    $certificate_images_file_name = uniqid().$uniqueString.'.'. $designer_certificate->getClientOriginalExtension();
                    $s3filePath = '/public/designers'.'/'. auth()->user()->id .'/certificates'. '/' .$certificate_images_file_name;
                    $s3->put($s3filePath, file_get_contents($designer_certificate));
                    array_push($certificateImg, $certificate_images_file_name);
                }
            }

            $designerData = new Designers();
            $designerData->user_id = auth()->user()->id;
            $designerData->designer_location = $request->designer_location;
            $designerData->designer_nationality = $request->designer_nationality;
            $designerData->designer_experience = $request->designer_experience;
            $designerData->designer_worked_with = $request->designer_worked_with;
            $designerData->designer_completed_task = $request->designer_completed_task;
            $designerData->designer_skills = json_encode($request->designer_skills) ?? NULL;
            $designerData->designer_asking_price = $request->designer_asking_price;
            $designerData->designer_certifications = json_encode($certificateImg);
            $designerData->designer_about_me = $request->designer_about_me;
            $designerData->created_by = auth()->user()->id;
            $designerData->save();

        }
        else
        {
            $designerData = Designers::where('user_id', $request->designer_id)->first();

            // delete certificate images from s3
            if(isset($designerData->designer_certifications))
            {
                foreach(json_decode($designerData->designer_certifications) as $certificateImg)
                {
                    Storage::disk('s3')->delete('/public/designers/'.auth()->user()->id.'/certificates'.'/'. $certificateImg);
                }
                $designerData->update([ 'designer_certifications'=> [] ]);
            }

            // upload certificate images to s3
            $certificateImg = [];
            if(isset($request->designer_certifications))
            {
                $designerData->update([ 'designer_certifications'=> [] ]);
                foreach ($request->designer_certifications as $designer_certificate)
                {
                    $s3 = \Storage::disk('s3');
                    $uniqueString = generateUniqueString();
                    $certificate_images_file_name = uniqid().$uniqueString.'.'. $designer_certificate->getClientOriginalExtension();
                    $s3filePath = '/public/designers'.'/'. auth()->user()->id .'/certificates'. '/' .$certificate_images_file_name;
                    $s3->put($s3filePath, file_get_contents($designer_certificate));
                    array_push($certificateImg, $certificate_images_file_name);
                }
            }
            $designerData->update([
                'designer_location'=> $request->designer_location,
                'designer_nationality'=> $request->designer_nationality,
                'designer_experience'=> $request->designer_experience,
                'designer_worked_with'=> $request->designer_worked_with,
                'designer_completed_task'=> $request->designer_completed_task,
                'designer_skills'=> json_encode($request->designer_skills) ?? NULL,
                'designer_asking_price'=> $request->designer_asking_price,
                'designer_certifications'=> json_encode($certificateImg),
                'designer_about_me'=> $request->designer_about_me,
                'updated_by'=> auth()->user()->id,
            ]);
        }

        return response()->json(["status" => 1, "message" => "Data updated successfully."]);

        // return redirect()->route('single.designer.details', auth()->user()->id);

    }
}
