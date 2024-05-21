@extends('layouts.admin-navbar')
@section('content')
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Thêm phim mới</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('movie.index') }}" class="btn btn-primary">Trở lại</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <form action="" method="post" name="movieForm" id="movieForm">
            <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="title">Tên phim</label>
                                        <input type="text" name="title" id="title" class="form-control" placeholder="Tên phim">
                                        <p class="error"></p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="description">Mô tả</label>
                                        <textarea name="description" id="description" type="text" cols="30" rows="10" class="summernote" placeholder="Description"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="card-body">
                            <input type="hidden" id="image_id" name="image_id" value="">
                            <label for="image" class="mb-3">Ảnh</label>
                            <div id="image" class="dropzone dz-clickable">
                                <div class="dz-message needsclick">
                                    <br>Thả tệp ở đây hoặc ấn để tải lên.<br><br>
                                </div>
                                <p></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h2 class="h4">Trạng thái</h2>
                            <div class="mb-3">
                                <select name="status" id="status" class="form-select">
                                    <option value="1">Chiếu</option>
                                    <option value="0">Không chiếu</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Chi tiết</h2>
                            <div class="accordion accordion-flush" id="accordionExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                            Thể loại
                                        </button>
                                    </h2>
                                    <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample" style="">
                                        <div class="accordion-body">
                                            <div class="navbar-nav">
                                                <div class="form-check mb-2">
                                                    <form name="genre_id" id="genre_id" class="form-control">
                                                        @if($genres->count() > 0)
                                                            @foreach($genres as $genre)
                                                                <input class="form-check-input" type="checkbox" value="{{ $genre->id }}" id="genre_id" name="genre_id[]">
                                                                <option class="form-check-label" value="{{$genre->id}}" id="genre_id" name="genre_id">
                                                                    {{$genre->name}}
                                                                </option>
                                                            @endforeach
                                                        @else
                                                            <label class="form-check-label" for="genre_id">
                                                                Không tìm thấy thể loại nào
                                                            </label>
                                                        @endif
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            Độ tuổi
                                        </button>
                                    </h2>
                                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample" style="">
                                        <div class="accordion-body">
                                            <div class="navbar-nav">
                                                <div class="form-check mb-2">
                                                    <select name="age_id" id="age_id" class="form-control">
                                                        <option value="">Select an age</option>
                                                    @if($ages->count() > 0)
                                                        @foreach($ages as $age)
                                                                <option value="{{$age->id}}">{{$age->name}}</option>
                                                        @endforeach
                                                    @endif
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                            Diễn viên
                                        </button>
                                    </h2>
                                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample" style="">
                                        <div class="accordion-body">
                                            <div class="navbar-nav">
                                                <div class="form-check mb-2">
                                                    <select name="cast_id" id="cast_id" class="form-control d-none">
                                                        @if($casts->count() > 0)
                                                            @foreach($casts as $cast)
                                                                <input class="form-check-input" type="checkbox" value="{{$cast->id}}" id="cast_id" name="cast_id[]">
                                                                <option class="form-check-label" value="{{$cast->id}}" id="cast_id" name="cast_id">
                                                                    {{$cast->name}}
                                                                </option>
                                                            @endforeach
                                                        @else
                                                            <label class="form-check-label" for="cast_id">
                                                                Không tìm thấy diễn viên nào
                                                            </label>
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Đạo diễn</h2>
                            <div class="mb-3">
                                <input type="text" name="director" id="director" class="form-control" placeholder="Nhập tên đạo diễn">
                            </div>
                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Ngôn ngữ</h2>
                            <div class="mb-3">
                                <input type="text" name="language" id="language" class="form-control" placeholder="Ngôn ngữ">
                            </div>
                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="card-body">
                            <h2 class="h4">Phổ biến</h2>
                            <div class="mb-3">
                                <select name="is_featured" id="is_featured" class="form-select">
                                    <option value="No">Không</option>
                                    <option value="Yes">Có</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Thời gian</h2>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="release_date">Khỏi chiếu</label>
                                        <input type="date" name="release_date" id="release_date" class="form-control" placeholder="date">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="duration">Thời lượng</label>
                                        <input type="text" name="duration" id="duration" class="form-control" placeholder="Duration">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pb-5 pt-3">
                <button class="btn btn-primary" type="submit" >Tạo</button>
                <a href="{{ route('movie.index') }}" class="btn btn-outline-dark ml-3">Hủy</a>
            </div>
        </div>
        </form>
        <!-- /.card -->
    </section>
@endsection

@section('customJs')
    <script>
        $("#movieForm").submit(function (event){
            event.preventDefault();
            var formArray = $(this).serializeArray();
            $.ajax({
                url: '{{route('movie.store')}}',
                type: 'post',
                data: formArray,
                dataType: 'json',
                success: function (response) {
                    $("button[type=submit]").prop('disabled', false)

                    if (response["status"] == true){
                        window.location.href='{{route('movie.index')}}'

                    }else {
                        var errors = response['errors'];
                        $(".error").removeClass('invalid-feedback').html('');
                        $("input[type='text'], select, input[type='number']").removeClass('is-invalid')
                        $.each(errors, function (key, value){
                            $(`#${key}`).addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(value)
                        })
                    }
                },
                error: function (){
                    console.log('Something Went Wrong')
                }
            })
        })

        Dropzone.autoDiscover = false;
        const dropzone = $("#image").dropzone({
            init: function () {
                this.on('addedfile', function (file) {
                    if (this.files.length > 1) {
                        this.removeFile(this.files[0]);
                    }
                })
            },
            url: "{{ route('movie.temp-images.create') }}",
            maxFiles: 1,
            paramName: 'image',
            addRemoveLinks: true,
            acceptedFiles: "image/jpeg,image/png,image/gif",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }, success: function (file, response){
                $("#image_id").val(response.image_id);
                //console.log(response)
            }
        })
    </script>
@endsection

