@extends('layouts.admin')
@section('content')


<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Rfq </li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row admin_order_list_table_wrap">
                <div class="col-md-12">
                    <div class="rfq_order_list_top">
                        <div class="row">
                            <legend>RFQ</legend>
                            <div class="col-sm-12 col-md-6">
                                <div class="select_show">
                                    <label>Show</label>
                                        <select name="rfq_per_page" class="rfq-per-page" >
                                            <option value="10">10</option>
                                            <option value="20">20</option>
                                            <option value="30">30</option>
                                            <option value="40">40</option>
                                            <option value="50">50</option>
                                            <option value="60">60</option>
                                            <option value="100">100</option>
                                        </select>
                                    <label>Entries</label>
                                   
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="row">
                                    <div class="rfq_order_list_search">
                                        <label>Search</label>
                                        <input class="filter_title" placeholder="Search" name ="filter_title" type="text" />
                                        <div class="spinner-border text-primary spinner-class"style="display:none" role="status">
                                            <span class="visually-hidden"></span>
                                        </div>                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="no_more_tables">
                        @include('admin.rfq.table')
                    </div> 

                    @if( $noOfPages > 1)
                        @php
                            $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
                        @endphp
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <li class="page-item">
                                    <a class="page-link" href="javascript:void(0);" data-page="0" tabindex="-1">Previous</a>
                                </li>
                                @for( $i=1; $i <= $noOfPages; $i++)
                                    @php
                                        $r=route('admin.rfq.index');
                                    @endphp
                                    <li class="page-item page-element {{ ($page == $i) ? 'active':'' }}">
                                        <a class="page-link" href="{{ $r.'?page='.$i }}" data-page="{{$i}}">{{$i}}</a>
                                    </li>
                                @endfor
                                <li class="page-item">
                                    <a class="page-link" href="javascript:void(0);" data-page="2">Next</a>
                                </li>
                            </ul>
                        </nav>
                    @endif                        

                                   
                </div>
            </div>

        </div>
    </section>
</div>

@endsection
@push('js')
<script>
    $(document).ready(function(){
        //$(".pagination").children(".page-element").first().addClass("active");
        $(document).on('click', '.rfq-per-page', function(event){
            event.preventDefault(); 
            var rfqPerPage = $( ".rfq-per-page option:selected" ).val();
            var filter_title = $(".filter_title").val();
            console.log(rfqPerPage);
            console.log(filter_title);

            $.ajax({
                method: 'get',
                data: { limit:rfqPerPage, filter:filter_title},
                url: '{{ route("rfq.pagination") }}',
                beforeSend: function() {
                    $('.loading-message').html("Please Wait.");
                    $('#loadingProgressContainer').show();
                },
                success:function(response){
                    $('.loading-message').html("");
                    $('#loadingProgressContainer').hide();                    
                    $('.no_more_tables').html(response);
                }
            });
        });

        $(document).on('input', '.filter_title', function(event){
            var page = $(this).data("page");
            var rfqPerPage = $( ".rfq-per-page option:selected" ).val();
            var filter_title = $(".filter_title").val();
            $.ajax({
                method: 'get',
                data: { limit:rfqPerPage, filter:filter_title,page:page},
                url: '{{ route("rfq.pagination") }}',
                beforeSend: function() {
                    $('.spinner-border').show();
                },                
                success:function(response){
                    $('.spinner-border').hide();
                    $('.no_more_tables').html(response);
                }
            });
        });

        // $(document).on('click', '.page-link', function(event){
        //     if($(this).data('page') > 1) {
        //         $(".pagination").children(".page-element").removeClass("active");
        //         $(this).parent(".page-element").addClass("active");
        //     }
        // event.preventDefault(); 
        // var page = $(this).data("page");
        // var rfqPerPage = $( ".rfq-per-page option:selected" ).val();
        // var filter_title = $(".filter_title").val();
        // if(page == 1){
        //     $('.prev_link').data('page',page);
        // }else{
        //     $('.prev_link').data('page',page-1);
        // }
        // $('.next_link').data('page',page+1);
        
        // console.log(page);
        // $.ajax({
        //         method: 'get',
        //         data: { limit:rfqPerPage, filter:filter_title,page:page},
        //         url: '{{ route("rfq.pagination") }}',
        //         beforeSend: function() {
        //             $('.loading-message').html("Please Wait.");
        //             $('#loadingProgressContainer').show();
        //         },
        //         success:function(response){
        //             $('.loading-message').html("");
        //             $('#loadingProgressContainer').hide();
        //             $('.no_more_tables').html(response);
        //         }
        //     });
        // });

    });
</script>
@endpush



