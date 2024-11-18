@extends('layouts.customer-nav')
@section('content')
    @vite(["resources/sass/app.scss", "resources/js/app.js"])
    <head>
        <title>Thanh toán - Paradise Theatre</title>
        <link rel="stylesheet" href="{{asset('frontend/css/main.css')}}">
    </head>
    <body style="background-color: #00001c;">
    <hr class="text-white">
    {{--    <div class="container-fluid p-0">--}}
    {{--        <div class=" position-relative d-flex justify-content-center align-items-center text-white">--}}
    {{--            --}}
    {{--        </div>--}}
    {{--    </div>--}}

    <main>
        <section class="section-5 pt-3 pb-3 mb-3">
            <div class="container">
                <div>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a class="text-white nav-link" href="{{ route('home') }}">Trang chủ</a></li>
                        <li class="bi bi-slash-lg text-white">Thanh toán</li>
                    </ol>
                </div>
            </div>
        </section>

        <div class="form container">
            <div class="progressbar w-100 ">
                <div class="progress" id="progress"></div>

                <div class="progress-step progress-step-active" data-title=""></div>
                <div class="progress-step progress-step-active" data-title=""></div>
                <div class="progress-step progress-step-active" data-title=""></div>
            </div>
            <div class="form-step form-step-active">
                <section class="section-9 pt-4">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="col-md-10">
                                    <div class="sub-title">
                                        <h2 class="text-white">Movie Information</h2>
                                    </div>
                                    <div class="card shadow-lg border-0" style="background-color: #1A1B2A">
                                        <div class="card-body checkout-form">
                                            <div class="row">
                                                <div class="col-md-12 text-white">
                                                    Movie
                                                </div>
                                                <div class="col-md-12 text-white">
                                                    <div class="mb-3">
                                                        @foreach ($movie as $item)
                                                            {{$item->title}}
                                                        @endforeach
                                                    </div>
                                                </div>

                                                <div class="col-md-12 text-white">
                                                    Screening
                                                </div>

                                                <div class="col-md-12 text-white">
                                                    <div class="mb-3">
                                                        @foreach ($screening as $item)
                                                            {{$item->screening_start}}
                                                            {{$item->screening_end}}
                                                        @endforeach
                                                    </div>
                                                </div>

                                                <div class="col-md-4 text-white">
                                                    Seat: @foreach ($seats as $item)
                                                        {{ $item->number_of_row . chr($item->number_of_col + 64) }}
                                                    @endforeach
                                                </div>

                                                <div class="col-md-4 text-white">
                                                    Cinema Room: @foreach ($auditorium as $item)
                                                        {{ $item->name }}
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8 mt-5">
                                    <div class="sub-title">
                                        <h3 class="text-white">Payment Information</h3>
                                    </div>
                                    <div class="card shadow-lg cart-summery border-0" style="background-color: #1A1B2A">
                                        <div class="card-body rounded-3 text-white">
                                            <div class="d-flex justify-content-between pb-2">
                                                {{-- <div class="h6">Category</div> --}}
                                                <div class="h6">Seats Booked</div>
                                                <div class="h6">Total</div>
                                                {{-- <div class="h6">Price</div> --}}
                                            </div>
                                            <div class="d-flex justify-content-between pb-2">
                                                <div class="h6 d-block">
                                                    @foreach ($seatTypes as $seatType)
                                                        {{ $seatType->name . ' x ' . $seatType->id}},
                                                    @endforeach
                                                </div>
                                                {{-- <div class="h6">$100</div> --}}
                                                <div class="h6">
                                                    @foreach ($seatTypes as $seatType)
                                                        {{ $seatType->totalPrice}},
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mt-5">
                                <div class="card payment-form " style="background-color: #1A1B2A">
                                    <h3 class="card-title h5 mb-3 text-white">Payment Details</h3>
                                    <div class="card-body p-0" >
                                        <div class="mb-3">
                                            <label for="card_number" class="mb-2">Card Number</label>
                                            <input type="text" name="card_number" id="card_number" placeholder="Valid Card Number" class="form-control">
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="expiry_date" class="mb-2">Expiry Date</label>
                                                <input type="text" name="expiry_date" id="expiry_date" placeholder="MM/YYYY" class="form-control">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="expiry_date" class="mb-2">CVV Code</label>
                                                <input type="text" name="expiry_date" id="expiry_date" placeholder="123" class="form-control">
                                            </div>
                                        </div>
                                        <div class="pt-4">
                                            <form action="{{url('/account/vnpay_payment')}}" method="POST" >
                                                @csrf
                                                <input type="hidden" name="totalMoney" value="{{$totalMoney}}">
                                                <input type="hidden" name="movie" value="{{$movie}}">
                                                @foreach ($seats as $seat)
                                                    <input type="hidden" name="seat[]" value="{{$seat->id}}">
                                                @endforeach
                                                @foreach ($screening as $item)
                                                    <input type="hidden" name="screening" value="{{$item->id}}">
                                                @endforeach
                                                @foreach ($movie as $item)
                                                    <input type="hidden" name="movie" value="{{$item->id}}">
                                                @endforeach
                                                @foreach ($screening as $item)
                                                <input type="hidden" name="screening" value="{{$item->id}}">
                                                @endforeach
                                                <button type="submit" name="redirect" class="btn-dark btn btn-block w-100">Pay Now</button>
                                            </form>
                                            <button type="submit" name="previous" class="btn-dark btn btn-block w-100">
                                               <a class="text-white nav-link" href="{{ route('choosingScreening', $movie_id) }}">Previous</a>
                                            </button>
                                            {{--//Movie, Screening, Customer(id , phone number), seat--}}

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

        </div>
    </main>
    {{--  Products  --}}

    {{--  SHIPPING  --}}

    @include('layouts/scroll_to_top')
    </body>
    <script src="{{asset('frontend/js/home.js')}}"></script>
    <script src="{{asset('admin-assets/plugins/jquery/jquery.min.js')}}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{asset('admin-assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{asset('admin-assets/js/adminlte.min.js')}}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{asset('admin-assets/js/demo.js')}}"></script>
@endsection

@section('customJs')

@endsection
