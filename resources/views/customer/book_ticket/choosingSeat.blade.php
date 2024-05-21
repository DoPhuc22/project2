@extends('layouts.customer-nav')
@section('content')
    @vite(["resources/sass/app.scss", "resources/js/app.js"])
    <head>
        <title>Choosing Seat</title>
        <link rel="stylesheet" href="{{asset('frontend/css/main.css')}}">
        <link rel="stylesheet" href="{{asset('frontend/css/style.css')}}">
    </head>
    <body style="background-color: #00001c;">
    <hr class="text-white">

    <div class="text-white container mt-2"><a href="{{ route('movie') }}" class="nav-link bi bi-arrow-left ">Back</a></div>
    <section class="mt-3 container">
        <div class="form row ">
            <!-- Progress bar -->
            <div class="col-xl-7 pe-5">
                <div class="progressbar w-100 ">
                    <div class="progress" id="progress"></div>

                    <div
                        class="progress-step progress-step-active"
                        data-title=""
                    ></div>
                    <div class="progress-step progress-step-active" data-title=""></div>
                    <div class="progress-step" data-title=""></div>
                </div>
                <!-- Steps -->
                <div class="form-step form-step-active">
                    <div class="text-center text-white fs-1">Choose seats</div>
                    @php
                        $nextSeat = 1;
                        $previous = 1;
                    @endphp
                    <form action="{{route('bookingStore', $movie)}}" id="chooseSeatForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <div class="col-md-12 screen" id="screen">
                            Screen
                        </div>
                        <input type="hidden" name="screening_id" value="{{$screening}}">
                        <input type="hidden" name="auditorium_id" value="{{$auditorium}}">
                        <input type="hidden" name="movie_id" value="{{$movie_id}}">
                        <ul class="justify-content-between d-flex col-6" style="padding: 5px 10px;border-radius: 5px;color: #777;list-style-type: none;">
                            <li>
                                <div class="" style="background-color: #444451; height: 12px;
                                 width: 15px;
                                 margin: 3px;
                                 border-top-left-radius: 10px;
                                 border-top-right-radius: 10px;"></div>
                                <small>Standard</small>
                            </li>
                            <li>
                                <div class="" style="background-color: #6feaf6; height: 12px;
                                 width: 15px;
                                 margin: 3px;
                                 border-top-left-radius: 10px;
                                 border-top-right-radius: 10px;"></div>
                                <small>Selected</small>
                            </li>
                            <li>
                                <div class="" style="background-color: yellow; height: 12px;
                                 width: 15px;
                                 margin: 3px;
                                 border-top-left-radius: 10px;
                                 border-top-right-radius: 10px;"></div>
                                <small>VIP</small>
                            </li>
                            <li>
                                <div class="seat occupied" style="background-color: #cf2e2e; height: 12px;
                                 width: 15px;
                                 margin: 3px;
                                 border-top-left-radius: 10px;
                                 border-top-right-radius: 10px;"></div>
                                <small>Occupied</small>
                            </li>
                        </ul>
                        <div class="d-flex justify-content-around col-md-12">
                            <div class="col-md-8 justify-content-sm-center">
                                <table class="col-md-12">
                                    @foreach ($seats as $seat)
                                        {{-- Cái này để giữ số hàng dọc đang ở --}}
                                        @php
                                            $currentCol = $seat->number_of_col
                                        @endphp
                                        {{-- Cái này để kiểm tra nếu hàng dọc hiện tại có lớn hơn số hàng dọc trước kia ko kiểu từ 1 lên 2 và 2 > 1. Nếu có số hàng dọc quá khứ tăng --}}
                                        @if ($currentCol > $previous)
                                            <tr>
                                                @php
                                                    $previous++;
                                                @endphp
                                                @endif

                                                {{-- comment --}}

                                                {{-- Cái này để chọn ghế --}}
                                                <td>
                                                    {{-- Cái dòng quan trọng ở dưới --}}
                                                    @if ($seat->status == 2)
                                                        <input type="checkbox"
                                                               @if (in_array($seat->id, $reservedSeats->pluck('seat_id')->toArray()))
                                                                    disabled
                                                               @endif
                                                               class="disabled" id="btn-check-{{$nextSeat}}" autocomplete="off" name="seat_id[]" value="{{$seat->id}}" data-id="{{$seat->seatType?->price}}" >

                                                        <label class="btn btn-danger" for="btn-check-{{$nextSeat}}">{{ $seat->number_of_row . chr($seat->number_of_col + 64) }}</label>

                                                    @elseif ($seat->status == 1 && $seat->type_id == 1)
                                                        <input type="checkbox" @if (in_array($seat->id, $reservedSeats->pluck('seat_id')->toArray()))
                                                             disabled
                                                               @endif class="btn-check bg-danger" id="btn-check-{{$nextSeat}}" autocomplete="off" name="seat_id[]" value="{{$seat->id}}" data-id="{{$seat->seatType?->price}}" >
                                                        <label class="btn btn-outline-secondary text-white mb-1" for="btn-check-{{$nextSeat}}">{{ $seat->number_of_row . chr($seat->number_of_col + 64) }}</label>

                                                    @elseif ($seat->status == 1 && $seat->type_id == 2)
                                                        <input type="checkbox" @if (in_array($seat->id, $reservedSeats->pluck('seat_id')->toArray()))

                                                               @endif class="btn-check" id="btn-check-{{$nextSeat}}" autocomplete="off" name="seat_id[]" value="{{$seat->id}}" data-id="{{$seat->seatType?->price}}">
                                                        <label class="btn btn-outline-warning mb-1" for="btn-check-{{$nextSeat}}">{{ $seat->number_of_row . chr($seat->number_of_col + 64) }}</label>
                                                    @endif
                                                    @php
                                                        $nextSeat++;
                                                    @endphp
                                                </td>
                                                {{-- comment --}}

                                                {{-- comment --}}
                                                @if ($currentCol > $previous)
                                            </tr>
                                        @endif
                                        {{-- comment --}}

                                    @endforeach

                                </table>
                            </div>
                            <!--In ghế-->


                            <!--Hết-->


                        </div>

                        <button class="btn btn-primary"><a class="text-white nav-link" href="{{ route('choosingScreening', $movie) }}">Previous</a></button>
                        <span class="form-submit">
                            <button class="btn btn-primary" type="submit" id="form-submit" href="{{ 'customer.checkout' }}"><i class="material-icons mdi mdi-message-outline"></i>Proceed to checkout</button>
                        </span>
                    </form>
                </div>
            </div>
            <div class="col-xl-4 h-100">
                <div class="rounded pt-3 pb-5 col-xl-12 mt-5 border border-light h-10 text-white">
                    <header class="fs-4 mx-3 fw-bold">* SEAT PRICE:</header>
                    <div class="mx-3 fs-5">
                        <section class="d-flex">
                            <div class="" style="background-color: #444451; height: 12px;
                                 width: 15px;
                                 margin: 3px;
                                 border-top-left-radius: 10px;
                                 border-top-right-radius: 10px;"></div>
                            <small>Standard: $10</small>
                        </section>
                        <section class="d-flex">
                            <div class="" style="background-color: yellow; height: 12px;
                                 width: 15px;
                                 margin: 3px;
                                 border-top-left-radius: 10px;
                                 border-top-right-radius: 10px;"></div>
                            <small>VIP: $20</small>
                        </section>
                    </div>
                </div>
                <div class="left rounded pt-3 pb-5 col-xl-12 mt-5 border border-light h-10 text-white">
                    @foreach($screening as $item)
                        @if($item->screening_end > now())
                            <div class="fs-3 mx-3">
                                Auditorium: <span class="text-danger">{{$item->auditorium->name}}</span>
                            </div>
                            <div class="px-xl-5 mt-xl-2 py-sm-3 ">
                                <h2 class="text-danger">{{ $movie->title }}</h2>
                                <h6 class="fw-bolder">Screening: {{ \Carbon\Carbon::parse($item->screening_end)->format("d-m-Y | H:i") }}<span></span></h6>
                                <h6 class="fw-bolder">Directed by: {{$movie->director}}</h6>
                                <span class="language"><span class="bg-success rounded fs-5">{{ $movie->language }}</span>
                                <span class="bg-danger rounded fs-5">{{ $movie->age->name }}</span></span>
                            </div>
                        @endif
                    @endforeach
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
{{--        $('#chooseSeatForm').submit(function (event){--}}
{{--            event.preventDefault();--}}
{{--            $('#form-submit').prop('disabled', true)--}}
{{--            $.ajax({--}}
{{--                url: '{{route("bookingStore", $movie_id)}}',--}}
{{--                type: 'post',--}}
{{--                data: $(this).serializeArray(),--}}
{{--                dataType: 'json',--}}
{{--                success: function (response){--}}
{{--                    $('#form-submit').prop('disabled', false)--}}
{{--                    if (response.status == true){--}}
{{--                        window.location.href = "{{ route('choose_food') }}"--}}
{{--                    }else {--}}
{{--                        var errors = response.errors;--}}
{{--                        if (errors.btn-check-{{$nextSeat}}) {--}}
{{--                            $("#btn-check-{{$nextSeat}}").siblings('p').addClass('invalid-feedback').html(errors.btn-check-{{$nextSeat}});--}}
{{--                            $("#btn-check-{{$nextSeat}}").addClass('is-invalid');--}}
{{--                        }else {--}}
{{--                            $("#btn-check-{{$nextSeat}}").siblings('p').removeClass('invalid-feedback').html('');--}}
{{--                            $("#btn-check-{{$nextSeat}}").removeClass('is-invalid');--}}
{{--                        }--}}
{{--                    }--}}
{{--                }--}}
{{--            })--}}
{{--        })--}}
{{--    </script>--}}
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
