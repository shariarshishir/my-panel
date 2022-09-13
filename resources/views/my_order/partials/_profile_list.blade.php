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
</style>
@endsection

<div class="col s12 profile-menu-list">
    <ul class=" z-depth-1 profile-tabs">
        <li class="profile-item-tab  orders-tab"><a class="{{ Route::is('myorder') ? 'active' : ''}}" href="{{route('myorder')}}">Submitted Orders</a></li>
        <li class="profile-item-tab  orders-modification-tab"><a class="{{ Route::is('ord.mod.req.index') ? 'active' : ''}}" href="{{route('ord.mod.req.index')}}"><span class="orderModificationCount"></span>  Requested For Modification</a></li>
        <li class="profile-item-tab  orders-tab"><a class="{{ Route::is('user.order.query.index') ? 'active' : ''}}" href="{{route('user.order.query.index')}}"><span class="orderQueryProcessedCount"></span> Orders Query</a></li>
        <li class="profile-item-tab  inquiries-tab"><a class="{{ Route::is('po.index') ? 'active' : ''}}" href="{{route('po.index')}}"> Inquiries</a></li>
        {{-- <li class="profile-item-tab  quick-query-tab"><a class="" href="#"> Quick Query</a></li> --}}
    </ul>
</div>

