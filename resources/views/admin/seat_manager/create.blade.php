@extends('layouts.admin-navbar')
@section('content')
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Thêm ghế mới</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{route('seat.index')}}" class="btn btn-primary">Trở lại</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <form action="" method="post" id="seatForm" name="seatForm">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="number_of_row">Số lượng ghế theo hàng ngang</label>
                                    <input type="number" min="1" name="number_of_row" id="number_of_row" class="form-control">
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="Screening End">Số lượng ghế theo hàng dọc</label>
                                    <input type="number" min="1" name="number_of_col" id="number_of_col" class="form-control">
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="auditorium_id">Phòng chiếu</label>
                                    <select name="auditorium_id" id="auditorium_id" class="btn btn-dark bi bi-caret-down">
                                        @foreach ($auditoriums as $auditorium)
                                        <option value="{{$auditorium -> id}}">{{$auditorium -> name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="pb-5 pt-3">
                    <button class="btn btn-primary" type="submit">Tạo</button>
                    <a href="{{route('seat.index')}}" class="btn btn-outline-dark ml-3">Hủy</a>
                </div>
            </form>
        </div>
        <!-- /.card -->
    </section>
@endsection
@section('customJs')
    <script>
        $("#seatForm").submit(function (event){
            event.preventDefault();
            var element = $(this);
            $("button[type=submit]").prop('disabled', true)
            $.ajax({
                url: '{{route('seat.store')}}',
                type: 'post',
                data: element.serializeArray(),
                dataType: 'json',
                success: function (response){
                    $("button[type=submit]").prop('disabled', false)

                    if (response["status"] == true){
                        window.location.href='{{route('seat.index')}}'
                        $("#number_of_row").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                        $("#number_of_col").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                    }else {
                        var errors = response['errors'];
                        if (errors['number_of_row']){
                            $("#number_of_row").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['number_of_row']);
                        }else {
                            $("#number_of_row").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                        }

                        if (errors['number_of_col']){
                            $("#number_of_col").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['number_of_col']);
                        }else {
                            $("#number_of_col").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                        }
                    }

                }, error: function (jqXHR, exception){
                    console.log("Something went wrong");
                }
            })
        })
    </script>
@endsection
