<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('faculty.dashboard') }} " class="brand-link  text-center ">

        <span class="brand-text font-weight-light font-weight-bolder" style="font-size: 1.5rem;">AMS</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item menu">
                    <a href="{{ route('faculty.dashboard') }}"
                        class="nav-link {{ \Route::currentRouteName() == 'faculty.dashboard' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>

                <li class="nav-item menu">
                    <a href="{{ route('faculty.attendance') }}"
                        class="nav-link {{ \Route::currentRouteName() == 'faculty.attendance' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Attendance
                        </p>
                    </a>
                </li>


                <li class="nav-item ">
                    <a href="{{ route('faculty.logout') }}" class="nav-link">
                        <i class="fas fa-sign-out-alt nav-icon"></i>
                        <p>
                            Logout
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
