@extends('layouts.admin-navbar')
@section('content')
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid my-2">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Tất cả các loại ghế</h1>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a href="{{route('seatType.create')}}" class="bi bi-plus-circle btn btn-primary">Tạo loại ghế mới</a>
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
                                <button type="button" onclick="window.location.href='{{route('seatType.index')}}'" class="btn btn-default btn-sm">
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
                        <table class="table table-hover table-bordered text-nowrap">
                            <thead>
                            <tr class="text-center">
                                <th scope="col">ID</th>
                                <th scope="col">Tên loại ghế</th>
                                <th scope="col">Giá</th>
                                {{-- <th scope="col">Description</th>
                                <th scope="col">Status</th> --}}
                                <th scope="col">Hành động</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($seatTypes->count() > 0)
                                @foreach($seatTypes as $seatType)
                                <tr class="text-center">
                                    <td>{{$seatType->id}}</td>
                                    <td>{{$seatType->name}}</td>
                                    <td>{{ number_format($seatType->price) }} VND</td>
                                    <td>
                                        <a href="{{route('seatType.edit', $seatType->id)}}">
                                            <svg class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                            </svg>
                                        </a>
                                        <a href="#" onclick="deleteSeatType({{ $seatType->id }})" class="text-danger w-4 h-4 mr-1">
                                            <svg wire:loading.remove.delay="" wire:target="" class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path	ath fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5">Chưa có loại ghế nào 😓</td>
                                </tr>
                            @endif

                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer clearfix">
                        {{$seatTypes->onEachSide(3)->links()}}
                    </div>
                </div>
            </div>
            <!-- /.card -->
        </section>
        <!-- /.content -->
@endsection
@section('customJs')
    <script>
        function deleteSeatType(id) {
            var url = '{{ route('seatType.destroy', 'ID') }}';
            var newUrl = url.replace("ID", id);

            if (confirm("Bạn có chắc rằng muốn xóa loại ghế này không !!")) {
                $.ajax({
                    url: newUrl,
                    type: 'delete',
                    data: {},
                    dataType: 'json',
                    success: function (response) {
                        if (response["status"]) {
                            window.location.href = '{{route('seatType.index')}}'
                        } else {

                        }
                    }
                });
            }
        }
    </script>
@endsection
