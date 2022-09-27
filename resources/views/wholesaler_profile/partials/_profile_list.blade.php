@section('css')
<style type="text/css">
    img {
        display: block;
        max-width: 100%;
    }
    .preview {
        overflow: hidden;
        width: 160px !important;
        height: 68px !important;
        margin: 10px;
        border: 1px solid red;
    }
    .modal-lg{
        max-width: 1000px !important;
    }
    .active{
        background-color: #448547;
        color:white;
    }
</style>
@endsection

<!--div class="col s12 shop-banner-wrapper">
    <div class="shop-banner-img">
        @if(auth()->user()->user_banner)
        <img src="{{asset('storage/'.auth()->user()->user_banner)}}" id="preview-banner-before-upload" class="responsive-img" alt="Profile Banner Image" />
        @else
        <img src="{{asset('images/frontendimages/shop_banner.png')}}" id="preview-banner-before-upload" class="responsive-img" alt="Profile Banner Image" />
        @endif
    </div>
    <div class="change_banner_photo">
        <form method="post" id="upload-banner-form" enctype="multipart/form-data">
            @csrf
            <a href="javascript:void(0)" class="btn profile-banner-upload-trigger waves-effect waves-light green">
                <i class="material-icons">create</i> Change Banner
            </a>
            <input type="file" name="image" class="form-control profile-banner-upload-trigger-alias" id="banner-input" style="display: none;" />
        </form>
    </div>
    <div class="shop-name">
        <i class="material-icons dp48">store</i>
    </div>
</div-->

<!--div class="col s12 profile-menu-list">
    <ul class=" z-depth-1 profile-tabs">
        <li class="profile-item-tab col m2 profile-tab"><a class="{{ Route::is('manufacturer.profile.show') ? 'active' : ''}}" href="{{route('manufacturer.profile.show', $business_profile->alias)}}">Profile</a></li>
        <li class="profile-item-tab col m2 products-tab"><a class="{{ Route::is('wholesaler.product.index') ? 'active' : ''}}" href="{{route('wholesaler.product.index', $business_profile->alias)}}">Products</a></li>
        <li class="profile-item-tab col m2 orders-tab"><a class="{{ Route::is('wholesaler.order.index') ? 'active' : ''}}" href="{{route('wholesaler.order.index', $business_profile->alias)}}">Orders</a></li>
        {{-- <li class="profile-item-tab col m2 orders-modification-tab"><a class="{{ Route::is('ord.mod.req.index') ? 'active' : ''}}" href="{{route('ord.mod.req.index')}}"><span class="orderModificationCount"></span>  Requested For Msodification</a></li>
        <li class="profile-item-tab col m2 orders-tab"><a class="{{ Route::is('user.order.query.index') ? 'active' : ''}}" href="{{route('user.order.query.index')}}"><span class="orderQueryProcessedCount"></span> Orders Query</a></li>
        <li class="profile-item-tab col m2 reviews-tab"><a class="{{ Route::is('vendor.review.index') ? 'active' : ''}}" href="{{route('vendor.review.index')}}">Reviews</a></li> --}}
    </ul>
</div-->

<div class="profile_tab_menu profile_wholesaler_tab_menu">
    <ul>
        <li><a   class="{{ empty(request()->segment(4)) ? 'active' : '' }}"  href="{{route('wholesaler.profile.show', $business_profile->alias)}}" >Home</a></li>
        <li><a   class="{{ (request()->segment(4) == 'info') ? 'active' : '' }}"  href="{{route('wholesaler.profile.info', $business_profile->alias)}}" >Profile</a></li>
        <li><a   class="{{ (request()->segment(4) == 'products') ? 'active' : '' }}"   href="{{route('wholesaler.product.index', $business_profile->alias)}}" >Products</a></li>
        <li><a   class="{{ (request()->segment(4) == 'received-orders') ? 'active' : '' }}"   href="{{route('wholesaler.order.index', $business_profile->alias)}}">Received Orders</a></li>

    </ul>
</div>

{{-- banner model --}}

<!--div id="banner-img-preview-modal" class="modal banner-img-preview-modal">
    <div class="modal-content">
        <div class="modal-body">
            <div class="img-container">
                <div class="row">
                    <div class="col m8">
                        {{-- <img id="image" src="https://avatars0.githubusercontent.com/u/3456749"> --}}
                        <img id="profile-banner-image-preview" src="" />
                    </div>
                    <div class="col m4">
                        <h4>Cropping Preview</h4>
                        <div class="preview"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <a href="javascript:void(0);" class="cropper-image-modal-close">
            <i class="material-icons green-text text-darken-1">close</i>
        </a>
        <button type="button" class="btn btn-primary green" id="crop">Crop</button>
    </div>
</div-->
