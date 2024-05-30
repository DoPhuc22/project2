@extends('layouts.admin-navbar')
@section('content')
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid my-2">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Tất cả đơn đặt </h1>
                    </div>
                    <div class="col-sm-6 text-right">
                        {{-- <a href="{{route('reservationType.create')}}" class="bi bi-plus-circle btn btn-primary">New Reservation Type</a> --}}
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
                                <button type="button" onclick="window.location.href='{{route('order.index')}}'" class="btn btn-default btn-sm">
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
                                <th scope="col">Phim chiếu</th>
                                <th scope="col">Ngày đặt</th>
                                <th scope="col">Status</th>
                                <th scope="col">Tên khách hàng</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($orders->count() > 0)
                                @foreach($orders as $order)
                                <tr class="text-center">
                                    <td>{{$order->id}}</td>
                                    <td>{{$order->screening->movie->title}}</td>
                                    <td>{{ \Carbon\Carbon::parse($order->date)->format('d-m-Y') }}</td>
                                    <td>
                                        @if($order->status == 1)
                                            <svg class="text-success-500 h-6 w-6 text-success" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>

                                        @else
                                            <svg class="text-danger h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        @endif
                                    </td>
                                    <td>{{$order->customer->first_name . " " . $order->customer->last_name}}</td>
                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="8  ">Records Not Found</td>
                                </tr>
                            @endif

                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer clearfix">
                        {{$orders->onEachSide(3)->links()}}
                    </div>
                </div>
            </div>
            <!-- /.card -->
        </section>
        <!-- /.content -->
@endsection
@section('customJs')
    <script>
        function deleteOrder(id) {
            var url = '{{ route('order.destroy', 'ID') }}';
            var newUrl = url.replace("ID", id);

            if (confirm("Are you sure you want to delete !!")) {
                $.ajax({
                    url: newUrl,
                    type: 'delete',
                    data: {},
                    dataType: 'json',
                    success: function (response) {
                        if (response["status"]) {
                            window.location.href = '{{route('order.index')}}'
                        } else {

                        }
                    }
                });
            }
        }
    </script>
@endsection
