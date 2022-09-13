
@extends('layouts.app_containerless')

@section('content')
    <div id="main">
        <div class="row">
            <div class="main-content-area">
                <div class="container">
                    <div class="row">
                        <div class="col m3 left-column">
                        
                            <div class="module-rating-filter">
                                <h3>Ratings</h3>
                                <form action="#" class="display-grid">
                                    <label class="rating-item">
                                        <input type="checkbox">
                                        <span>
                                            <i class="material-icons amber-text"> star </i>
                                            <i class="material-icons amber-text"> star </i>
                                            <i class="material-icons amber-text"> star </i>
                                            <i class="material-icons amber-text"> star </i>
                                            <i class="material-icons amber-text"> star </i>
                                        </span>
                                    </label>
                                    <label class="rating-item">
                                        <input type="checkbox">
                                        <span>
                                            <i class="material-icons amber-text"> star </i>
                                            <i class="material-icons amber-text"> star </i>
                                            <i class="material-icons amber-text"> star </i>
                                            <i class="material-icons amber-text"> star </i>
                                        </span>
                                    </label>
                                    <label class="rating-item">
                                        <input type="checkbox">
                                        <span>
                                            <i class="material-icons amber-text"> star </i>
                                            <i class="material-icons amber-text"> star </i>
                                            <i class="material-icons amber-text"> star </i>
                                        </span>
                                    </label>
                                    <label class="rating-item">
                                        <input type="checkbox">
                                        <span>
                                            <i class="material-icons amber-text"> star </i>
                                            <i class="material-icons amber-text"> star </i>
                                        </span>
                                    </label>
                                    <label class="rating-item">
                                        <input type="checkbox">
                                        <span>
                                            <i class="material-icons amber-text"> star </i>
                                        </span>
                                    </label>
                                </form>
                            </div>
                            <a href="javascript:void(0);" class="waves-effect waves-block waves-light btn green lighten-1">Filter</a>
                        </div>
                        <div class="col m9 content-column">

                            @if($searchType=="vendor")
                                <div class="main-content-area">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col m12 content-column">

                                                <div class="row active_grid">
                                                    @if(count($vendors)>0)
                                                        @foreach($vendors as $key=>$vendor)
                                                            <div class="col s12 m4 l4">
                                                                <div class="card">
                                                                    <div class="card-content">
                                                                        <div class="vendor_short_details">
                                                                            <div class="vendor_name">
                                                                                @if(Auth::check())
                                                                                <a href="{{ route('users.myshop',$vendor->vendor_uid) }}">{{$vendor->vendor_name}}</a>
                                                                                @else
                                                                                <a href="#login-register-modal" class="modal-trigger">{{$vendor->vendor_name}}</a>
                                                                                @endif
                                                                            </div>
                                                                            <div class="vendor_info">
                                                                                <span><b>Vendor Name:</b> {{$vendor->vendor_name}}</span>
                                                                            </div>
                                                                            <div class="vendor_info">
                                                                                <span><b>Vendor Owner Name:</b> {{$vendor->vendor_ownerame}}</span>
                                                                            </div>
                                                                            <div class="vendor_info">
                                                                                <span><b>Vendor Address:</b> {{$vendor->vendor_address}}</span>
                                                                            </div>
                                                                            <div class="vendor_info">
                                                                                <span><b>Vendor Main Product:</b> {{$vendor->main_product}}</span>
                                                                            </div>
                                                                            <div class="view_vendor_profile">
                                                                                @if(Auth::check())
                                                                                <a href="{{ route('users.myshop',$vendor->vendor_uid) }}" class="btn waves-effect waves-light green">View Profile</a>
                                                                                @else
                                                                                <a href="#login-register-modal" class="modal-trigger btn waves-effect waves-light green">View Profile</a>
                                                                                @endif
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach

                                                    @else
                                                        <div class="card-alert card cyan">
                                                            <div class="card-content white-text">
                                                                <p>INFO : No Store available.</p>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                            @else
                                <div>No data found</div>
                            @endif                            

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection