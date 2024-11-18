@extends('layouts.admin-navbar')
@section('content')
    <!-- Content Header (Page header) -->
{{--    <section class="content-header">--}}
{{--        <div class="container-fluid my-2">--}}
{{--            <div class="row mb-2">--}}
{{--                <div class="col-sm-6">--}}
{{--                    <h1>Tài khoản</h1>--}}
{{--                </div>--}}
{{--                <div class="col-sm-6 text-right">--}}
{{--                    <a href="" class="btn btn-primary">Back</a>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <!-- /.container-fluid -->--}}
{{--    </section>--}}
    <!-- Main content -->
        <div class=" row content">
            <div class="container">
                <div class="card mt-5">
                    <div class="card-header">
                        <h3>Tài khoản
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-danger btn-sm text-white float-end">Trở lại</a>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    <div class="content">
        <form action="" id="editUserForm" method="post" enctype="multipart/form-data" class="d-flex bg-white py-sm-3 rounded-3 container border">
            <div class="col-lg-4 border-right">
                    @if(!empty(Auth::guard('admin')->user()->image))
                        <img src="{{ asset('uploads/user/'.Auth::guard('admin')->user()->image) }}" class="card-img object-fit-cover rounded-circle border shadow-sm" alt="">
                    @else
                        <img width="100" src="{{ asset('admin-assets/img/default-150x150.png') }}" class="card-img object-fit-cover rounded-circle border shadow-sm" alt="">
                        <span class="position-absolute bi bi-"></span>
                    @endif
                    <input type="hidden" id="image_id" name="image_id" value="">
                    <div id="image" class="dropzone dz-clickable">
                        <div href="#" class="text-center dz-message needsclick" type="file">Đổi ảnh đại diện <span class="bi bi-pen-fill"></span></div>
                    </div>
            </div>
            <div class="col-lg-7">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="home-tab" data-bs-toggle="tab"
                                data-bs-target="#home-tab-pane" type="button" role="tab"
                                aria-controls="home-tab-pane" aria-selected="true">
                            Thông tin
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="detail-tab" data-bs-toggle="tab"
                                data-bs-target="#detail-tab-pane" type="button" role="tab"
                                aria-controls="detail-tab-pane" aria-selected="false">
                            Quản lý
                        </button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                        <div class="mb-3 mt-3">
                            <label class="fs-4">Họ & Tên</label>
                            <input type="text" name="name" class="form-control" id="name"
                                   value="{{Auth::guard('admin')->user()->name}}">
                            <p></p>
                        </div>
                        <div class="mb-3 mt-3">
                            <label class="fs-4">Vai trò</label>
                            <div id="status" class="btn btn-secondary">
                                @if(Auth::guard('admin')->user()->role == 1)
                                    <span class="text-success">Quản trị viên</span>
                                @else
                                    <span class="text-warning">Nhân viên</span>
                                @endif
                            </div>
                        </div>
                        <div class="mb-3 mt-3">
                            <label class="fs-4">Email</label>
                            <input type="email" name="email" class="form-control" id="email"
                                   value="{{ Auth::guard('admin')->user()->email }}">
                            <p></p>
                        </div>
                        <div class="mb-3 mt-3">
                            <label class="fs-4">Số điện thoại</label>
                            <input type="number" name="phone_number" class="form-control" id="phone_number"
                                   value="{{ Auth::guard('admin')->user()->phone_number }}">
                        </div>
                    </div>
                    <div class="tab-pane fade" id="detail-tab-pane" role="tabpanel" aria-labelledby="detail-tab" tabindex="0">
                        <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                            <div class="mb-3 mt-3">
                                <label class="fs-4">Product Name</label>
                                <input type="text" name="product_name" class="form-control"
                                       value="" >
                            </div>
                            <div class="mb-3 mt-3">
                                <label class="fs-4">Quantity</label>
                                <input type="text" name="quantity" class="form-control"
                                       value="" >
                            </div>
                            <div class="mb-3 mt-3">
                                <label class="fs-4">Price</label>
                                <input type="text" name="price" class="form-control"
                                       value="" >
                            </div>
                            <div class="mb-3 mt-3">
                                <label class="fs-4">Description</label>
                                <textarea type="text" name="description" class="form-control" rows="4"
                                ></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <button type="submit" class="btn btn-primary">Cập nhật</button>
            </div>
        </form>
    </div>
@endsection
@section('customJs')
    <script>
        $("#editUserForm").submit(function (event){
            event.preventDefault();
            var element = $(this);
            $("button[type=submit]").prop('disabled', true)
            $.ajax({
                url: '{{route('user.update')}}',
                type: 'post',
                data: element.serializeArray(),
                dataType: 'json',
                success: function (response){
                    $("button[type=submit]").prop('disabled', false)

                    if (response["status"] === true){
                        window.location.href='{{route('admin.dashboard')}}';

                        $("#name").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                        $("#email").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                    }else {
                        if (response['notFound'] == true){
                            window.location.href = "{{ route('admin.profile') }}";
                        }

                        var errors = response['errors'];
                        if (errors['name']){
                            $("#name").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['name']);
                        }else {
                            $("#name").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                        }

                        if (errors['email']){
                            $("#email").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['email']);
                        }else {
                            $("#email").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                        }
                    }

                }, error: function (jqXHR, exception){
                    console.log("Something went wrong");
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
            url: "{{ route('user.temp-images.create') }}",
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