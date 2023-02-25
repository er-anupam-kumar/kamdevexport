<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>@yield('title',env('APP_NAME'))</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/preloader.min.css')}}" type="text/css" />
    <link href="{{ asset('assets/css/bootstrap.min.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/app.min.css')}}" id="app-style" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/libs/alertifyjs/build/css/alertify.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/alertifyjs/build/css/themes/default.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/custom.css')}}" rel="stylesheet" type="text/css" />
    @yield('style')
</head>

<body dalayout-size="boxed" ta-data-sidebar-size="sm">
    <div id="layout-wrapper">
        @include('admin.partials.header')
        @include('admin.partials.sidebar')
        <div class="main-content">
            @yield('content')
        </div>
        @include('admin.partials.footer')
    </div>
    <script src="{{ asset('assets/libs/jquery/jquery.min.js')}}"></script>
    <script src="{{ asset('assets/libs/jquery/jquery.cookie.js')}}"></script>
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{ asset('assets/libs/metismenu/metisMenu.min.js')}}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js')}}"></script>
    <script src="{{ asset('assets/libs/node-waves/waves.min.js')}}"></script>
    <script src="{{ asset('assets/libs/feather-icons/feather.min.js')}}"></script>
    <script src="{{ asset('assets/libs/pace-js/pace.min.js')}}"></script>
    <script src="{{ asset('assets/js/app.js')}}"></script>
    <script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{ asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{ asset('assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{ asset('assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{ asset('assets/libs/jszip/jszip.min.js')}}"></script>
    <script src="{{ asset('assets/libs/pdfmake/build/pdfmake.min.js')}}"></script>
    <script src="{{ asset('assets/libs/pdfmake/build/vfs_fonts.js')}}"></script>
    <script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
    <script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.print.min.js')}}"></script>
    <script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.colVis.min.js')}}"></script>
    <script src="{{ asset('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{ asset('assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js')}}"></script>
    <script src="{{ asset('assets/libs/select2/js/select2.full.js')}}"></script>
    <script src="{{ asset('assets/js/jquery.form.js')}}"></script>
    <script src="{{ asset('assets/libs/tinymce/tinymce.min.js')}}"></script>
    <script src="{{ asset('assets/libs/alertifyjs/build/alertify.min.js')}}"></script>
    <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js')}}"></script>
    <script src="{{ asset('assets/js/custom.js')}}"></script>

    
    <script>

        // Script to maintain sidebar state after refresh
        $(document).ready(function() {
            var body_class = $.cookie('data-sidebar-size');
            if(body_class) {
                $('body').attr('data-sidebar-size', body_class);
            }
            $("#vertical-menu-btn").click(function() {
                var cookie_value = $("body").attr("data-sidebar-size");
                $.cookie('data-sidebar-size', cookie_value, {path: '/'});
            });
        });

        // Script for all forms submissions
        $(document).on('submit','#form',function(e){
            e.preventDefault();

            var _this = this

            $(_this).ajaxSubmit({
                beforeSubmit: function(){
                    $(_this).find('.help-block').remove();
                    $(_this).find('.form-group').removeClass('has-error');
                    $(_this).find('.form-control').removeClass('is-invalid');
                    $('#submit').attr('disabled',true);
                    $('#submit').html('Please wait...');
                },
                success: function (res) {
                    $('#submit').attr('disabled',false);
                    $('#submit').html('Submit');
                    showSuccess(res.message)
                    if(res.url){
                        setTimeout(function(){
                            window.location.href = res.url
                        },2000)
                    }
                },
                error: function (data) {
                    $('#submit').attr('disabled',false);
                    $('#submit').html('Submit');
                    messages = data.responseJSON.errors;

                    jQuery.each(messages, function(index, item) 
                    {

                        if(index.includes('.')){
                            index = index.split('.').join('');
                        }

                        if(jQuery.isArray(item)){
                            jQuery.each(item , function(key , val) {
                                $(_this).find('#'+index).parent().append('<span class="help-block">'+val+'<strong></span>')
                            })
                        }
                        else {
                            $(_this).find('#'+index).parent().append('<span class="help-block">'+item+'<strong></span>')
                        }

                        $(_this).find('#'+index).closest('.form-group').addClass('has-error');
                        $(_this).find('#'+index).addClass('is-invalid');
                    });

                    showError(data.responseJSON.message)
                }
            });
        });

        // Script for delete operation on all tables
        $(document).on('click','.del',function(){
            var id  = $(this).data('id');
            var url = $(this).data('url');

            if(id){

                Swal.fire({
                    title: 'Are you sure want to delete?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel!',
                    confirmButtonClass: 'btn btn-success mt-2',
                    cancelButtonClass: 'btn btn-danger ms-2 mt-2',
                    buttonsStyling: false
                }).then(function (result) {
                    if (result.value) {
                        $.ajax({
                            url: url,
                            type: 'DELETE',
                            data: {
                                id,
                                _token:'{{csrf_token()}}'
                            },
                        })
                        .done(function(res) {
                            Swal.fire({
                                title: 'Deleted!',
                                text: res.message,
                                icon: 'success',
                                confirmButtonColor: '#001149',
                            })
                            $('#table').DataTable().ajax.reload()
                        })
                        .fail(function(res) {
                            showError(res.responseJSON.message)
                        })                  
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        Swal.fire({
                            title: 'Cancelled',
                            text: 'Your information is safe.',
                            icon: 'error',
                            confirmButtonColor: '#001149',
                        })
                    }
                });

            }
        });

    </script>

    @yield('script')
</body>

</html>