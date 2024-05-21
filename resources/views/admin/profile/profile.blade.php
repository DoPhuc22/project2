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
                            <a href="" class="btn btn-danger btn-sm text-white float-end">Trở lại</a>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    <div class="row content">
        <form action="" method="post" enctype="multipart/form-data" class="d-flex bg-white py-sm-3 rounded-3 container">
            <div class="col-md-4 border-right">
                dd
            </div>
            <div class="col-md-7">
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
                            <label class="fs-4">Product Name</label>
                            <input type="text" name="product_name" class="form-control"
                                   value="" required>
                        </div>
                        <div class="mb-3 mt-3">
                            <label class="fs-4">Quantity</label>
                            <input type="text" name="quantity" class="form-control"
                                   value="" required>
                        </div>
                        <div class="mb-3 mt-3">
                            <label class="fs-4">Price</label>
                            <input type="text" name="price" class="form-control"
                                   value="" required>
                        </div>
                        <div class="mb-3 mt-3">
                            <label class="fs-4">Description</label>
                            <textarea type="text" name="description" class="form-control" rows="4"
                            ></textarea>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="detail-tab-pane" role="tabpanel" aria-labelledby="detail-tab" tabindex="0">
                        <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                            <div class="mb-3 mt-3">
                                <label class="fs-4">Product Name</label>
                                <input type="text" name="product_name" class="form-control"
                                       value="" required>
                            </div>
                            <div class="mb-3 mt-3">
                                <label class="fs-4">Quantity</label>
                                <input type="text" name="quantity" class="form-control"
                                       value="" required>
                            </div>
                            <div class="mb-3 mt-3">
                                <label class="fs-4">Price</label>
                                <input type="text" name="price" class="form-control"
                                       value="" required>
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
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <form action="" method="post" id="editCastForm" name="editCastForm">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Họ & Tên</label>
                                    <input value="{{Auth::guard('admin')->user()->name}}" type="text" name="name" id="name" class="form-control" placeholder="Name">
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Vai trò</label>
                                    <select name="status" id="status" class="btn btn-dark bi bi-caret-down">--}}
                                        <option {{(Auth::guard('admin')->user()->role == 1) ? 'selected' : ''}} value="1" >Quản trị viên</option>
                                        <option {{(Auth::guard('admin')->user()->role == 2) ? 'selected' : ''}} value="0" >Nhân viên</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <input type="hidden" id="image_id" name="image_id" value="">
                                    <label for="image">Ảnh</label>
                                    <div id="image" class="dropzone dz-clickable">
                                        <div class="dz-message needsclick">
                                            <br>Thả tập tin vào đây hoặc bấm vào để tải lên
                                        </div>
                                    </div>
                                </div>
{{--                                @if(!empty($cast->image))--}}
{{--                                    <div>--}}
{{--                                        <img width="250" src="{{ asset('uploads/cast/'.$cast->image) }}" alt="">--}}
{{--                                    </div>--}}
{{--                                @endif--}}
                            </div>
                            <div class="col-md-1">
                                <div class="mb-3">
                                    <label for="status">Trạng thái</label>
                                    <select name="status" id="status" class="btn btn-dark bi bi-caret-down">
                                        <option {{(Auth::guard('admin')->user()->status == 1) ? 'selected' : ''}} value="1" >Hoạt động</option>
                                        <option {{(Auth::guard('admin')->user()->status == 2) ? 'selected' : ''}} value="0" >Không hoạt động</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
{{--                <div class="pb-5 pt-3">--}}
{{--                    <button class="btn btn-primary" type="submit">Update</button>--}}
{{--                    <a href="{{route('cast.index')}}" class="btn btn-outline-dark ml-3">Cancel</a>--}}
{{--                </div>--}}
            </form>
        </div>
        <!-- /.card -->
    </section>
@endsection
@section('customJs')
    <script>
        function deleteGenre(id) {
            var url = '{{ route('cast.destroy', 'ID') }}';
            var newUrl = url.replace("ID", id);

            if (confirm("Are you sure you want to delete !!")) {
                $.ajax({
                    url: newUrl,
                    type: 'delete',
                    data: {},
                    dataType: 'json',
                    success: function (response) {
                        if (response["status"]) {
                            window.location.href = '{{route('cast.index')}}'
                        } else {

                        }
                    }
                });
            }
        }
    </script>
@endsection
