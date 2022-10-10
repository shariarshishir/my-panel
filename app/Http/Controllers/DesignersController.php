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
use App\Models\DesignerPortfolio;
use stdClass;

class DesignersController extends Controller
{
    public function designers(Request $request)
    {
        $users = User::with(['designers','designerPortfolio'])->where("user_type", "designer")->get();
        return view('designers.index', compact('users'));
    }

    public function singleDesignerDetails(Request $request)
    {
        $user = User::with(['designers', 'designerPortfolio'])->where("id", $request->id)->first();
        $preloaded_image = [];
        $portfolio_preloader_image = [];
        //dd($user);
        if($user->designers)
        {
            $page_mode = 1;
            if(isset($user->designers->designer_certifications))
            {
                $i = 0;
                foreach(json_decode($user->designers->designer_certifications) as $key =>  $image) {
                    $obj[$key] = new stdClass;
                    $obj[$key]->id = $i;
                    $obj[$key]->src = Storage::disk('s3')->url('public/designers/'.$user->id.'/certificates/'.$image);
                    $preloaded_image[] = $obj[$key];
                    $i++;
                }
            }

            if(isset($user->designerPortfolio))
            {
                foreach($user->designerPortfolio as $key => $item)
                {
                    $obj[$key] = new stdClass;
                    $obj[$key]->id = $item['id'];
                    $obj[$key]->src = Storage::disk('s3')->url('public/designers/'.$user->id.'/portfolio/'.$item['image']);
                    $portfolio_preloader_image[] = $obj[$key];
                }
            }

        }
        else
        {
            $page_mode = 0;
        }

        return view('designer.index', compact('user', 'page_mode', 'preloaded_image', 'portfolio_preloader_image'));
    }

    public function singleDesignerDetailsUpdate(Request $request)
    {
        //dd($request->all());

        $user = User::with(['designers', 'designerPortfolio'])->where("id", $request->user_id)->first();

        if($request->page_mode == 0)
        {
            // upload certificate images to s3
            $certificateImg = [];
            if(isset($request->designer_certifications)) {
                foreach ($request->designer_certifications as $designer_certificate) {
                    $s3 = \Storage::disk('s3');
                    $uniqueString = generateUniqueString();
                    $certificate_images_file_name = uniqid().$uniqueString.'.'. $designer_certificate->getClientOriginalExtension();
                    $s3filePath = '/public/designers'.'/'. $user->id .'/certificates'. '/' .$certificate_images_file_name;
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
            $designerData = Designers::where('user_id', $request->user_id)->first();

            // delete certificate images from s3
            if(isset($designerData->designer_certifications))
            {
                foreach(json_decode($designerData->designer_certifications) as $certificateImg)
                {
                    Storage::disk('s3')->delete('/public/designers/'.$user->id.'/certificates'.'/'. $certificateImg);
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
                    $s3filePath = '/public/designers'.'/'. $user->id .'/certificates'. '/' .$certificate_images_file_name;
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

    public function singleDesignerPortfolioDetailsUpdate(Request $request)
    {
        // dd($request->all());
        $user = User::with(['designers', 'designerPortfolio'])->where("id", $request->user_id)->first();
        if($request->page_mode == 0)
        {
            $portfolioImg = [];
            if(isset($request->designer_portfolio)) {
                foreach ($request->designer_portfolio as $designer_portfolio) {
                    $s3 = \Storage::disk('s3');
                    $uniqueString = generateUniqueString();
                    $portfolio_images_file_name = uniqid().$uniqueString.'.'. $designer_portfolio->getClientOriginalExtension();
                    $s3filePath = '/public/designers'.'/'. $user->id .'/portfolio'. '/' .$portfolio_images_file_name;
                    $s3->put($s3filePath, file_get_contents($designer_portfolio));
                    array_push($portfolioImg, $portfolio_images_file_name);

                    $portfolio_image = DesignerPortfolio::create([
                        'user_id' => auth()->user()->id,
                        'image' => $portfolio_images_file_name,
                        'created_by' => auth()->user()->id,
                    ]);
                }
            }
        }
        else
        {
            $designerPortfolio = DesignerPortfolio::where('user_id', $request->user_id)->get();

            // delete certificate images from s3
            // if(count($designerPortfolio) > 0)
            // {
            //     foreach($designerPortfolio as $portfolioImg)
            //     {
            //         Storage::disk('s3')->delete('/public/designers/'.$user->id.'/portfolio'.'/'. $portfolioImg['image']);
            //     }
            //     $designerPortfolio = DesignerPortfolio::where('user_id', $request->user_id)->delete();
            // }

            // check preloader and delete portfolio images from s3
            if(isset($request->preloaded))
            {
                $designerPortfolioItems = DesignerPortfolio::where('user_id', $request->user_id)->whereNotIn('id', $request->preloaded)->get();
            }
            else
            {
                $designerPortfolioItems = DesignerPortfolio::where('user_id', $request->user_id)->get();
            }

            if($designerPortfolioItems->isNotEmpty())
            {
                foreach($designerPortfolioItems as $item)
                {
                    Storage::disk('s3')->delete('/public/designers/'.$user->id.'/portfolio'.'/'. $item['image']);
                    $item->delete();
                }
            }

            $portfolioImg = [];
            if(isset($request->designer_portfolio)) {
                foreach ($request->designer_portfolio as $designer_portfolio) {
                    $s3 = \Storage::disk('s3');
                    $uniqueString = generateUniqueString();
                    $portfolio_images_file_name = uniqid().$uniqueString.'.'. $designer_portfolio->getClientOriginalExtension();
                    $s3filePath = '/public/designers'.'/'. $user->id .'/portfolio'. '/' .$portfolio_images_file_name;
                    $s3->put($s3filePath, file_get_contents($designer_portfolio));
                    array_push($portfolioImg, $portfolio_images_file_name);

                    $portfolio_image = DesignerPortfolio::create([
                        'user_id' => auth()->user()->id,
                        'image' => $portfolio_images_file_name,
                        'created_by' => auth()->user()->id,
                    ]);
                }
            }
        }

        return response()->json(["status" => 1, "message" => "Data updated successfully."]);

    }
}
