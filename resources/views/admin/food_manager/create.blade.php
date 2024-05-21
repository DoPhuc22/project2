
@extends('layouts.admin-navbar')
@section('content')
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Food</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('food.index') }}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <form action="" method="post" id="foodForm" name="foodForm">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Food Name">
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="price">Price</label>
                                    <input type="text" name="price" id="price" class="form-control" placeholder="Price (e.g., 12.99)">
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="description">Description</label>
                                    <textarea type="text" name="description" id="description" class="form-control" placeholder="Food Description" rows="4"></textarea>
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <input type="hidden" id="image_id" name="image_id" value="">
                                    <label for="image">Image</label>
                                    <div id="image" class="dropzone dz-clickable">
                                        <div class="dz-message needsclick">
                                            <br>Drop files here or click to upload
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="btn btn-dark bi bi-caret-down">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pb-5 pt-3">
                    <button class="btn btn-primary" type="submit">Create</button>
                    <a href="{{ route('food.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
                </div>
            </form>
        </div>
    </section>
@endsection
@section('customJs')
    <script>
        $("#foodForm").submit(function (event) {
            event.preventDefault();
            var element = $(this);
            $("button[type=submit]").prop('disabled', true)
            $.ajax({
                url: '{{ route('food.store') }}',
                type: 'post',
                data: element.serializeArray(),
                dataType: 'json',
                success: function (response) {
                    $("button[type=submit]").prop('disabled', false)

                    if (response["status"] == true) {
                        window.location.href = '{{ route('food.index') }}'

                        $("#name").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                        $("#price").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                        $("#description").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                    } else {
                        var errors = response['errors'];
                        if (errors['name']) {
                            if (errors['name']) {
                                $("#name").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['name'][0]);
                            } else {
                                $("#name").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                            }

                            if (errors['price']) {
                                $("#price").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['price'][0]);
                            } else {
                                $("#price").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                            }

                            if (errors['description']) {
                                $("#description").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['description'][0]);
                            } else {
                                $("#description").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                            }
                        }
                    }
                }, error: function (jqXHR, exception) {
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
                url: "{{ route('food.temp-images.create') }}",
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
