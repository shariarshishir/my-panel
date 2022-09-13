
@extends('layouts.app_containerless')

@section('content')
    <div id="main">
        <div class="row">
            <div class="banner-outer-wrapper suppliers-list">
                <div class="container">
                    <div class="row">
                        <div class="col m12 banner-outer">
                            <div class="vendor-banner-text">
                                <h3>KNOW MORE, SOURCE BETTER</h3>
                                <h5>Get to know suppliers trade insight, contact info and listed products by your desired category</h5>
                            </div>
                            <div class="shop-key-features">
                                <div class="row">
                                    <div class="col m3 supplier-gold">
                                        <div class="key-item white lighten-1">
                                            <a href="javascript:void(0);" class="overlay_hover"></a>
                                            <div class="key-icon">
                                                <i aria-hidden="true" class="fas fa-ribbon"></i>
                                            </div>
                                            <div class="key-content">
                                                <h4>Gold</h4>
                                                <p>Suppliers</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col m3 supplier-experienced">
                                        <div class="key-item white lighten-1">
                                            <a href="javascript:void(0);" class="overlay_hover"></a>
                                            <div class="key-icon">
                                                <i aria-hidden="true" class="fas fa-ribbon"></i>
                                            </div>
                                            <div class="key-content">
                                                <h4>Experienced</h4>
                                                <p>Suppliers</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col m3 supplier-verified">
                                        <div class="key-item white lighten-1">
                                            <a href="javascript:void(0);" class="overlay_hover"></a>
                                            <div class="key-icon">
                                                <i class="material-icons dp48">verified_user</i>
                                            </div>
                                            <div class="key-content">
                                                <h4>Verified</h4>
                                                <p>Suppliers</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col m3 supplier-secured">
                                        <div class="key-item white lighten-1">
                                            <a href="javascript:void(0);" class="overlay_hover"></a>
                                            <div class="key-icon">
                                                <i class="material-icons dp48">lock</i>
                                            </div>
                                            <div class="key-content">
                                                <h4>Trade Secured</h4>
                                                <p>Suppliers</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="main-content-area">
                <div class="container">
                    <div class="row">
                        <div class="col m12 content-column">
                            <div class="row show-product-results-wrapper">
                                <div class="col s12 m12 l12 show-product-results-inside-wrapper">
                                    <div class="col s12 m6 l6 show-total-results">
                                        Showing {{($vendors->currentpage()-1)*$vendors->perpage()+1}} to {{$vendors->currentpage()*$vendors->perpage()}} of  {{$vendors->total()}} results
                                    </div>
                                    <div class="col s12 m6 l6 product-filters-and-views">
                                        <div class="col s6 m8 l8 sorting-filter">
                                            <select class="select2 browser-default sorting_vendor">
                                                <option value="" disabled selected>Select</option>
                                                <option value="name">Sort by Name</option>
                                                <option value="created_at">Sort by Latest</option>
                                            </select>
                                        </div>
                                        <div class="col s12 m4 l4 hide-on-med-and-down grid-list-filter">
                                            <a href="javascript:void(0);" class="btn btn-default btn-grid active">
                                                <i class="material-icons dp48">grid_on</i>
                                            </a>
                                            <a href="javascript:void(0);" class="btn btn-default btn-list">
                                                <i class="material-icons dp48">list</i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row active_grid ">
                                @if(count($vendors)>0)
                                <div class="sorting_vendor_list">
                                   @include('include.partials._vendor_list')
                                </div>
                            </div>
                            <div class="pagination-block-wrapper">
                                <div class="col s12 center">
                                    {!! $vendors->links() !!}
                                </div>
                            </div>

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
    </div>
@endsection
@push('js')
    <script>
    //sorting vendor
    $(document).on('change','.sorting_vendor', function(){
        var value= $(this).val();
        var url = '{{ route("sorting.vendor", ":value" )}}';
            url = url.replace(':value', value);
        $.ajax({
            method: 'get',
            processData: false,
            contentType: false,
            cache: false,
            url: url,
            beforeSend: function() {
                $("body").addClass("loading");
            },
            complete: function(){
                $("body").removeClass("loading");
            },
            success:function(data)
                {

                    $('.sorting_vendor_list').html('');
                    $('.sorting_vendor_list').html(data.data);
                },
            error: function(xhr, status, error)
                {
                    $('#errors').empty();
                    $("#errors").append("<li class='alert alert-danger'>"+error+"</li>")
                    $.each(xhr.responseJSON.error, function (key, item)
                    {
                        $("#errors").append("<li class='alert alert-danger'>"+item+"</li>")
                    });
                }
        });

    });
    </script>
@endpush



