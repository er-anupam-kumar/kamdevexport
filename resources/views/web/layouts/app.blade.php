<!doctype html>
<html lang="zxx">

<head>
  <meta charset="utf-8">
  <title>@yield('title','Kamdev Export')</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" type="image/x-icon" href="{{asset('web/assets/img/favicon.ico')}}">
  <link rel="stylesheet" href="{{asset('web/assets/css/plugins/swiper-bundle.min.css')}}">
  <link rel="stylesheet" href="{{asset('web/assets/css/plugins/glightbox.min.css')}}">
  <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{asset('web/assets/css/vendor/bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{asset('web/assets/css/style.css')}}">
  @yield('style')
</head>

<body>
    @include('web.partials.preloader')
    @include('web.partials.header')
    @yield('content')
    @include('web.partials.footer')
    @include('web.partials.quick_view')
    @include('web.partials.news_letter')
    @include('web.partials.scroll_to_top')
    <script src="{{asset('web/assets/js/vendor/popper.js')}}" defer="defer"></script>
    <script src="{{asset('web/assets/js/vendor/bootstrap.min.js')}}" defer="defer"></script>
    <script src="{{asset('web/assets/js/plugins/swiper-bundle.min.js')}}"></script>
    <script src="{{asset('web/assets/js/plugins/glightbox.min.js')}}"></script>
    <script src="{{asset('web/assets/js/script.js')}}"></script>
    @yield('script')
</body>
</html>