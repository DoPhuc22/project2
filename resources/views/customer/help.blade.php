
@extends('layouts.customer-nav')
@section('content')
    @vite(["resources/sass/app.scss", "resources/js/app.js"])
    <head>
        <title>Help</title>
        <link rel="stylesheet" href="{{asset('frontend/css/main.css')}}">
    </head>
    <body style="background-color: #00001c;">
    <hr class="text-white">
    <section class="section-5 pt-3 pb-3 mb-3">
        <div class="container">
            <div>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a class="text-white nav-link" href="{{ route('home') }}">Home</a></li>
                    <li class="bi bi-slash-lg text-white">Help</li>
                </ol>
            </div>
        </div>
    </section>

    <!--Phần CARDS-->


    <div class="container-fluid p-0">
        {{-- <div class=" position-relative d-flex justify-content-center align-items-center text-white">
            trang help
        </div> --}}
        <div class="row justify-content-evenly">
            <div class="col-5">
                <div class="card" style="width: 100%;
                height:250px;background-color: hsl(248, 93%, 73%, 5%);
                color:#E7E6EF;border: 1px solid #212121;border-radius: 1rem">
                    <div class="card-body text-center">
                        <div class="p-3 m-3 fs-1 mb-1 rounded-circle" >
                            <i class="bi bi-info-circle"></i>
                        </div>
                        <h2 class="card-title">We're are here to help</h5>
                            <p class="card-text m-2">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    </div>
                </div>
            </div>
            <div class="col-5">
                <div class="card" style="width: 100%;
              height:250px;background-color: hsl(248, 93%, 73%, 5%);
              color:#E7E6EF;border: 1px solid #212121;border-radius: 1rem">
                    <div class="card-body text-center">
                        <div class="p-3 m-3 fs-1 mb-1">
                            <i class="bi bi-chat"></i>
                        </div>
                        <h2 class="card-title">Immidiate Assistant? Chat With Us</h5>
                            {{-- <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6> --}}
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-evenly">
            <div class="col-5 mt-5">
                <div class="card" style="width: 100%;
              height:250px;background-color: hsl(248, 93%, 73%, 5%);
              color:#E7E6EF;border: 1px solid #212121;border-radius: 1rem">
                    <div class="card-body text-center">
                        <div class="p-3 m-3 fs-1 mb-1">
                            <i class="bi bi-phone-vibrate"></i>
                        </div>
                        <h2 class="card-title">Reached out directly</h5>
                            {{-- <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6> --}}
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    </div>
                </div>
            </div>
            <div class="col-5 mt-5">
                <div class="card" style="width: 100%;
              height:250px;background-color: hsl(248, 93%, 73%, 5%);
              color:#E7E6EF;border: 1px solid #212121;border-radius: 1rem">
                    <div class="card-body text-center">
                        <div class="p-3 m-3 fs-1 mb-1">
                            <i class="bi bi-megaphone"></i>
                        </div>
                        <h2 class="card-title">Immidiate Assistant? Chat With Us</h5>
                            {{-- <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6> --}}
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    </div>
                </div>
            </div>
        </div>


        <!--Phần accordion-->

        <div class="m-5 p-5">
            <div class="accordion d-flex flex-column" style="gap:8px" id="accordionExample">
                <div class="accordion-item text-light" style="color:;background-color: hsl(250, 77%, 32%, 20%);border: 1px solid #212121;">
                    <h2 class="accordion-header" id="headingOne" >
                        <button class="accordion-button" style="background-color: hsl(250, 77%, 32%, 20%);color:#E7E6EF;"
                                type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne"
                                aria-expanded="true" aria-controls="collapseOne">
                            How can i start booking ticket to watch films
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <strong>This is the first item's accordion body.</strong>
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. <code>.accordion-body</code>, though the transition does limit overflow.
                        </div>
                    </div>
                </div>
                <div class="accordion-item text-light" style="color:;background-color: hsl(250, 77%, 32%, 20%);border: 1px solid #212121">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed" style="background-color: hsl(250, 77%, 32%, 20%);color:#E7E6EF;" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Do I need to create an account to book tickets?
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <strong>This is the second item's accordion body.</strong>
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. <code>.accordion-body</code>, though the transition does limit overflow.
                        </div>
                    </div>
                </div>
                <div class="accordion-item text-light" style="color:;background-color: hsl(250, 77%, 32%, 20%);border: 1px solid #212121">
                    <h2 class="accordion-header" id="headingThree">
                        <button class="accordion-button collapsed" type="button" style="background-color: hsl(250, 77%, 32%, 20%);color:#E7E6EF;" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            Can I cancel my tickets?
                        </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <strong>This is the third item's accordion body.</strong>
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. <code>.accordion-body</code>, though the transition does limit overflow.
                        </div>
                    </div>
                </div>
                <div class="accordion-item text-light" style="color:;background-color: hsl(250, 77%, 32%, 20%);border: 1px solid #212121">
                    <h2 class="accordion-header" id="headingFour">
                        <button class="accordion-button collapsed" style="background-color: hsl(250, 77%, 32%, 20%);color:#E7E6EF;"  type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                            What are your ticket prices?
                        </button>
                    </h2>
                    <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <strong>This is the third item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
