<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav w-100">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ route('faculty.dashboard') }}" class="nav-link">Home</a>
        </li>

        <li class="nav-item " style="margin-left: auto;">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ $faculty->first_name }}
                    {{ $faculty->middle_name }} {{ $faculty->last_name }}</span>
                <img class="img-profile rounded-circle" style="width: 25px;heigth:18px;"
                    src="{{ asset('/dist/img/AdminLTELogo.png') }}">
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="{{ route('faculty.logout') }}">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400 text-primary"></i>
                    Logout
                </a>
            </div>
        </li>
    </ul>
</nav>
