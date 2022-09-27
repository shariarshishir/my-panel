@if($flag==0)
<div class="card-alert card orange store-update-warning">
    <div class="card-content white-text">
        <p>WARNING : Please update your store profile from <a href="#store-config-modal-block" class="modal-trigger">here</a>. This will make ensure your trust and buyer will find you easily. Shop Merchantbay system will use your store information to some filtration</p>
    </div>
</div>
@endif
<div class="col m12 card card-with-padding">

    <div class="row profile-block store-config-block">
        <legend>Profile Information</legend>
        <div class="col m6 profile-image-block">
            <img src="{{ asset('storage/'.$user->image) }}" id="profile_image" alt="avatar" width="300px">
            <div class="change_photo">
                <form method="post" id="upload-image-form" enctype="multipart/form-data">
                    @csrf
                    <a href="javascript:void(0)" class="btn profile-image-upload-trigger waves-effect waves-light green">
                        <i class="material-icons">create</i> Change Photo
                    </a>
                    <div class="form-group" style="display: none;">
                        <input type="file" name="image" class="form-control profile-image-upload-trigger-alias" id="image-input">
                        <span class="text-danger" id="image-input-error"></span>
                    </div>
                    <input type="hidden" name="user_id" value="{{$user->id}}">

                    <button type="submit" class="btn waves-effect waves-light green">Upload</button>
                </form>
            </div>
        </div>
        <div class="col m6 profile-info-block">
            <p><i class="material-icons dp48 waves-effect waves-light">person</i> {{$user->name}}</p>
            <p><i class="material-icons dp48 waves-effect waves-light">email</i> {{$user->email}}</p>
            <p><i class="material-icons dp48 waves-effect waves-light">local_phone</i> {{$user->phone}}</p>
        </div>
    </div>

    <div class="row storeinfo-block store-config-block">
        <a href="#store-config-modal-block" class="modal-trigger tooltipped edit_block_button" data-position="top" data-tooltip="Edit your store">
            <i class="material-icons dp48 btn waves-effect waves-light green darken-1">create</i>
        </a>
        <legend>Store Information</legend>
        <div class="col m6">
            <div class="form-group store-info-item row">
                <label for="vendor_name" class="col-md-4 col-form-label text-md-right">{{ __('Business Name') }}</label>
                <div class="col-md-6" id="vendor_name">{{ $user->vendor->vendor_name }}</div>
            </div>
            <div class="form-group store-info-item row">
                <label for="vendor_ownername" class="col-md-4 col-form-label text-md-right">{{ __('Owner Name') }}</label>
                <div class="col-md-6" id="vendor_ownername">{{ $user->vendor->vendor_ownername }}</div>
            </div>
            <div class="form-group store-info-item row">
                <label for="vendor_address" class="col-md-4 col-form-label text-md-right">{{ __('Address') }}</label>
                <div class="col-md-6" id="vendor_address">{{ $user->vendor->vendor_address }}</div>
            </div>
            <div class="form-group store-info-item row">
                <label for="vendor_country" class="col-md-4 col-form-label text-md-right">{{ __('Country / Region') }}</label>
                <div class="col-md-6" id="vendor_country">{{$user->vendor->vendor_country}}</div>
            </div>
            <div class="form-group store-info-item row">
                <label for="vendor_type" class="col-md-4 col-form-label text-md-right">{{ __('Business Type') }}</label>
                <div class="col-md-6" id="vendor_type">{{ $user->vendor->vendor_type }}</div>
            </div>
        </div>
        <div class="col m6">
            @if(auth()->user()->user_type!='buyer' )
            <div class="form-group store-info-item row">
                <label for="vendor_mainproduct" class="col-md-4 col-form-label text-md-right">{{ __('Main Products') }}</label>
                @php  $mainProduct= singleProductInformation($user->vendor->vendor_mainproduct); @endphp
                <div class="col-md-6 vendor_mainproduct">{{$mainProduct->name ?? '' }}</div>
            </div>
            @endif
            <div class="form-group store-info-item row">
                <label for="vendor_totalemployees" class="col-md-4 col-form-label text-md-right">{{ __('Total Employees') }}</label>
                <div class="col-md-6" id="vendor_totalemployees">{{ $user->vendor->vendor_totalemployees }}</div>
            </div>
            <div class="form-group store-info-item row">
                <label for="vendor_yearest" class="col-md-4 col-form-label text-md-right">{{ __('Year Established') }}</label>
                <div class="col-md-6" id="vendor_yearest">{{ $user->vendor->vendor_yearest }}</div>
            </div>
            {{-- <div class="form-group store-info-item row">
                <label for="vendor_certification" class="col-md-4 col-form-label text-md-right">{{ __('Certification') }}</label>
                <div class="col-md-6" id="vendor_certification">{{ $user->vendor->vendor_certification }}</div>
            </div> --}}
        </div>

        <div id="store-config-modal-block" class="modal modal-fixed-footer">
            <div class="modal-content">
                <div class="row">
                    <legend>Update Store Information</legend>
                </div>
                <div id="error_div">
                    <ul class="custom-errors"></ul>
                </div>
                <form method="POST" action="javascript:void(0);" enctype="multipart/form-data" id="store_info_update_form">
                    @csrf
                    <div class="form-group row">
                        <label for="vendor_name" class="col-md-4 col-form-label text-md-right">{{ __('Business Name') }}</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control @error('vendor_name') is-invalid @enderror" name="vendor_name" value="{{ $user->vendor->vendor_name }}" required autocomplete="vendor_name" autofocus />
                            @error('vendor_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="vendor_ownername" class="col-md-4 col-form-label text-md-right">{{ __('Owner Name') }}</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control @error('vendor_ownername') is-invalid @enderror" name="vendor_ownername" value="{{ $user->vendor->vendor_ownername }}" required autocomplete="vendor_ownername" autofocus />
                            @error('vendor_ownername')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="vendor_address" class="col-md-4 col-form-label text-md-right">{{ __('Address') }}</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control @error('vendor_address') is-invalid @enderror" name="vendor_address" value="{{ $user->vendor->vendor_address }}" required autocomplete="vendor_address" autofocus />
                            @error('vendor_address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="vendor_country" class="col-md-4 col-form-label text-md-right">{{ __('Country / Region') }}</label>
                        <div class="col-md-6">
                            <select class="select2 browser-default" name="vendor_country" id="vendor_country" required>
                                @if($user->vendor->vendor_country)
                                <option value="{{$user->vendor->vendor_country}}" selected>{{$user->vendor->vendor_country}}</option>
                                @else
                                <option value="" disabled selected>Select Your Country</option>
                                @endif
                                @foreach($countries as $country)
                                <option value="{{$country->name}}">{{$country->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="vendor_type" class="col-md-4 col-form-label text-md-right">{{ __('Business Type') }}</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control @error('vendor_type') is-invalid @enderror" name="vendor_type" value="{{ $user->vendor->vendor_type }}" required autocomplete="vendor_type" autofocus />
                            @error('vendor_type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    @if(auth()->user()->user_type!='buyer' )
                    <div class="form-group row">
                        <label for="vendor_mainproduct" class="col-md-4 col-form-label text-md-right">{{ __('Main Products') }}</label>
                        <div class="col-md-6">
                            <select class="select2 browser-default" name="vendor_mainproduct" >
                                @if(!$user->vendor->vendor_mainproduct)
                                    <option value="" disabled selected>Select Your Product</option>
                                @endif
                                @foreach($productFeatured as $products)
                                    <option value="{{$products->id}}" @if($user->vendor->vendor_mainproduct == $products->id) selected @endif">{{$products->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        @if(!$user->vendor->vendor_mainproduct)
                        <div class="card-alert card cyan main-product-warning">
                            <div class="card-content white-text" style="padding: 5px;">
                                <p>INFO : First you have to add some products to set a main product. Please go to the product tab to add products.</p>
                            </div>
                        </div>
                        @endif
                    </div>
                    @endif

                    <div class="row two-column">
                        <div class="form-group col m6">
                            <label for="vendor_totalemployees" class="col-md-4 col-form-label text-md-right">{{ __('Total Employees') }}</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control @error('vendor_totalemployees') is-invalid @enderror" name="vendor_totalemployees" value="{{ $user->vendor->vendor_totalemployees }}"  autocomplete="vendor_totalemployees" autofocus />
                                @error('vendor_totalemployees')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group col m6">
                            <label for="vendor_yearest" class="col-md-4 col-form-label text-md-right">{{ __('Year Established') }}</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control @error('vendor_yearest') is-invalid @enderror" name="vendor_yearest" value="{{ $user->vendor->vendor_yearest }}"  autocomplete="vendor_yearest" autofocus />
                                @error('vendor_yearest')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- <div class="form-group row">
                        <label for="vendor_certification" class="col-md-4 col-form-label text-md-right">{{ __('Certification') }}</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control @error('vendor_certification') is-invalid @enderror" name="vendor_certification" value="{{ $user->vendor->vendor_certification }}"  autocomplete="vendor_certification" autofocus />
                            @error('vendor_certification')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div> --}}

                    <button type="submit" class="btn waves-effect waves-light green update_store_information_trigger">Submit</button>
                    <a href="javascript:void(0);" class="modal-action modal-close btn waves-effect waves-light green">Cancel</a>

                </form>
            </div>
            <div class="modal-footer">
                <a href="javascript:void(0);" class="modal-action modal-close waves-effect waves-green btn-flat ">
                    <i class="material-icons green-text text-darken-1">close</i>
                </a>
            </div>
        </div>


    </div>
</div>

@include('user.profile.user_info._scripts')
