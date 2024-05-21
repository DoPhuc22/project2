@extends('layouts.customer-nav')
@section('content')
    <section class="container">
        <div class="col-md-12 text-center py-5">
            @if(\Illuminate\Support\Facades\Session::has('success'))
                <div class="alert alert-success">
                    {{ \Illuminate\Support\Facades\Session::get('success') }}
                </div>
            @endif
            <h1>Cảm ơn!</h1>
            <p>Your Order Id is {{$id}} </p>
        </div>
    </section>
@endsection
