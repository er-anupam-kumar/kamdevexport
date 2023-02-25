@extends('admin.layouts.layout')

@section('title','Dashboard : '.env('APP_NAME'))

@section('content')

<div class="page-content">
	<div class="container-fluid">
		<!-- start page title -->
		<div class="row">
			<div class="col-12">
				<div class="page-title-box d-sm-flex align-items-center
				justify-content-between">
				<h4 class="mb-sm-0 font-size-18">Dashboard</h4>

				<div class="page-title-right">
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="javascript:
							void(0);">{{env('APP_NAME')}}</a></li>
							<li class="breadcrumb-item active">Dashboard</li>
						</ol>
					</div>

				</div>
			</div>
		</div>

		<div class="row">

		</div>
	</div>
</div>
@endsection