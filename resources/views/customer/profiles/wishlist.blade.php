@extends('layouts.customer-nav')
@section('content')
    @vite(["resources/sass/app.scss", "resources/js/app.js"])
    <head>
        <title>Hồ sơ</title>
        <link rel="stylesheet" href="{{asset('frontend/css/main.css')}}">
    </head>
    <body style="background-color: #00001c">
    <hr class="text-white">
    <div class="container d-flex align-items-center mt-5 h-80 overflow-hidden">
        <div class="border w-20 rounded-start p-3 h-100 text-white" style="background-color: #191c33">
            @include('layouts/profile_menu')
        </div>
        <div class="border w-80 rounded-end p-3 h-100 text-white" style="background-color: #191c33">
            <section class="justify-content-lg-between">
                <div class="col-md-12">
                    @include('admin.message')
                </div>
                <div>
                    <div class="fs-5">
                        Phim yêu thích
                    </div>
                    <div>
                        Quản lý thông tin phim yêu thích
                    </div>
                </div>
            </section>
            <hr>

            <div id="vertical-scroller">
                @if($wishlists->isNotEmpty())
                    @foreach($wishlists as $wishlist)
                        <div class="d-sm-flex justify-content-between mt-lg-4 mb-4 pb-3 pb-sm-2 border-bottom me-2">
                            <div class="d-block d-sm-flex align-items-start text-center text-sm-start">
                                <a class="d-block flex-shrink-0 mx-auto me-sm-4" href="{{ route('movie-details', $wishlist->movie) }}" style="width: 7rem;">
                                    @if(!empty($wishlist->movie->image))
                                        <img src="{{ asset('uploads/movie/'.$wishlist->movie->image) }}" class="img-thumbnail" alt="Movie">
                                    @else
                                        <img src="{{ asset('admin-assets/img/default-150x150.png') }}" class="img-thumbnail">
                                    @endif
                                </a>
                                <div class="pt-2">
                                    <h3 class="product-title fs-base mb-2">
                                        <a class="nav-link" href="{{ route('movie-details', $wishlist->movie) }}">{{ $wishlist->movie->title }}</a>
                                    </h3>
                                    <div class="fs-lg text-accent pt-2">
                                        <span class="rounded p-2 me-3" style="background-color: #0093E9; background-image: linear-gradient(160deg, #0093E9 0%, #80D0C7 100%);">
                                            {{ $wishlist->movie->age->name }}
                                        </span>
                                        <div class="pt-3">
                                            @foreach($movieGenres as $movieGenre)
                                                @if($movieGenre->movie_id == $wishlist->movie->id)
                                                    <li class="">
                                                @foreach($genres as $genre)
                                                            <span> {{$genre->id == $movieGenre->genre_id ? $genre->name:''}}</span>
                                                        @endforeach
                                            </li>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="pt-2 ps-sm-3 mx-auto mx-sm-0 text-center">
                                <button onclick="removeMovie({{ $wishlist->movie_id }});" class="btn btn-outline-danger btn-sm" type="button">
                                    <i class="fas fa-trash-alt me-2"></i>Xóa
                                </button>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="fs-3">Danh sách phim yêu thích của bạn đang trống !!</div>
                @endif
            </div>
        </div>
    </div>
    </body>
@endsection

@section('customJs')
    <script>
        function removeMovie(id) {
            $.ajax({
                url: '{{ route("removeMovieFromWishlist") }}',
                type: 'post',
                data: {id: id},
                dataType: 'json',
                success: function (response){
                    if (response.status == true){
                        window.location.href = "{{ route('wishlist') }}";
                    }
                }
            })
        }
    </script>
@endsection
