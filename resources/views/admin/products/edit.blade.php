@extends('admin.layouts.layout')

@section('title','Edit Products : '.env('APP_NAME'))

@section('style')

@endsection

@section('content')
<div class="page-content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="page-title-box d-sm-flex align-items-center justify-content-between">
					<h4 class="mb-sm-0 font-size-18">Products</h4>

					<div class="page-title-right">
						<ol class="breadcrumb m-0">
							<li class="breadcrumb-item"><a href="{{url('/admin')}}">{{env('APP_NAME')}}</a>
							</li>
							<li class="breadcrumb-item"><a href="{{url('/admin/products')}}">Products</a>
							</li>
							<li class="breadcrumb-item active">Edit Product
							</li>
						</ol>
					</div>

				</div>
			</div>
		</div>

		{{ Form::open(array('url' => '/admin/products/'.encrypt($product->id), 'method' => 'PUT','id'=>'form')) }}

		<div class="row">
			<div class="col-lg-12">
				<div class="card">
					<div class="card-header">
						<h4 class="card-title">Edit Product</h4>
						<p class="card-title-desc">Fill the form below to add new product.</p>
					</div>
					<div class="card-body">					
						<div class="row">
							<div class="col-sm-6 mb-2">
								<div class="form-group">
									<label for="name">Name</label>
									<input type="text" class="form-control" name="name" id="name" value="{{ $product->name }}" placeholder="Enter name" required maxlength="50">
								</div>
							</div>
							<div class="col-sm-6 mb-2">
								<div class="form-group">
									<label for="category">Select Category</label>
									<select id="category" name="category" class="form-control select2">
										<option value="">Please select</option>
										@foreach ($categories as $category)
										<option value="{{$category->name}}" {{$product->category==$category->name?'selected':''}}>{{$category->name}}</option>
										@endforeach
									</select>		
								</div>							
							</div>

							<div class="col-sm-6 mb-2">
								<div class="form-group">
									<label for="product_status">Status</label>
									<select id="product_status" name="product_status" class="form-control">
										<option value="1" {{$product->status=='1'?'selected':''}}>Active</option>
										<option value="0" {{$product->status=='0'?'selected':''}}>Inactive</option>
									</select>		
								</div>							
							</div>

							<div class="col-sm-6 mb-2">
								<div class="form-group">
									<label for="featured">Featured</label>
									<select id="featured" name="featured" class="form-control">
										<option value="Yes" {{$product->featured=='Yes'?'selected':''}}>Yes</option>
										<option value="No" {{$product->featured=='No'?'selected':''}}>No</option>
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
									<label for="images">Images</label>
									<input type="file" multiple name="images[]" class="form-control image_input" id="image" data-rel='1'>
									<p class=" text-muted ">Maximum size should be 2mb and Maximum number of files should be 5.</p>

									<div class="form-group">
										<div class="file-input">
											<div class="file-preview">
												<div class="file-preview-thumbnails">
												</div>
												<div class="clearfix"></div>                        
											</div>
										</div>
									</div>

									@if($images)
									<div class="form-group" id="multiGroup">
										<!-- <label>Uploaded Images</label> -->
										<div class="file-input">
											<div class="file-preview_images d-flex">
												@foreach ($images as $key => $image)
												<div class="file-preview-thumbnails" id="{{ $key }}">
													<div class="file-preview-frame">
														<img src="{{ asset($image->image_url) }}" class="file-preview-image" alt="Image Thumbnail" style="height:160px;width:160px;">
														<div class="file-thumbnail-footer">

															<div class="file-actions">
																<div class="file-footer-buttons">

																	<button type="button" class="btn btn-danger delete_images" data-id="{{ $image->id }}" title="Remove file" data-key="{{ $key }}">X</button>

																</div>

																<div class="clearfix"></div>
															</div>
														</div>
													</div>
												</div>
												@endforeach
												<div class="clearfix"></div>
											</div>
										</div>
									</div>
									@endif
								</div>
							</div>
						</div>
					</div>
				</div>	


				<div class="card">
					<div class="card-body">					
						<div class="row">
							<div class="option_button mb-4">							
								<a href="javascript:void(0)" class="btn btn-sm btn-primary add_options">Add options</a>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<div class="card variants border-0">
									<div class="form-group row variant_label">
										<div class="col-sm-2">
											<h6>Listing Price</h6>
										</div>
										<div class="col-sm-2">
											<h6>Sell Price</h6>
										</div>
										<div class="col-sm-2">
											<h6>Quantity</h6>
										</div>
										<div class="col-sm-2">
											<h6>SKU</h6>
										</div>
										<div class="col-sm-2">
											<h6>Attribute</h6>
										</div>
									</div>
									@foreach ($variations as $key=>$variant)
									<div class="form-group row mb-2 variation">
										<div class="col-sm-2">
											<input type="text" value="{{$variant->listing_price}}" placeholder="Listing Price" name="variant_listing_price[]" class="form-control">
										</div>
										<div class="col-sm-2">
											<input type="text" value="{{$variant->sell_price}}" placeholder="Sell Price" name="variant_sell_price[]" class="form-control">
										</div>
										<div class="col-sm-2">
											<input type="text" value="{{$variant->quantity}}" placeholder="Quantity" name="variant_quantity[]" class="form-control">
										</div>
										<div class="col-sm-2">
											<input type="text" value="{{$variant->sku}}" placeholder="SKU" name="variant_sku[]" class="form-control">
										</div>
										<div class="col-sm-3">
											<input type="text" value="{{$variant->size}}" placeholder="Enter size" name="sizes[]" class="form-control">
										</div>			
										<div class="col-sm-1">
											<button href="javascript:;" class="remove-option btn btn-danger">X</button>
										</div>
									</div>
									@endforeach
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
									<input type="text" class="form-control" name="meta_tags" id="meta_tags" value="{{ $product->meta_tags }}" placeholder="Enter meta tags" maxlength="100">
								</div>
							</div>

							<div class="col-sm-12 mb-2">
								<div class="form-group">
									<label for="meta_description">Meta Description</label>
									<input type="text" class="form-control" name="meta_description" id="meta_description" value="{{ $product->meta_description }}" placeholder="Enter meta description" maxlength="100">
								</div>
							</div>

							<div class="col-sm-12 mb-2">
								<div class="form-group">
									<label for="short_description">Short Description</label>
									<input type="text" class="form-control" name="short_description" id="short_description" value="{{ $product->short_description }}" placeholder="Enter short description"  maxlength="100">
								</div>
							</div>
							<div class="col-sm-12 mb-2">
								<div class="form-group">
									<label for="description">Description</label>
									<textarea class="form-control tinymce" name="description" id="description" placeholder="Enter description">{!!$product->description!!}</textarea>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="card">
					<div class="card-body">	
						<div class="row">

							<div class="col-sm-6">
								<a href="{{ url('/admin/products') }}" class="btn btn-primary w-md">
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
<script type="text/javascript">
	$("#attributes").change(function(event) {
		var attribute= $(this).val();
		if(attribute){
			fetchUnits(attribute)
			$('.unit').removeClass('d-none');
			$('.option_button').removeClass('d-none');
		}else{
			$('.unit').addClass('d-none');
			$('.option_button').addClass('d-none');
		}
		
	});

	function fetchUnits(attribute){
		$.ajax({
			url: '{{url('admin/fetch-units')}}/'+attribute
		})
		.done(function(res) {
			$('#units').html(res);
		});		
	}

	$(".add_options").click(function(event) {
		$('.variant_label').show();
		var div = '<div class="form-group row mb-2 variation"><div class="col-sm-2"><input type="number" placeholder="Listing Price" name="variant_listing_price[]" value="" class="form-control" required oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" min="0" step="0.01" maxlength="10"></div><div class="col-sm-2"><input type="number" class="form-control" name="variant_sell_price[]" value="" required placeholder="Sell Price" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" min="0" maxlength="6"/></div><div class="col-sm-2"><input type="number" placeholder="Quantity" name="variant_quantity[]" value="" required class="form-control" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" min="0" step="0.01" maxlength="10"></div><div class="col-sm-2"><input type="text" required placeholder="SKU" name="variant_sku[]" value="" class="form-control" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" min="0" step="0.01" maxlength="10"></div><div class="col-sm-3"><input type="text" placeholder="Enter size" name="sizes[]" value="" required class="form-control"></div><div class="col-sm-1"><button href="javascript:;" class="remove-option btn btn-danger">X</button></div></div>'
		$('.variants').append(div);
	});
	$(document).on("click",".remove-option",function(event) {
		var count = $('.variation').length;
		if(count<=1){
			alert("Can not delete parent variation");
			return false;
		}
		else{
			$(this).parent().parent().remove();
		}
	});

	$(document).on('click', '.delete_images', function(){
		if(confirm("Are you sure you want to delete this image?")){
			var id = $(this).attr('data-id');
			var key = $(this).attr('data-key');

			$.ajax({
				type: "GET",
				url: "{{ url('admin/products') }}/"+id+"/delete_image",
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