<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Certification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CertificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $collection=Certification::latest()->paginate(5);
        return view('admin.certification.index', compact('collection'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $collection=new Certification();
        return view('admin.certification.create',compact('collection'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'certification_programs' => 'required',
            'provider' => 'required',
            'nation' => 'required',
            'about' => 'required',
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg,JPEG,PNG,JPG,GIF,SVG|max:5120'
        ]);
        //logo upload
        $filename = $request->logo->store('images/certification_from_admin','public');
        // $image_resize = Image::make(public_path('storage/'.$filename));
        // $image_resize->fit(300, 300);
        // $image_resize->save(public_path('storage/'.$filename));
        $data=$request->only(['certification_programs','provider','nation','about',]);
        $data['logo']=$filename;
        Certification::create($data);
        return redirect()->route('admin.certification.index')->with('success', 'successfully created');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin\Certification  $certification
     * @return \Illuminate\Http\Response
     */
    public function show(Certification $certification)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin\Certification  $certification
     * @return \Illuminate\Http\Response
     */
    public function edit(Certification $certification)
    {
        return view('admin.certification.edit',['collection' => $certification]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin\Certification  $certification
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Certification $certification)
    {
        $request->validate([
            'certification_programs' => 'required',
            'provider' => 'required',
            'nation' => 'required',
            'about' => 'required',
            'logo' => 'image|mimes:jpeg,png,jpg,gif,svg,JPEG,PNG,JPG,GIF,SVG|max:5120'
        ]);

        $filename=$certification->logo;
        if($request->logo)
        {
            if(Storage::exists($certification->logo)){
                Storage::delete($certification->logo);
            }
            $filename = $request->logo->store('images/certification_from_admin','public');
        }

        $data=$request->only(['certification_programs','provider','nation','about',]);
        $data['logo']=$filename;
        $certification->update($data);
        return redirect()->route('admin.certification.index')->with('success', 'successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin\Certification  $certification
     * @return \Illuminate\Http\Response
     */
    public function destroy(Certification $certification)
    {
        //
    }
}
