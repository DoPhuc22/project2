@vite(["resources/sass/app.scss", "resources/js/app.js"])
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Paradise Theatre :: Administrative Panel</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=EB+Garamond:ital,wght@0,400..800;1,400..800&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('admin-assets/plugins/fontawesome-free/css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin-assets/plugins/dropzone/min/dropzone.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin-assets/plugins/summernote/summernote.min.css')}}">
    <!-- Theme style -->
    <link rel="shortcut icon" href="{{asset('admin-assets/img/paradise-theatre-logo.png')}}"/>
    <link rel="stylesheet" href="{{asset('admin-assets/css/adminlte.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin-assets/css/custom.css')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Right navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>
        <div class="navbar-nav pl-2">
            <!-- <ol class="breadcrumb p-0 m-0 bg-white">
                <li class="breadcrumb-item active">Dashboard</li>
            </ol> -->
        </div>

        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                    <i class="fas fa-expand-arrows-alt"></i>
                </a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link p-0 pr-3" data-toggle="dropdown" href="#">
                    @if(!empty(Auth::guard('admin')->user()->image))
                        <img src="{{ asset('uploads/user/'.Auth::guard('admin')->user()->image) }}" class='img-circle elevation-2' width="40" height="40" alt="">
                    @else
                        <img src="{{ asset('admin-assets/img/default-150x150.png') }}" class='img-circle elevation-2' width="40" height="40" alt="">
                        <span class="position-absolute bi bi-"></span>
                    @endif
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-3">
                        <h4 class="h4 mb-0"><strong>{{Auth::guard('admin')->user()->name}}</strong></h4>
                        <div class="mb-3">{{Auth::guard('admin')->user()->email}}</div>
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('admin.profile') }}" class="dropdown-item {{ request()->routeIs('admin.profile') ? 'bg-danger rounded-4' : '' }}">
                        <i class="fas fa-user mr-2"></i> Tài khoản
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-user-cog mr-2"></i> Cài đặt
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('change_password') }}" class="dropdown-item {{ request()->routeIs('change_password') ? 'bg-danger rounded-4' : '' }}">
                        <i class="fas fa-lock mr-2"></i> Đổi mật khẩu
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="{{route('admin.logout')}}" class="dropdown-item  text-danger">
                        <i class="fas fa-sign-out-alt mr-2"></i> Đăng xuất
                    </a>
                </div>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <aside class="main-sidebar sidebar-dark-primary elevation-5 " style="background-color: #00001c; height: 100%">
        <!-- Brand Logo -->
        <a href="#" class="brand-link">
            <img src="{{asset('admin-assets/img/paradise-theatre-logo.png')}}" alt="AdminLTE Logo"
                 class=" img-circle elevation-3" style="opacity: .8" width="70px">
            <span class="brand-text font-weight-light">PARADISE THEATRE</span>
        </a>
        <!-- Sidebar -->

        <div class="sidebar">
            <!-- Sidebar user (optional) -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                        with font-awesome or any other icon font library -->
                    <li class="nav-item">
                        <a href="{{route('admin.dashboard')}}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'bg-danger' : '' }}" aria-current="page">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Thống kê</p>
                        </a>
                    </li>
{{--                    <li class="nav-item">--}}
{{--                        <a href="#" class="nav-link d-flex" aria-current="page">--}}
{{--                            <i class="nav-icon fas bi-window"></i>--}}
{{--                            <button class="accordion-button collapsed ml-2 fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">--}}
{{--                                Quản lý--}}
{{--                            </button>--}}
{{--                        </a>--}}
{{--                            <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample" style="">--}}
{{--                                <div class="accordion-body">--}}
{{--                                    <div class="navbar-nav ml-5">--}}
{{--                                        <a href="{{route('admin.dashboard')}}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'bi bi-arrow-right bg-danger' : '' }}" class="nav-item nav-link">Employee</a>--}}
{{--                                        <a href="" class="nav-item nav-link">Speakers</a>--}}
{{--                                        <a href="" class="nav-item nav-link">Watches</a>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                    </li>--}}
                    <li class="nav-item">
                        <a href="{{route('genre.index')}}" class="nav-link {{ request()->routeIs('genre.index', 'genre.create', 'genre.edit') ? 'bg-danger' : '' }}">
                            <svg class="h-6 nav-icon w-6 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 4v12l-4-2-4 2V4M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <p>Thể loại</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('movie.index')}}" class="nav-link {{ request()->routeIs('movie.index', 'movie.create', 'movie.edit', 'movie.indexDetail') ? 'bg-danger' : '' }}">
                            <i class="nav-icon fa fa-film"></i>
                            <p>Phim</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('cast.index')}}" class="nav-link {{ request()->routeIs('cast.index', 'cast.creat', 'cast.edit') ? 'bg-danger' : '' }}">
                            <i class="nav-icon fas bi-person-rolodex"></i>
                            <p>Diễn viên</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('screening.index')}}" class="nav-link {{ request()->routeIs('screening.index', 'screening.create', 'screening.edit') ? 'bg-danger' : '' }}">
                            <i class="nav-icon fas bi-tv"></i>
                            <p>Xuất chiếu</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('auditorium.index')}}" class="nav-link {{ request()->routeIs('auditorium.index', 'auditorium.create', 'auditorium.edit') ? 'bg-danger' : '' }}">
                            <i class="nav-icon fas bi-laptop"></i>
                            <p>Phòng chiếu</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('order.index')}}" class="nav-link {{ request()->routeIs('order.index') ? 'bg-danger' : '' }}">
                            <i class="nav-icon fas fa-shopping-bag" aria-hidden="true"></i>
                            <p>Các đơn đặt vé</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('seat.index')}}" class="nav-link {{ request()->routeIs('seat.index', 'seat.create', 'seat.change', 'seat.edit') ? 'bg-danger' : '' }}">
                            <i class="m-1 nav-icon bi bi-person-wheelchair" aria-hidden="true"></i>
                            <p>Ghế</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('seatType.index')}}" class="nav-link {{ request()->routeIs('seatType.index','seatType.create', 'seatType.edit') ? 'bg-danger' : '' }}">
                            <i class="nav-icon fas bi-list-ul" aria-hidden="true"></i>
                            <p>Kiểu ghế</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('age.index') }}" class="nav-link {{ request()->routeIs('age.index', 'age.create', 'age.edit') ? 'bg-danger' : '' }}">
                            <i class="nav-icon  fa fa-birthday-cake" aria-hidden="true"></i>
                            <p>Tuổi</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('customerAdmin.index')}}" class="nav-link {{ request()->routeIs('customerAdmin.index', 'customer.create', 'customer.edit') ? 'bg-danger' : '' }}">
                            <i class="nav-icon  fas fa-users"></i>
                            <p>Khách hàng</p>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>

        <!-- /.sidebar -->
    </aside>
    <!-- Main Sidebar Container -->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrappers" style="margin-left: 250px">
        <!-- Content Header (Page header) -->
            @yield('content')
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer footer">
        <strong>Copyright &copy; Paradise Theatre by Phuc & Huy</strong>
    </footer>

</div>
<!-- ./wrapper -->
<!-- jQuery -->
<script src="{{asset('admin-assets/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('admin-assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('admin-assets/js/adminlte.min.js')}}"></script>

<script src="{{asset('admin-assets/plugins/dropzone/min/dropzone.min.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{asset('admin-assets/js/demo.js')}}"></script>
<script src="{{asset('admin-assets/plugins/summernote/summernote.min.js')}}"></script>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function (){
        $(".summernote").summernote({
            height: 250
        })
    });
</script>
@yield("customJs")

</body>
</html>