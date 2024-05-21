@extends('layouts.customer-nav')
@section('content')
    @vite(["resources/sass/app.scss", "resources/js/app.js"])
    <head>
        <title>Choose Date</title>
        <link rel="stylesheet" href="{{asset('frontend/css/main.css')}}">
        <link rel="stylesheet" href="{{asset('frontend/css/style.css')}}">
    </head>
    <body style="background-color: #00001c;">
    <hr class="text-white">

    <div class="text-white container mt-5"><a href="{{ route('movie') }}" class="nav-link bi bi-arrow-left ">Back</a></div>
    <section class="mt-5">
        <div class="form w-75">
            <!-- Progress bar -->
            <div class="progressbar w-100">
                <div class="progress" id="progress"></div>

                <div
                    class="progress-step progress-step-active"
                    data-title=""
                ></div>
                <div class="progress-step" data-title=""></div>
                <div class="progress-step" data-title=""></div>
                <div class="progress-step" data-title=""></div>
            </div>
            <!-- Steps -->
            <div class="form-step form-step-active">
                <h3 class="text-center text-white ">Stage 1: Choose time</h3>
                <div class="container">
                    <div class="row text-white">
                        <div class="col-md-12 text-center">
                            <form action="{{route('postScreening', $movie_id)}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('POST')
                                <div class="col-md-12">
                                    @if($screening->count() > 0)
                                        @foreach ($screening as $item)
                                            @if ($item->screening_end > \Carbon\Carbon::now('Asia/Ho_Chi_Minh'))
                                                {{-- <input type="hidden" name="screening_id" value="{{$item ->id}}"> --}}
                                                <input type="hidden" name="auditorium_id" value="{{$item->auditorium_id}}">
                                                <input type="hidden" name="movie_id" value="{{$item->movie_id}}">
                                                <input type="radio" class="btn-check" name="screening_id" id="success-outlined-{{$item->id}}" autocomplete="off" value="{{$item ->id}}">
{{--                                                <label class="btn btn-outline-success col-sm-4" for="success-outlined-{{$item->id}}">--}}
{{--                                                    <span class="text-white">Date:</span> {{\Carbon\Carbon::parse($item->screening_end)->format('d-m-Y')}}--}}
{{--                                                    <span class="text-white">Time:</span> {{\Carbon\Carbon::parse($item->screening_end)->format('H:i')}}--}}
{{--                                                    <span class="text-white">Auditorium:</span> {{$item->auditorium->name}}--}}
{{--                                                </label>--}}

                                                <label class="btn btn-outline-success col-sm-3 m-2" for="success-outlined-{{$item->id}}">
                                                    <div class="text-white">Date: {{\Carbon\Carbon::parse($item->screening_start)->format('d-m-Y')}}</div>
                                                    <div class="text-white">Time: {{\Carbon\Carbon::parse($item->screening_start)->format('H:i')}}</div>
                                                    <span class="text-white">Auditorium:</span> {{$item->auditorium->name}}
                                                </label>
                                                <div class="ds">
                                                    <button type="submit" class=" btn btn-primary w-10">Primary</button>
                                                </div>
                                            @endif

                                        @endforeach

                                            {{-- End Screening --}}
{{--                                    @else--}}
{{--                                        <div>--}}
{{--                                            <p class="fs-3 text-center">There are no screenings</p>--}}
{{--                                        </div>--}}
                                    @endif

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('layouts/scroll_to_top')
    </body>
    <script src="{{asset('frontend/js/home.js')}}"></script>
    <script src="{{asset('frontend/js/script.js')}}"></script>
    <script src="{{asset('admin-assets/plugins/jquery/jquery.min.js')}}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{asset('admin-assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{asset('admin-assets/js/adminlte.min.js')}}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{asset('admin-assets/js/demo.js')}}"></script>
    <script src="{{ asset('customer-assets/js/movie.js') }}"></script>


{{--    <script>--}}
{{--        const container = document.querySelector('.container');--}}
{{--        const seats = document.querySelectorAll('.row .seat:not(.booked)');--}}
{{--        const count = document.getElementById('count');--}}
{{--        const total = document.getElementById('total')--}}


{{--        function updateSelectedCount()--}}
{{--        {--}}
{{--            const selectedSeats = document.querySelectorAll('.row .seat.selected');--}}
{{--            const selectedSeatsCount = selectedSeats.length;--}}
{{--            count.innerText = selectedSeatsCount;--}}
{{--            total.innerText = selectedSeatsCount * ticketPrice;--}}
{{--        }--}}

{{--        container.addEventListener('click', (e) => {--}}
{{--            if (e.target.classList.contains('seat') &&--}}
{{--                !e.target.classList.contains('booked')) {--}}
{{--                e.target.classList.toggle('selected');--}}
{{--            }--}}

{{--            updateSelectedCount();--}}
{{--        })--}}
{{--    </script>--}}
@endsection
