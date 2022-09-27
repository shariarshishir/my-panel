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
						<li class="breadcrumb-item active">Users </li>
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
					<div class="card">
						<legend>Verification list</legend>
						<div class="no_more_tables">
                            @if(count($users) > 0)
							<table class="table table-bordered users-table data-table" >
								<thead class="cf">
									<tr>
										<th>User Name</th>
										<th>Email</th>
										<th>Phone</th>
                                        <th>&nbsp;</th>
									</tr>
								</thead>
                                <tbody>
                                    @foreach ($users as $user)
                                    <tr>
                                        <td>{{$user->name}}</td>
                                        <td>{{$user->email}}</td>
                                        <td>{{$user->phone}}</td>
                                        <td><a href="javascript:void(0);" class="trigger_user_request_approve_from_admin" data-id="{{$user->id}}">Click to verify</a></td>
                                    </tr>
                                    @endforeach
                                </tbody>
							</table>
                            @else
                                No request found.
                            @endif
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
        $(".trigger_user_request_approve_from_admin").click(function(){
            var user_id = $(this).data('id');
            var url = "{{route('update.user.verification.request')}}";

            if (confirm('Are you sure?'))
            {
                $.ajax({
                    type:'GET',
                    url: url,
                    dataType:'json',
                    data:{id : user_id },
                    beforeSend: function() {
                        $('.loading-message').html("Please Wait.");
                        $('#loadingProgressContainer').show();
                    },
                    success:function(data)
                    {
                        window.location.reload();
                    }
                });
            }

        });
  </script>
@endpush
