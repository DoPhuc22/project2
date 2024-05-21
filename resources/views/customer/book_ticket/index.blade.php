
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{asset('frontend/css/style.css')}}">
    <title>Movie Ticket Booking Website</title>
</head>
<body>
<div class="book container">
    <div class="left">
        <div class="link-light cont">
            <a class="link-light bi bi-arrow-left" href="{{ route('movie') }}">Back movie home</a>
        </div>
        <img src="{{ asset('uploads/movie/'.$movie->image) }}" alt="" id="poster">

        <div class="cont">
            <h6>Directed by</h6>
            <p>{{$movie->director}}</p>
            <h6>Starring</h6>
            <p>	@foreach($movieCasts as $movieCast)
                @if($movieCast->movie_id == $movie->id)
                        <span class="bi bi-dash"></span>
                    @foreach($casts as $cast)
                        {{$cast->id == $movieCast->cast_id ? $cast->name:''}}
                        @endforeach
                        @endif
                        @endforeach
                        </p>
            <h6>Genre</h6>
            <p>
                @foreach($movieGenres as $movieGenre)
                    @if($movieGenre->movie_id == $movie->id)
                        <span class="bi bi-dot">
                            @foreach($genres as $genre)
                                <span> {{$genre->id == $movieGenre->genre_id ? $genre->name:''}}</span>
                            @endforeach
                        </span>
                    @endif
                @endforeach
            </p>
        </div>
    </div>
    @php
        $nextSeat = 1;
        $previous = 1;
    @endphp
    <form action="{{route('bookingStore')}}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('POST')
        <div class="d-flex justify-content-around">
            <div>
                <table>
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
                                    {{-- @if ($seat->status == 2)
                                      <input type="checkbox" disabled class="btn-check" id="btn-check-{{$nextSeat}}" autocomplete="off" name="id[]" value="{{$seat->id}}">
                                      <label class="btn btn-primary" style="background-color: grey" for="btn-check-{{$nextSeat}}">{{ $seat->number_of_row . chr($seat->number_of_col + 64) }}</label>

                                    @elseif ($seat->status == 1 && $seat->type_id == 1)
                                      <input type="checkbox" class="btn-check" id="btn-check-{{$nextSeat}}" autocomplete="off" name="seat_id[]" value="{{$seat->id}}">
                                      <label class="btn btn-primary" for="btn-check-{{$nextSeat}}">{{ $seat->number_of_row . chr($seat->number_of_col + 64) }}</label>

                                    @elseif ($seat->status == 1 && $seat->type_id == 2)
                                      <input type="checkbox" class="btn-check" id="btn-check-{{$nextSeat}}" autocomplete="off" name="seat_id[]" value="{{$seat->id}}">
                                      <label class="btn btn-primary" style="background-color: yellow" for="btn-check-{{$nextSeat}}">{{ $seat->number_of_row . chr($seat->number_of_col + 64) }}</label>
                                    @endif --}}


                                    {{-- Cái dòng quan trọng ở dưới --}}
                                    <input type="checkbox" class="btn-check" id="btn-check-{{$nextSeat}}" autocomplete="off" name="seat_id[]" value="{{$seat->id}}"
                                           @if (in_array($seat->id, $reservedSeats->pluck('seat_id')->toArray()))
                                               disabled
                                        @endif>
                                    {{-- Dùng để kiểm tra --}}
                                    {{-- Cái dòng quan trọng ở trên --}}
                                    <label class="btn @if (in_array($seat->id, $reservedSeats->pluck('seat_id')->toArray())) btn-secondary @else btn-primary @endif" for="btn-check-{{$nextSeat}}">{{ $seat->number_of_row . chr($seat->number_of_col + 64) }}</label>

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
            {{-- Screening --}}
            <input type="hidden" name="screening_id" value="{{$screening_id}}">
            {{-- <div class="d-flex flex-column">
              @foreach ($screening as $item)
                @if ($item->screening_end > now())
                <input type="hidden" name="screening_id" value="{{$item ->id}}">
                <input type="hidden" name="auditorium_id" value="{{$item->auditorium_id}}">
                <input type="hidden" name="movie_id" value="{{$item->movie_id}}">
                <input type="radio" class="btn-check" name="options-screening_start" id="success-outlined-{{$item->id}}" autocomplete="off" checked>
                <label class="btn btn-outline-success" for="success-outlined-{{$item->id}}">{{$item->screening_start}}</label>
                @endif
               @endforeach
            </div> --}}
            {{-- End Screening --}}
        </div>
        <button type="submit" class="btn btn-primary">Primary</button>
    </form>
    <div class="right">
        <div class="head_time">
            <h1 id="title">{{$movie->title}}</h1>
            <div class="time">
                <h6><i class="bi bi-clock"></i> {{ $movie->duration }} </h6>
                <button>PG-13</button>
            </div>
        </div>

        <div class="date_type">
            <div class="left_card">
                <h6 class="title">Choose Date</h6>
                <div class="card_month crd">
                    <input type="date">
                </div>
            </div>
            <div class="right_card">
                <h6 class="title">Show Time</h6>
                <div class="card_month crd">
                    <input type="time">
                </div>
            </div>
        </div>

        <div class="container">
            <div class="screen" id="screen">
                Screen
            </div>

            <!-- chairs  -->
            <div class="chair" id="chair">
                <ul class="row" id="seats">
                    <span>J</span>
                    <li id="seats" value="10" class="seat">560</li>
                    <li id="seats" value="10" class="seat">560</li>
                    <li class="seat">560</li>
                    <li class="seat">560</li>
                    <li class="seat">560</li>
                    <li class="seat">560</li>
                    <li class="seat">560</li>
                    <li class="seat">560</li>
                    <li class="seat">560</li>
                    <li class="booked">560</li>
                    <li class="seat">560</li>
                    <li class="seat">560</li>
                    <li class="booked">560</li>
                    <li class="booked">560</li>
                    <li class="seat">560</li>
                    <li class="seat">560</li>
                    <li class="seat">560</li>
                    <li class="booked">560</li>
                    <li class="seat">560</li>
                    <li class="seat">560</li>
                    <li class="seat">560</li>
                    <li class="seat">560</li>
                    <li class="seat">560</li>
                    <li class="seat">560</li>
                    <span>J</span>
                </ul>
                <p class="text">
                    You have selected <span id="count">0</span> seats for a price of $<span id="total">0</span>
                </p>
            </div>
        </div>


        <!-- Ticket  -->
        <div class="ticket" id="ticket">
            <div class="tic">
                <div class="barcode">
                    <div class="card">
                        <h6>ROW J</h6>
                        <h6>7 September 2023</h6>
                    </div>
                    <div class="card">
                        <h6>Seat 18</h6>
                        <h6>23:00</h6>
                    </div>

                    <svg id="barcode"></svg>
                    <h5>VEGUS CINEMA</h5>
                </div>
                <div class="tic_details">
                    <div class="type">4DX</div>
                    <h5 class="pvr"><span>Vegus</span> Cinema</h5>
                    <h1>Jawan</h1>
                    <div class="seat_det">
                        <div class="seat_cr">
                            <h6>ROW</h6>
                            <h6>J</h6>
                        </div>
                        <div class="seat_cr">
                            <h6>SEAT</h6>
                            <h6>18</h6>
                        </div>
                        <div class="seat_cr">
                            <h6>DATE</h6>
                            <h6>7 <sub>sep</sub></h6>
                        </div>
                        <div class="seat_cr">
                            <h6>TIME</h6>
                            <h6>11:30 <sub>pm</sub></h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <!-- Details  -->
        <div class="details" id="det">
            <div class="details_chair">
                <li>Available</li>
                <li>Booked</li>
                <li>Selected</li>
            </div>
        </div>
        <button class="book_tic" id="book_ticket">
            <i class="bi bi-arrow-right-short"></i>
        </button>
        <button class="book_tic" id="back_ticket">
            <i class="bi bi-arrow-left-short"></i>
        </button>
    </div>
</div>
<script src="{{ asset('customer-assets/js/movie.js') }}"></script>
</body>

<script>
    const container = document.querySelector('.container');
    const seats = document.querySelectorAll('.row .seat:not(.booked)');
    const count = document.getElementById('count');
    const total = document.getElementById('total')
    const seatSelect = document.getElementById('seats');

    let ticketPrice = seatSelect.value.string()
    console.log( ticketPrice)

    function updateSelectedCount()
    {
        const selectedSeats = document.querySelectorAll('.row .seat.selected');
        const selectedSeatsCount = selectedSeats.length;
        console.log(selectedSeatsCount)
        count.innerText = selectedSeatsCount;
    }

    container.addEventListener('click', e => {
        if (e.target.classList.contains('seat') &&
        !e.target.classList.contains('booked')) {
            e.target.classList.toggle('selected');
        }

        updateSelectedCount();
    })
</script>
<script>
    JsBarcode("#barcode", "J18800792023");
</script>

