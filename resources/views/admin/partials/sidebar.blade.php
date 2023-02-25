<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <div id="sidebar-menu">
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" data-key="t-menu">MENU</li>
                
                <li>
                    <a href="{{url('/admin')}}">
                        <i data-feather="home"></i>
                        <span data-key="t-dashboard">Dashboard</span>
                    </a>
                </li>

                <li class="{{ request()->is('admin/categories*') ? 'mm-active' : '' }}">
                    <a href="javascript:;" class="has-arrow">
                        <i data-feather="globe"></i>
                        <span data-key="t-categories">Categories</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li>
                            <a href="{{url('admin/categories')}}">
                                <span data-key="t-categories">All Categories</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{url('admin/categories/create')}}">
                                <span data-key="t-addcategories">Add Category</span>
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>
        </div>
    </div>
</div>
