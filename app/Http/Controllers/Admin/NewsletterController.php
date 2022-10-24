<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use App\Models\Newsletter;

class NewsletterController extends Controller
{
    public function index()
    {
        $newsletters = Newsletter::latest()->get();
        return view('admin.newsletter.index',compact('newsletters'));
    }

    public function  create()
    {
        $newsletter = new Newsletter();
        return view('admin.newsletter.create',compact('newsletter'));
    }

    public function store(Request $request)
    {

        //dd($request->all());
        $allData = $request->except('_token');

        if ($request->hasFile('pdf_path')){
            $pdf = $request->file('pdf_path');
            $s3 = \Storage::disk('s3');
            $uniqueString = generateUniqueString();
            $pdf_file_name = uniqid().$uniqueString.'.'. $pdf->getClientOriginalExtension();
            $s3filePath = '/public/newsletters/' . $pdf_file_name;
            $s3->put($s3filePath, file_get_contents($pdf));
            $allData['pdf_path'] = 'newsletters/'.$pdf_file_name;
        }

        $allData['created_by'] = Auth::guard('admin')->user()->id;
        $newsletter = Newsletter::create($allData);

        return redirect()->route('newsletter.index');

    }

    public function  edit($id){
        //Session::flash('success','Blog post created successfully!!!!');
        Session::put('backUrl',  url()->previous());
        $newsletter = Newsletter::where('id',$id)->first();
        return view('admin.newsletter.edit',compact('newsletter'));
    }

    public function  show($id){
        $newsletter = Newsletter::where('id',$id)->first();
        return view('admin.newsletter.show',compact('newsletter'));
    }

    public function update(Request $request, $id)
    {
        $newsletter = Newsletter::where('id', $id)->first();
        $newsletter->title = $request->title;
        $newsletter->description = $request->description;

        if ($request->hasFile('pdf_path')){
            //dd($newsletter->pdf_path);
            //$newsletterPdf = explode("/", $newsletter->pdf_path);
            //Storage::delete($newsletterPdf[1]);
            Storage::disk('s3')->delete('/public/' . $newsletter->pdf_path);
            $pdf = $request->file('pdf_path');
            $s3 = \Storage::disk('s3');
            $uniqueString = generateUniqueString();
            $pdf_file_name = uniqid().$uniqueString.'.'. $pdf->getClientOriginalExtension();
            $s3filePath = '/public/newsletters/' . $pdf_file_name;
            $s3->put($s3filePath, file_get_contents($pdf));
            $newsletter->pdf_path = 'newsletters/'.$pdf_file_name;
        }

        $newsletter->updated_by = Auth::guard('admin')->user()->id;
        $newsletter->save();

        $url = Session::get('backUrl');
        //Session::flash('success','Blog post updated successfully!!!!');
        return redirect($url);
    }

    public function destroy($id)
    {
        dd($id);
        Newsletter::destroy($id);
        //Session::flash('success','Newsletter post deleted successfully!!!!');
        return redirect()->back();
    }
}
