<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CompanyOverview;
use Illuminate\Http\Request;
use App\Models\CategoriesProduced;
use App\Models\MachineriesDetail;
use App\Models\ProductionCapacity;
use App\Models\BusinessTerm;
use App\Models\Sampling;
use App\Models\SpecialCustomization;
use App\Models\SustainabilityCommitment;
use App\Models\ProductionFlowAndManpower;
use App\Models\BusinessProfileVerification;
use App\Models\Walfare;
use App\Models\Security;
use App\Models\BusinessProfile;
use App\Models\BusinessProfileVerificationsRequest;
use Illuminate\Support\Facades\Auth;
use stdClass;
use DataTables;


class BusinessProfileController extends Controller
{


    public function index(Request $request,$type)
    {

        if ($request->ajax()) {
            switch ($type) {
                case 'manufacturer':
                    $type= 1;
                    break;
                case 'wholesaler':
                    $type= 2;
                    break;
                case 'design_studio':
                    $type= 3;
                    break;
            }
            $data=BusinessProfile::with(['user','representativeUser','businessCategory'])->withTrashed()->where('business_type', $type);
            return Datatables::of($data)
                    ->addIndexColumn()
                    // ->editColumn('email', function($row) {
                    //    $route= route('user.show', $row->id);
                    //    $action='<a href="'.$route.'">'.$row->email.'</a>';
                    //    return $action;
                    // })
                    // ->editColumn('created_at', function ($user) {
                    //     return \Carbon\Carbon::parse($user->created_at)->isoFormat('MMMM Do YYYY');
                    // })
                    // ->orderColumn('name', function ($query) {
                    //     $query->orderBy('created_at', 'desc');
                    // })
                    ->addColumn('category', function($row){
                        if($row->business_type == 1){
                            return $row->businessCategory->name ?? '';
                        }
                        return '';
                    })
                    ->addColumn('parent_user', function($row){
                        return $row->user->name;
                    })
                    ->addColumn('representative_name', function($row){
                       if($row->representativeUser){
                           return $row->representativeUser->name;
                       }
                       return '';
                    })
                    ->addColumn('representative_email', function($row){
                        if($row->representativeUser){
                            return $row->representativeUser->email;
                        }
                        return '';
                     })
                     ->addColumn('phone', function($row){
                        return $row->user->phone;
                     })
                     ->addColumn('badge', function($row){
                        return 'badge';
                     })
                     ->addColumn('action', function($row){
                        if($row->deleted_at){
                            $checked= '';
                            $status = 'block';
                        }else{
                            $checked= 'checked';
                            $status = 'active';
                        }
                        $button='<div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input selectRow" id="customSwitch1'.$row->id.'" '.$checked.' data-id="'.$row->id.'">
                        <label class="custom-control-label" for="customSwitch1'.$row->id.'">'.$status.'</label>
                        </div>';
                        return $button;
                     })
                     ->addColumn('push', function($row){
                        $route= route('admin.business.profile.details', $row->id);
                        $action='<a href="'.$route.'"><i class="fa fa-arrow-right"></i></a>';
                        return $action;
                     })
                     ->editColumn('business_name', function($row) {
                        $route= route('admin.business.profile.details', $row->id);
                        $action='<a href="'.$route.'">'.$row->business_name.'</a>';
                        return $action;
                    })
                    ->orderColumn('business_name', function ($query) {
                        $query->orderBy('created_at', 'desc');
                    })
                    ->rawColumns(['push','business_name','action'])
                    ->make(true);
        }
        return view('admin.business_profile.index', compact('type'));

    }

    public function businessProfileDetails($profile_id)
    {
        $business_profile=BusinessProfile::withTrashed()->where('id', $profile_id)->with('companyOverview','machineriesDetails','categoriesProduceds','productionCapacities','productionFlowAndManpowers','certifications','mainbuyers','exportDestinations','associationMemberships','pressHighlights','businessTerms','samplings','specialCustomizations','sustainabilityCommitments','walfare','security')->first();
        if(!$business_profile)
        {
            abort(404);
        }
        return view('admin.business_profile.business_profile_details', compact('business_profile'));
    }

    public function companyOverviewVarifie(Request $request,$company_overview_id)
    {
        $company_overview=CompanyOverview::findOrFail($company_overview_id);
        $data=[];
        foreach($request->name as $key => $value)
        {
            array_push($data,['name' => $key, 'value' => $value, 'status' => $request->status[$key]]);
        }
        $company_overview->update(['data' => $data]);

        $flag=0;
        foreach ($company_overview->data as $data){
            if($data['status']==1){
                $flag=1;
            }
            else{
                $flag=0;
                break;
            }
        }
        if($flag==1){

            $businessProfileVerification = BusinessProfileVerification::where('business_profile_id',$company_overview->business_profile_id)->first();
            if( $businessProfileVerification )
            {
                $businessProfileVerification->company_overview = 1;
                $businessProfileVerification->save();
            }
            else{
                $businessProfileVerification =new BusinessProfileVerification();
                $businessProfileVerification->business_profile_id = $company_overview->business_profile_id;
                $businessProfileVerification->company_overview = 1;
                $businessProfileVerification->save();
            }

        }
        else{
            $businessProfileVerification = BusinessProfileVerification::where('business_profile_id',$company_overview->business_profile_id)->first();
            if( $businessProfileVerification )
            {
                $businessProfileVerification->company_overview = 0;
                $businessProfileVerification->save();
            }
            else{
                $businessProfileVerification =new BusinessProfileVerification();
                $businessProfileVerification->business_profile_id = $company_overview->business_profile_id;
                $businessProfileVerification->company_overview = 0;
                $businessProfileVerification->save();
            }
        }

        return redirect()->back()->with('success', 'company overview updated');
    }
    /*public function capacityAndMachineriesInformationVerify(Request $request)
    {

        $machineriesDetails = MachineriesDetail::where('business_profile_id',$request->business_profile_id)->delete();
        $categoriesProduceds = CategoriesProduced::where('business_profile_id',$request->business_profile_id)->delete();
        // $productionCapacities = ProductionCapacity::where('business_profile_id',$request->business_profile_id)->delete();
        // if(isset($request->machine_type)){
        //     $noOfMachineType=count($request->machine_type);
        //     if($noOfMachineType>0){
        //         for($i=0;$i<$noOfMachineType ;$i++){
        //             $productionCapacity  =  new ProductionCapacity();
        //             $productionCapacity->machine_type = $request->machine_type[$i];
        //             $productionCapacity->annual_capacity = $request->annual_capacity[$i];
        //             $productionCapacity->business_profile_id = $request->business_profile_id;
        //             $productionCapacity->status = $request->production_capacity_status[$i];
        //             $productionCapacity->save();
        //         }
        //     }
        // }



        if(isset($request->type)){
            $noOftype=count($request->type);
            if($noOftype>0){
                for($i=0;$i<$noOftype; $i++){
                    $categoriesProduced  =  new CategoriesProduced();
                    $categoriesProduced->type = $request->type[$i];
                    $categoriesProduced->percentage = $request->percentage[$i];
                    $categoriesProduced->business_profile_id = $request->business_profile_id;
                    $categoriesProduced->status = $request->categories_produced_status[$i];
                    $categoriesProduced->save();
                }
            }

        }

        if(isset($request->machine_name)){
            $noOfMachineName=count($request->machine_name);
            if($noOfMachineName>0){
                for($i=0; $i<$noOfMachineName ;$i++){

                    $machineriesDetail   =  new MachineriesDetail();
                    $machineriesDetail->machine_name = $request->machine_name[$i];
                    $machineriesDetail->quantity = $request->quantity[$i];
                    $machineriesDetail->business_profile_id = $request->business_profile_id;
                    $machineriesDetail->status = $request->machineries_detail_status[$i];
                    $machineriesDetail->save();
                }

            }
        }

        $machineriesDetails = MachineriesDetail::where('business_profile_id',$request->business_profile_id)->get();
        $categoriesProduceds = CategoriesProduced::where('business_profile_id',$request->business_profile_id)->get();
        // $productionCapacities = ProductionCapacity::where('business_profile_id',$request->business_profile_id)->get();
        $machineriesDetailsVerified = 0;

        foreach($machineriesDetails as $machineriesDetail){
            if($machineriesDetail->status == 1){
                $machineriesDetailsVerified = 1;
            }
            else{
                $machineriesDetailsVerified = 0;
                break;
            }

        }


        $categoriesProducedsVerified = 0;
        foreach($categoriesProduceds as $categoriesProduceds){
            if($categoriesProduceds->status == 1){
                $categoriesProducedsVerified = 1;
            }
            else{
                $categoriesProducedsVerified = 0;
                break;
            }

        }

        // $productionCapacitiesVerified = 0;
        // foreach($productionCapacities as $productionCapacity){
        //     if($productionCapacity->status == 1){
        //         $productionCapacitiesVerified=1;
        //     }
        //     else{
        //         $productionCapacitiesVerified = 0;

        //     }

        // }
        if($machineriesDetailsVerified == 1){
            $businessProfileVerification = BusinessProfileVerification::where('business_profile_id',$request->business_profile_id)->first();
            if( $businessProfileVerification ){
                $businessProfileVerification->machinery_details = 1;
                $businessProfileVerification->save();
            }
            else{
                $businessProfileVerification =new BusinessProfileVerification();
                $businessProfileVerification->business_profile_id = $request->business_profile_id;
                $businessProfileVerification->machinery_details = 1;
                $businessProfileVerification->save();
            }
        }
        if( $categoriesProducedsVerified == 1){
                $businessProfileVerification = BusinessProfileVerification::where('business_profile_id',$request->business_profile_id)->first();
                if( $businessProfileVerification ){
                    $businessProfileVerification->categories_produced = 1;
                    $businessProfileVerification->save();
                }
                else{
                    $businessProfileVerification =new BusinessProfileVerification();
                    $businessProfileVerification->business_profile_id = $request->business_profile_id;
                    $businessProfileVerification->categories_produced = 1;
                    $businessProfileVerification->save();
                }

            }
        return redirect()->back()->with('success', 'capacity and machineries information  updated');
    }*/

    public function ctegoriesProducedInformationVerify(Request $request)
    {

        foreach($request->categories_produced_id as $id){
            $categoriesProduceds = CategoriesProduced::where('id',$id)->update(['status' => $request->categories_produced_status[$id]]);
        }

        $categoriesProduceds = CategoriesProduced::where('business_profile_id',$request->business_profile_id)->get();

        $categoriesProducedsVerified = 0;
        foreach($categoriesProduceds as $categoriesProduceds){
            if($categoriesProduceds->status == 1){
                $categoriesProducedsVerified = 1;
            }
            else{
                $categoriesProducedsVerified = 0;
                break;
            }

        }

        if( $categoriesProducedsVerified == 1){
                $businessProfileVerification = BusinessProfileVerification::where('business_profile_id',$request->business_profile_id)->first();
                if( $businessProfileVerification ){
                    $businessProfileVerification->categories_produced = 1;
                    $businessProfileVerification->save();
                }
                else{
                    $businessProfileVerification =new BusinessProfileVerification();
                    $businessProfileVerification->business_profile_id = $request->business_profile_id;
                    $businessProfileVerification->categories_produced = 1;
                    $businessProfileVerification->save();
                }

            }
        return redirect()->back()->with('success', 'Categories Produceds information  updated');
    }

    public function machinariesDetailsInformationVerify(Request $request)
    {
        foreach($request->machineries_detail_id as $id){
            $machineriesDetails = MachineriesDetail::where('id',$id)->update(['status' => $request->machineries_detail_status[$id]]);
        }

        $machineriesDetails = MachineriesDetail::where('business_profile_id',$request->business_profile_id)->get();
        $machineriesDetailsVerified = 0;

        foreach($machineriesDetails as $machineriesDetail){
            if($machineriesDetail->status == 1){
                $machineriesDetailsVerified = 1;
            }
            else{
                $machineriesDetailsVerified = 0;
                break;
            }

        }


        if($machineriesDetailsVerified == 1){
            $businessProfileVerification = BusinessProfileVerification::where('business_profile_id',$request->business_profile_id)->first();
            if( $businessProfileVerification ){
                $businessProfileVerification->machinery_details = 1;
                $businessProfileVerification->save();
            }
            else{
                $businessProfileVerification =new BusinessProfileVerification();
                $businessProfileVerification->business_profile_id = $request->business_profile_id;
                $businessProfileVerification->machinery_details = 1;
                $businessProfileVerification->save();
            }
        }

        return redirect()->back()->with('success', 'Machineries details information  updated');
    }


    public function businessTermsInformationVerify(Request $request)
    {

        $result = BusinessTerm::where('business_profile_id',$request->business_profile_id)->delete();
        if(isset($request->business_term_title)){
            $noOfBusinessTermTitle=count($request->business_term_title);
            if($noOfBusinessTermTitle>0){
                for($i=0;$i<$noOfBusinessTermTitle ;$i++){
                    $businessTerm  =  new BusinessTerm();
                    $businessTerm->title = $request->business_term_title[$i];
                    $businessTerm->quantity = $request->business_term_quantity[$i];
                    $businessTerm->business_profile_id = $request->business_profile_id;
                    $businessTerm->status = $request->business_term_status[$i];
                    $businessTerm->save();
                }
            }
        }

        $businessTerms = BusinessTerm::where('business_profile_id',$request->business_profile_id)->get();

        $flag = 0;
        foreach($businessTerms as $businessTerm){
            if($businessTerm->status == 1){
                $flag = 1;

            }
            else{
                $flag = 0;
                break;
            }
        }

        if($flag==1){
            $businessProfileVerification = BusinessProfileVerification::where('business_profile_id',$request->business_profile_id)->first();
            if( $businessProfileVerification ){
                $businessProfileVerification->business_terms = 1;
                $businessProfileVerification->save();
            }
            else{
                $businessProfileVerification =new BusinessProfileVerification();
                $businessProfileVerification->business_profile_id = $request->business_profile_id;
                $businessProfileVerification->business_terms = 1;
                $businessProfileVerification->save();
            }
        }
        else{
            $businessProfileVerification = BusinessProfileVerification::where('business_profile_id',$request->business_profile_id)->first();
            if( $businessProfileVerification ){
                $businessProfileVerification->business_terms = 0;
                $businessProfileVerification->save();
            }
            else{
                $businessProfileVerification =new BusinessProfileVerification();
                $businessProfileVerification->business_profile_id = $request->business_profile_id;
                $businessProfileVerification->business_terms = 0;
                $businessProfileVerification->save();
            }
        }
        return redirect()->back()->with('success', 'BusinessTerm information  updated');
    }

    public function samplingsInformationVerify(Request $request)
    {

        $result = Sampling::where('business_profile_id',$request->business_profile_id)->delete();
        if(isset($request->sampling_title)){
            $noOfSamplingTitle=count($request->sampling_title);
            if($noOfSamplingTitle>0){
                for($i=0;$i<$noOfSamplingTitle ;$i++){
                    $sampling  =  new Sampling();
                    $sampling->title = $request->sampling_title[$i];
                    $sampling->quantity = $request->sampling_quantity[$i];
                    $sampling->business_profile_id = $request->business_profile_id;
                    $sampling->status = $request->sampling_status[$i];
                    $sampling->save();
                }
            }
            $samplings = Sampling::where('business_profile_id',$request->business_profile_id)->get();
            $flag = 0;
            foreach($samplings as $sampling){
                if($sampling->status == 1){
                    $flag = 1;

                }
                else{
                    $flag = 0;
                    break;
                }
            }
            if($flag==1){
                $businessProfileVerification = BusinessProfileVerification::where('business_profile_id',$request->business_profile_id)->first();
                if( $businessProfileVerification ){
                    $businessProfileVerification->sampling = 1;
                    $businessProfileVerification->save();
                }
                else{
                    $businessProfileVerification =new BusinessProfileVerification();
                    $businessProfileVerification->business_profile_id = $request->business_profile_id;
                    $businessProfileVerification->sampling = 1;
                    $businessProfileVerification->save();
                }

            }
            else{
                $businessProfileVerification = BusinessProfileVerification::where('business_profile_id',$request->business_profile_id)->first();
                if( $businessProfileVerification ){
                    $businessProfileVerification->sampling = 0;
                    $businessProfileVerification->save();
                }
                else{
                    $businessProfileVerification =new BusinessProfileVerification();
                    $businessProfileVerification->business_profile_id = $request->business_profile_id;
                    $businessProfileVerification->sampling = 0;
                    $businessProfileVerification->save();
                }
            }
        }

        $samplings = Sampling::where('business_profile_id',$request->business_profile_id)->get();
        return redirect()->back()->with('success', 'Sampling information  updated');
    }


    public function specialCustomizationInformationVerify(Request $request)
    {

        $result = SpecialCustomization::where('business_profile_id',$request->business_profile_id)->delete();
        if(isset($request->special_customization_title)){
            $noOfSpecialCustomizationTitle=count($request->special_customization_title);
            if($noOfSpecialCustomizationTitle>0){
                for($i=0;$i<$noOfSpecialCustomizationTitle ;$i++){
                    $specialCustomization  =  new SpecialCustomization();
                    $specialCustomization->title = $request->special_customization_title[$i];
                    $specialCustomization->business_profile_id = $request->business_profile_id;
                    $specialCustomization->status =$request->special_customization_status[$i];
                    $specialCustomization->save();
                }
            }
        }
        $specialCustomizations = SpecialCustomization::where('business_profile_id',$request->business_profile_id)->get();
        $flag = 0;
        foreach($specialCustomizations as $specialCustomization){
            if($specialCustomization->status == 1){
                $flag = 1;

            }
            else{
                $flag = 0;
                break;
            }
        }
        if($flag==1){
            $businessProfileVerification = BusinessProfileVerification::where('business_profile_id',$request->business_profile_id)->first();
            if( $businessProfileVerification ){
                $businessProfileVerification->special_customizations = 1;
                $businessProfileVerification->save();
            }
            else{
                $businessProfileVerification =new BusinessProfileVerification();
                $businessProfileVerification->business_profile_id = $request->business_profile_id;
                $businessProfileVerification->special_customizations = 1;
                $businessProfileVerification->save();
            }

        }
        else{
            $businessProfileVerification = BusinessProfileVerification::where('business_profile_id',$request->business_profile_id)->first();
            if( $businessProfileVerification ){
                $businessProfileVerification->special_customizations = 0;
                $businessProfileVerification->save();
            }
            else{
                $businessProfileVerification =new BusinessProfileVerification();
                $businessProfileVerification->business_profile_id = $request->business_profile_id;
                $businessProfileVerification->special_customizations = 0;
                $businessProfileVerification->save();
            }
        }
        return redirect()->back()->with('success', 'Special Customization information  updated');
    }

    public function sustainabilityCommitmentsInformationVerify(Request $request)
    {

        $result = SustainabilityCommitment::where('business_profile_id',$request->business_profile_id)->delete();
        if(isset($request->sustainability_commitment_title)){
            $noOfSustainabilityCommitmentTitle=count($request->sustainability_commitment_title);
            if($noOfSustainabilityCommitmentTitle>0){
                for($i=0;$i<$noOfSustainabilityCommitmentTitle ;$i++){
                    $sustainabilityCommitment  =  new SustainabilityCommitment();
                    $sustainabilityCommitment->title = $request->sustainability_commitment_title[$i];
                    $sustainabilityCommitment->business_profile_id = $request->business_profile_id;
                    $sustainabilityCommitment->status = $request->sustainability_commitment_status[$i];
                    $sustainabilityCommitment->save();
                }
            }
        }

        $sustainabilityCommitments = SustainabilityCommitment::where('business_profile_id',$request->business_profile_id)->get();

        $flag = 0;
        foreach($sustainabilityCommitments as $sustainabilityCommitment){
            if($sustainabilityCommitment->status == 1){
                $flag  = 1;

            }
            else{
                $flag = 0;
                break;
            }
        }


        if($flag == 1){
            $businessProfileVerification = BusinessProfileVerification::where('business_profile_id',$request->business_profile_id)->first();
            if( $businessProfileVerification ){
                $businessProfileVerification->sustainability_commitments = 1;
                $businessProfileVerification->save();
            }
            else{
                $businessProfileVerification =new BusinessProfileVerification();
                $businessProfileVerification->business_profile_id = $request->business_profile_id;
                $businessProfileVerification->sustainability_commitments = 1;
                $businessProfileVerification->save();
            }

        }
        else{
            $businessProfileVerification = BusinessProfileVerification::where('business_profile_id',$request->business_profile_id)->first();
            if( $businessProfileVerification ){
                $businessProfileVerification->sustainability_commitments = 0;
                $businessProfileVerification->save();
            }
            else{
                $businessProfileVerification =new BusinessProfileVerification();
                $businessProfileVerification->business_profile_id = $request->business_profile_id;
                $businessProfileVerification->sustainability_commitments = 0;
                $businessProfileVerification->save();
            }
        }
        return redirect()->back()->with('success', 'Special Customization information  updated');
    }


    public function productionflowAndManpowerInformationVerify(Request $request){

        $productionFlowAndManpowers = ProductionFlowAndManpower::where('business_profile_id',$request->business_profile_id)->delete();
        if(isset($request->production_type)){
            if(count($request->production_type)>0){

                for($i=0; $i < count($request->production_type); $i++){


                    //jacquardMachines object
                    $jacquardMachinesStatusArray=[];
                    foreach($request->no_of_jacquard_machines_status as $key=>$status){
                            array_push($jacquardMachinesStatusArray,$status);
                    }
                    $jacquardMachines = new stdClass();
                    $jacquardMachines->name='No of Machines';
                    foreach($jacquardMachinesStatusArray as $key=>$status){
                        if($key==$i){
                            $jacquardMachines->status=$status;
                        }
                    }
                    $jacquardMachines->value=$request->no_of_jacquard_machines[$i];



                    //manpower object
                    $manpowerStatusArray=[];
                    foreach($request->manpower_status as $key=>$status){
                            array_push($manpowerStatusArray,$status);
                    }
                    $manpower = new stdClass();
                    $manpower->name='Manpower';
                    $manpower->value=$request->manpower[$i];
                    foreach($manpowerStatusArray as $key=>$status){
                        if($key==$i){
                            $manpower->status=$status;
                        }
                    }

                    //daily Capacity object
                    $dailyCapacityStatusArray=[];
                    foreach($request->daily_capacity_status as $key=>$status){
                            array_push($dailyCapacityStatusArray,$status);
                    }
                    $dailyCapacity = new stdClass();
                    $dailyCapacity->name='Capacity Daily';
                    $dailyCapacity->value=$request->daily_capacity[$i];
                    foreach($dailyCapacityStatusArray as $key=>$status){
                        if($key==$i){
                            $dailyCapacity->status=$status;
                        }
                    }

                    //push all object into array
                    $flowAndManpowerArray=[];
                    array_push($flowAndManpowerArray,$jacquardMachines,$manpower,$dailyCapacity);

                    $productionFlowAndManpower=new ProductionFlowAndManpower;
                    $productionFlowAndManpower->production_type=$request->production_type[$i];
                    $productionFlowAndManpower->flow_and_manpower=json_encode($flowAndManpowerArray);
                    $productionFlowAndManpower->business_profile_id = $request->business_profile_id;
                    $productionFlowAndManpower->save();
                }

                //set verification status
                $productionFlowAndManpowers = ProductionFlowAndManpower::where('business_profile_id',$request->business_profile_id)->get();
                $flag = 0 ;
                foreach($productionFlowAndManpowers as $productionFlowAndManpower){

                    foreach(json_decode($productionFlowAndManpower->flow_and_manpower) as $flow_and_manpower){

                        if($flow_and_manpower->status == "1"){
                            $flag = 1;
                        }
                        else{
                            $flag = 0;
                            break;
                        }
                    }
                }

                if($flag==1){
                    $businessProfileVerification = BusinessProfileVerification::where('business_profile_id',$request->business_profile_id)->first();
                    if( $businessProfileVerification ){
                        $businessProfileVerification->production_capacity = 1;
                        $businessProfileVerification->save();
                    }
                    else{
                        $businessProfileVerification =new BusinessProfileVerification();
                        $businessProfileVerification->business_profile_id = $request->business_profile_id;
                        $businessProfileVerification->production_capacity = 1;
                        $businessProfileVerification->save();
                    }
                }
                else{
                    $businessProfileVerification = BusinessProfileVerification::where('business_profile_id',$request->business_profile_id)->first();
                    if( $businessProfileVerification ){
                        $businessProfileVerification->production_capacity = 0;
                        $businessProfileVerification->save();
                    }
                    else{
                        $businessProfileVerification =new BusinessProfileVerification();
                        $businessProfileVerification->business_profile_id = $request->business_profile_id;
                        $businessProfileVerification->production_capacity = 0;
                        $businessProfileVerification->save();
                    }
                }

            }
        }

        $productionFlowAndManpowers = ProductionFlowAndManpower::where('business_profile_id',$request->business_profile_id)->get();
        return redirect()->back()->with('success', 'ProductionFlow And Manpower information  updated');
    }

    public function walfareInformationVerify(Request $request){
        $walfare = Walfare::where('business_profile_id',$request->business_profile_id)->delete();

            $walfareArray=[];
            $healthcareFacility = new stdClass();
            $healthcareFacility->name='healthcare_facility';
            $healthcareFacility->checked=$request->healthcare_facility;
            $healthcareFacility->status=$request->healthcare_facility_status;

            $dayCare = new stdClass();
            $dayCare->name='day_care';
            $dayCare->checked=$request->day_care;
            $dayCare->status=$request->day_care_status;

            $doctor = new stdClass();
            $doctor->name='doctor';
            $doctor->checked=$request->doctor_work;
            $doctor->status=$request->doctor_status;

            $maternityLeave = new stdClass();
            $maternityLeave->name='maternity_leave';
            $maternityLeave->checked=$request->maternity_leave;
            $maternityLeave->status=$request->maternity_leave_status;

            $playground = new stdClass();
            $playground->name='playground';
            $playground->checked=$request->playground;
            $playground->status=$request->playground_status;

            $socialWork = new stdClass();
            $socialWork->name='social_work';
            $socialWork->checked=$request->social_work;
            $socialWork->status=$request->social_work_status;

            array_push($walfareArray,$healthcareFacility,$dayCare,$doctor,$maternityLeave,$playground,$socialWork);

            $walfare = new Walfare();
            $walfare->walfare_and_csr=json_encode($walfareArray);
            $walfare->business_profile_id = $request->business_profile_id;
            $walfare->save();

            $walfare = Walfare::where('business_profile_id',$request->business_profile_id)->first();
            return redirect()->back()->with('success', 'Worker walfare information  updated');
    }

    public function securityInformationVerify(Request $request){

        $security = Security::where('business_profile_id',$request->business_profile_id)->delete();

        $securityArray=[];
        $fireExit = new stdClass();
        $fireExit->name='fire_exit';
        $fireExit->checked=$request->fire_exit;
        $fireExit->status=$request->fire_exit_status;

        $fireHydrant = new stdClass();
        $fireHydrant->name='fire_hydrant';
        $fireHydrant->checked=$request->fire_hydrant;
        $fireHydrant->status=$request->fire_hydrant_status;

        $waterSource = new stdClass();
        $waterSource->name='water_source';
        $waterSource->checked=$request->water_source;
        $waterSource->status=$request->water_source_status;

        $protocols = new stdClass();
        $protocols->name='protocols';
        $protocols->checked=$request->protocols;
        $protocols->status=$request->water_source_status;

        array_push($securityArray,$fireExit,$fireHydrant,$waterSource,$protocols);

        $security = new Security();
        $security->security_and_others=json_encode($securityArray);
        $security->business_profile_id = $request->business_profile_id;
        $security->save();

        $security = Security::where('business_profile_id',$request->business_profile_id)->first();
        return redirect()->back()->with('success', 'Worker walfare information  updated');
    }

    public function verifyBusinessProfile(Request $request) {
        //dd($request->all());

        // start update company overview table data and company_overview column in business_profile_verifications table
        if($request->verifyVal == 1)
        {
            $company_overview = CompanyOverview::findOrFail($request->companyId);
            $company_overview_data = json_decode($company_overview->data);
            $data=[];
            foreach($company_overview_data as $value)
            {
                array_push($data,['name' => $value->name, 'value' => $value->value, 'status' => "1"]);
            }
            $company_overview->update(['data' => $data]);

            $businessProfileVerification = BusinessProfileVerification::where('business_profile_id',$company_overview->business_profile_id)->first();
            if( $businessProfileVerification )
            {
                $businessProfileVerification->company_overview = 1;
                $businessProfileVerification->save();
            }
            else{
                $businessProfileVerification =new BusinessProfileVerification();
                $businessProfileVerification->business_profile_id = $company_overview->business_profile_id;
                $businessProfileVerification->company_overview = 1;
                $businessProfileVerification->save();
            }
            $deleteVerificationRequest = BusinessProfileVerificationsRequest::where('business_profile_id', $company_overview->business_profile_id)->delete();
        }
        else
        {
            $company_overview = CompanyOverview::findOrFail($request->companyId);
            $company_overview_data = json_decode($company_overview->data);
            $data=[];
            foreach($company_overview_data as $value)
            {
                array_push($data,['name' => $value->name, 'value' => $value->value, 'status' => "0"]);
            }
            $company_overview->update(['data' => $data]);

            $businessProfileVerification = BusinessProfileVerification::where('business_profile_id',$company_overview->business_profile_id)->first();
            if( $businessProfileVerification )
            {
                $businessProfileVerification->company_overview = 0;
                $businessProfileVerification->save();
            }
            else{
                $businessProfileVerification =new BusinessProfileVerification();
                $businessProfileVerification->business_profile_id = $company_overview->business_profile_id;
                $businessProfileVerification->company_overview = 0;
                $businessProfileVerification->save();
            }
        }
        // end update company overview table data and company_overview column in business_profile_verifications table

        $businessProfile = BusinessProfile::where("id", $request->profileId)->first();
        $businessProfile->is_business_profile_verified = $request->verifyVal;
        $businessProfile->profile_verified_by_admin = Auth::guard('admin')->user()->id ;
        $businessProfile->save();

        return response()->json(["status"=>1, "message"=>"verified successfully"]);
    }

    public function showBusinessProfileVerificationRequest()
    {
        auth()->guard('admin')->user()->unreadNotifications->where('type','App\Notifications\NewBusinessProfileVerificationRequestNotification')->where('read_at',null)->markAsRead();

        $businessProfileVerificationsRequest = BusinessProfileVerificationsRequest::latest()->paginate(10);

        return view('admin.business_profile_verification_request.index',compact('businessProfileVerificationsRequest'));
    }

    public function spotlightBusinessProfile(Request $request) {
        //dd($request->all());

        if($request->spotlightVal == 1)
        {
            $businessProfile = BusinessProfile::where("id", $request->profileId)->first();
            $businessProfile->is_spotlight = 0;
            $businessProfile->save();
        }
        else
        {
            $businessProfile = BusinessProfile::where("id", $request->profileId)->first();
            $businessProfile->is_spotlight = 1;
            $businessProfile->save();
        }

        return response()->json(["status"=>1, "message"=>"successful"]);
    }
}
