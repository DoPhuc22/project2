{{--<link rel="preconnect" href="https://fonts.googleapis.com">--}}
{{--<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>--}}
{{--<link href="https://fonts.googleapis.com/css2?family=Metrophobic&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">--}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Kode+Mono:wght@400..700&display=swap" rel="stylesheet">
<link rel="canonical" href="https://getbootstrap.com/docs/5.0/getting-started/rfs/">
<meta name="HandheldFriendly" content="True" />
<meta name="pinterest" content="nopin" />

<meta property="og:locale" content="en_AU" />
<meta property="og:type" content="website" />
<meta property="fb:admins" content="" />
<meta property="fb:app_id" content="" />
<meta property="og:site_name" content="" />
<meta property="og:title" content="" />
<meta property="og:description" content="" />
<meta property="og:url" content="" />
<meta property="og:image" content="" />
<meta property="og:image:type" content="image/jpeg" />
<meta property="og:image:width" content="" />
<meta property="og:image:height" content="" />
<meta property="og:image:alt" content="" />

<meta name="twitter:title" content="" />
<meta name="twitter:site" content="" />
<meta name="twitter:description" content="" />
<meta name="twitter:image" content="" />
<meta name="twitter:image:alt" content="" />
<meta name="twitter:card" content="summary_large_image" />
<meta name="csrf-token" content="{{ csrf_token() }}">

<link rel="stylesheet" type="text/css" href="{{asset('customer-assets/css/slick.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset('customer-assets/css/slick-theme.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset('customer-assets/css/video-js.css')}}" />


<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<body>
<nav class="navbar nav-underline navbar-expand-lg bd-navbar fixed-top pt-2 text-center" style="background-color: #00001c; box-sizing: border-box">
    <div class="container-xxl bd-gutter flex-wrap flex-lg-nowrap text-uppercase px-0 ">
        <a class="navbar-brand" href="/">
            <img src="{{asset('admin-assets/img/paradise-theatre-logo.png')}}" alt="brand"
                 height="40" class="rounded">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 fw-medium">
                <li class="nav-item">
                    <a class="nav-link link-light {{ request()->routeIs('home') ? 'active' : '' }}" aria-current="page"
                       href="{{route('home')}}">Trang chủ</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link link-light  {{ request()->routeIs('movie', 'movie-details', 'bookTickets') ? 'active' : '' }}" href="{{route('movie')}}">
                        {{--                       id="navbarDropdown" role="button" data-bs-toggle="dropdown">--}}
                        Phim
                    </a>
                    {{--                    <div class="dropdown-menu rounded-4" aria-labelledby="navbarDropdown">--}}
                    {{--                        <ul>--}}
                    {{--                            <li><a class="dropdown-item">Popular</a></li>--}}
                    {{--                            <li><a class="dropdown-item" href="{{route('movie')}}">featured</a></li>--}}
                    {{--                            <li><a class="dropdown-item" href="{{route('movie')}}">most popular</a></li>--}}
                    {{--                            <li><a class="dropdown-item" href="{{route('movie')}}">new releases</a></li>--}}
                    {{--                            <li><a class="dropdown-item" href="{{route('movie')}}">recommend</a></li>--}}
                    {{--                        </ul>--}}
                    {{--                        <ul class="accordion-item">--}}
                    {{--                            <li><a class="dropdown-item">genres</a></li>--}}
                    {{--                                <div>--}}
                    {{--                                    @foreach(getGenres() as $genre)--}}
                    {{--                                        <li><a class="dropdown-item d-none"></a></li>--}}
                    {{--                                        <li><a class="dropdown-item genre-label" href="{{ route('movie', $age->name) }}">{{$genre->name}}</a>--}}
                    {{--                                            @if($genre->count() > 0)--}}
                    {{--                                                    <section>--}}
                    {{--                                                        <div class="form-check mb-2">--}}
                    {{--                                                            <input class="form-check-input genre-label"--}}
                    {{--                                                                   type="checkbox" name="genre[]" value="{{$genre->id}}" id="genre-{{ $genre->id }}">--}}
                    {{--                                                            <span class="form-check-label nav-link nav-tabs-right ">--}}
                    {{--                                            {{$genre->name}}--}}
                    {{--                                        </span>--}}
                    {{--                                                        </div>--}}
                    {{--                                                    </section>--}}
                    {{--                                            @endif</li>--}}
                    {{--                                    @endforeach--}}
                    {{--                                </div>--}}
                    {{--                        </ul>--}}
                    {{--                        <ul>--}}
                    {{--                            <li><a class="dropdown-item">Something else here</a></li>--}}
                    {{--                            <li><a class="dropdown-item" href="#">Mega Menu Link</a></li>--}}
                    {{--                            <li><a class="dropdown-item" href="#">Mega Menu Link</a></li>--}}
                    {{--                            <li><a class="dropdown-item" href="#">Mega Menu Link</a></li>--}}
                    {{--                            <li><a class="dropdown-item" href="#">Mega Menu Link</a></li>--}}
                    {{--                        </ul>--}}
                    {{--                    </div>--}}
                </li>
                <li class="nav-item">
                    <a class="nav-link link-light {{ request()->routeIs('contact_us') ? 'active' : '' }}" href="{{route('contact_us')}}">Liên hệ
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link link-light {{ request()->routeIs('help') ? 'active' : '' }}" href="{{route('help')}}">Giúp đỡ
                    </a>
                </li>
            </ul>
            <h2 class="mt-3 text-center text-white me-md-auto fw-semibold font-monospace rounded-2" style="background-image: linear-gradient(to right, red,orange,yellow,green,blue,indigo,violet);">PARADISE THEATRE</h2>
            <form method="get" action="{{ route('movie') }}" class="d-flex search-form mb-0">
                <div class="input-group input-group-sm">
                    <input class="form-control" type="text" placeholder="Tìm kiếm phim..." name="search" id="search"
                           value="{{ request()->get('search') }}">
                    <button class="btn btn-outline-secondary" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>
            <ul class="navbar-nav mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link link-light {{ request()->routeIs('profile','customer.login', 'customer.register', 'customer.forgotPassword') ? 'active' : '' }}"
                       href="{{ route('profile') }}">
                        <i class="bi bi-person"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link link-light {{ request()->routeIs('wishlist') ? 'active' : '' }}"
                       href="{{ route('wishlist') }}">
                        <i class="bi bi-heart"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link link-light " href="">
                        <i class="bi bi-bag"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div>
    @yield('content')
</div>
<footer class="bg-dark mt-5">
    <div class="container-xxl pb-5 pt-3 backgroundEffect position-relative">
        <div class="row justify-content-sm-center col-12 text-sm-center">
            <div class="col-md-3">
                <div class="footer-card text-white">
                    <img src="{{asset('admin-assets/img/paradise-theatre-logo.png')}}" alt="brand"
                         height="110" class="rounded">
                </div>
            </div>

            <div class="col-md-3">
                <div class="footer-card text-white bd-lead">
                    <h3>Liên lạc</h3>
                    <p>No dolore ipsum accusam no lorem. <br>
                        123 Street, New York, USA <br>
                        phucsonmai999@gmail.com <br>
                        012 345 6789</p>
                </div>
            </div>

            <div class="col-lg-3">
                <div class="footer-card text-white">
                    <h3>Đường dẫn quan trọng</h3>
                    <ul class="nav flex-column">
                        <li><a class="text-decoration-none link-light" href="{{ route('about') }}" title="About">Về chúng tôi</a></li>
                        <li><a class="text-decoration-none link-light" href="{{ route('contact_us') }}" title="Contact Us">Liên hệ</a></li>
                        <li><a class="text-decoration-none link-light" href="#" title="Privacy">Sự riêng tư</a></li>
                        <li><a class="text-decoration-none link-light" href="#" title="Privacy">Điều khoản & Điều kiện</a></li>
                    </ul>
                </div>
            </div>

            <div class="col-xl-3">
                <div class="footer-card text-white">
                    <h3>Tài khoản</h3>
                    <ul class="nav flex-column">
                        <li><a class="text-decoration-none link-light" href="{{route('profile')}}" title="Login">Đăng nhập</a></li>
                        <li><a class="text-decoration-none link-light" href="#" title="Contact Us">Vé đã đặt</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <hr class="text-white">
    <div class="">
        <div class="container">
            <div class="row">
                <div class="col-12 mt-3 mb-3">
                    <div class="copy-right text-center text-white">
                        <span class="text-white">2024 © Paradise Theatre - Made by Phuc&Huy</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- Wishlist Modal -->
<div class="modal fade" id="wishlistModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Thành công</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('customer-assets/js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('customer-assets/js/bootstrap.bundle.5.1.3.min.js') }}"></script>
<script src="{{ asset('customer-assets/js/instantpages.5.1.0.min.js') }}"></script>
<script src="{{ asset('customer-assets/js/lazyload.17.6.0.min.js') }}"></script>
<script src="{{ asset('customer-assets/js/slick.min.js') }}"></script>
<script src="{{ asset('customer-assets/js/custom.js') }}"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
<script>
    window.onscroll = function() {myFunction()};

    var navbar = document.getElementById("navbar");
    var sticky = navbar.offsetTop;

    function myFunction() {
        if (window.pageYOffset >= sticky) {
            navbar.classList.add("sticky")
        } else {
            navbar.classList.remove("sticky");
        }
    }


    function addToWishList(id) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '{{ route("customer.addToWishlist") }}',
            type: 'post',
            data: {id: id},
            dataType: 'json',
            success: function (response){
                if (response.status == true){
                    $("#wishlistModal .modal-body").html(response.message);
                    $("#wishlistModal").modal('show');
                }else {
                    window.location.href = "{{ route('customer.login') }}";
                    //alert(response.message);
                }
            }
        })
    }
</script>

@yield('customJs')
</body>

