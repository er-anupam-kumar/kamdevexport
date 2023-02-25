@extends('auth.layout')

@section('title','Forgot password : '.env('APP_NAME'))

@section('style')
@endsection

@section('content')
<div class="auth-page">
	<div class="container-fluid p-0">
		<div class="row g-0">
			<div class="col-xxl-3 col-lg-4 col-md-5">
				<div class="auth-full-page-content d-flex p-sm-5 p-4">
					<div class="w-100">
						<div class="d-flex flex-column h-100">
							<div class="mb-4 mb-md-5 text-center">
								<a href="{{url('/')}}" class="d-block auth-logo">
									{{-- <img src="assets/images/logo-h.png" alt="logo" height="40">  --}}
									<span class="logo-txt">{{env('APP_NAME')}}</span>
								</a>
							</div>
							<div class="auth-content my-auto">
								<div class="text-center">
									<h5 class="mb-0">Welcome Back !</h5>
									<p class="text-muted mt-2">Sign in to continue to {{env('APP_NAME')}}.</p>
								</div>
								<form class="custom-form mt-4 pt-2" action="{{ url('/forgot-password') }}" method="POST" enctype="multipart/form-data" id="form">
									@csrf
									<div class="mb-4">
										<label class="form-label">Email</label>
										<input type="text" name="email" class="form-control" id="email" placeholder="Enter email">
									</div>
									
									<div class="mb-3">
										<button class="btn btn-primary w-100 waves-effect waves-light" id="submit" type="submit">Log In</button>
									</div>
								</form>

								<div class="mt-5 text-center">
									<p class="text-muted mb-0">Remember password ? <a href="{{url('login')}}"
										class="text-primary fw-semibold"> Login now </a> 
									</p>
								</div>
							</div>
							{{-- @include('auth.navigation') --}}
						</div>
					</div>
				</div>
			</div>

			<div class="col-xxl-9 col-lg-8 col-md-7">
				<div class="auth-bg pt-md-5 p-4 d-flex">
					<div class="bg-overlay bg-primary"></div>
					<ul class="bg-bubbles">
						<li></li>
						<li></li>
						<li></li>
						<li></li>
						<li></li>
						<li></li>
						<li></li>
						<li></li>
						<li></li>
						<li></li>
					</ul>
					<div class="row justify-content-center align-items-center">
						<div class="col-xl-2"></div>
						<div class="col-xl-10">
							<div class="p-0 p-sm-4 px-xl-0">
								<div id="reviewcarouselIndicators" class="carousel slide" data-bs-ride="carousel">
									<div class="carousel-inner">
										<div class="carousel-item active">
											<div class="testi-contain text-white">
												<i class="bx bxs-quote-alt-left text-success display-6"></i>
												<h3 class="mt-4 fw-medium lh-base text-white">
													Forgot your login password ? We are here to help you.
												</h3>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('script')
<script>
	$(document).on('submit','#form',function(e){
		e.preventDefault();

		var _this = this

		$(_this).ajaxSubmit({
			beforeSubmit: function(){
				$(_this).find('.help-block').remove();
				$(_this).find('.form-group').removeClass('has-error');
				$('#submit').attr('disabled',true);
				$('#submit').html('Please wait...');
			},
			success: function (res) {
				$('#submit').attr('disabled',false);
				$('#submit').html('Send Password');
				$(_this).trigger('reset');
				showSuccess(res.message,3000)
				if(res.url){
					setTimeout(function(){
						window.location.href = res.url
					},2000)
				}
			},
			error: function (data) {
				$('#submit').attr('disabled',false);
				$('#submit').html('Send Password');
				messages = data.responseJSON.errors;

				jQuery.each(messages, function(index, item) 
				{
					if(jQuery.isArray(item)){
						jQuery.each(item , function(key , val) {
							$(_this).find('#'+index).parent().append('<span class="help-block">'+val+'<strong></span>')
						})
					}
					else {
						$(_this).find('#'+index).parent().append('<span class="help-block">'+item+'<strong></span>')
					}

					$(_this).find('#'+index).closest('.form-group').addClass('has-error');
				});

				showError(data.responseJSON.message)
			}
		});
	});
</script>
@endsection
