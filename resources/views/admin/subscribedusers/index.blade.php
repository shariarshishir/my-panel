@extends('layouts.admin')
@section('content')

<!-- Main content -->


<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Subscribed Users</li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card admin_categories_list">
                        <legend>Subscribed Users List</legend>
                        <div style="text-align: right;">
                            <a href="{{route('export.subscribed.users.email')}}" target="_blank" class="btn btn-primary">Export Emails</a>
                        </div>
                        <div class="no_more_tables">
                            <table id="" class="table table-striped table-bordered table-hover blog_list_table" width="100%">
                                <thead class="cf">
                                    <tr>
                                        <th data-hide="ID">ID</th>
                                        <th data-class="Email">Email</th>
                                        <th data-class="Date">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($subscribedUserList as $index => $item)
                                    <tr>
                                        <td data-title="ID">{{ $index+1 }}</td>
                                        <td data-title="Email">{{ $item->newsletter_email_address }}</td>
                                        <td data-title="Date">{{ $item->created_at }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="pagination">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>


@endsection
@section('js')
<script>
    $(document).ready(function(){
        $(".export_email_trigger").click(function(){

            var url = "{{route('export.subscribed.users.email')}}";
            if (confirm('Are you sure?'))
            {
                $.ajax({
                    type:'GET',
                    url: url,
                    dataType:'json',
                    beforeSend: function() {
                        $('.loading-message').html("Please Wait.");
                        $('#loadingProgressContainer').show();
                    },
                    success:function(data)
                    {
                        $('.loading-message').html("");
                        $('#loadingProgressContainer').hide();
                        console.log(data.data);
                        //window.location.reload();
                    }
                });
            }

        })
    })
</script>
@endsection
