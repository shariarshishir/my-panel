
@foreach($vendors as $key=>$vendor)
<div class="col s12 m3 l3">
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
                    <div class="info_icon">
                        <i class="fas fa-store"></i>
                    </div>
                    <div class="info_text">
                        {{$vendor->vendor_type}}
                    </div>
                </div>
                <div class="vendor_info">
                    <div class="info_icon">
                        <i class="fas fa-tshirt"></i>
                    </div>
                    <div class="info_text">
                        @php  $mainProduct= singleProductInformation($vendor->vendor_mainproduct); @endphp
                        {{ $mainProduct->name ?? '' }}
                    </div>
                </div>
                <div class="vendor_info">
                    <div class="info_icon">
                        <i class="fas fa-store"></i>
                    </div>
                    <div class="info_text">
                        {{$vendor->vendor_yearest}}
                    </div>
                </div>
                <div class="vendor_info">
                    <div class="info_icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div class="info_text">
                        {{$vendor->vendor_country}}
                    </div>
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
