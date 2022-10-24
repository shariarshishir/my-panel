@if(count(auth()->user()->unreadNotifications) > 0)
    <div class="card-alert card orange store-update-warning">
    <div class="card-content white-text">
    <ul style="margin: 0px;">
    @foreach( auth()->user()->unreadNotifications as $notification)
        @if($notification->type == "App\Notifications\ProductAvailabilityNotification")

            {{-- <!-- @foreach ($notification->data['alert_data'] as $key => $data)
                @foreach ($data as $key2 => $data2 )
                {{ $key2 }} {{ $data2 }}
                @endforeach
            @endforeach --> --}}
            @if(isset($notification->data['alert_data']))
               <li>WARNING : Stock quantity of "{{ $notification->data['notification_data']['name'] }}" is less than MOQ. Please restock to keep business coming. Please click <a href="javascript:void(0)" class="seller-edit-product notification_identifier" id="{{$notification->data['notification_data']['sku']}}" data-notification-id="{{ $notification->data['notification_data']['id'] }}">here</a> </li>
            @else
               <li>WARNING : Stock out of "{{ $notification->data['notification_data']['name'] }}". Please restock to keep business coming. Please click <a href="javascript:void(0)" class="seller-edit-product notification_identifier" id="{{$notification->data['notification_data']['sku']}}" data-notification-id="{{ $notification->data['notification_data']['id'] }}">here</a> </li>
            @endif
        @endif
    @endforeach
    </ul>
    </div>
    </div>
@endif
<section class="content">
    <div class="container-fluid">
        <div class="product-list-block">
            <div class="col-md-12">
                    <div class="card card-with-padding">
                        <legend>Products List</legend>
                        <div class="card-body">
                            <div class="row">
                                <div class="col s12 m12 add-new-product-button">
                                    <a href="javascript:void(0);" class="modal-trigger tooltipped product-add-modal-trigger btn waves-effect waves-light green" data-position="top" data-tooltip="add new product">
                                        <i class="material-icons dp48">add</i> Add New product
                                    </a>
                                </div>
                            </div>
                        <div>

                        <div class="seller-product-list">
                            <div class="exists-seller-product-list">
                                <div class="col s12 m12 product-search-block">
                                    <div class="row">
                                        <div class="col s12 m4">
                                            <label for="status">Status</label>
                                            <select class="select2 browser-default" name="status_id" id="filter_state" >
                                                <option value=""  selected>Choose your option</option>
                                                <option value="1" >Publish</option>
                                                <option value="0" >UnPublish</option>
                                            </select>
                                        </div>
                                        <div class="col s12 m4">
                                            <label for="new_arrival">Product Type</label>
                                            <select class="select2 browser-default" name="filter_product_type" id="filter_product_type">
                                                <option value="" selected>Choose your option</option>
                                                <option value="1">Fresh Order</option>
                                                <option value="2">Ready Stock</option>
                                                <option value="3">Non Clothing Item</option>
                                            </select>
                                        </div>
                                        {{-- <div class="col s12 m4">
                                            <label for="product_category_id">Is Featured</label>
                                            <select class="select2 browser-default" name="featured_id" id="filter_featured">
                                                <option value=""  selected>Choose your option</option>
                                                <option value="1">Active</option>
                                                <option value="0">InActive</option>
                                            </select>
                                        </div>
                                        <div class="col s12 m4">
                                            <label for="new_arrival">New Arrival</label>
                                            <select class="select2 browser-default" name="new_arrival_id" id="filter_arrival">
                                                <option value="" selected>Choose your option</option>
                                                <option value="1">Active</option>
                                                <option value="0">InActive</option>
                                            </select>
                                        </div> --}}
                                    </div>
                                    <div class="row input-field">
                                        <div class="col s12 m3">
                                            <label>Search:</label>
                                        </div>
                                        <div class="col s12 m3">
                                            <input type="search" class="form-control input-sm" placeholder="Enter Product Name" id="dt-product-name-search" autocomplete="off">
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="table-content">
                                    <div clss="no_more_tables">
                                        <table class="table striped" width="100%" id="seller-product-datatable">
                                            <thead class="cf">
                                                <tr>
                                                    <th>Image</th>
                                                    <th>Product Name</th>
                                                    <th>Status</th>
                                                    <th>Featured</th>
                                                    <th>New Arrival</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="card-alert card cyan card-with-padding not-exists-seller-product-list">
                                <div class="card-content white-text" style="padding: 0px;">
                                    <p>INFO : You don't have any products in the list. Please click "Add New Product" button to add products.</p>
                                </div>
                            </div>


                        </div>

                        @include('user.profile.products._add_product_modal')
                        @include('user.profile.products._edit_product_modal')

                    </div>
            </div>
        </div>
    </div>
</section>

@include('user.profile.products._scripts')
