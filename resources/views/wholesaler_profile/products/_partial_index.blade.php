<section class="content">
    <div class="container-fluid">
        <div class="product-list-block">
            <div class="col-md-12">
                    <div class="card-with-padding profile_wholesaler_inner">
                        @include('wholesaler_profile.verification_message')
                        <div class="card-body">
                            <div class="row">
                                <div class="col m12 add-new-product-button">
                                    <a href="javascript:void(0);" class="btn_green modal-trigger tooltipped product-add-modal-trigger btn waves-effect waves-light green" data-position="top" data-tooltip="add new product">
                                        <i class="material-icons dp48">add</i> Add New product
                                    </a>
                                </div>
                            </div>
                        <div>
                        <legend>Products List</legend>
                        <div class="seller-product-list">
                            <div class="exists-seller-product-list">
                                <div class="product-search-block">
                                    <div class="row">
                                        <div class="col s12 m4">
                                            <div class="input-field">
                                                <div class="col s12">
                                                    <label for="status">Status</label>
                                                </div>
                                                <select class="select2 browser-default" name="status_id" id="filter_state" >
                                                    <option value=""  selected>Choose your option</option>
                                                    <option value="1" >Publish</option>
                                                    <option value="0" >UnPublish</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col s12 m4">
                                            <div class="input-field">
                                                <div class="col s12">
                                                    <label for="new_arrival">Product Type</label>
                                                </div>
                                                <select class="select2 browser-default" name="filter_product_type" id="filter_product_type">
                                                    <option value="" selected>Choose your option</option>
                                                    <option value="1">Fresh Order</option>
                                                    <option value="2">Ready Stock</option>
                                                    <option value="3">Non Clothing Item</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col s12 m4">
                                            <div class="input-field">
                                                <div class="col s12">
                                                    <label>Search</label>
                                                </div>
                                                <div class="col s12">
                                                    <input type="search" class="form-control input-sm" placeholder="Enter Product Name" id="dt-product-name-search" autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-content product_data_table_wrap">
                                    <div class="no_more_tables">
                                        <table class="table striped box_shadow_radius" width="100%" id="seller-product-datatable">
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
                            <div id="pageInfo" class="right pageInfo">

                            </div>

                            <div class="card-alert card cyan card-with-padding not-exists-seller-product-list">
                                <div class="card-content white-text" style="padding: 0px;">
                                    <p>INFO : You don't have any products in the list. Please click "Add New Product" button to add products.</p>
                                </div>
                            </div>


                        </div>

                        @include('wholesaler_profile.products._add_product_modal')
                        @include('wholesaler_profile.products._edit_product_modal')

                    </div>
            </div>
        </div>
    </div>
</section>

@include('wholesaler_profile.products._scripts')
