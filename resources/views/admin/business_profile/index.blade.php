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
              <li class="breadcrumb-item active">Dashboard </li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <legend>Profiles</legend>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
				    <legend>{{ucwords(str_replace("_", " ", $type))}}</legend>
                <div class="no_more_tables">
                      <table class="table table-bordered users-table data-table" >
                          <thead class="cf">
                                  <tr>
                                      <th>Business Name</th>
                                      <th>Category</th>
                                      <th>Parent User</th>
                                      <th>Representative Name</th>
                                      <th>Representative Email</th>
                                      <th>Phone</th>
                                      <th>Badge</th>
                                      <th>Action</th>
                                      <th>Push</th>
                                  </tr>
                          </thead>
                      </table>
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
</div>

@endsection

@push('js')
  <script>

    $(function () {
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            // order: [['5', 'desc']],
            ajax: "{{ route('admin.business.profile.list.type', $type) }}",
            columns: [
                {data: 'business_name', name: 'business_name'},
                {data: 'category', name: 'category'},
                {data: 'parent_user', name: 'parent_user'},
                {data: 'representative_name', name: 'representative_name'},
                {data: 'representative_email', name: 'representative_email'},
                {data: 'phone', name: 'phone', orderable: false},
                {data: 'badge', name: 'badge'},
                {data: 'action', name: 'action'},
                {data: 'push', name: 'push'},
            ]
        });


        $(document).on('change','.selectRow',function() {
                var sure = confirm("Are you sure?");
                if(sure == false){
                    var checkBoxes = $(this);
                    checkBoxes.prop("checked", !checkBoxes.prop("checked"));
                    return false;
                }
                var status = $(this).prop('checked') == true ? 1 : 0;
                var profile_id = $(this).data('id');
                if(status  == false){
                    var url = '{{ route("admin.business.profile.delete", ":slug") }}';
                }else{
                    var url = '{{ route("admin.business.profile.restore", ":slug") }}';
                }
                url = url.replace(':slug', profile_id);

                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: url,
                    //data: {'status': status, 'profile_id': user_id},
                    beforeSend: function() {
                        $('.loading-message').html("Please Wait.");
                        $('#loadingProgressContainer').show();
                    },
                    success: function(data){
                        $('.loading-message').html("");
		                $('#loadingProgressContainer').hide();
                        table.draw();
                    }
                });
            })



    });


  </script>
@endpush
