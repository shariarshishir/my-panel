<?php

namespace App\Http\Controllers\Admin;
use DataTables;
use Carbon\Carbon;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\RelatedProduct;
use App\Models\BusinessProfile;
use App\Models\ProductCategory;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use App\Models\Manufacture\Product as ManufactureProduct;
use App\Models\Manufacture\ProductCategory as ManufactureProductCategory;

class ProductController extends Controller
{

    public function index(Request $request)
    {
        $wholesaler_products=Product::with(['images','businessProfile'])->where('business_profile_id', '!=', null)->withTrashed()->get();
        $manufacture_products=ManufactureProduct::with(['product_images','businessProfile'])->where('business_profile_id', '!=', null)->withTrashed()->get();
        $merged = $wholesaler_products->mergeRecursive($manufacture_products)->sortByDesc('created_at')->values();

        if(isset($request->product_name)){
            $search=$request->product_name;
            $merged = $merged->filter(function($item) use ($search) {
                if($item->flag == 'mb'){
                    return stripos($item['title'],$search) !== false;
                }
                return stripos($item['name'],$search) !== false;
            });
        }

        if(isset($request->product_category)){
            $merged = $merged->where('flag', 'shop')->where('product_category_id', $request->product_category);
            $merged->all();
        }
        if(isset($request->factory_category)){
            $merged = $merged->where('flag', 'mb')->where('product_category', $request->factory_category);
            $merged->all();
        }
        if(isset($request->status)){
            $merged2=$merged;
            if($request->status == true){
                $manufacture = $merged->where('flag', 'mb')->where('deleted_at', null);
            }else{
                $manufacture = $merged->where('flag', 'mb')->whereNotNull('deleted_at');
            }
            $wholesaler = $merged2->where('flag', 'shop')->where('state', $request->status);

            $merged=$wholesaler->merge($manufacture);

        }
        if(isset($request->business_profile)){
            $merged = $merged->where('business_profile_id', $request->business_profile);
            $merged->all();
        }

        if(isset($request->priority)){
            $merged = $merged->where('priority_level', $request->priority);
            $merged->all();
        }

        if(isset($request->datefilter)){
            $datefilter=explode('-', $request->datefilter);
            $start_date = Carbon::parse($datefilter[0])->format('d/m/Y');
            $end_date = Carbon::parse($datefilter[1]) ->format('d/m/Y');

            $start_date = Carbon::createFromFormat('d/m/Y', $start_date);
            $end_date = Carbon::createFromFormat('d/m/Y', $end_date);

            $merged = $merged->whereBetween('created_at', [$start_date, $end_date]);
            $merged->all();
        }


        $page = Paginator::resolveCurrentPage() ?: 1;
        $perPage = 12;
        $products = new \Illuminate\Pagination\LengthAwarePaginator(
            $merged->forPage($page, $perPage),
            $merged->count(),
            $perPage,
            $page,
            ['path' => Paginator::resolveCurrentPath()],
        );

        $product_category=ProductCategory::get();
        $factory_category=ManufactureProductCategory::get();
        $business_profile= BusinessProfile::pluck('business_name','id');

        return view('admin.products.index', compact('products','product_category','factory_category','business_profile'));
    }

    public function show($flag, $id)
    {
        if($flag == 'shop'){
            $product=Product::with(['category', 'images', 'video'])->withTrashed()->findOrFail($id);
            $related_products=Product::where('business_profile_id',$product->business_profile_id)->pluck('name','id');
            $related_products_id=RelatedProduct::withTrashed()->where('business_profile_id',$product->business_profile_id)->where('product_id',$product->id)->pluck('related_product_id')->toArray();
            return view('admin.products.show', compact('product','related_products','related_products_id'));
        }else{
            $product=ManufactureProduct::with(['category', 'product_video'])->withTrashed()->findOrFail($id);
            return view('admin.products.show', compact('product'));
        }


    }

    public function changePriorityLevel($flag, $id)
    {
        if($flag == 'shop'){
            $product=Product::findOrFail($id);

        }else{
            $product=ManufactureProduct::findOrFail($id);
        }

        $product->update(['priority_level' => request()->input('priority_level')]);
        return redirect()->back()->withSuccess('Priority level change successfully');
    }


}
