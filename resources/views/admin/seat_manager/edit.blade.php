@extends('layouts.admin-navbar')
@section('content')
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Seat</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{route('seat.index')}}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <form action="" method="post" id="editSeatForm" name="editSeatForm">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="number_of_row">Number Of Row</label>
                                    <input type="number" min="1" name="number_of_row" id="number_of_row" disabled class="form-control" value="{{$seat->number_of_row}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="number_of_col">Number Of Column</label>
                                    <input type="number" min="1" name="number_of_col" id="number_of_col" disabled class="form-control" value="{{$seat->number_of_col}}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="btn btn-dark bi bi-caret-down">
                                        <option {{($seat->status == 1) ? 'selected' : ''}} value="1" >Active</option>
                                        <option {{($seat->status == 0) ? 'selected' : ''}} value="0" >Block</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="auditorium_id">Auditorium</label>
                                    <select disabled name="auditorium_id" id="auditorium_id" class="btn btn-dark bi bi-caret-down">
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
                    <button class="btn btn-primary" type="submit">Update</button>
                    <a href="{{route('seat.index')}}" class="btn btn-outline-dark ml-3">Cancel</a>
                </div>
            </form>
        </div>
        <!-- /.card -->
    </section>
@endsection
@section('customJs')
    <script>
        $("#editSeatForm").submit(function (event){
            event.preventDefault();
            var element = $(this);
            $("button[type=submit]").prop('disabled', true)
            $.ajax({
                url: '{{route('seat.update', $seat->id)}}',
                type: 'put',
                data: element.serializeArray(),
                dataType: 'json',
                success: function (response){
                    $("button[type=submit]").prop('disabled', false)

                    if (response["status"] === true){
                        window.location.href='{{route('seat.index')}}';

                        $("#number_of_row").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                        $("#number_of_col").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                        $("#auditorium_id").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                    }else {
                        if (response['notFound'] == true){
                            window.location.href = "{{ route('screening.index') }}";
                        }

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

                        if (errors['auditorium_id']){
                            $("#auditorium_id").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['auditorium_id']);
                        }else {
                            $("#auditorium_id").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                        }
                    }

                }, error: function (jqXHR, exception){
                    console.log("Something went wrong");
                }
            })
        })
    </script>
@endsection
