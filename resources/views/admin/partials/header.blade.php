<header id="page-topbar" class="bg-soft-light">
    <div class="navbar-header">
        <div class="d-flex">
            <div class="navbar-brand-box">
                <a href="{{url('/admin')}}" class="logo logo-dark">
                    <span class="logo-sm">
                        {{-- <img src="{{asset('assets/images/logo-v1.png')}}" alt="" height="35"> --}}
                        <span class="logo-txt">KE</span>
                    </span>
                    <span class="logo-lg">
                        {{-- <img src="{{asset('assets/images/logo-h.png')}}" alt="" height="35">  --}}
                        <span class="logo-txt">{{env('APP_NAME')}}</span>
                    </span>
                </a>

                <a href="{{url('/admin')}}" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{asset('assets/images/logo-v1.png')}}" alt="" height="35">
                    </span>
                    <span class="logo-lg">
                        <img src="{{asset('assets/images/logo-h.png')}}" alt="" height="35"> 
                        <!-- <span class="logo-txt"> {{env('APP_NAME')}}</span> -->
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-16 header-item" id="vertical-menu-btn">
                <i class="fa fa-fw fa-bars"></i>
            </button>
        </div>
        <div class="d-flex">
            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item bg-white border-start border-end" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
<!--                     <img class="rounded-circle header-profile-user" src="{{asset(Auth::user()->profile_picture??'assets/images/users/avatar-1.jpg')}}" alt="Header Avatar"> -->
                    <span class="d-none d-xl-inline-block ms-1 fw-medium">{{Auth::user()->name}}</span>
                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>

                <div class="dropdown-menu dropdown-menu-end">
                    <a class="dropdown-item" href="{{url('admin/change-password')}}"><i class="mdi
                        mdi-lock font-size-16 align-middle
                        me-1"></i> Change Password
                    </a>
                    <a class="dropdown-item" href="{{url('/logout')}}"><i class="mdi
                        mdi-logout font-size-16 align-middle
                        me-1"></i> Logout
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>