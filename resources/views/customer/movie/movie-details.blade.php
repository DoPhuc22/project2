@extends('layouts.customer-nav')
@section('content')
    @vite(["resources/sass/app.scss", "resources/js/app.js"])
    <head>
        <title>Chi tiết phim</title>
        <link rel="stylesheet" href="{{asset('frontend/css/main.css')}}">
    </head>
    <body style="background-color: #00001c;">
    <hr class="text-white">
    <main>
        <section class="section-5 pt-3 pb- mb-3">
            <div class="container">
                <div class="text-white">
                    <ul class="breadcrumb primary-color text-white mb-0">
                        <li><a class="nav-link text-danger fw-bold" href="{{ route('home') }}">Trang chủ<span class="text-white bi bi-slash-lg"></span></a></li>
                        <li><a class="nav-link text-danger fw-bold" href="{{ route('movie') }}">Phim</a></li>
                        <li class="bi bi-slash-lg text-white breadcrumb-item">{{ $movie->title }}</li>
                    </ul>
                </div>
            </div>
        </section>

        <section class="section-7 pt-3 mb-3">
            <div class="container">
                <div class="row ">
                    <div class="col-md-4 mb-sm-4">
                        <div>
                            @if(!empty($movie->image))
                                <img src="{{ asset('uploads/movie/'.$movie->image) }}" class="rounded-4 w-75" alt="">
                            @else
                                <img src="{{ asset('admin-assets/img/default-150x150.png') }}" class="rounded" width="300px" alt="">
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-8 fs-5">
                        <div class=" right text-white">
                            <h1>{{$movie->title}}</h1>
                            <div class="d-flex">
                                <div class="language">
                                    <span>{{$movie->language}}</span>
                                </div>
                                <span class="rounded mt-2 p-2 fs-6" style="background-color: #0093E9; background-image: linear-gradient(160deg, #0093E9 0%, #80D0C7 100%);">
                                {{ $movie->age->name }}
                            </span>
                            </div>
                            <div class="mt-3">
                                <span>{{\Carbon\Carbon::parse($movie->release_date)->format('d-m-Y')}}</span>
                                <span class="bi bi-dot">{{$movie->duration}}</span>
                            </div>
                            <p class="text-justify my-sm-4">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Perferendis officiis dolor aut nihil iste porro
                                ullam repellendus inventore voluptatem nam veritatis exercitationem doloribus voluptates dolorem nobis voluptatum
                                qui, minus facere. {!! $movie->description !!}</p>
                            <div class="mt-3">
                                <span>
                                    <b>Thể loại:</b>
                                    @foreach($movieGenres as $movieGenre)
                                        @if($movieGenre->movie_id == $movie->id)
                                            <li class="">
                                                @foreach($genres as $genre)
                                                    <span> {{$genre->id == $movieGenre->genre_id ? $genre->name:''}}</span>
                                                @endforeach
                                            </li>
                                        @endif
                                    @endforeach
                                </span>
                            </div>
                            <div class="mt-3">
                                <span>
                                    <b>Diễn viên:</b>
                                    @foreach($movieCasts as $movieCast)
                                        @if($movieCast->movie_id == $movie->id)
                                            <span class="bi bi-das">
                                            @foreach($casts as $cast)
                                                <span>{{$cast->id == $movieCast->cast_id ? $cast->name:''}}</span>
                                            @endforeach
                                            </span>
                                            ,
                                        @endif
                                    @endforeach
                                    ...
                                </span>
                            </div>
                            <div class="mt-3 row">
                                <a href="{{ route('choosingScreening', $movie) }}" class="watch-btn nav-link">Đặt vé</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>
    @include('layouts/scroll_to_top')
    </body>
    <script src="{{asset('frontend/js/home.js')}}"></script>
    <script src="{{asset('admin-assets/plugins/jquery/jquery.min.js')}}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{asset('admin-assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{asset('admin-assets/js/adminlte.min.js')}}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{asset('admin-assets/js/demo.js')}}"></script>
@endsection
