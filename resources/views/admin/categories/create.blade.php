@extends('admin.layouts.layout')

@section('title','Add Categories : '.env('APP_NAME'))

@section('style')

@endsection

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
							<li class="breadcrumb-item"><a href="{{url('/admin/categories')}}">Categories</a>
							</li>
							<li class="breadcrumb-item active">Add Category
							</li>
						</ol>
					</div>

				</div>
			</div>
		</div>

		{{ Form::open(array('url' => '/admin/categories', 'method' => 'POST','id'=>'form')) }}

		<div class="row">
			<div class="col-lg-12">

				<div class="card">
					<div class="card-header">
						<h4 class="card-title">Add Category</h4>
						<p class="card-title-desc">Fill the form below to add new category.</p>
					</div>
					<div class="card-body">					
						<div class="row">

							<div class="col-sm-6 mb-2">
								<div class="form-group">
									<label for="name">Name</label>
									<input type="text" class="form-control" name="name" id="name" placeholder="Enter name" maxlength="50">
								</div>
							</div>

							<div class="col-sm-6 mb-2">
								<div class="form-group">
									<label for="image">Image</label>
									<input type="file" accept=".png,.jpeg,.jpg" class="form-control" name="image" id="image">
								</div>
							</div>

							<div class="col-sm-6 mb-2">
								<div class="form-group">
									<label for="category_status">Status</label>
									<select id="category_status" name="category_status" class="form-control">
										<option value="1">Active</option>
										<option value="0">Inactive</option>
									</select>		
								</div>							
							</div>

							<div class="col-sm-6 mb-2">
								<div class="form-group">
									<label for="featured">Featured</label>
									<select id="featured" name="featured" class="form-control">
										<option value="Yes">Yes</option>
										<option value="No">No</option>
									</select>		
								</div>							
							</div>
						</div>
					</div>
				</div>

				<div class="card">
					<div class="card-body">					
						<div class="row">
							<div class="col-sm-12 mb-2">
								<div class="form-group">
									<label for="meta_tags">Meta Tags</label>
									<input type="text" class="form-control" name="meta_tags" id="meta_tags" placeholder="Enter meta-tags" maxlength="50">
								</div>
							</div>
							<div class="col-sm-12 mb-2">
								<div class="form-group">
									<label for="meta_description">Meta Description</label>
									<input type="textarea" class="form-control" name="meta_description" id="meta_description" placeholder="Enter meta-description" maxlength="100">
								</div>
							</div>
							<div class="col-sm-12 mb-2">
								<div class="form-group">
									<label for="description">Description</label>
									<textarea class="form-control tinymce" name="description" id="description" placeholder="Enter description"></textarea>
								</div>
							</div>

						</div>
					</div>
				</div>

				<div class="card">
					<div class="card-body">	
						<div class="row">

							<div class="col-sm-6">
								<a href="{{ url('/admin/categories') }}" class="btn btn-primary w-md">
								Go Back</a>
							</div>

							<div class="col-sm-6 text-right">
								<button class="btn btn-primary w-md" type="submit" id="submit">Submit</button>
							</div>							

						</div>

					</div>
				</div>

			</div>
		</div>

		{{Form::close()}}

	</div>
</div>
@endsection