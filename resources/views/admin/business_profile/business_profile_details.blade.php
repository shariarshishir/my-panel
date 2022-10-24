@extends('layouts.admin')
@section('css')
<style>
    .card {
        display: block;
    }
</style>
@endsection
@section('content')


<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Business Profile </li>
            </ol>
            </div>
        </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
           <div class="row">
                <div class="orders_box">
                    <a class="btn_green" href="{{route('business.profile.orders.index', $business_profile->id)}}">Orders <span>({{count($business_profile->wholesalerOrders)}})</span></a>
                </div>
                <div class="col-md-12 admin_business_profile_details">
                    <div class="card">
                        <legend>Business Profile Details</legend>
                        <div class="show_on_spot_light">
                            @if($business_profile->is_spotlight == 1)
                            <input type="checkbox" name="is_spotlight" value="{{ $business_profile->is_spotlight ? 1 : 0 }}" class="checkbox-spotlight" data-businessprofileid="{{$business_profile->id}}" checked="checked" />
                            @else
                            <input type="checkbox" name="is_spotlight" value="{{ $business_profile->is_spotlight ? 1 : 0 }}" class="checkbox-spotlight" data-businessprofileid="{{$business_profile->id}}" />
                            @endif
                            Show on spotlight
                        </div>

                        <div id="company_overview">
                            <label>Company Overview</label>
                            <form action="{{route('company.overview.varifie', $business_profile->companyOverview->id)}}" method="post">
                                @csrf
                                <div class="no_more_tables">
                                    <table class="table">
                                        <thead class="cf">
                                            <tr>
                                                <th>Name</th>
                                                <th>Value</th>
                                                <th class="text-center">Status</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach (json_decode($business_profile->companyOverview->data) as $company_overview)
                                                <tr>
                                                    <td data-title="Name">{{str_replace('_', ' ', ucfirst($company_overview->name))}}</td>
                                                    <td data-title="Value" class="{{$company_overview->name}}_value order_value">{{$company_overview->value}}
                                                        <input type="hidden" name="name[{{$company_overview->name}}]" value="{{$company_overview->value}}">
                                                    </td>
                                                    <td data-title="Status" class="{{$company_overview->name}}_status text-center">
                                                        <label class="radio-inline">
                                                            <input type="radio" name="status[{{$company_overview->name}}]" value="1" {{ $company_overview->status == true ? 'checked' : '' }}>
                                                            <span>Verified</span>
                                                        </label>
                                                        <label class="radio-inline">
                                                            <input type="radio" name="status[{{$company_overview->name}}]" value="0" {{ $company_overview->status == false ? 'checked' : '' }}>
                                                            <span>Unverified</span>
                                                        </label>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="submitBox">
                                    <button type="submit" class="btn_green btn-success">Submit</button>
                                </div>
                            </form>
                        </div>

                        @if($business_profile->business_type == 1)
                        <div class="capacity-and-machineries">
                            {{-- <legend>Capacity and machineries</legend> --}}
                            {{-- <form action="{{route('capacity.machineries.verify')}}" method="post"> --}}
                                {{-- @csrf
                                <input type="hidden" name="business_profile_id" value="{{$business_profile->id}}"> --}}
                                <!-- <div clas="row production-capacity">
                                    <label>Production Capacity (Annual)</label>
                                    <br>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Machine Type</th>
                                                <th>Annual Capacity</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @if(count($business_profile->productionCapacities)>0)
                                                @foreach($business_profile->productionCapacities as $key1=> $productionCapacity)
                                                <tr>
                                                    <td><input readonly  name="machine_type[]" id="machine_type" type="text" class="form-control "  value="{{$productionCapacity->machine_type}}" ></td>
                                                    <td><input readonly  name="annual_capacity[]" id="annual_capacity" type="number" class="form-control "  value="{{$productionCapacity->annual_capacity}}" ></td>
                                                    <td>
                                                        <label class="radio-inline">
                                                            <input type="radio" name="production_capacity_status[{{$key1}}]" {{ $productionCapacity->status == 1 ? 'checked' : '' }} value="1">verified
                                                        </label>
                                                        <label class="radio-inline">
                                                            <input type="radio" name="production_capacity_status[{{$key1}}]" {{ $productionCapacity->status == 0 ? 'checked' : '' }} value="0">unverified
                                                        </label>
                                                    </td>
                                                </tr>
                                                @endforeach
                                                @else
                                                <tr id="production-capacity-table-no-data">
                                                    <td><p>INFO : No data found.</p></td>
                                                </tr>
                                                @endif
                                        </tbody>
                                    </table>
                                </div> -->
                            <form action="{{route('ctegories.produced.verify')}}" method="post">
                                @csrf
                                <input type="hidden" name="business_profile_id" value="{{$business_profile->id}}">
                                <div class="categories-produced">
                                    <label>Categories Produced</label>
                                    <div class="no_more_tables">
                                        <table class="categories-produced-table-block table">
                                            <thead class="cf">
                                                <tr>
                                                    <th>Type</th>
                                                    <th>Percentage</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(count($business_profile->categoriesProduceds)>0)
                                                    @foreach($business_profile->categoriesProduceds as $key2=>$categoriesProduced)
                                                        <tr>
                                                            <input type="hidden" name="categories_produced_id[]" value="{{$categoriesProduced->id}}">
                                                            <td data-title="Type"><input readOnly name="type[]" id="type" type="text" class="form-control "  value="{{$categoriesProduced->type}}" ></td>
                                                            <td data-title="Percentage"><input readOnly name="percentage[]" id="percentage" type="number" class="form-control "  value="{{$categoriesProduced->percentage}}" ></td>
                                                            <td data-title="Status">
                                                                <label class="radio-inline">
                                                                    <input type="radio" name="categories_produced_status[{{$categoriesProduced->id}}]" value="1" {{ $categoriesProduced->status == 1 ? 'checked' : '' }}>verified
                                                                </label>
                                                                <label class="radio-inline">
                                                                    <input type="radio" name="categories_produced_status[{{$categoriesProduced->id}}]" value="0" {{ $categoriesProduced->status == 0 ? 'checked' : '' }}>unverified
                                                                </label>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                <tr id="categories-produced-table-no-data">
                                                    <td class="no_data_td">
                                                        <p>INFO : No data found.</p>
                                                    </td>
                                                </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>

                                </div>

                                <div class="submitBox">
                                    <button type="submit" class="btn_green btn-success">Submit</button>
                                </div>
                            </form>

                            <form action="{{route('machinaries.details.verify')}}" method="post">
                                @csrf
                                <input type="hidden" name="business_profile_id" value="{{$business_profile->id}}">
                                <div class="machinaries-details">
                                    <label>Machinaries Details</label>

                                    <div class="no_more_tables">
                                        <table class="machinaries-details-table-block table">
                                            <thead class="cf">
                                                <tr>
                                                    <th>Machine Name</th>
                                                    <th>Quantity</th>
                                                    <th>&nbsp;</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(count($business_profile->machineriesDetails)>0)
                                                @foreach($business_profile->machineriesDetails as $key3=>$machineriesDetail)
                                                <tr>
                                                    <input type="hidden" name="machineries_detail_id[]" value="{{$machineriesDetail->id}}">
                                                    <td data-title="Machine Name"><input readOnly name="machine_name[]" id="machine_name" type="text" class="form-control "  value="{{$machineriesDetail->machine_name}}" ></td>
                                                    <td data-title="Quantity"><input readOnly name="quantity[]" id="quantity" type="number" class="form-control "  value="{{$machineriesDetail->quantity}}" ></td>
                                                    <td data-title="Status">
                                                        <label class="radio-inline">
                                                            <input type="radio" name="machineries_detail_status[{{$machineriesDetail->id}}]" value="1" {{ $machineriesDetail->status == 1 ? 'checked' : '' }}>verified
                                                        </label>
                                                        <label class="radio-inline">
                                                            <input type="radio" name="machineries_detail_status[{{$machineriesDetail->id}}]" value="0" {{ $machineriesDetail->status == 0 ? 'checked' : '' }}>unverified
                                                        </label>
                                                    </td>
                                                </tr>
                                                @endforeach
                                                @else
                                                <tr id="machinaries-details-table-no-data">
                                                    <td class="no_data_td">
                                                        <p>INFO : No data found.</p>
                                                    </td>
                                                </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="submitBox">
                                    <button type="submit" class="btn_green btn-success">Submit</button>
                                </div>

                            </form>
                        <div>

                        <div class="production-flow-and-manpower">
                            <form  method="POST" action="{{route('productionflow.manpower.verify')}}" id="production-flow-and-manpower-form">
                                @csrf
                                <input type="hidden" name="business_profile_id" value="{{$business_profile->id}}">
                                <legend>Production Flow and Manpower</legend>
                                <div class="no_more_tables">
                                    <tbody>
                                        @if(count($business_profile->productionFlowAndManpowers)>0)
                                            @foreach($business_profile->productionFlowAndManpowers as $productionFlowAndManpower)
                                            <tr>
                                                <td data-title="Production Type">
                                                    {{$productionFlowAndManpower->production_type}} </td>
                                                    <input  name="production_type[]" id="production_type" type="hidden"   value="{{$productionFlowAndManpower->production_type}}" >
                                                </th>
                                                <td>
                                                    <table class="table">
                                                        @foreach(json_decode($productionFlowAndManpower->flow_and_manpower) as $key=>$flowAndManpower)
                                                        <tr>
                                                            @if($flowAndManpower->name=='No of Machines')
                                                            <td data-title="Name">{{$flowAndManpower->name}}</td>
                                                            <td data-title="Value">{{$flowAndManpower->value}}</td>
                                                            <td data-title="No. of Jacquard machines"><input  name="no_of_jacquard_machines[]" id="no_of_jacquard_machines" type="hidden" class="form-control "  value="{{$flowAndManpower->value}}"></td>
                                                            <td data-title="Status">
                                                                <label class="radio-inline">
                                                                    <input type="radio" name="no_of_jacquard_machines_status[{{$productionFlowAndManpower->id}}]" value="1" {{ $flowAndManpower->status == 1 ? 'checked' : '' }}>verified
                                                                </label>
                                                                <label class="radio-inline">
                                                                    <input type="radio" name="no_of_jacquard_machines_status[{{$productionFlowAndManpower->id}}]" value="0" {{ $flowAndManpower->status == 0 ? 'checked' : '' }}>unverified
                                                                </label>
                                                            </td>
                                                            @endif
                                                            @if($flowAndManpower->name=='Manpower')
                                                            <td data-title="Name">{{$flowAndManpower->name}}</td>
                                                            <td data-title="Value">{{$flowAndManpower->value}}</td>
                                                            <td data-title="Manpower"><input  name="manpower[]" id="manpower" type="hidden"  value="{{$flowAndManpower->value}}"></td>
                                                            <td data-title="Status">
                                                                <label class="radio-inline">
                                                                    <input type="radio" name="manpower_status[{{$productionFlowAndManpower->id}}]" value="1" {{ $flowAndManpower->status == 1 ? 'checked' : '' }}>verified
                                                                </label>
                                                                <label class="radio-inline">
                                                                    <input type="radio" name="manpower_status[{{$productionFlowAndManpower->id}}]" value="0" {{ $flowAndManpower->status == 0 ? 'checked' : '' }}>unverified
                                                                </label>
                                                            </td>
                                                            @endif
                                                            @if($flowAndManpower->name=='Capacity Daily')
                                                            <td data-title="Name">{{$flowAndManpower->name}}</td>
                                                            <td data-title="Value">{{$flowAndManpower->value}}</td>
                                                            <td data-title="Daily Capacity"><input  name="daily_capacity[]" id="daily-capacity" type="hidden"  value="{{$flowAndManpower->value}}"></td>
                                                            <td data-title="Status">
                                                                <label class="radio-inline">
                                                                    <input type="radio" name="daily_capacity_status[{{$productionFlowAndManpower->id}}]" value="1" {{ $flowAndManpower->status == 1 ? 'checked' : '' }}>verified
                                                                </label>
                                                                <label class="radio-inline">
                                                                    <input type="radio" name="daily_capacity_status[{{$productionFlowAndManpower->id}}]" value="0" {{ $flowAndManpower->status == 0 ? 'checked' : '' }}>unverified
                                                                </label>
                                                            </td>
                                                            @endif
                                                        </tr>
                                                        @endforeach
                                                    </table>
                                                </td>
                                            </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td class="no_data_td">
                                                    <div class="card-alert cyan lighten-5">
                                                        <div class="card-content cyan-text">
                                                            <p>INFO : No data found.</p>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </div>
                                <div class="submitBox">
                                    <button class="btn_green btn-success" type="submit">Submit</button>
                                </div>
                            </form>
                        </div>

                        <div class="business-terms">
                            <form action="{{route('business.terms.verify')}}" method="post">
                                @csrf
                                <input type="hidden" name="business_profile_id" value="{{$business_profile->id}}">
                                <legend>Bsuiness terms</legend>

                                <div class="no_more_tables">
                                    <table class="business-terms-table-block table">
                                        <thead class="cf">
                                            <tr>
                                                <th>Machine Name</th>
                                                <th>Quantity</th>
                                                <th>&nbsp;</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @if(count($business_profile->businessTerms)>0)
                                            @foreach($business_profile->businessTerms as $key4 => $businessTerm)
                                            <tr>

                                                <td data-title="Machine Name"><input readOnly name="business_term_title[]" id="business-term-title" type="text" class="form-control "  value="{{$businessTerm->title}}" ></td>
                                                <td data-title="Quantity"><input readOnly name="business_term_quantity[]" id="business-term-quantity" type="number" class="form-control "  value="{{$businessTerm->quantity}}" ></td>
                                                <td>
                                                    <label class="radio-inline">
                                                        <input type="radio" name="business_term_status[{{$key4}}]" value="1" {{ $businessTerm->status == 1 ? 'checked' : '' }}>verified
                                                    </label>
                                                    <label class="radio-inline">
                                                        <input type="radio" name="business_term_status[{{$key4}}]" value="0" {{ $businessTerm->status == 0 ? 'checked' : '' }}>unverified
                                                    </label>
                                                </td>
                                            </tr>
                                            @endforeach
                                            @else
                                            <tr id="business-terms-details-table-no-data">
                                                <td class="no_data_td">
                                                    <p>INFO : No data found.</p>
                                                </td>
                                            </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                <div class="submitBox">
                                    <button type="submit" class="btn_green btn-success">Submit</button>
                                </div>

                            </form>
                        <div>

                        <div class="samplings">
                            <form action="{{route('samplings.verify')}}" method="post">
                                @csrf
                                <input type="hidden" name="business_profile_id" value="{{$business_profile->id}}">
                                <legend>Sampling and R&D</legend>
                                <div class="no_more_tables">
                                    <table class="samplings-table-block table">
                                        <thead class="cf">
                                            <tr>
                                                <th> Name</th>
                                                <th>Quantity</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        @if(count($business_profile->samplings)>0)
                                        @foreach($business_profile->samplings as $key5=>$sampling)
                                            <tr>

                                                <td data-title="Name"><input readOnly name="sampling_title[]" id="sampling-title" type="text" class="form-control "  value="{{$sampling->title}}" ></td>
                                                <td data-title="Quantity"><input readOnly name="sampling_quantity[]" id="sampling-quantity" type="number" class="form-control "  value="{{$sampling->quantity}}" ></td>
                                                <td data-title="Status">
                                                    <label class="radio-inline">
                                                        <input type="radio" name="sampling_status[{{$key5}}]" value="1" {{ $sampling->status == 1 ? 'checked' : '' }}>verified
                                                    </label>
                                                    <label class="radio-inline">
                                                        <input type="radio" name="sampling_status[{{$key5}}]" value="0" {{ $sampling->status == 0 ? 'checked' : '' }}>unverified
                                                    </label>
                                                </td>
                                            </tr>
                                            @endforeach
                                            @else
                                            <tr id="sampling-details-table-no-data">
                                                <td class="no_data_td">
                                                    <p>INFO : No data found.</p>
                                                </td>
                                            </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                <div class="submitBox">
                                    <button type="submit" class="btn_green btn-success">Submit</button>
                                </div>
                            </form>
                        <div>

                        <div class="special-customizations">
                            <form action="{{route('special.customizations.verify')}}" method="post">
                                @csrf
                                <input type="hidden" name="business_profile_id" value="{{$business_profile->id}}">
                                <legend>Special customization ability</legend>
                                <div class="no_more_tables">
                                    <table class="special-customizations-table-block table">
                                        <thead class="cf">
                                            <tr>
                                                <th> Name</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        @if(count($business_profile->specialCustomizations)>0)
                                        @foreach($business_profile->specialCustomizations as $key=>$specialCustomization)
                                            <tr>

                                                <td data-title="Name"><input readOnly name="special_customization_title[]" id="special-customizations-title" type="text" class="form-control "  value="{{$specialCustomization->title}}"  ></td>
                                                <td data-title="Status">
                                                    <label class="radio-inline">
                                                        <input type="radio" name="special_customization_status[{{$key}}]" value="1" {{ $specialCustomization->status == 1 ? 'checked' : '' }}>verified
                                                    </label>
                                                    <label class="radio-inline">
                                                        <input type="radio" name="special_customization_status[{{$key}}]" value="0" {{ $specialCustomization->status == 0 ? 'checked' : '' }}>unverified
                                                    </label>
                                                </td>
                                            </tr>
                                            @endforeach
                                            @else
                                            <tr id="special-customizations-details-table-no-data">
                                                <td class="no_data_td">
                                                    <p>INFO : No data found.</p>
                                                </td>
                                            </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                <div class="submitBox">
                                    <button type="submit" class="btn_green btn-success">Submit</button>
                                </div>
                            </form>
                        <div>

                        <div class="sustainability-commitments">
                            <form action="{{route('sustainability.commitments.verify')}}" method="post">
                                @csrf
                                <input type="hidden" name="business_profile_id" value="{{$business_profile->id}}">
                                <legend>Sustainability commitments</legend>
                                <div class="no_more_tables">
                                    <table class="sustainability-commitments-table-block table">
                                        <thead class="cf">
                                            <tr>
                                                <th>Name</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @if(count($business_profile->sustainabilityCommitments)>0)
                                            @foreach($business_profile->sustainabilityCommitments as $key=>$sustainabilityCommitment)
                                            <tr>
                                                <td data-title="Name"><input readOnly name="sustainability_commitment_title[]" id="special-customizations-title" type="text" class="form-control "  value="{{$sustainabilityCommitment->title}}"  ></td>
                                                <td data-title="Status">
                                                    <label class="radio-inline">
                                                        <input type="radio" name="sustainability_commitment_status[{{$key}}]" value="1" {{ $sustainabilityCommitment->status == 1 ? 'checked' : '' }}>verified
                                                    </label>
                                                    <label class="radio-inline">
                                                        <input type="radio" name="sustainability_commitment_status[{{$key}}]" value="0" {{ $sustainabilityCommitment->status == 0 ? 'checked' : '' }}>unverified
                                                    </label>
                                                </td>
                                            </tr>
                                            @endforeach
                                            @else
                                            <tr id="sustainability-commitments-details-table-no-data">
                                                <td class="no_data_td">
                                                    <p>INFO : No data found.</p>
                                                </td>
                                            </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                <div class="submitBox">
                                    <button type="submit" class="btn_green btn-success">Submit</button>
                                </div>
                            </form>
                        <div>

                        <div class="worker-welfare-and-csr" style="display: none;">
                            <legend>Worker welfare and CSR</legend>
                            @if($business_profile->walfare)
                            <div class="row">
                                <form  method="POST" action="{{route('worker.walfare.verify')}}" >
                                    @csrf
                                    <input type="hidden" name="business_profile_id" value="{{$business_profile->id}}">
                                    @foreach(json_decode($business_profile->walfare->walfare_and_csr) as $walfareAndCsr)
                                    @if($walfareAndCsr->name == 'healthcare_facility')
                                    <div class="row">
                                        <span class="">Healthcare Facility</span>
                                        <input  name="healthcare_facility"   type="hidden" value="{{$walfareAndCsr->checked}}">

                                        <label class="">
                                            <input class="" name="healthcare_facility_status"  class="health-facility-verified"  type="radio" value="1" {{  ($walfareAndCsr->status == "1" ? ' checked' : '') }}>
                                            <span>Verify</span>
                                        </label>
                                        <label class="">
                                            <input class="" name="healthcare_facility_status" class="health-facility-unverified"    value="0" type="radio" {{  ($walfareAndCsr->status == "0" ? ' checked' : '') }}>
                                            <span>Unverify</span>
                                        </label>
                                    </div>
                                    @endif
                                    @if($walfareAndCsr->name == 'doctor')
                                    <div class="row">
                                        <span class="">On sight Doctor</span>
                                        <input  name="doctor"   type="hidden" value="{{$walfareAndCsr->checked}}">
                                        <label class="">
                                            <input  name="doctor_status"  class="doctor-verified"  type="radio" value="1" {{  ($walfareAndCsr->status == "1" ? ' checked' : '') }}>
                                            <span>Yes</span>
                                        </label>
                                        <label class="">
                                            <input  name="doctor_status" class="doctor-verified"  value="0" type="radio" {{  ($walfareAndCsr->status == "0" ? ' checked' : '') }}>
                                            <span>No</span>
                                        </label>
                                    </div>
                                    @endif
                                    @if($walfareAndCsr->name == 'day_care')
                                    <div class="row">
                                        <span class=" ">On sight Day Care</span>
                                        <input  name="day_care"   type="hidden" value="{{$walfareAndCsr->checked}}">

                                        <label class="">
                                            <input  name="day_care_status" class="day-care-verified" type="radio" value="1" {{  ($walfareAndCsr->status == "1" ? ' checked' : '') }} >
                                            <span>Yes</span>
                                        </label>
                                        <label class="">
                                            <input  name="day_care_status" class="day-care-verified" value="0" type="radio" {{  ($walfareAndCsr->status == "0" ? ' checked' : '') }}>
                                            <span>No</span>
                                        </label>
                                    </div>
                                    @endif
                                    @if($walfareAndCsr->name == 'playground')
                                    <div class="row">
                                        <span class="">Playground</span>
                                        <input  name="playground"   type="hidden" value="{{$walfareAndCsr->checked}}">

                                        <label class="">
                                            <input  name="playground_status" class="playground-verified"   type="radio" value="1" {{  ($walfareAndCsr->status == "1" ? ' checked' : '') }}>
                                            <span>Yes</span>
                                        </label>
                                        <label class="">
                                            <input  name="playground_status"  class="playground-verified"  value="0" type="radio" {{  ($walfareAndCsr->status == "0" ? ' checked' : '') }}>
                                            <span>No</span>
                                        </label>
                                    </div>
                                    @endif
                                    @if($walfareAndCsr->name == 'maternity_leave')
                                    <div class="row">
                                        <span class="">Maternity Leave</span>
                                        <input  name="maternity_leave"   type="hidden" value="{{$walfareAndCsr->checked}}">

                                        <label class="">
                                            <input name="maternity_leave_status" class="maternity-leave--verified" type="radio" value="1" {{  ($walfareAndCsr->status == "1" ? ' checked' : '') }} >
                                            <span>Yes</span>
                                        </label>
                                        <label ">
                                            <input  name="maternity_leave_status" class="maternity-leave--verified" type="radio" value="0" {{  ($walfareAndCsr->status == "0" ? ' checked' : '') }}>
                                            <span>No</span>
                                        </label>
                                    </div>
                                    @endif
                                    @if($walfareAndCsr->name == 'social_work')
                                    <div class="row">
                                        <span class="">Social work</span>
                                        <input  name="social_work"   type="hidden" value="{{$walfareAndCsr->checked}}">

                                        <label class="">
                                            <input class="" name="social_work_status"  class="social-work--verified" type="radio" value="1" {{  ($walfareAndCsr->status == "1" ? ' checked' : '') }} >
                                            <span>Yes</span>
                                        </label>
                                        <label class="">
                                            <input  name="social_work_status"  class="social-work--verified" type="radio" value="0" {{  ($walfareAndCsr->status == "0" ? ' checked' : '') }} >
                                            <span>No</span>
                                        </label>
                                    </div>
                                    @endif
                                    @endforeach

                                    <div class="submitBox">
                                        <button class="btn_green btn-success" type="submit">Submit</button>
                                    </div>
                                </form>
                            </div>
                            @else
                                <div class="no_data_box">
                                    <p>INFO : No data found.</p>
                                </div>
                            @endif
                        </div>

                        <div class="worker-security-and-others" style="display: none;">
                            <legend>Worker Security and others</legend>
                                @if(isset($business_profile->security))

                                <div class="row">
                                    <form  method="POST" action="{{route('worker.security.verify')}}" >
                                        @csrf
                                        <input type="hidden" name="business_profile_id" value="{{$business_profile->id}}">
                                        @foreach(json_decode($business_profile->security->security_and_others) as $securityAndOther)
                                            @if($securityAndOther->name == 'fire_exit')
                                            <div class="row">
                                                <span class="">Fire exit</span>
                                                <input  name="fire_exit"   type="hidden" value="{{$securityAndOther->checked}}">

                                                <label class="">
                                                    <input class="" name="fire_exit_status"  class="fire-exit-facility-verified"  type="radio" value="1" {{  ($securityAndOther->status == "1" ? ' checked' : '') }}>
                                                    <span>Verify</span>
                                                </label>
                                                <label class="">
                                                    <input class="" name="fire_exit_status" class="fire-exit-facility-unverified"    value="0" type="radio" {{  ($securityAndOther->status == "0" ? ' checked' : '') }}>
                                                    <span>Unverify</span>
                                                </label>
                                            </div>
                                            @endif
                                            @if($securityAndOther->name == 'fire_hydrant')
                                            <div class="row">
                                                <span class="">Fire hydrant</span>
                                                <input  name="fire_hydrant"   type="hidden" value="{{$securityAndOther->checked}}">
                                                <label class="">
                                                    <input  name="fire_hydrant_status"  class="fire-hydrant-verified"  type="radio" value="1" {{  ($securityAndOther->status == "1" ? ' checked' : '') }}>
                                                    <span>Verify</span>
                                                </label>
                                                <label class="">
                                                    <input  name="fire_hydrant_status" class="fire-hydrant-verified"  value="0" type="radio" {{  ($securityAndOther->status == "0" ? ' checked' : '') }}>
                                                    <span>Unverify</span>
                                                </label>
                                            </div>
                                            @endif
                                            @if($securityAndOther->name == 'water_source')
                                            <div class="row">
                                                <span class=" ">Water source</span>
                                                <input  name="water_source"   type="hidden" value="{{$securityAndOther->checked}}">

                                                <label class="">
                                                    <input  name="water_source_status" class="water-source-verified" type="radio" value="1" {{  ($securityAndOther->status == "1" ? ' checked' : '') }} >
                                                    <span>Verify</span>
                                                </label>
                                                <label class="">
                                                    <input  name="water_source_status" class="water-source-verified" value="0" type="radio" {{  ($securityAndOther->status == "0" ? ' checked' : '') }}>
                                                    <span>Unverify</span>
                                                </label>
                                            </div>
                                            @endif
                                            @if($securityAndOther->name == 'protocols')
                                            <div class="row">
                                                <span class="">Protocols</span>
                                                <input  name="protocols"   type="hidden" value="{{$securityAndOther->checked}}">

                                                <label class="">
                                                    <input  name="protocols_status" class="protocols-verified"   type="radio" value="1" {{  ($securityAndOther->status == "1" ? ' checked' : '') }}>
                                                    <span>Verify</span>
                                                </label>
                                                <label class="">
                                                    <input  name="protocols_status"  class="protocols-verified"  value="0" type="radio" {{  ($securityAndOther->status == "0" ? ' checked' : '') }}>
                                                    <span>Unerify</span>
                                                </label>
                                            </div>
                                            @endif

                                        @endforeach
                                        <div class="submitBox">
                                            <button class="btn_green btn-success" type="submit">Submit</button>
                                        </div>
                                    </form>
                                </div>
                                @else
                                <div class="no_data_box">
                                    <p>INFO : No data found.</p>
                                </div>
                                @endif

                        </div>
                        @endif

                        @if($business_profile->is_business_profile_verified == 0)
                        <a href="javascript:void(0)" class="btn_green verification_trigger_from_backend" data-businessprofileid="{{$business_profile->id}}" data-companyid="{{$business_profile->companyOverview->id}}" data-verified="1" data-spotlight="0">Click to verify this profile</a>
                        @else
                        <a href="javascript:void(0)" class="btn btn-danger unverification_trigger_from_backend" data-businessprofileid="{{$business_profile->id}}" data-companyid="{{$business_profile->companyOverview->id}}" data-verified="0">Click to unverify this profile</a>
                        @endif



                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection

@push('js')
<script>
    $(document).ready(function(){

        $('.checkbox-spotlight').on('change', function() {
            var url = '{{ route("business.profile.spotlight") }}';
            var spotlightVal = $(this).val();
            var profileId = $(this).attr("data-businessprofileid");
            if(spotlightVal == 0) {
                if (confirm('Are you sure? You want to show this profile in spotlight section?'))
                {
                    $.ajax({
                        method: 'get',
                        data: {spotlightVal:spotlightVal, profileId:profileId},
                        url: url,
                        beforeSend: function() {
                            $('.loading-message').html("Please Wait.");
                            $('#loadingProgressContainer').show();
                        },
                        success:function(data)
                        {
                            $('.loading-message').html("");
                            $('#loadingProgressContainer').hide();
                            //window.location.reload();
                            //alert("Successfull.");
                        }
                    });
                }
            } else {
                if (confirm('Are you sure? You want to remove this profile from spotlight section?'))
                {
                    $.ajax({
                        method: 'get',
                        data: {spotlightVal:spotlightVal, profileId:profileId},
                        url: url,
                        beforeSend: function() {
                            $('.loading-message').html("Please Wait.");
                            $('#loadingProgressContainer').show();
                        },
                        success:function(data)
                        {
                            $('.loading-message').html("");
                            $('#loadingProgressContainer').hide();
                            //window.location.reload();
                            //alert("Successfull.");
                        }
                    });
                }                
            }
            
        });

        $('.verification_trigger_from_backend').on('click',function(){
            //e.preventDefault();
            var url = '{{ route("business.profile.verify") }}';
            var verifyVal = $(this).attr("data-verified");
            var profileId = $(this).attr("data-businessprofileid");
            var companyId = $(this).attr("data-companyid");
            if (confirm('Are you sure you want to make this company verfied?'))
            {
                $.ajax({
                    method: 'get',
                    data: {verifyVal:verifyVal, profileId:profileId, companyId:companyId},
                    url: url,
                    beforeSend: function() {
                        $('.loading-message').html("Please Wait.");
                        $('#loadingProgressContainer').show();
                    },
                    success:function(data)
                    {
                        if(data.status==1){
                            $(".verification_trigger_from_backend").hide();
                            $(".unverification_trigger_from_backend").show();
                        }
                        window.location.reload();
                    }
                });
            }
        });

        $('.unverification_trigger_from_backend').on('click',function(){
            //e.preventDefault();
            var url = '{{ route("business.profile.verify") }}';
            var verifyVal = $(this).attr("data-verified");
            var profileId = $(this).attr("data-businessprofileid");
            var companyId = $(this).attr("data-companyid");
            if (confirm('Are you sure you want to make this company unverfied?'))
            {
                $.ajax({
                    method: 'get',
                    data: {verifyVal:verifyVal, profileId:profileId, companyId:companyId},
                    url: url,
                    beforeSend: function() {
                        $('.loading-message').html("Please Wait.");
                        $('#loadingProgressContainer').show();
                    },
                    success:function(data)
                    {
                        if(data.status==1){
                            $(".verification_trigger_from_backend").show();
                            $(".unverification_trigger_from_backend").hide();
                        }
                        window.location.reload();
                    }
                });
            }
        });
    });
</script>
@endpush
