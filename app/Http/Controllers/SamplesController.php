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
use App\Models\Samples;
use App\Models\Product;
use App\Models\Manufacture\Product as ManufactureProduct;
use Illuminate\Pagination\Paginator;
use stdClass;

class SamplesController extends Controller
{
    public function samples(Request $request)
    {
        $samples = Samples::where("created_by", auth()->user()->id)->get();
        $page_param = "mycollection";
        return view('samples.index', compact('samples', 'page_param'));
    }

    public function mbCollection()
    {
        $product_type_mapping_id = 1;
        $product_type_mapping_child_id = 3;

        $wholesaler_products = Product::with(['images','businessProfile'])->where('product_type_mapping_id', $product_type_mapping_id)->where(['state' => 1])->where('business_profile_id', '!=', null)->get();
        $manufacture_products = ManufactureProduct::with(['product_images','businessProfile'])->where('product_type_mapping_id', $product_type_mapping_id)->where('business_profile_id', '!=', null)->get();
        $merged = $wholesaler_products->mergeRecursive($manufacture_products)->sortBy([ ['priority_level', 'asc'], ['created_at', 'desc'] ])->values();

        $merged_products = $merged->filter(function($item) use ($product_type_mapping_child_id) {
            $result = array_intersect($item->product_type_mapping_child_id,(array)$product_type_mapping_child_id);
            if(count($result) > 0){
                return true;
            }
        });
        //dd($design_products);

        $page = Paginator::resolveCurrentPage() ?: 1;
        $perPage = 32;
        $design_products = new \Illuminate\Pagination\LengthAwarePaginator(
            $merged_products->forPage($page, $perPage),
            $merged_products->count(),
            $perPage,
            $page,
            ['path' => Paginator::resolveCurrentPath()],
        );

        $page_param = "mbcollection";
        return view('samples.index', compact('page_param', 'design_products'));
    }

    public function store(Request $request)
    {
        //dd($request->all());

        $user = User::where("id", auth()->user()->id)->first();

        $sampleImgs = [];
        if(isset($request->product_images)) {
            foreach ($request->product_images as $sample_image) {
                $s3 = \Storage::disk('s3');
                $uniqueString = generateUniqueString();
                $sample_image_file_name = uniqid().$uniqueString.'.'. $sample_image->getClientOriginalExtension();
                $s3filePath = '/public/sample_images'.'/'. $user->id . '/' .$sample_image_file_name;
                $s3->put($s3filePath, file_get_contents($sample_image));
                array_push($sampleImgs, $sample_image_file_name);
            }
        }

        $sampleData = new Samples();
        $sampleData->supplier_name = $request->supplier_name;
        $sampleData->supplier_email = $request->supplier_email;
        $sampleData->product_title = $request->product_title;
        $sampleData->product_tags = json_encode($request->product_tags);
        $sampleData->product_images = json_encode($sampleImgs);
        $sampleData->details = $request->details;
        $sampleData->created_by = auth()->user()->id;
        $sampleData->save();

        return response()->json(["status" => 1, "message" => "Data updated successfully."]);
    }
}
