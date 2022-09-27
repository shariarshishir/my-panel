
@extends('layouts.admin')

@section('content')
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<div class="content-header">
			<div class="container-fluid">
				<div class="row mb-2">
					<div class="col-sm-12">
						<ol class="breadcrumb float-sm-right">
							<li class="breadcrumb-item"><a href="#">Home</a></li>
							<li class="breadcrumb-item active">Dashboard</li>
						</ol>
					</div><!-- /.col -->
				</div><!-- /.row -->
			</div><!-- /.container-fluid -->
		</div>
		<!-- /.content-header -->

		<!-- Main content -->
		<section class="content">
			<div class="card">
				<legend>Dashboard</legend>
				
				<div class="row">
					<div class="col-md-6">
						<div class="data-filter-bar">
							<select name="stats_year" id="stats_year" class="statistics-list">
								<option value="2017">2017</option>
								<option value="2018">2018</option>
								<option value="2019">2019</option>
								<option value="2020">2020</option>
								<option value="2021">2021</option>
								<option value="2022" selected="selected">2022</option>
							</select>
							<select name="stats_month" id="stats_month" class="statistics-list">
								<option value="" selected="selected">All</option>
								<option value="01">Jan</option>
								<option value="02">Feb</option>
								<option value="03">Mar</option>
								<option value="04">Apr</option>
								<option value="05">May</option>
								<option value="06">Jun</option>
								<option value="07">Jul</option>
								<option value="08">Aug</option>
								<option value="09">Sep</option>
								<option value="10">Oct</option>
								<option value="11">Nov</option>
								<option value="12">Dec</option>
							</select>		
							<a href="javascript:void(0);" class="show-users-list-trigger btn_green">Show registered users list</a>
							<div class="modal fade" id="user-list-modal">
								<div class="modal-dialog modal-xl" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title" id="userListModalLabel">User List</h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
										</div>
										<div class="modal-body">
											<div class="no_more_tables">
												<div class="selected-users-list-block"></div>
											</div>
										</div>
									</div>
								</div>
							</div>							
						</div>
						<div id="registered-userschartbar-container" style="margin: 0 auto;"></div>
					</div>
					<div class="col-md-6">
						<div class="active_users_list">
							<a href="javascript:void(0);" class="show-active-users-list-trigger btn_green">Show active users list</a>
						</div>
						
						<div class="modal fade" id="active-users-list-modal">
							<div class="modal-dialog modal-xl" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="ActiveUsersListModalLabel">User List</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<div class="no_more_tables">
											<div class="active-users-list-block"></div>
										</div>
									</div>
								</div>
							</div>
						</div>						
						<div id="active-userschartbar-container" style="margin: 0 auto;"></div>
					</div>
				</div>

			</div>
			<div class="card">
				<div class="row number-counts-on-dashboard" style="text-align: center;">
					<div class="col-md-3">
						<h3 class="count">{{$rfqsCount}}</h3>
						<span>Total RFQ Submitted</span>
					</div>
					<div class="col-md-3">
						<h3 class="count">{{$suggestedSupplierCount}}</h3>
						<span>Total Quotation sent</span>
					</div>
					<div class="col-md-3">
						<h3 class="count">{{$proformaInvoicesCount}}</h3>
						<span>Total Proforma Invoice (PI)</span>
					</div>
					<div class="col-md-3">
						<h3 class="count">{{$proformaOrdersCount}}</h3>
						<span>Total Purchase Orders (PO)</span>
					</div>
				</div>				
			</div>			
		</section>
		<!-- /.content -->
	</div>
  @endsection

@push('js')
<script>
var area_chart, bar_chart, xhr, xhr2;
$(document).ready(function () {

	$(".count").each(function () {
		$(this)
		.prop("Counter", 0)
		.animate(
			{
				Counter: $(this).text(),
			},
			{
				duration: 4000,
				easing: "swing",
				step: function (now) {
					now = Number(Math.ceil(now)).toLocaleString('en');
					$(this).text(now);
				},
			}
		);
  	});	
	
    area_chart = Highcharts.chart('registered-userschartbar-container', {
		chart: {
			type: 'area',
			//width: $(window).width() - 100,
			height: 400
		},
		title: {
			text: 'Monthly registered user'
		},
		credits: {
			enabled: false
		},
		legend: {
			enabled: false
		},
		xAxis: {
			categories: [],
			crosshair: true
		},
		yAxis: {
			allowDecimals: false,
			min: 0,
			title: {
				text: 'Number of Users'
			}
		},
		loading: {
			labelStyle: {
				color: '#333333'
			},
			style: {
				"position": "absolute", "backgroundColor": "#ffffff", "opacity": 0.9, "textAlign": "center"
			}
		},
		tooltip: {
			headerFormat: '<span style="font-size:12px"><b>{point.key}</b></span><table>',
			pointFormat: '<tr><td style="color:{series.color};padding:0">Users: </td>' +
			'<td style="padding:0"><b>{point.y}</b></td></tr>',
			footerFormat: '</table>',
			shared: true,
			useHTML: true
		},
		plotOptions: {
			column: {
				pointPadding: 0.2,
				borderWidth: 0
			}
		},
		series: [{
			name: 'Months',
			data: []
		}]
    });

    $.fn.getStatsData = function() 
	{
		// if there is a previous ajax search, then we abort it and then set xhr to null
			if( xhr != null ) {
				xhr.abort();
				xhr = null;
			}
		
		var stats_month = $("#stats_month").val();
		if(stats_month==""){
			var all_month_val = 1;
		}
		else {
			var all_month_val = 0;
		}
		
		xhr = $.ajax({
			type: 'get',
			url: '{{ route("monthly.registered.users") }}',
			data: {
				stats_year: $("#stats_year").val(),
				all_month: all_month_val,
				stats_month: function(){
					var stats_month = $("#stats_month").val();
					if(stats_month=="")  // if month is ALL, send all month options
					{
						var all_months = new Array;
						$("#stats_month option").each(function()
						{
							if($(this).val()!=""){
								all_months.push($(this).val());
							}
						});
						
						return all_months;
					}
					else {
						return stats_month;
					}
				}
			},
			dataType: 'json',
			beforeSend: function(){
				area_chart.showLoading();
			},
			complete: function(){
			},
			success: function(response){
				console.log(response);
				area_chart.hideLoading();
				
				if(response.error==0){

					area_chart.xAxis[0].setCategories(response.barCategories);
					area_chart.series[0].setData(response.barData);
					
					if(all_month_val==1){
						area_chart.xAxis[0].setTitle({text: 'Months'});
					}
					else {
						area_chart.xAxis[0].setTitle({text: 'Days'});
					}

				}
			}
		})  
    };
    
    $.fn.getStatsData();
	$('#stats_year, #stats_month').change(function(){
		$.fn.getStatsData();
    });

	$(".show-users-list-trigger").click(function()
	{
		var selectedYear = $("#stats_year").val();
		var selectedMonth = $("#stats_month").val();
		var url = '{{ route("get.userslist.basedonselectedparams") }}';
		$.ajax({
			method: 'get',
			data: {selectedYear:selectedYear, selectedMonth:selectedMonth},
			url: url,
			beforeSend: function() {
				$('.loading-message').html("Please Wait.");
				$('#loadingProgressContainer').show();
			},
			success:function(response)
			{
				$('.loading-message').html();
				$('#loadingProgressContainer').hide();				
				$('#user-list-modal').modal('show');
				$(".selected-users-list-block").html(response.data);
			}
		});
	});
	$('#user-list-modal').on('hidden.bs.modal', function () {
    	$(".selected-users-list-block").html();
	});

	// bar chart start

    bar_chart = Highcharts.chart('active-userschartbar-container', {
		chart: {
			type: 'line',
			//width: $(window).width() - 100,
			height: 400
		},
		title: {
			text: 'Recently active users'
		},
		credits: {
			enabled: false
		},
		legend: {
			enabled: false
		},
		xAxis: {
			categories: [],
			crosshair: true
		},
		yAxis: {
			allowDecimals: false,
			min: 0,
			title: {
				text: 'Number of Users'
			}
		},
		loading: {
			labelStyle: {
				color: '#333333'
			},
			style: {
				"position": "absolute", "backgroundColor": "#ffffff", "opacity": 0.9, "textAlign": "center"
			}
		},
		tooltip: {
			headerFormat: '<span style="font-size:12px"><b>{point.key}</b></span><table>',
			pointFormat: '<tr><td style="color:{series.color};padding:0">Users: </td>' +
			'<td style="padding:0"><b>{point.y}</b></td></tr>',
			footerFormat: '</table>',
			shared: true,
			useHTML: true
		},
		plotOptions: {
			column: {
				pointPadding: 0.2,
				borderWidth: 0
			}
		},
		series: [{
			name: 'Weeks',
			data: []
		}]
    });

    $.fn.getLastTwoWeeksActiveUserStatsData = function() 
	{
		// if there is a previous ajax search, then we abort it and then set xhr to null
		if( xhr2 != null ) {
			xhr2.abort();
			xhr2 = null;
		}
		
		var last_two_weeks = 2;
		xhr2 = $.ajax({
			type: 'get',
			url: '{{ route("get.last.twoweeks.active.users") }}',
			data: {
				last_two_weeks: last_two_weeks
			},
			dataType: 'json',
			beforeSend: function(){
				bar_chart.showLoading();
			},
			complete: function(){
			},
			success: function(response){
				console.log(response);
				bar_chart.hideLoading();

				if(response.error==0){

					bar_chart.xAxis[0].setCategories(response.barCategories);
					bar_chart.series[0].setData(response.barData);
					bar_chart.xAxis[0].setTitle({text: 'Days'});

				}
				
			}
		})  
    };
    
    $.fn.getLastTwoWeeksActiveUserStatsData();
	/*
	$('#stats_year, #stats_month').change(function(){
		$.fn.getLastTwoWeeksActiveUserStatsData();
    });
	*/

	$(".show-active-users-list-trigger").click(function()
	{
		var last_two_weeks = 2;
		var url = '{{ route("get.userslist.basedonactivityparams") }}';
		$.ajax({
			method: 'get',
			data: {last_two_weeks:last_two_weeks},
			url: url,
			beforeSend: function() {
				$('.loading-message').html("Please Wait.");
				$('#loadingProgressContainer').show();
			},
			success:function(response)
			{
				$('.loading-message').html();
				$('#loadingProgressContainer').hide();				
				$('#active-users-list-modal').modal('show');
				$(".active-users-list-block").html(response.data);
			}
		});
	});
	$('#active-users-list-modal').on('hidden.bs.modal', function () {
    	$(".active-users-list-block").html();
	});	
		
	
});	
</script>
@endpush
