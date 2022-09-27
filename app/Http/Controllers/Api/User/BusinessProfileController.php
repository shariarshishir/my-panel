<?php

namespace App\Http\Controllers\API\USER;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Manufacture\ProductCategory;
use App\Models\BusinessProfile;
use App\Models\CompanyOverview;
use App\Models\CategoriesProduced;
use App\Models\MachineriesDetail;
use App\Models\ProductionCapacity;
use App\Models\supplierQuotationToBuyer;
use App\Models\Product as WholesalerProduct;
use App\Models\Manufacture\Product;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use stdClass;
use App\Events\NewBusinessProfileHasCreatedEvent;

class BusinessProfileController extends Controller
{
        public function show($id){
            $businessProfile= BusinessProfile::with('companyOverview','machineriesDetails','categoriesProduceds','productionCapacities','productionFlowAndManpowers','certifications','mainbuyers','exportDestinations','associationMemberships','pressHighlights','businessTerms','samplings','specialCustomizations','sustainabilityCommitments','walfare','security')->findOrFail($id);

            if( $businessProfile){

                //company overview without json
                if($businessProfile->companyOverview){
                    $companyOverview = new stdClass();
                    $companyOverview->id=$businessProfile->companyOverview->id;
                    $companyOverview->data=json_decode($businessProfile->companyOverview->data);
                    $companyOverview->about_company=$businessProfile->companyOverview->about_company;
                    $companyOverview->address=$businessProfile->companyOverview->address;
                    $companyOverview->factory_address=$businessProfile->companyOverview->factory_address;
                    $companyOverview->terms_of_service=$businessProfile->companyOverview->terms_of_service;
                    $companyOverview->status=$businessProfile->companyOverview->status;
                }
                else{
                    $companyOverview=[];
                }

                //production flow and manpower without json
                if(count($businessProfile->productionFlowAndManpowers)>0){
                    $productionFlowAndManpowerArray = [];
                    foreach($businessProfile->productionFlowAndManpowers as $key => $productionFlowAndManpower){
                        $productionFlowAndManpowerObject = new stdClass();
                        $productionFlowAndManpowerObject->id =  $productionFlowAndManpower->id;
                        $productionFlowAndManpowerObject->business_profile_id = $productionFlowAndManpower->business_profile_id;
                        $productionFlowAndManpowerObject->production_type = $productionFlowAndManpower->production_type;
                        $productionFlowAndManpowerObject->flow_and_manpower = json_decode($productionFlowAndManpower->flow_and_manpower);
                        array_push($productionFlowAndManpowerArray,$productionFlowAndManpowerObject);
                    }
                }
                else{
                    $productionFlowAndManpowerArray=[];

                }


                //walfare and csr
                if($businessProfile->walfare){
                    $walfareObject = new stdClass();
                    $walfareObject->id= $businessProfile->walfare->id;
                    $walfareObject->walfare_and_csr=json_decode($businessProfile->walfare->walfare_and_csr);
                    $walfareObject->business_profile_id=$businessProfile->walfare->business_profile_id;
                }
                else{
                    $walfareObject=[];
                }

                //security and others
                if($businessProfile->security){
                    $securityObject = new stdClass();
                    $securityObject->id= $businessProfile->security->id;
                    $securityObject->security_and_others=json_decode($businessProfile->security->security_and_others);
                    $securityObject->business_profile_id=$businessProfile->security->business_profile_id;
                }
                else{
                    $securityObject=[];
                }
                return response()->json(["businessProfile"=>$businessProfile,"companyOverview"=>$companyOverview,"productionFlowAndManpower"=>$productionFlowAndManpowerArray,"walfare"=>$walfareObject,"security"=>$securityObject,"success"=>true],200);

            }
            else{
                return response()->json(["success"=>false],404);
            }
        }

        public function manufactureProductCategories(){
            $manufactureProductCategories = ProductCategory::with('subcategories')->get();
            if( count($manufactureProductCategories)>0){
                return response()->json(["productCategories"=>$manufactureProductCategories,"success"=>true],200);
            }
            else{
                return response()->json(["productCategories"=>$manufactureProductCategories,"success"=>false],204);
            }

        }

        public function manufactureProductCategoriesWithIcon(){
            $manufactureProductCategories = ProductCategory::with('subcategories')->get();
            $manufactureProductCategoriesArray = [];
            foreach($manufactureProductCategories as $key=>$manufactureProductCategory){
                $manufactureProductCategoryObject = new stdClass();
                $manufactureProductCategoryObject->id = $manufactureProductCategory->id;
                $manufactureProductCategoryObject->name = $manufactureProductCategory->name;
                $manufactureProductCategoryObject->icon = asset('images/frontendimages/manufacture_category_icon/'.$key.'.svg');
                array_push($manufactureProductCategoriesArray,$manufactureProductCategoryObject);
            }
            if( count($manufactureProductCategoriesArray)>0){
                return response()->json(["productCategories"=>$manufactureProductCategoriesArray,"success"=>true],200);
            }
            else{
                return response()->json(["productCategories"=>$manufactureProductCategoriesArray,"success"=>false],204);
            }

        }

        public function manufactureProductCategoriesByIndustryType(Request $request){
            $manufactureProductCategoriesByInduestryType=ProductCategory::with('subcategories')->where('industry',$request->industry)->get();
            if( count($manufactureProductCategoriesByInduestryType)>0){
                return response()->json(["productCategories"=>$manufactureProductCategoriesByInduestryType,"success"=>true],200);
            }
            else{
                return response()->json(["productCategories"=>$manufactureProductCategoriesByInduestryType,"success"=>false],204);
            }
        }

        //business profile list of auth user
        public function businessProfileList($id){
            //dd($request);
            $userObj = User::where('sso_reference_id', $id)->first();
            $businessProfiles = BusinessProfile::with('user','businessCategory')->where('user_id',$userObj['id'])->withTrashed()->get();
            if(count($businessProfiles)>0){
                $companyOverviewArray=[];
                foreach($businessProfiles as $businessProfile){
                    //company overview without json
                        if($businessProfile->companyOverview){
                            $companyOverview = new stdClass();
                            $companyOverview->id = $businessProfile->companyOverview->id;
                            $companyOverview->business_profile_id = $businessProfile->companyOverview->business_profile_id;
                            $companyOverview->data = json_decode($businessProfile->companyOverview->data);
                            $companyOverview->about_company = $businessProfile->companyOverview->about_company;
                            $companyOverview->address = $businessProfile->companyOverview->address;
                            $companyOverview->factory_address = $businessProfile->companyOverview->factory_address;
                            $companyOverview->status = $businessProfile->companyOverview->status;
                        }
                        else{
                            $companyOverview=[];
                        }
                        array_push($companyOverviewArray,$companyOverview);

                }
                return response()->json(["businessProfiles"=>$businessProfiles,"success"=>true,"companyOverviews"=>$companyOverviewArray],200);
            }
            else{
                $businessProfiles=[];
                return response()->json(["businessProfiles"=>$businessProfiles,"success"=>false],200);
            }
        }

        //All business profile list
        public function allBusinessProfile(){
            $allBusinessProfiles = BusinessProfile::with('user','businessCategory')->paginate(10);
            if(count($allBusinessProfiles)){
                return response()->json([
                    'success' => true,
                    'allBusinessProfiles'=>$allBusinessProfiles
                ],200);
            }
            else{
                return response()->json([
                    'success' => false,
                    'allBusinessProfiles'=>[]
                ],200);
            }
        }


        public function store(Request $request)
        {
            $validator = Validator::make($request->all(), [
                'business_name' => 'required',
                'location'      => 'required',
                'business_type' => 'required',
                'trade_license' => 'required',
                'industry_type' => 'required',
                'number_of_outlets' => Rule::requiredIf(function () use ($request) {
                    return $request->business_type == 2;
                }),
                'number_of_factories' => Rule::requiredIf(function () use ($request) {
                    return $request->business_type == 1;
                }),
                'email' => 'required_if:has_representative,0|unique:users',
                'phone' => 'required_if:has_representative,0',
                'nid_passport' => 'required_if:has_representative,0',
                'representive_name' =>'required_if:has_representative,0',
                'business_category_id' => 'required_if:business_type,1',

            ]);
            if($validator->fails()){
                return response()->json(array(
                'success' => false,
                'error' => $validator->getMessageBag()),
                400);
            }
            try{
                    $business_profile_data=[
                        'business_name' => $request->business_name,
                        'alias'   => $this->createAlias($request->business_name),
                        'user_id'       => auth()->user()->id,
                        'location'      => $request->location,
                        'business_type' => $request->business_type,
                        'has_representative'=> $request->has_representative,
                        'number_of_outlets' => $request->number_of_outlets,
                        'number_of_factories' => $request->number_of_factories,
                        'business_category_id' => $request->business_category_id,
                        'industry_type' => $request->industry_type,
                        'profile_type' =>'buyer',

                    ];

                    if($request->has_representative == true){
                        $business_profile=BusinessProfile::create($business_profile_data);
                        //create company overview
                        $companyOverview=$this->createCompanyOverview($request,$business_profile->id);
                        event(new NewBusinessProfileHasCreatedEvent($business_profile));
                        return response()->json([
                            'success' => true,
                            'business_profile'=>$business_profile,
                            'companyOverview'=>$companyOverview

                        ],201);
                    }
                    if($request->has_representative == false){
                        $representive_info=[
                            'name' => $request->representive_name,
                            'company'=>auth()->user()->company_name,
                            'email' => $request->email,
                            'phone' => $request->phone,
                            'password' =>'mb12345678',
                            'nid_passport' => $request->nid_passport,
                            'is_representative' => true,
                            'user_type'      => 'buyer',
                            'is_email_verified' => 1,
                        ];
                        $representive_data=[
                            'name' => $request->representive_name,
                            'email' => $request->email,
                            'phone' => $request->phone,
                            'password' =>'mb12345678',
                            'nid_passport' => $request->nid_passport,
                            'is_representative' => true,
                            'user_type'      => 'buyer',
                            'is_email_verified' => 1,
                        ];
                        // sso registration
                        if(env('APP_ENV') == 'production')
                        {
                            $sso=Http::post(env('SSO_URL').'/api/auth/signup/',$representive_info);
                            if(!$sso->successful()){
                                return response()->json([
                                    'success' => false,
                                    'error' => 'Internal Server Error',
                                ],500);
                            }
                        }

                        //user registraion as represetative
                        $representive_data['password'] =bcrypt($representive_data['password']);
                        $user_id = IdGenerator::generate(['table' => 'users', 'field' => 'user_id','reset_on_prefix_change' =>true,'length' => 18, 'prefix' => date('ymd').time()]);
                        $representive_data['user_id'] =$user_id;
                        $user=User::create($representive_data);

                        //profile create
                        $business_profile_data['representative_user_id']= $user->id;
                        $business_profile=BusinessProfile::create($business_profile_data);

                        //create company overview
                        $companyOverview=$this->createCompanyOverview($request,$business_profile->id);
                        event(new NewBusinessProfileHasCreatedEvent($business_profile));
                        $newCompanyOverview = new stdClass();
                        $newCompanyOverview->business_profile_id=$companyOverview->business_profile_id;
                        $newCompanyOverview->business_profile_id=json_decode($companyOverview->data);

                        return response()->json([
                            'success' => true,
                            'business_profile'=>$business_profile,
                            'companyOverview'=>$newCompanyOverview
                        ],201);
                    }

                }catch(\Exception $e){
                return response()->json([
                    'success' => false,
                    'error'   => ['msg' => $e->getMessage()],
                ],500);
                }
        }



        public function removeSpecialCharacterFromAlais($alias)
        {
            $lowercase=strtolower($alias);
            $pattern= '/[^A-Za-z0-9\-]/';
            $preg_replace= preg_replace($pattern, '-', $lowercase);
            $single_hypen= preg_replace('/-+/', '-', $preg_replace);
            $alias= $single_hypen;
            return $alias;
        }


        public function createAlias($name)
        {
            $alias=$this->removeSpecialCharacterFromAlais($name);
            return $this->checkExistsAlias($alias);
        }

        public function checkExistsAlias($alias)
        {
            $check_exists=BusinessProfile::where('alias', $alias)->first();
            if($check_exists){
                $create_array= explode('-',$alias);
                $last_key=array_slice($create_array,-1,1);
                $last_key_string=implode(' ',$last_key);
                if(is_numeric($last_key_string)){
                    $last_key_string++;
                    array_pop($create_array);
                    array_push($create_array,$last_key_string);
                }else{
                    array_push($create_array,1);
                }
                $alias=implode("-",$create_array);
                return $this->checkExistsAlias($alias);

            }

            return $alias;
        }

        //company overview data
        public function createCompanyOverview(Request $request, $profile_id)
        {
            $name=['annual_revenue','number_of_worker','number_of_female_worker','trade_license_number','year_of_establishment','opertaing_hours','shift_details','main_products'];
            $value=[null,null,null,$request->trade_license,null,null,null,null,null];
            $data=[];
            foreach($name as $key => $value2){
                array_push($data,['name' => $value2, 'value' => $value[$key], 'status' => 0]);
            }
            $companyOverview=CompanyOverview::create([
                'business_profile_id' => $profile_id,
                'data'        => json_encode($data),
            ]);
            return $companyOverview;

        }
        public function LowMOQProducts(Request $request)
        {
            //select('name','business_profile_id','product_type','moq','product_unit','sold','full_stock','full_stock_price','full_stock_negotiable')
            $wholesaler_products= WholesalerProduct::with(['images','businessProfile'])->where('moq','!=', null)->where(['state' => 1, 'sold' => 0,])->where('business_profile_id', '!=', null)->get(['id','name','moq','product_type','moq','product_unit','sold','full_stock','flag']);
            $manufacture_products=Product::with(['product_images','businessProfile'])->where('moq','!=', null)->where('business_profile_id', '!=', null)->get(['id','title','moq','price_per_unit','price_unit','moq','qty_unit','industry','lead_time','flag']);
            $merged = $wholesaler_products->merge($manufacture_products)->sortBy('moq');
            $sorted=$merged->sortBy('moq');
            $sorted_value= $sorted->values()->all();


            // $wholesaler_products=WholesalerProduct::with(['images','businessProfile'])->where('moq','!=', null)->where(['state' => 1, 'sold' => 0,])->where('business_profile_id', '!=', null)->get();
            // $manufacture_products=Product::with(['product_images','businessProfile'])->where('moq','!=', null)->where('business_profile_id', '!=', null)->get();
            // $merged = $wholesaler_products->merge($manufacture_products)->sortBy('moq');
            // $sorted=$merged->sortBy('moq');
            // $sorted_value= $sorted->values()->all();
            if(count($sorted_value)>0){
                return response()->json([
                    'success' => true,
                    'products'=>$sorted_value
                ],200);
            }
            else{
                return response()->json([
                    'success' => false,
                    'products'=>[]
                ],404);
            }

        }
        public function wholesalerLowMOQProducts(Request $request)
        {

            $products = WholesalerProduct::with(['images','businessProfile'])->where('moq','!=', null)->where(['state' => 1, 'sold' => 0,])->where('business_profile_id', '!=', null)->orderByDesc('moq')->paginate(10);

            $productsArray=[];
            if($products->total()>0){

                foreach($products as $product){

                    if($product->product_type==1 ){
                        foreach(json_decode($product->attribute) as $attribute){
                            $attribute_array[] = (object) array('quantity_min' =>$attribute[0], 'quantity_max' => $attribute[1],'price'=>$attribute[2],'lead_time'=>$attribute[3]);
                        }
                    }
                    else if($product->product_type==2){
                        foreach(json_decode($product->attribute) as $attribute){
                            $attribute_array[] = (object) array('ready_quantity_min' =>$attribute[0], 'ready_quantity_max' => $attribute[1],'ready_price'=>$attribute[2]);
                        }
                    }
                    else{
                        foreach(json_decode($product->attribute) as $attribute){
                            $attribute_array[] = (object) array('non_clothing_quantity_min' =>$attribute[0], 'non_clothing_quantity_max' => $attribute[1],'non_clothing_price'=>$attribute[2]);
                        }

                    }

                    $newFormatedProduct= new stdClass();
                    $newFormatedProduct->id=$product->id;
                    $newFormatedProduct->name=$product->name;
                    $newFormatedProduct->business_profile_id=$product->business_profile_id;
                    $newFormatedProduct->business_name=$product->businessProfile->business_name;
                    $newFormatedProduct->sku=$product->sku;
                    $newFormatedProduct->copyright_price=$product->copyright_price;
                    $newFormatedProduct->full_stock= $product->full_stock;
                    $newFormatedProduct->full_stock_price= $product->full_stock_price;
                    $newFormatedProduct->attribute=  $attribute_array;
                    $newFormatedProduct->colors_sizes=$product->product_type==1 ? [] :json_decode($product->colors_sizes);
                    $newFormatedProduct->product_category_id=$product->product_category_id;
                    $newFormatedProduct->product_type=$product->product_type;
                    $newFormatedProduct->moq=$product->moq;
                    $newFormatedProduct->product_unit=$product->product_unit;
                    $newFormatedProduct->is_new_arrival=$product->is_new_arrival;
                    $newFormatedProduct->is_featured=$product->is_featured;
                    $newFormatedProduct->description=$product->description;
                    $newFormatedProduct->state= $product->state;
                    $newFormatedProduct->sold= $product->sold;
                    $newFormatedProduct->additional_description=$product->additional_description;
                    $newFormatedProduct->availability=$product->availability;
                    $newFormatedProduct->productReview=$product->productReview;
                    $newFormatedProduct->productTotalAverageRating=productRating($product->id);
                    $newFormatedProduct->images=$product->images;
                    array_push($productsArray,$newFormatedProduct);
                    $attribute_array=[];

                }

                return response()->json([
                    'success' => true,
                    'products'=>$productsArray
                ],200);
            }
            else{
                return response()->json([
                    'success' => false,
                    'products'=>[]
                ],404);
            }

        }

        public function manufactureLowMOQProducts(Request $request)
        {
            $manufactureProducts=Product::with(['businessProfile','product_images'])->where('moq','!=', null)->where('business_profile_id', '!=', null)->orderByDesc('moq')->paginate(10);
            if(count($manufactureProducts)>0){
                return response()->json([
                    'success' => true,
                    'products'=>$manufactureProducts
                ],200);
            }
            else{
                return response()->json([
                    'success' => false,
                    'products'=>[]
                ],404);
            }

        }

        public function productsWithShortestLeadTime()
        {
            $products=Product::with('product_images','businessProfile')->where('lead_time','!=', null)->where('business_profile_id', '!=', null)->orderBy('lead_time')->paginate(20);
            if(count($products)>0){
                return response()->json([
                    'success' => true,
                    'products'=>$products
                ],200);
            }
            else{
                return response()->json([
                    'success' => false,
                    'products'=>[]
                ],200);
            }

        }


    public function profilePublishOrUnpublish(Request $request)
    {
        if($request->is_publish==false){
            $business_profile = BusinessProfile::where('id',$request->business_profile_id)->first();

        }
        else{
            $business_profile=BusinessProfile::onlyTrashed()
                ->where('id', $request->business_profile_id)
                ->first();
        }

        if(!$business_profile){
            return response()->json([
                'code' => false,
                'message'     => 'Profile not found'
            ],404);
        }
        $business_profile_rel_auth_id=[];
        array_push($business_profile_rel_auth_id, $business_profile->user_id,$business_profile->representative_user_id);

        if(!in_array(auth()->id(), $business_profile_rel_auth_id)){
            return response()->json([
                'code' => false,
                'message'     => 'You are not authorized'
            ],401);
        }

        if($request->is_publish==false){
            $business_profile->delete();
            return response()->json([
                'code' => true,
                'message'     => 'Business profile unpublished successfully.'
            ],200);

        }
        else{

            $business_profile->restore();
            return response()->json([
                'code' => true,
                'message'     => 'Business profile published successfully.'
            ],200);

        }
    }
       //Search suppliers by supplier name
       //suppliers
        public function searchSuppliersByBusinessName(Request $request)
        {
           if(!empty($request->search_input)) {
                $businessProfiles=BusinessProfile::with('user')->where('business_name', 'like', '%'.$request->search_input.'%')->paginate(10);
                if($businessProfiles->total()>0){
                    return response()->json(['suppliers' => $businessProfiles, 'message' => 'Store found','code'=>false], 200);
                }
                else{
                    return response()->json(['suppliers' => $businessProfiles, 'message' => 'Store not found','code'=>False], 200);
                }

            }
            else
            {
                $businessProfiles = [];
                return response()->json(['suppliers' =>$businessProfiles, 'message' => 'Search key is empty','code'=>False], 200);
            }
        }





        //suppliers
        public function filterSuppliers(Request $request)
        {
            $suppliers=BusinessProfile::with(['businessCategory', 'user', 'companyOverview'])->where(function($query) use ($request){

                if($request->industry_type){
                    $query->whereIn('industry_type',$request->industry_type)->get();
                }
                if($request->factory_type){
                    $query->whereHas('businessCategory', function ($sub_query) use ($request) {
                        $sub_query->where('id', $request->factory_type);
                    })->get();
                }
                if(isset($request->business_name)){
                    $query-> where('business_name', 'like', '%'.$request->business_name.'%')->get();
                }
                if(isset($request->location)){
                    $query-> where('location', 'like', '%'.$request->location.'%')->get();
                }
                if(isset($request->verified)){
                    $query-> whereIn('is_business_profile_verified', $request->verified)->get();
                }
                if(isset($request->standard)){
                    $target = array('compliance', 'non_compliance');
                    if(count(array_intersect($request->standard, $target)) == count($target)){
                        $query->get();
                    }else{

                        if(in_array('compliance', $request->standard)){
                            $query->has('certifications')->get();
                        }
                        if(in_array('non_compliance', $request->standard)){
                            $query->has('certifications', '<', 1)->get();
                        }
                    }


                }
            })
            ->orderBy('is_business_profile_verified', 'DESC')->paginate(12);
            return view('suppliers.index',compact('suppliers'));
        }

        public function supplierQuotationToBuyer(Request $request){
            //dd($request->all());
            $supplierQuotationToBuyer = new supplierQuotationToBuyer();
            $supplierQuotationToBuyer->rfq_id = $request->rfq_id;
            $supplierQuotationToBuyer->business_profile_id = $request->business_profile_id;
            $supplierQuotationToBuyer->offer_price = $request->offer_price;
            $supplierQuotationToBuyer->offer_price_unit = $request->offer_price_unit;
            $supplierQuotationToBuyer->from_backend = 0; // 0 means it come froms APP or Frontend
            $supplierQuotationToBuyer->save();

            return response()->json(["status" => 1, "message" => "successful"]);
        }







}
