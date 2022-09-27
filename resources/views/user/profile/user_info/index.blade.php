@if($flag==0)
<div class="card-alert card orange store-update-warning">
    <div class="card-content white-text">
        <p>WARNING : Please update your store profile from <a href="#store-config-modal-block" class="modal-trigger">here</a>. This will make ensure your trust and buyer will find you easily. Shop Merchantbay system will use your store information to some filtration</p>
    </div>
</div>
@endif
<div class="col m12 card user-profile-basic-info-block">

    <div class="row profile-block store-config-block">
        <div class="col s12">
            <legend style="margin-bottom: 20px;">Profile Information</legend>
        </div>
        <div class="col m3 profile-image-block">
            <div class="profile_image" itemscope itemtype="https://schema.org/Person">
                @if($user->image)
                <img itemprop="image" src="{{ Storage::disk('s3')->url('public/'.$user->image) }}" id="profile_image" alt="avatar" width="300px">
                @else
                <img itemprop="image" src="{{Storage::disk('s3')->url('public/frontendimages/no-image.png')}}" alt="avatar" width="300px">
                @endif
            </div>
            <div class="change_photo">
                <form method="post" id="upload-image-form" enctype="multipart/form-data">
                    @csrf
                    <a href="javascript:void(0)" class="btn profile-image-upload-trigger waves-effect waves-light btn_white">
                        <i class="material-icons">create</i> Change Photo
                    </a>
                    <div class="form-group" style="display: none;">
                        <input type="file" name="image" class="form-control profile-image-upload-trigger-alias" id="image-input">
                        <span class="text-danger" id="image-input-error"></span>
                    </div>
                    <input type="hidden" name="user_id" value="{{$user->id}}">

                    <button type="submit" class="btn waves-effect waves-light green profile-image-upload-button" style="display: none">Upload</button>
                </form>
            </div>
        </div>
        <div class="col m9 profile-info-block">
            <div class="user-profile-info-block" itemscope itemtype="https://schema.org/Person">
                <p itemprop="name"><i class="material-icons dp48 waves-effect waves-light">person</i> {{$user->name}}</p>
                <p itemprop="email"><i class="material-icons dp48 waves-effect waves-light">email</i> {{$user->email}}</p>
                <p itemprop="telephone"><i class="material-icons dp48 waves-effect waves-light">local_phone</i> {{$user->phone}}</p>

                <div class="user_my_order_btnwrap">
                    <a class="btn_green" href="{{route('myorder')}}">My Orders</a>
                </div>
            </div>
        </div>
        <div class="col s12">
            @if(count($businessProfiles) > 0)
            @php
                $className = '';
                if(count($businessProfiles)==3) {
                    //$className = "col s12 m6 l3";
                    $className = "my_businesses_innerbox";
                } elseif(count($businessProfiles)==2) {
                    //$className = "col s12 m6 l3";
                    $className = "my_businesses_innerbox";
                } else {
                    $className = "my_businesses_innerbox";
                }
            @endphp
            <div class="row profile-block business-profile-block">
                <div class="col s12">
                    <legend>My Businesses</legend>
                </div>
                <div class="col s12 my_businesses_wrap">
                    @foreach($businessProfiles as $key=>$businessprofile)
                    <div class="<?php echo $className; ?>">
                        <div class="my_businesses_box card user-business-profile-short-info" itemscope itemtype="https://schema.org/Organization">
                            {{-- @if($businessprofile->business_type== 'manufacturer')
                                <p><span style="font-weight: 500;">Business Name:</span> <a href="{{route('manufacturer.profile.show',$businessprofile->alias)}}" itemprop="legalName">{{ $businessprofile->business_name }}</a></p>
                            @elseif($businessprofile->business_type== 'wholesaler')
                                <p><span style="font-weight: 500;">Business Name:</span> <a href="{{route('wholesaler.profile.show',$businessprofile->alias)}}" itemprop="legalName">{{ $businessprofile->business_name }}</a></p>
                            @endif --}}
                            <p class="businessName"span style="font-weight: 500;">Business Name:</span> <a href="{{route('new.profile.index',$businessprofile->alias)}}" itemprop="legalName"><b>{{ $businessprofile->business_name }}</b></a></p>
                            <p><span style="font-weight: 500;">Business Location:</span> <span itemprop="location" itemscope itemtype="https://schema.org/Place"><b>{{ $businessprofile->location }}</b></span></p>
                            <p><span style="font-weight: 500;">Business Type:</span> <b>{{ucwords($businessprofile->business_type)}}</b></p>
                            {{-- <div class="business-shortcut-bar">
                                <ul>
                                    <li><a href="javascript:void(0);">Messages</a></li>
                                    <li>
                                        @if($businessprofile->business_type=='manufacturer')
                                            <a href="javascript:void(0);">Received Orders</a></li>
                                        @elseif($businessprofile->business_type=='wholesaler')
                                            <a href="{{route('wholesaler.order.index', $businessprofile->alias)}}">Received Orders <span>{{count($businessprofile->profileBasedOrders)}}</span></a></li>
                                        @endif
                                    <li><a href="javascript:void(0);">Submitted Orders</a></li>
                                    <li>
                                        @if($businessprofile->business_type=='manufacturer')
                                            <a href="javascript:void(0);">Received Queries</a>
                                        @else
                                            <a href="{{route('user.order.query.index',  ['business_id' => $businessprofile->id])}}">Received Queries <span>{{count($businessprofile->profileBasedQueries)}}</span></a></li>
                                        @endif
                                    </li>
                                    <li>
                                        @if($businessprofile->business_type == 'manufacturer')
                                            <a href="{{route('po.index', ['business_id' => $businessprofile->id])}}">PI/PO <span>{{count($businessprofile->profileBasedPo)}}</span></a>
                                        @else
                                            <a href="javascript:void(0);">PI/PO</a>
                                        @endif
                                    </li>
                                </ul>
                            </div> --}}

                            <div class="switch profile_enable_disable_trigger">
                                <label>
                                    <input type="checkbox" bpid={{$businessprofile->id}} {{$businessprofile->deleted_at ? '' : 'checked'}}>
                                    <span class="lever"></span>
                                    <span class="enable_disable_label {{$businessprofile->deleted_at ? '' : 'teal white-text text-darken-2'}}">{{$businessprofile->deleted_at ? 'Unpublish' : 'Publish'}}</span>
                                </label>
                            </div>

                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
    <!-- <div class="user_my_order_btnwrap">
        <a class="btn_green" href="{{route('myorder')}}">My Orders</a>
    </div> -->



</div>

@include('user.profile.user_info._scripts')

