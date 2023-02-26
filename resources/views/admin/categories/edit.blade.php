@extends('admin.layouts.layout')

@section('title','Edit Categories : '.env('APP_NAME'))

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
							<li class="breadcrumb-item active">Edit Category
							</li>
						</ol>
					</div>

				</div>
			</div>
		</div>

		{{ Form::open(array('url' => '/admin/categories/'.encrypt($category->id), 'method' => 'PUT','id'=>'form')) }}

		<div class="row">
			<div class="col-lg-12">

				<div class="card">
					<div class="card-header">
						<h4 class="card-title">Edit Category</h4>
						<p class="card-title-desc">Fill the form below to edit category.</p>
					</div>
					<div class="card-body">					
						<div class="row">

							<div class="col-sm-6 mb-2">
								<div class="form-group">
									<label for="name">Name</label>
									<input type="text" class="form-control" name="name" value="{{ $category->name }}" id="name" placeholder="Enter name" required maxlength="50">
								</div>
							</div>

							<div class="col-sm-6 mb-2">
								<div class="form-group">
									<label for="featured">Featured</label>
									<select id="featured" name="featured" class="form-control">
										<option value="Yes" {{$category->featured=='Yes'?'selected':''}}>Yes</option>
										<option value="No" {{$category->featured=='No'?'selected':''}}>No</option>
									</select>		
								</div>							
							</div>

							<div class="col-sm-6 mb-4">
								<div class="form-group">
									<label for="image">Image</label>
									<input type="file" accept=".png,.jpeg,.jpg" class="form-control mb-2" name="image" id="image">

									@if($category->image_url)
									<div class="form-group" id="multiGroup">
										<!-- <label>Uploaded Images</label> -->
										<div class="file-input ">
											<div class="file-preview_images  d-flex">
												<div class="file-preview-thumbnails"  id="0">
													<div class="file-preview-frame">
														<img src="{{ asset($category->image_url) }}" class="file-preview-image" alt="Image Thumbnail" style="height:160px;width:160px;">
														<div class="file-thumbnail-footer">
															<div class="file-actions">
																<div class="file-footer-buttons">
																	<button type="button" data-id="{{ $category->id }}" data-key="0" class="btn btn-danger delete_images" title="Remove file">X</button>
																</div>
																<div class="clearfix"></div>
															</div>
														</div>
													</div>
												</div>
												<div class="clearfix"></div>
											</div>
										</div>
									</div>
									@endif
								</div>
							</div>

							<div class="col-sm-6 mb-2">
								<div class="form-group">
									<label for="category_status">Status</label>
									<select id="category_status" name="category_status" class="form-control">
										<option value="1" {{$category->status=='1'?'selected':''}}>Active</option>
										<option value="0" {{$category->status=='0'?'selected':''}}>Inactive</option>
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
									<input type="text" class="form-control" name="meta_tags" value="{{ $category->meta_tags }}" id="meta_tags" placeholder="Enter meta-tags" maxlength="50">
								</div>
							</div>

							<div class="col-sm-12 mb-2">
								<div class="form-group">
									<label for="meta_description">Meta Description</label>
									<input type="textarea" class="form-control" name="meta_description" value="{{ $category->meta_description }}" id="meta_description" placeholder="Enter meta-description" maxlength="100">
								</div>
							</div>
							<div class="col-sm-12 mb-2">
								<div class="form-group">
									<label for="description">Description</label>
									<textarea class="form-control tinymce"  name="description" id="description" placeholder="Enter description">{!!$category->description!!}</textarea>
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

@section('script')
<script>	
$(document).on('click', '.delete_images', function(){
		if(confirm("Are you sure you want to delete this image?")){
			var id = $(this).attr('data-id');
			var key = $(this).attr('data-key');

			$.ajax({
				type: "GET",
				url: "{{ url('admin/categories') }}/"+id+"/delete_image",
				data: {},
				dataType: "json",
				success: function( msg ) {
					if(msg.status == 'success'){

						$(".file-preview-thumbnails#"+key).remove();
					}else{
						alert(msg.message);
					}
				}
			});
		}
	});
</script>
@endsection