@extends('layouts.customer-nav')
@section('content')
    @vite(["resources/sass/app.scss", "resources/js/app.js"])
    <head>
        <title>Movie</title>
        <link rel="stylesheet" href="{{asset('frontend/css/main.css')}}">
    </head>
    <body style="background-color: #00001c;">
    <hr class="text-white">
{{--    <div class="container-fluid p-0">--}}
{{--        <div class=" position-relative d-flex justify-content-center align-items-center text-white">--}}
{{--            --}}
{{--        </div>--}}
{{--    </div>--}}

    <main>
        <section class="section-5 pt-3 pb-3 mb-3">
            <div class="container">
                <div>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a class="text-white nav-link" href="{{ route('home') }}">Home</a></li>
                        <li class="bi bi-slash-lg text-white">Movie</li>
                    </ol>
                </div>
            </div>
        </section>

        <section class="section-6 pt-3">
            <div class="container-lg">
                <div class="row">
                    <div class="col-lg-3 sidebar">
                        <div class="card-title">
                            <button type="button" onclick="window.location.href='{{route('movie')}}'" class="btn text-white btn-outline-danger">
                                Reset <span class="bi bi-arrow-clockwise"></span>
                            </button>
                        </div>
                        <div class="sub-title mt-4 text-white">
                            <span class="fs-2">Explore by Genres</span>
                        </div>

                        <div class="card w-70 text-white" style="background-color: #191c33">
                            <div class="card-body justify-content-between col-lg-12">
                                @if($genres->count() > 0)
                                    @foreach($genres as $genre)
                                <section>
                                    <div class="form-check mb-2">
                                        {{-- <input {{in_array($genre->id, $genresArray) ? 'checked' : ''}} class="form-check-input genre-label"
                                               type="checkbox" name="genre[]" value="{{$genre->id}}" id="genre-{{ $genre->id }}">
                                        <span class="form-check-label nav-link nav-tabs-right fs-6">
                                            {{$genre->name}}
                                        </span> --}}
                                    </div>
                                </section>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        <div class="sub-title mt-5 text-white">
                            <h2>Ages</h2>
                        </div>
                        <div class="card w-70 text-white" style="background-color: #191c33">
                            <div class="card-body justify-content-between">
                                {{-- @if($ages->count() > 0)
                                    @foreach($ages as $age)
                                        <section>
                                            <div class="form-check mb-2">
                                                <button class="btn" style="background-color: #161934">
                                                    <a class="nav-link link-light {{ ($ageSelected == $age->id) ? 'text-danger bi bi-arrow-right' : '' }}"
                                                       href="{{ route('movie', $age->name) }}">
                                                        {{$age->name}}
                                                    </a>
                                                </button>
                                            </div>
                                        </section>
                                    @endforeach
                                @endif --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <div class="row pb-3">
                            <div class="col-12 pb-1">
                                <div class="d-flex align-items-center justify-content-end mb-4">
                                    <form action="" class="d-flex mb-0" style="width: 250px">
                                        {{--                select--}}
                                        <label for="sorting" class="w-50 d-flex align-items-center justify-content-center text-white">
                                            Sort by <span class="bi bi-filter-circle-fill"></span>
                                        </label>
                                        <select class="form-select rounded-5" id="sort" name="sort">
                                            <option>
                                            </option>
                                            {{-- <option value="newest" {{ ($sort == 'newest') ? 'selected' : ''}}>
                                                Newest
                                            </option>
                                            <option value="oldest" {{ ($sort == 'oldest') ? 'selected' : '' }}>
                                                Oldest --}}
                                            </option>
                                        </select>
                                    </form>
                                </div>
                            </div>

                            <div class="container">
                                <div class="row">
                                    @if($movies->count() > 0)
                                        @foreach($movies as $movie)
                                            <div class="col-12 col-md-4">
                                                <div class="p-3 rounded rounded-4 mb-3" style=" background: linear-gradient(45deg, rgba(255,255,255, .05), rgba(205,140,56,.15));">
                                                    @if(!empty($movie->image))
                                                        <div class="position-relative rounded rounded-4 overflow-hidden mb-3">
                                                            <img src="{{ asset('uploads/movie/'.$movie->image) }}" class="card-img" alt="">
                                                            <div class="position-absolute text-white top-0 p-2 border  rounded-4">
                                                    <span class="luxury-font fs-5">
                                                        @switch($movie->age->id)
                                                            @case(1)
                                                                <div class="text-success">
                                                                    13+
                                                                </div>
                                                                @break
                                                            @case(2)
                                                                <div class="text-warning">
                                                                    16+
                                                                </div>
                                                                @break
                                                            @case(3)
                                                                <div class="text-danger">
                                                                    18+
                                                                </div>
                                                                @break
                                                        @endswitch
                                                        {{--                                                        {{ $movie->age->name }}--}}
                                                    </span>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    <h3 class="text-white mb-2">{{$movie->title}}</h3>
                                                    <span class="language justify-content-lg-between">
                                                        <span class="fs-6 bg-success  rounded-3">{{$movie->language}}</span>
                                                        <span class="bg-danger rounded-3">
                                                            <a class="bi bi-heart link-light" href="javascript:void(0);" onclick="addToWishList({{ $movie->id }})"></a>
                                                        </span>
                                                    </span>
                                                    <div class="justify-content-between">
                                                    <span class="nav-link text-white-50">
                                                        @foreach($movieGenres as $movieGenre)
                                                            @if($movieGenre->movie_id == $movie->id)
                                                                <span class="bi bi-dot">
                                                                    @foreach($genres as $genre)
                                                                        <span> {{$genre->id == $movieGenre->genre_id ? $genre->name:''}}</span>
                                                                    @endforeach
                                                                </span>
                                                            @endif
                                                        @endforeach
                                                    </span>
                                                    </div>
                                                    <p class="screen-name"></p>
                                                    <div class="d-flex align-items-center justify-content-sm-center justify-content-between row">
                                                        <a href="{{ route('movie-details', $movie) }}" class="btn btn-outline-success text-white border-light-subtle col-lg-6 mx-lg-2">View Detail <span class="bi bi-exclamation-circle"></span></a>
                                                        <form action="{{route('postMovie')}}" method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            @method('POST')
                                                            <input type="hidden" name="id" value="{{$movie->id}}">
                                                            <button class="btn btn-outline-danger text-white border-white col-lg-5">Book tickets</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                        @endforeach
                                    @else
                                        <span class="text-white fs-4 text-center bg-danger">No Movies found</span>
                                    @endif
                                </div>
                            </div>
                        </div>
{{--                        <div class="card-footer clearfix ">--}}
{{--                            {{$movies->onEachSide(3)->links()}}--}}
{{--                        </div>--}}
                    </div>
                </div>
            </div>
        </section>
    </main>
    {{--  Products  --}}

    {{--  SHIPPING  --}}

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


