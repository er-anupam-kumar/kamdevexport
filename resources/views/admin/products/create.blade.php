@extends('admin.layouts.layout')

@section('title','Add Products : '.env('APP_NAME'))

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
							<li class="breadcrumb-item active">Add Product
							</li>
						</ol>
					</div>

				</div>
			</div>
		</div>

		{{ Form::open(array('url' => '/admin/products', 'method' => 'POST','id'=>'form')) }}

		<div class="row">
			<div class="col-lg-12">
				<div class="card">
					<div class="card-header">
						<h4 class="card-title">Add Product</h4>
						<p class="card-title-desc">Fill the form below to add new product.</p>
					</div>
					<div class="card-body">					
						<div class="row">
							<div class="col-sm-6 mb-2">
								<div class="form-group">
									<label for="name">Name</label>
									<input type="text" class="form-control" name="name" id="name" placeholder="Enter name"  maxlength="50">
								</div>
							</div>
							<div class="col-sm-6 mb-2">
								<div class="form-group">
									<label for="category">Select Category</label>
									<select id="category" name="category" class="form-control select2">
										<option value="">Please select</option>
										@foreach ($categories as $category)
										<option value="{{$category->name}}">{{$category->name}}</option>
										@endforeach
									</select>		
								</div>							
							</div>	

							<div class="col-sm-6 mb-2">
								<div class="form-group">
									<label for="product_status">Status</label>
									<select id="product_status" name="product_status" class="form-control">
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
									<div class="form-group row variant_label" style="display:none;">
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
											<h6>Size</h6>
										</div>
									</div>
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
									<input type="text" class="form-control" name="meta_tags" id="meta_tags" placeholder="Enter  meta tags" maxlength="100">
								</div>
							</div>

							<div class="col-sm-12 mb-2">
								<div class="form-group">
									<label for="meta_description">Meta Description</label>
									<input type="text" class="form-control" name="meta_description" id="meta_description" placeholder="Enter  meta description" maxlength="100">
								</div>
							</div>

							<div class="col-sm-12 mb-2">
								<div class="form-group">
									<label for="short_description">Short Description</label>
									<input type="text" class="form-control" name="short_description" id="short_description" placeholder="Enter short description"  maxlength="200">
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

</script>
@endsection