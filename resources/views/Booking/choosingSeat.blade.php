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
            @if ($seat->status == 2)
              <input type="checkbox"  
              @if (in_array($seat->id, $reservedSeats->pluck('seat_id')->toArray()))
              disabled
              @endif
              class="btn-check" id="btn-check-{{$nextSeat}}" autocomplete="off" name="seat_id[]" value="{{$seat->id}}" data-id="{{$seat->seatType?->price}}" >
              
              <label class="btn btn-primary" style="background-color: grey" for="btn-check-{{$nextSeat}}">{{ $seat->number_of_row . chr($seat->number_of_col + 64) }}</label>
            
            @elseif ($seat->status == 1 && $seat->type_id == 1)
              <input type="checkbox" @if (in_array($seat->id, $reservedSeats->pluck('seat_id')->toArray()))
              disabled
              @endif class="btn-check" id="btn-check-{{$nextSeat}}" autocomplete="off" name="seat_id[]" value="{{$seat->id}}" data-id="{{$seat->seatType?->price}}" >
              <label class="btn btn-primary" for="btn-check-{{$nextSeat}}">{{ $seat->number_of_row . chr($seat->number_of_col + 64) }}</label>

            @elseif ($seat->status == 1 && $seat->type_id == 2)
              <input type="checkbox" @if (in_array($seat->id, $reservedSeats->pluck('seat_id')->toArray()))
              disabled
              @endif class="btn-check" id="btn-check-{{$nextSeat}}" autocomplete="off" name="seat_id[]" value="{{$seat->id}}" data-id="{{$seat->seatType?->price}}">
              <label class="btn btn-primary" style="background-color: yellow" for="btn-check-{{$nextSeat}}">{{ $seat->number_of_row . chr($seat->number_of_col + 64) }}</label>
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
        <p class="text" style="color: white">
          You have selected <span id="count">0</span> seats for a price of $<span id="total">0</span>
        </p>
        {{-- Cái dòng quan trọng ở dưới --}}
            {{-- <input type="checkbox" class="btn-check" id="btn-check-{{$nextSeat}}" autocomplete="off" name="seat_id[]" value="{{$seat->id}}"
                @if (in_array($seat->id, $reservedSeats->pluck('seat_id')->toArray()))
                    disabled
                @endif> --}}
            {{-- Dùng để kiểm tra --}}
            {{-- Cái dòng quan trọng ở trên --}}
            {{-- <label class="btn @if (in_array($seat->id, $reservedSeats->pluck('seat_id')->toArray())) btn-secondary @else btn-primary @endif" for="btn-check-{{$nextSeat}}">{{ $seat->number_of_row . chr($seat->number_of_col + 64) }}</label> --}}
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



@include('layouts/scroll_to_top')
    </body>
    <script src="{{asset('frontend/js/home.js')}}"></script>
    <script src="{{asset('admin-assets/plugins/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('admin-assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('admin-assets/js/adminlte.min.js')}}"></script>
    <script src="{{asset('admin-assets/js/demo.js')}}"></script>
@endsection

<script>
  const container = document.querySelector('form');
  // const seats = document.querySelectorAll('input type'); // Target checkboxes within seats
  const seats = document.querySelectorAll('input[type="checkbox"]');
  const count = document.getElementById('count');
  const total = document.getElementById('total');
  const ticketPrice = 5 /* Your ticket price here */; // Set ticket price

  function updateSelectedCount() {
    const selectedSeats = document.querySelectorAll('input[type="checkbox"]'); // Get checked checkboxes
    const selectedSeatsCount = selectedSeats.length;
    count.innerText = selectedSeatsCount;
    total.innerText = selectedSeatsCount * ticketPrice;
  }

  container.addEventListener('click', (e) => {
    // Handle click events on checkboxes only
    if (e.target.type === 'input[type="checkbox"]') {
      e.target.classList.toggle('checked'); // Toggle checked class on click
      updateSelectedCount();
    }
  });

  // Update count initially (optional, in case seats are pre-selected)
  updateSelectedCount();

  
</script>