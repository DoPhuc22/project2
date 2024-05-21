@extends('layouts.customer-nav')
@section('content')
    <head>
        <title>Về chúng tôi</title>
        <link rel="stylesheet" href="{{asset('frontend/css/main.css')}}">
    </head>
    @vite(["resources/sass/app.scss", "resources/js/app.js"])
    <hr class="text-white">
    <body style="background-color: #00001c;">
    <div class="container h-60 mt-5 justify-content-center align-items-center">
        <section class="section-5 pt-3 pb-3 mb-3">
            <div class="container">
                <div class="light-font">
                    <ol class="breadcrumb primary-color mb-0 text-white">
                        <li class="breadcrumb-item"><a class="text-white nav-link" href="#">Trang chủ</a></li>
                        <li class="breadcrumb-item">Về chúng tôi</li>
                    </ol>
                </div>
            </div>
        </section>

        <section class=" section-10">
            <div class="container text-white">
                <h1 class="my-3">Về chúng tôi</h1>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Quas assumenda aliquam deserunt aspernatur numquam animi sit veniam distinctio voluptatem nihil ratione possimus ex eligendi molestias, similique earum? Ut accusamus exercitationem illo porro quis doloribus quasi atque, inventore dignissimos. Vel molestias quos maiores sequi explicabo numquam doloribus labore qui facilis rem.</p>

                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Quas assumenda aliquam deserunt aspernatur numquam animi sit veniam distinctio voluptatem nihil ratione possimus ex eligendi molestias, similique earum? Ut accusamus exercitationem illo porro quis doloribus quasi atque, inventore dignissimos. Vel molestias quos maiores sequi explicabo numquam doloribus labore qui facilis rem.</p>

                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Quas assumenda aliquam deserunt aspernatur numquam animi sit veniam distinctio voluptatem nihil ratione possimus ex eligendi molestias, similique earum? Ut accusamus exercitationem illo porro quis doloribus quasi atque, inventore dignissimos. Vel molestias quos maiores sequi explicabo numquam doloribus labore qui facilis rem.</p>

                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Quas assumenda aliquam deserunt aspernatur numquam animi sit veniam distinctio voluptatem nihil ratione possimus ex eligendi molestias, similique earum? Ut accusamus exercitationem illo porro quis doloribus quasi atque, inventore dignissimos. Vel molestias quos maiores sequi explicabo numquam doloribus labore qui facilis rem.</p>

                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Quas assumenda aliquam deserunt aspernatur numquam animi sit veniam distinctio voluptatem nihil ratione possimus ex eligendi molestias, similique earum? Ut accusamus exercitationem illo porro quis doloribus quasi atque, inventore dignissimos. Vel molestias quos maiores sequi explicabo numquam doloribus labore qui facilis rem.</p>

            </div>
        </section>
    </div>

@endsection

