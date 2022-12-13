<ul>
    <li style="display: none;"><a class="{{ Route::is('new.profile.index',$alias) ? 'active' : ''}}" href="{{route('new.profile.index',$alias)}}">General Info</a></li>
    @if($business_profile->profile_type == 'supplier')
        <li style="display: none;"><a class="{{ Route::is('new.profile.home',$alias) ? 'active' : ''}}" href="{{route('new.profile.home',$alias)}}">Profile</a></li>
    @endif
    @if($business_profile->is_enabled_product_option == 1 && auth()->user()->user_type == "buyer")
        <li><a class="{{ Route::is('new.profile.products',$alias) ? 'active' : ''}}" href="{{ route('new.profile.products',$alias)}}">Products</a></li>
    @endif
    <li><a class="{{ Route::is('new.profile.rfqs',$alias) ? 'active' : ''}}" href="{{route('new.profile.rfqs',$alias)}}">RFQs</a></li>
    <li><a class="{{ Route::is('new.profile.profoma_orders.pending',$alias) ? 'active' : ''}}" href="{{route('new.profile.profoma_orders.pending',$alias)}}">POs</a></li>
    <li><a class="{{ Route::is('new.profile.development_center',$alias) ? 'active' : ''}}" href="{{route('new.profile.development_center',$alias)}}">Development Center</a></li>
    <li><a class="{{ Route::is('new.profile.order_management',$alias) ? 'active' : ''}}" href="{{route('new.profile.order_management',$alias)}}">Order Management</a></li>
</ul>
