@extends('layouts.admin-navbar')
@section('content')
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Thêm đợt chiếu mới</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{route('screening.index')}}" class="btn btn-primary">Trở lại</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <form action="" method="post" id="screeningForm" name="screeningForm">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="Screening Start">Thời gian đợt chiếu bắt đầu</label>
                                    <input type="datetime-local" name="screening_start" id="screening_start" class="form-control">
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="Screening End">Thời gian đợt chiếu kết thúc</label>
                                    <input type="datetime-local" name="screening_end" id="screening_end" class="form-control">
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
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="movie_id">Phim</label>
                                    <select name="movie_id" id="movie_id" class="btn btn-dark bi bi-caret-down">
                                        @foreach ($movies as $movie)
                                        <option value="{{$movie -> id}}">{{$movie -> title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pb-5 pt-3">
                    <button class="btn btn-primary" type="submit">Tạo</button>
                    <a href="{{route('screening.index')}}" class="btn btn-outline-dark ml-3">Hủy</a>
                </div>
            </form>
        </div>
        <!-- /.card -->
    </section>
@endsection
@section('customJs')
    <script>
        $("#screeningForm").submit(function (event){
            event.preventDefault();
            var element = $(this);
            $("button[type=submit]").prop('disabled', true)
            $.ajax({
                url: '{{route('screening.store')}}',
                type: 'post',
                data: element.serializeArray(),
                dataType: 'json',
                success: function (response){
                    $("button[type=submit]").prop('disabled', false)

                    if (response["status"] == true){
                        window.location.href='{{route('screening.index')}}'
                        $("#movie_id").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                        $("#auditorium_id").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                        $("#screening_start").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                        $("#screening_end").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                    }else {
                        var errors = response['errors'];
                        if (errors['movie_id']){
                            $("#movie_id").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['movie_id']);
                        }else {
                            $("#movie_id").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                        }

                        if (errors['auditorium_id']){
                            $("#auditorium_id").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['auditorium_id']);
                        }else {
                            $("#auditorium_id").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                        }

                        if (errors['screening_start']){
                            $("#screening_start").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['screening_start']);
                        }else {
                            $("#screening_start").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                        }

                        if (errors['screening_end']){
                            $("#screening_end").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['screening_end']);
                        }else {
                            $("#screening_end").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                        }
                    }

                }, error: function (jqXHR, exception){
                    console.log("Something went wrong");
                }
            })
        })
    </script>
@endsection
