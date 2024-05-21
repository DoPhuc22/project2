@extends('layouts.admin-navbar')
@section('content')
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Reservation Type</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{route('reservationType.index')}}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <form action="" method="post" id="editReservationTypeForm" name="editReservationTypeForm">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="reservation_type">Reservation Type</label>
                                    <input value="{{$reservationType->reservation_type}}" type="text" 
                                    name="reservation_type" id="reservation_type" class="form-control" placeholder="Name">
                                    <p></p>
                                </div>
                            </div>
                            {{-- <div class="col-md-1">
                                <div class="mb-3">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="btn btn-dark bi bi-caret-down">
                                        <option {{($reservationType->status == 1) ? 'selected' : ''}} value="1" >Active</option>
                                        <option {{($reservationType->status == 0) ? 'selected' : ''}} value="0" >Block</option>
                                    </select>
                                </div> --}}
                            </div>
                            {{-- <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email">Description</label>
                                    <textarea type="text" name="description" id="description" class="form-control" placeholder="Description" rows="4">
                                        {{$reservationType->description}}
                                    </textarea>
                                    <p></p>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
                <div class="pb-5 pt-3">
                    <button class="btn btn-primary" type="submit">Update</button>
                    <a href="{{route('reservationType.index')}}" class="btn btn-outline-dark ml-3">Cancel</a>
                </div>
            </form>
        </div>
        <!-- /.card -->
    </section>
@endsection
@section('customJs')
    <script>
        $("#editReservationTypeForm").submit(function (event){
            event.preventDefault();
            var element = $(this);
            $("button[type=submit]").prop('disabled', true)
            $.ajax({
                url: '{{route('reservationType.update', $reservationType->id)}}',
                type: 'put',
                data: element.serializeArray(),
                dataType: 'json',
                success: function (response){
                    $("button[type=submit]").prop('disabled', false)

                    if (response["status"] === true){
                        window.location.href='{{route('reservationType.index')}}';

                        $("#reservation_type").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                    }else {
                        if (response['notFound'] == true){
                            window.location.href = "{{ route('reservationType.index') }}";
                        }
                            var errors = response['errors'];
                                if (errors['name']){
                                    $("#reservation_type").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['reservation_type']);
                                }else {
                                    $("#reservation_type").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                                }
                    }

                }, error: function (jqXHR, exception){
                    console.log("Something went wrong");
                }
            })
        })
    </script>
@endsection
