@extends('layouts.admin-navbar')
@section('content')
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Order</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{route('order.index')}}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <form action="" method="post" id="editOrderForm" name="editOrderForm">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="number_of_row">Date</label>
                                        <input type="datetime-local" name="date" id="date" disabled class="form-control" value="{{$order ->date}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="number_of_col">Reservation Contact</label>
                                        <input type="tel" name="reservation_contact" id="reservation_contact" disabled class="form-control" value="{{$order->reservation_contact}}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="number_of_col">Customer Id</label>
                                        <input type="tel" name="number_of_col" id="number_of_col" disabled class="form-control" value="{{$order->customer->last_name . $order->customer->first_name}}">
                                    </div>
                                </div>
                                <div class="col-md-4 d-flex">
                                    <div class="mb-3">
                                        <label for="status">Status</label>
                                        <select name="status" id="status" class="btn btn-dark bi bi-caret-down">
                                            <option {{($order->status == 1) ? 'selected' : ''}} value="1" >Active</option>
                                            <option {{($order->status == 0) ? 'selected' : ''}} value="0" >Block</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="screening_id">Screening Id</label>
                                        <select disabled name="screening_id" id="screening_id" class="btn btn-dark bi bi-caret-down">
                                            <option value="{{$order->screening->id}}">{{$order->screening->movie->title}}</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="reservation_type_id">Reservation Type</label>
                                        <select disabled name="reservation_type_id" id="reservation_type_id" 
                                        class="btn btn-dark bi bi-caret-down">
                                            <option value="{{$order->reservation_type->id}}">{{$order->reservation_type->reservation_type}}</option>
                                        </select>
                                    </div>
                                </div>
                                {{-- <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="screening_id">Screening Id</label>
                                        <select disabled name="screening_id" id="screening_id" class="btn btn-dark bi bi-caret-down">
                                            <option value="{{$order->screening->id}}">{{$order->screening->movie->title}}</option>
                                        </select>
                                    </div>
                                </div> --}}
                        </div>
                    </div>
                </div>
                <div class="pb-5 pt-3">
                    <button class="btn btn-primary" type="submit">Update</button>
                    <a href="{{route('order.index')}}" class="btn btn-outline-dark ml-3">Cancel</a>
                </div>
            </form>
        </div>
        <!-- /.card -->
    </section>
@endsection
@section('customJs')
    <script>
        $("#editOrderForm").submit(function (event){
            event.preventDefault();
            var element = $(this);
            $("button[type=submit]").prop('disabled', true)
            $.ajax({
                url: '{{route('order.update', $order->id)}}',
                type: 'put',
                data: element.serializeArray(),
                dataType: 'json',
                success: function (response){
                    $("button[type=submit]").prop('disabled', false)

                    if (response["status"] === true){
                        window.location.href='{{route('order.index')}}';

                        $("#screening_id").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                        $("#reservation_type_id").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                        $("#status").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                        $("#reservation_contact").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                        $("#customer_id").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                        $("#contact").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                    }else {
                        if (response['notFound'] == true){
                            window.location.href = "{{ route('order.index') }}";
                        }
                            var errors = response['errors'];
                                if (errors['status']){
                                    $("#status").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['status']);
                                }else {
                                    $("#status").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                                }
                    }

                }, error: function (jqXHR, exception){
                    console.log("Something went wrong");
                }
            })
        })
    </script>
@endsection
