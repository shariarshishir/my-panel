<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\Config;


class ConfigController extends Controller
{
    public function __construct()
    {
      $this->middleware('is.admin');
    }
    public function configDashboard()
    {
        $config=Config::first();
        $configArray=[];
        $configArray[0]="frontend";

        if($config){
            return redirect()->route('edit.configuration',$config->id);
        }
        else{
            return view('admin.config.create',compact( 'configArray'));
        }

    }
    public function storeConfigurationInformation(Request $request)
    {
        $config=new Config();
        $config->config_data=json_encode($request->config);
        $config->save();
        $config=Config::latest()->first();
        return redirect()->route('edit.configuration',$config->id);
    }

    public function editConfigurationInformation($id)
    {
        $config=Config::where('id',$id)->first();
        $configArray=[];
        foreach( json_decode($config->config_data) as $key=>$data){
           array_push($configArray,$data);

        }
        $config=json_decode($config);
        return view('admin.config.edit',compact('config','configArray'));
    }


    public function updateConfigurationInformation(Request $request,$id)
    {
        $collection=[];
        foreach($request->config as $key => $list){
            $collection[$key] = $list;
        }

        $config=Config::where('id',$id)->first();
        $config->config_data=json_encode($collection);
        $config->save();

        $config=Config::latest()->first();
        return redirect()->route('edit.configuration',$config->id);
    }


}
