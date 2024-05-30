@extends('layouts.customer-nav')
@section('content')
    <head>
        <title>Đăng nhập - Paradise Theatre</title>
        <link rel="stylesheet" href="{{asset('frontend/css/main.css')}}">
    </head>
    @vite(["resources/sass/app.scss", "resources/js/app.js"])
    <hr class="text-white">
    <body style="background: linear-gradient(#141e30, #243b55)">
        <div class="pt-3 pb-3 mt-4 mb-3">
            <div class="container">
                <div>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a class="text-white nav-link" href="{{ route('home') }}">Trang chủ</a></li>
                        <li class="bi bi-slash-lg text-white">Đăng nhập</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="container h-60 mt-5 d-flex justify-content-center align-items-center slider">
                <div class="login-box col-4">
                    @if(Session::has('success'))
                        <div class="alert alert-success">
                            {{ Session::get('success') }}
                        </div>
                    @endif
                    @if(Session::has('error'))
                        <div class="alert alert-danger">
                            {{ Session::get('error') }}
                        </div>
                    @endif
                    <h2>Đăng nhập</h2>
                    <form action="{{ route('customer.loginProcess') }}" method="post">
                        @csrf
                        <div class="user-box">
                            <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" value="{{old('email')}}" id="email">
                            <label for="email">Email</label>
                            @error('email')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="user-box">
                            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password">
                            <label for="password">Mật khẩu</label>
                            @error('password')
                                 <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>
                        <button class="justify-content-center border-0 bg-dark align-items-center">
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                            Đăng nhập
                        </button>
                        <div class="d-flex justify-content-between row mt-3">
                            <div class="col-md-5">
                               <a class="nav-link link-danger" href="{{route('customer.forgotPassword')}}">Quên mật khẩu</a>
                            </div>
                            <div class="col-md-7 text-white">
                                 Bạn chưa có tài khoản? Join us <a class="nav-link link-danger" href="{{route('customer.register')}}">ở đây</a>
                            </div>
                        </div>
                    </form>
                </div>
        </div>
    </body>
@endsection

