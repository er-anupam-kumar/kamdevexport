@extends('admin.layouts.layout')

@section('title','Categories : '.env('APP_NAME'))

@section('content')
<div class="page-content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="page-title-box d-sm-flex align-items-center justify-content-between">
					<h4 class="mb-sm-0 font-size-18">Categories</h4>

					<div class="page-title-right">
						<ol class="breadcrumb m-0">
							<li class="breadcrumb-item"><a href="{{url('/admin')}}">{{env('APP_NAME')}}</a>
							</li>
							<li class="breadcrumb-item active">Categories
							</li>
						</ol>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12" id="categoryBtnDiv" style="display: none">
				<a class="btn btn-primary w-md" href="{{url('admin/categories/create')}}">Add New </a>
			</div>
			<div class="col-sm-2" id="categoryStatusDiv" style="display: none">
				<select id="categoryStatus" name="status" class="form-control form-control-sm categoryStatus">
					<option value="">Select Status</option>
					<option value="1">Active</option>
					<option value="0">Inactive</option>
				</select>									
			</div>

			<div class="col-12">
				<div class="card">
					<div class="card-body">

						<table id="table" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
							<thead>
								<tr>
									<th class="action">#</th>
									<th>Name</th>
									<th>Featured</th>
									<th>Status</th>
									<th class="action">Action</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>

					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('script')
<script>
	$(document).ready(function() {
		var table = $('#table').DataTable({
			"bProcessing": true,
			"serverSide": true,
			"pageLength": 50,
			"buttons": [
			{
				extend: 'excel',
				text: 'Export Excel',
				className: 'btn btn-default',
				exportOptions: {
					columns: 'th:not(:last-child)'
				}
			},
			{
				extend:'colvis'
			}
			],
			"order": [[ 1, "desc" ]],
			"ajax":{
				url :"{{ url('admin/categories') }}",
				error: function(){  
					alert('Something went wrong');
				}
			},
			"drawCallback": function(settings) {
				// console.log('fetched');
			},
			"aoColumns": [
			{ mData: 'id' },
			{ mData: 'name' },
			{ mData: 'featured' },
			{ mData: 'status' },
			{ mData: 'actions' },
			],
			"aoColumnDefs": [
			{ "bSortable": false, "aTargets": ['action'] }
			],
			"language": {
				"zeroRecords": "No category available"
			},
			"dom":
			"<'ui grid'"+
			"<'row'"+
			"<'col-sm-6 mb-4 add_btn'>"+
			"<'col-sm-6 mb-4 text-right'B>"+
			"<'col-sm-5'l>"+
			"<'col-sm-2'>"+
			"<'col-sm-2 status_filter'>"+
			"<'col-sm-3'f>"+
			">"+
			"<'row dt-table'"+
			"<'col-sm-12'tr>"+
			">"+
			"<'row'"+
			"<'col-sm-4'i>"+
			"<'col-sm-8'p>"+
			">"+
			">",
		});

		table.buttons().container().appendTo('#table_wrapper .col-md-6:eq(0)');

		$("div.add_btn").html($('#categoryBtnDiv').html());
		$("div.status_filter").html($('#categoryStatusDiv').html());

		$('.categoryStatus').on('change', function () {
			var status = $(this).val();
			table.columns(3)
			.search(status)
			.draw();
		});
	});
</script>
@endsection