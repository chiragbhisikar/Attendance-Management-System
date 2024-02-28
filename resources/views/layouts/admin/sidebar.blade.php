<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('admin.dashboard') }} " class="brand-link  text-center ">

        <span class="brand-text font-weight-light font-weight-bolder" style="font-size: 1.5rem;">AMS</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <li class="nav-item menu">
                    <a href="{{ route('admin.dashboard') }}"
                        class="nav-link {{ \Route::currentRouteName() == 'admin.dashboard' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>


                <li class="nav-item menu">
                    <a href="{{ route('admin.faculty') }}"
                        class="nav-link {{ request()->is('admin/faculty*') ? 'active ' : ' ' }}">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            Faculty
                        </p>
                    </a>
                </li>



                {{-- <li class="nav-item menu">
                    <a href="{{ route('admin.attendance') }}"
                        class="nav-link {{ request()->is('admin/attendance*') ? 'active ' : ' ' }}">
                        <i class="nav-icon fas fa-chalkboard-teacher"></i>
                        <p>
                            Attandance
                        </p>
                    </a>
                </li> --}}

                <li class="nav-item menu">
                    <a href="{{ route('admin.lecture') }}"
                        class="nav-link {{ request()->is('admin/lecture*') ? 'active ' : ' ' }}">
                        <i class="nav-icon fas fa-chalkboard-teacher"></i>
                        <p>
                            Lecture
                        </p>
                    </a>
                </li>



                <li class="nav-item menu">
                    <a href="{{ route('admin.time-table') }}"
                        class="nav-link {{ request()->is('admin/time-table*') ? 'active ' : ' ' }}">
                        <i class="nav-icon fas fa-building"></i>
                        <p>
                            Time Table
                        </p>
                    </a>
                </li>



                <li class="nav-item menu">
                    <a href="{{ route('admin.division') }}"
                        class="nav-link {{ request()->is('admin/division*') ? 'active ' : ' ' }}">
                        <i class="nav-icon fas fa-landmark"></i>
                        <p>
                            Class
                        </p>
                    </a>
                </li>


                <li class="nav-item menu">
                    <a href="{{ route('admin.subject') }}"
                        class="nav-link {{ request()->is('admin/subject*') ? 'active ' : ' ' }}">
                        <i class="nav-icon fas fa-book"></i>
                        <p>
                            Subject
                        </p>
                    </a>
                </li>


                <li class="nav-item menu">
                    <a href="{{ route('admin.branch') }}"
                        class="nav-link {{ request()->is('admin/branch*') ? 'active ' : ' ' }}">
                        <i class="nav-icon fas fa-school"></i>
                        <p>
                            Department
                        </p>
                    </a>
                </li>

                <li class="nav-item ">
                    <a href="{{ route('admin.logout') }}" class="nav-link">
                        <i class="fas fa-sign-out-alt nav-icon"></i>
                        <p>
                            Logout
                        </p>
                        <i class="right fas fa-angle-right"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
