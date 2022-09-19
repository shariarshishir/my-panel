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

        return view('designer.index', compact('user'));
        //return view('designers.index');
    }

    public function singleDesignerDetailsUpdate(Request $request)
    {
        //dd($request->all());

        $designerData = new Designers();
        $designerData->designer_location = $request->designer_location;
        $designerData->designer_nationality = $request->designer_nationality;
        $designerData->designer_experience = $request->designer_experience;
        $designerData->designer_worked_with = $request->designer_worked_with;
        $designerData->designer_completed_task = $request->designer_completed_task;
        $designerData->designer_skills = json_encode($request->designer_skills);
        $designerData->designer_asking_price = $request->designer_asking_price;
        $designerData->designer_certifications = json_encode($request->designer_certifications);
        $designerData->designer_about_me = $request->designer_about_me;
        $designerData->created_by = auth()->user()->id;
        $designerData->save();

        return redirect()->route('single.designer.details');

    }
}
