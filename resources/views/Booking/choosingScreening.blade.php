@extends('layouts.customer-nav')
@section('content')
    @vite(["resources/sass/app.scss", "resources/js/app.js"])
    <head>
        <title>Booking</title>
        <link rel="stylesheet" href="{{asset('frontend/css/main.css')}}">
    </head>
    <body style="background-color: #00001c;">
    <hr class="text-white">
    <section class="section-5 pt-3 pb-3 mb-3">
        <div class="container">
            <div>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a class="text-white nav-link" href="{{ route('home') }}">Home</a></li>
                    <li class="bi bi-slash-lg text-white">Booking</li>
                </ol>
            </div>
        </div>
    </section>
      {{-- @foreach ($seats as $seat)
        @php
          $rows = $seat->number_of_row;
          $cols = $seat->number_of_col;
          $nextSeat = 1;
       @endphp
      @endforeach --}}
      @php
          $nextSeat = 1;
          $previous = 1;
      @endphp
<form action="{{route('postScreening')}}" method="POST" enctype="multipart/form-data">
@csrf
@method('POST')
        
        <div class="d-flex flex-column">
          @foreach ($screening as $item)
            @if ($item->screening_end > now())
            {{-- <input type="hidden" name="screening_id" value="{{$item ->id}}"> --}}
            <input type="hidden" name="auditorium_id" value="{{$item->auditorium_id}}">
            <input type="hidden" name="movie_id" value="{{$item->movie_id}}">
            <input type="radio" class="btn-check" name="screening_id" id="success-outlined-{{$item->id}}" autocomplete="off" value="{{$item ->id}}">
            <label class="btn btn-outline-success" for="success-outlined-{{$item->id}}">{{$item->screening_start}} {{$item->auditorium->name}}</label>
            @endif
           @endforeach
        </div>
         {{-- End Screening --}}
  </div>
  <button type="submit" class="btn btn-primary">Primary</button>
</form>


@include('layouts/scroll_to_top')
    </body>
    <script src="{{asset('frontend/js/home.js')}}"></script>
    <script src="{{asset('admin-assets/plugins/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('admin-assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('admin-assets/js/adminlte.min.js')}}"></script>
    <script src="{{asset('admin-assets/js/demo.js')}}"></script>
@endsection
