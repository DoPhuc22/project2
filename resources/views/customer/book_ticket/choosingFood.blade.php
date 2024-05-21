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
        <div class="form">
            <!-- Progress bar -->
            <div class="col-xl-12 pe-5">
                <div class="progressbar w-100 ">
                    <div class="progress" id="progress"></div>
                    <div class="progress-step progress-step-active" data-title=""></div>
                    <div class="progress-step progress-step-active" data-title=""></div>
                    <div class="progress-step progress-step-active" data-title=""></div>
                    <div class="progress-step" data-title=""></div>
                </div>
                <!-- Steps -->
                <div class="form-step form-step-active">
                    <div class="text-center text-white fs-1">Choose foods</div>
                    <section class=" section-9 pt-4">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="table-responsive">
                                        <table class="table table-dark" id="cart">
                                            <thead>
                                            <tr>
                                                <th class="text-center">Item</th>
                                                <th>Price</th>
                                                <th>Quantity</th>
                                                <th>Total</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center justify-content-center">
                                                            <img src="images/product-1.jpg" width="" height="">
                                                            <h2>Product Name Goes Here</h2>
                                                        </div>
                                                    </td>
                                                    <td>$100</td>
                                                    <td>
                                                        <div class="input-group quantity mx-auto" style="width: 100px;">
                                                            <div class="input-group-btn">
                                                                <button class="btn btn-sm btn-dark btn-minus p-2 pt-1 pb-1">
                                                                    <i class="fa fa-minus"></i>
                                                                </button>
                                                            </div>
                                                            <input type="text" class="form-control form-control-sm bg-dark text-white border rounded text-center" value="1">
                                                            <div class="input-group-btn">
                                                                <button class="btn btn-sm btn-dark btn-plus p-2 pt-1 pb-1">
                                                                    <i class="fa fa-plus"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        $100
                                                    </td>

                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card cart-summery text-white bg-dark">
                                        <div class="sub-title">
                                            <h3 class="">Cart Summery</h3>
                                        </div>
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between pb-2">
                                                <div>Subtotal</div>
                                                <div>$400</div>
                                            </div>
                                            <div class="d-flex justify-content-between pb-2">
                                                <div>Shipping</div>
                                                <div>$20</div>
                                            </div>
                                            <div class="d-flex justify-content-between summery-end">
                                                <div>Total</div>
                                                <div>$420</div>
                                            </div>
                                            <div class="pt-5">
                                                <a href="login.php" class="btn-secondary  btn btn-block w-100">Proceed to Checkout</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
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
    <script>

    </script>
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

