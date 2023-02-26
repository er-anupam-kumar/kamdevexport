@extends('admin.layouts.layout')

@section('title','Product : '.env('APP_NAME'))

@section('content')
<div class="page-content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="page-title-box d-sm-flex align-items-center justify-content-between">
					<h4 class="mb-sm-0 font-size-18">Product</h4>

					<div class="page-title-right">
						<ol class="breadcrumb m-0">
							<li class="breadcrumb-item"><a href="{{url('/admin')}}">{{env('APP_NAME')}}</a>
							</li>
							<li class="breadcrumb-item active">Product
							</li>
						</ol>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12" id="productBtnDiv" style="display: none">
				<a class="btn btn-primary w-md" href="{{url('admin/products/create')}}">Add New </a>
			</div>
			<div class="col-sm-2" id="productStatusDiv" style="display: none">
				<select id="productStatus" name="status" class="form-control form-control-sm productStatus">
					<option value="">Select Status</option>
					<option value="1">Active</option>
					<option value="0">Inactive</option>
				</select>									
			</div>

			<div class="col-sm-2" id="productDateDiv" style="display: none">
				<input id="productDate" name="from_date" class="form-control form-control-sm w-auto d-inline productDate ml-4" type="date" />
				<input id="productToDate" name="to_date" class="form-control form-control-sm w-auto d-inline productToDate ml-2" type="date" />
			</div>

			<div class="col-12">
				<div class="card">
					<div class="card-body">

						<table id="table" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
							<thead>
								<tr>
									<th class="action">#</th>
									<th>Name</th>
									<th>Category</th>
									<th>Status</th>
									<th>Featured</th>		
									<th>Created At</th>
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
			"order": [[ 5, "desc" ]],
			"ajax":{
				url :"{{ url('admin/products') }}",
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
			{ mData: 'category' },
			{ mData: 'status' },
			{ mData: 'featured' },			
			{ mData: 'created_at' },
			{ mData: 'actions' },
			],
			"aoColumnDefs": [
			{ "bSortable": false, "aTargets": ['action'] }
			],
			"language": {
				"zeroRecords": "No product available"
			},
			"dom":
			"<'ui grid'"+
			"<'row'"+
			"<'col-sm-6 mb-4 add_btn'>"+
			"<'col-sm-6 mb-4 text-right'B>"+
			"<'col-sm-2'l>"+
			"<'col-sm-2 status_filter'>"+
			"<'col-sm-5 date_filter'>"+
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

		$("div.add_btn").html($('#productBtnDiv').html());
		$("div.status_filter").html($('#productStatusDiv').html());
		$("div.date_filter").html($('#productDateDiv').html());

		$('.productStatus').on('change', function () {
			var status = $(this).val();
			table.columns(3)
			.search(status)
			.draw();
		});

		$('.productDate').on('change', function () {
			from_date = $(this).val();
			table.columns(4)
			.search(from_date)
			.draw();
		});

		$('.productToDate').on('change', function () {
			to_date = $(this).val();
			table.columns(5)
			.search(to_date)
			.draw();
		});
	});
</script>
@endsection