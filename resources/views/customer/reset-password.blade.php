@extends('layouts.customer-nav')
@section('content')
    <head>
        <title>Đặt lại mật khẩu - Paradise Theatre</title>
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
                    <li class="bi bi-slash-lg text-white">Đặt lại mật khẩu</li>
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
            <h2>Đặt lại mật khẩu</h2>
            <form action="{{ route('customer.processResetPassword') }}" method="post">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="user-box">
                    <input type="password" name="new_password" class="form-control @error('new_password') is-invalid @enderror" value="">
                    <label for="password">Mật khẩu mới</label>
                    @error('new_password')
                    <p class="invalid-feedback">{{ $message }}</p>
                    @enderror
                </div>
                <div class="user-box">
                    <input type="password" name="confirm_password" class="form-control @error('confirm_password') is-invalid @enderror" value="">
                    <label for="password">Xác nhận mật khẩu</label>
                    @error('confirm_password')
                    <p class="invalid-feedback">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" value="Submit" class="justify-content-center border-0 bg-dark align-items-center">
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    Cập nhật mật khẩu
                </button>
            </form>
            <div class="text-center">
                <a href="{{ route('customer.login') }}" class="nav-link text-danger">Nhấn vào đây để đăng nhập</a>
            </div>
        </div>
    </div>
    </body>
@endsection

