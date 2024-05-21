@extends('layouts.admin-navbar')
@section('content')
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit User</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{route('user.index2')}}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <form action="" method="post" id="editUserForm" name="editUserForm">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name">Name</label>
                                        <input type="text" name="name" id="name" class="form-control" disabled placeholder="Name" value="{{$user->name}}">
                                        <p></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="email">Email</label>
                                        <input type="email" name="email" id="email" class="form-control" disabled placeholder="Name" value="{{$user->email}}">
                                        <p></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="password">Pasword</label>
                                        <input type="password" name="password" id="password" class="form-control" disabled placeholder="Name" value="{{$user->password}}">
                                        <p></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="phone_number">Phone Number</label>
                                        <input type="tel" name="phone_number" id="phone_number" class="form-control" disabled placeholder="Name" value="{{$user->phone_number}}">
                                        <p></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <input type="hidden" id="image_id" name="image_id" value="">
                                        <label for="image" class="mb-3">Media</label>
                                        <div id="image" class="dropzone dz-clickable">
                                            <div class="dz-message needsclick">
                                                <br>Drop files here or click to upload.<br><br>
                                            </div>
                                            <p></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="role">Type of Seat</label>
                                        <select name="role" id="role" class="btn btn-dark bi bi-caret-down">
                                            <option value="1">Admin</option>
                                            <option value="0">Employee</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
                <div class="pb-5 pt-3">
                    <button class="btn btn-primary" type="submit">Update</button>
                    <a href="{{route('user.index2')}}" class="btn btn-outline-dark ml-3">Cancel</a>
                </div>
            </form>
        </div>
        <!-- /.card -->
    </section>
@endsection
@section('customJs')
    <script>
        $("#editUserForm").submit(function (event){
            event.preventDefault();
            var element = $(this);
            $("button[type=submit]").prop('disabled', true)
            $.ajax({
                url: '{{route('user.update', $user->id)}}',
                type: 'put',
                data: element.serializeArray(),
                dataType: 'json',
                success: function (response){
                    $("button[type=submit]").prop('disabled', false)

                    if (response["status"] == true){
                        window.location.href='{{route('user.index2')}}'

                    }else {
                        var errors = response['errors'];
                        $(".error").removeClass('invalid-feedback').html('');
                        $("input[type='text'], select, input[type='number']").removeClass('is-invalid')
                        $.each(errors, function (key, value){
                            $(`#${key}`).addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(value)
                        })
                    }

                }, error: function (){
                    console.log('Something Went Wrong')
                }
            })
        })

        // Dropzone.autoDiscover = false;
        // const dropzone = $("#image").dropzone({
        //     init: function () {
        //         this.on('addedfile', function (file) {
        //             if (this.files.length > 1) {
        //                 this.removeFile(this.files[0]);
        //             }
        //         })
        //     },
        //     url: "{{ route('user.temp-images.create') }}",
        //     maxFiles: 1,
        //     paramName: 'image',
        //     addRemoveLinks: true,
        //     acceptedFiles: "image/jpeg,image/png,image/gif",
        //     headers: {
        //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //     }, success: function (file, response){
        //         $("#image_id").val(response.image_id);
        //         //console.log(response)
        //     }
        // })
    </script>
@endsection
