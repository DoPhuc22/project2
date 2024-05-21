@extends('layouts.admin-navbar')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Tất cả phim</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{route('movie.create')}}" class="bi bi-plus-circle btn btn-primary">Thêm phim mới</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            @include('admin.message')
            <div class="card">
                <form action="" method="get">
                    <div class="card-header">
                        <div class="card-title">
                            <button type="button" onclick="window.location.href='{{route('movie.index')}}'" class="btn btn-default btn-sm">
                                Reset
                            </button>
                        </div>
                        <div class="card-tools">
                            <div class="input-group input-group" style="width: 250px;">
                                <input type="text" name="keyword" class="form-control float-right" placeholder="Tìm kiếm">

                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover table-bordered">
                        <thead>
                        <tr class="text-center">
                            <th scope="col">ID</th>
                            <th scope="col">Tên phim</th>
                            <th scope="col">Ảnh</th>
                            <th scope="col">Thể loại</th>
                            <th scope="col">Đạo diễn</th>
                            <th scope="col">Trạng thái</th>
                            <th scope="col">Hành động</th>
                            <th scope="col">Chi tiết</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($movies->count() > 0)
                            @foreach($movies as $movie)
                                <tr class="text-center">
                                    <td>{{$movie->id}}</td>
                                    <td>{{$movie->title}}</td>
                                    <td>
                                        @if(!empty($movie->image))
                                            <img width="70" src="{{ asset('uploads/movie/'.$movie->image) }}" class="img-thumbnail" alt="">
                                        @else
                                            <img width="100" src="{{ asset('admin-assets/img/default-150x150.png') }}" class="img-thumbnail" alt="">
                                        @endif
                                    </td>
                                    <td>@foreach($movieGenres as $movieGenre)
                                            @if($movieGenre->movie_id == $movie->id)
                                                @foreach($genres as $genre)
                                                   <div> {{$genre->id == $movieGenre->genre_id ? $genre->name:''}}</div>
                                                @endforeach
                                            @endif

                                    @endforeach</td>
                                    <td>{{$movie->director}}</td>

                                    <td>
                                        @if($movie->status == 1)
                                            <svg class="text-success-500 h-6 w-6 text-success" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>

                                        @else
                                            <svg class="text-danger h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{route('movie.edit', $movie->id)}}">
                                            <svg class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                            </svg>
                                        </a>
                                        <a href="#" onclick="deleteMovie({{ $movie->id }})" class="text-danger w-4 h-4 mr-1">
                                            <svg wire:loading.remove.delay="" wire:target="" class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path	ath fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                            </svg>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ route('movie.indexDetail', $movie) }}" class="bi bi-ticket-perforated nav-link">
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="8">Records Not Found</td>
                            </tr>
                        @endif

                        </tbody>
                    </table>
                </div>
                <div class="card-footer clearfix">
                    {{$movies->onEachSide(3)->links()}}
                </div>
            </div>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
@endsection
@section('customJs')
    <script>
        function deleteMovie(id) {
            var url = '{{ route('movie.destroy', 'ID') }}';
            var newUrl = url.replace("ID", id);

            if (confirm("Are you sure you want to delete !!")) {
                $.ajax({
                    url: newUrl,
                    type: 'delete',
                    data: {},
                    dataType: 'json',
                    success: function (response) {
                        if (response["status"] === true) {
                            window.location.href = '{{route('movie.index')}}'
                        } else {
                            window.location.href = '{{route('movie.index')}}'
                        }
                    }
                });
            }
        }
    </script>

@endsection
