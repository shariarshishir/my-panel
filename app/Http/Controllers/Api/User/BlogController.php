<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;

class BlogController extends Controller
{
    public function blogs(){

        $blogs=Blog::latest()->paginate(10);
        if( count($blogs)>0){
            return response()->json(["blogs"=>$blogs,"success"=>true],200);
        }
        else{
            return response()->json(["blogs"=>$blogs,"success"=>false],200);
        }

    }

    public function blogDetails($id)
    {
        $blog = Blog::where('id',$id)->firstOrFail();
        $data = [];
        $blogs = $blog->source;
        foreach((array)$blogs as $blo)
        {
            if(!is_null($blo['name']) && $blo['name'] != "")
            {
               $data[] = ['name' => $blo['name'],'link' => $blo['link']];
            }
        }

        $blog['sourcedata'] = $data;
        if( $blog ){
            return response()->json(["blog"=>$blog,"success"=>true],200);
        }
        else{
            return response()->json(["blog"=>$blog,"success"=>false],200);
        }
    }
}
