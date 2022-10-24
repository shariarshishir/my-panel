@if($vendor->user_id != Auth::user()->user_id)
<div class="row">
<div class="wholesaler-profile-menu col s12">
    <ul class="z-depth-1 item-tab-list">
        <li class="col m2 item-tab"><a href="{{ route('users.myshop', $vendor->vendor_uid) }}" class="profile-item {{ Route::is('users.myshop') ? 'active' : ''}}">Store Products</a></li>
        <li class="col m2 item-tab"><a href="{{ route('users.myShopProfile', $vendor->vendor_uid) }}" class="profile-item {{ Route::is('users.myShopProfile') ? 'active' : ''}}">Store Profile</a></li>
        <li class="col m2 item-tab"><a href="{{ route('users.myShopContact', $vendor->vendor_uid) }}" class="profile-item {{ Route::is('users.myShopContact') ? 'active' : ''}}">Contact</a></li>
        <li class="col m2 item-tab"><a href="{{ route('users.myShopReviews', $vendor->vendor_uid) }}" class="profile-item {{ Route::is('users.myShopReviews') ? 'active' : ''}}">Store Reviews</a></li>
    </ul>
</div>
</div>
@endif
