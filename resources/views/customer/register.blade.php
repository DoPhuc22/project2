@extends('layouts.customer-nav')
@section('content')
    @vite(["resources/sass/app.scss", "resources/js/app.js"])
    <head>
        <title>Đăng ký - Paradise Theatre</title>
        <link rel="stylesheet" href="{{asset('frontend/css/main.css')}}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>

    <body style="background: linear-gradient(#141e30, #243b55)">
    <hr class="text-white">
    <main>
        <div class="pt-3 pb-3 mt-4 mb-3">
            <div class="container">
                <div>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a class="text-white nav-link" href="{{ route('home') }}">Trang chủ</a></li>
                        <li class="bi bi-slash-lg text-white">Đăng ký</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="pt-3 mt-5">
            <div class="mt-5 container position-relative h-70 fixed">
                <div class="login-boX">
                    <h2 class="fs-2">Đăng ký</h2>
                    <form action="" method="post" name="registrationForm" id="registrationForm" class="col-12">
                        <div class="row">
                            <div class="user-box col-md-6">
                                <span class="">
                                    <input type="text" class="form-control" name="first_name" id="first_name">
                                    <p></p>
                                    <label>Họ</label>
                                </span>
                            </div>
                            <div class="user-box col-md-6">
                                <span class="">
                                    <input type="text" class="form-control" name="last_name" id="last_name">
                                    <label>Tên</label>
                                    <p></p>
                                </span>
                            </div>
                            <div class="user-box">
                                <input type="email" class="form-control" name="email" id="email">
                                <label>Email</label>
                                <p></p>
                            </div>
{{--                            <div class="col-md-12 text-white mb-3">--}}
{{--                                <label style="color: #03e9f4" class="fs-6 col-md-12">Birthday</label>--}}
{{--                                <form id="birthday" name="birthday" class="">--}}
{{--                                    <div id="birthday" name="birthday">--}}
{{--                                        <form id="birthday" name="birthday">--}}
{{--                                            <select class="btn bg-dark text-white text-start "  id="day"></select>--}}
{{--                                            <select class="btn bg-dark text-white text-start w-25"  id="month"></select>--}}
{{--                                            <select class="btn bg-dark text-white text-start"  id="year">Year:</select>--}}
{{--                                        </form>--}}
{{--                                    </div>--}}
{{--                                </form>--}}
{{--                                <p></p>--}}
{{--                            </>--}}

                            <div class="col-md-3 text-white mb-3 d-flex py-sm-2">
                                <label style="color: #03e9f4" class="fs-6 col-md-12">Giới tính</label>
                                <select name="gender" id="gender" class="btn btn-dark bi bi-caret-down">
                                    <option value="1">Nam</option>
                                    <option value="0">Nữ</option>
                                </select>
                                <p></p>
                            </div>

                            <div class="d-flex ">
                                <div class="user-box col-lg-6">
                                    <input type="password" class="form-control" name="password" id="password">
                                    <label>Mật khẩu</label>
                                    <p></p>
                                </div>
                                <div class="user-box col-lg-6">
                                    <input type="password" class="form-control" name="password_confirmation" id="password_confirmation">
                                    <label>Nhập lại mật khẩu</label>
                                </div>
                            </div>
                            <div class="user-box col-md-6">
                                <input type="number" class="form-control" name="phone_number" id="phone_number">
                                <label>Số điện thoại</label>
                            </div>
                            <div class="user-box col-md-6">
                                <input type="text" class="form-control" name="address" id="address">
                                <label>Địa chỉ</label>
                            </div>
                            <input class="hidden invisible opacity-0" type="hidden"
                                   name="status" value="1" readonly>
                        </div>
                        <button class="justify-content-center border-0 bg-dark align-items-center">
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                            Đăng ký
                        </button>
                        <div class="p-2 text-white">
                            Bạn đã có tài khoản? <a class="text-danger fs-4 text-decoration-none" href="{{route('customer.login')}}">Đăng nhập</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
    </body>
    <x-flash-message/>
@endsection

@section('customJs')
    <script type="text/javascript">
        $("#registrationForm").submit(function (event){
          event.preventDefault();
          $("button[type='submit']").prop('disabled', true);
            $.ajax({
                url: '{{ route("customer.registerProcess") }}',
                type: 'post',
                data: $(this).serializeArray(),
                dataType: 'json',
                success: function (response){
                    $("button[type='submit']").prop('disabled', false);
                    var errors = response.errors;
                    if (response.status == false) {
                        if (errors.first_name) {
                            $("#first_name").siblings('p').addClass('invalid-feedback').html(errors.first_name);
                            $("#first_name").addClass('is-invalid');
                        }else {
                            $("#first_name").siblings('p').removeClass('invalid-feedback').html('');
                            $("#first_name").removeClass('is-invalid');
                        }

                        if (errors.last_name) {
                            $("#last_name").siblings('p').addClass('invalid-feedback').html(errors.last_name);
                            $("#last_name").addClass('is-invalid');
                        }else {
                            $("#last_name").siblings('p').removeClass('invalid-feedback').html('');
                            $("#last_name").removeClass('is-invalid');
                        }

                        if (errors.email) {
                            $("#email").siblings('p').addClass('invalid-feedback').html(errors.email);
                            $("#email").addClass('is-invalid');
                        }else {
                            $("#email").siblings('p').removeClass('invalid-feedback').html('');
                            $("#email").removeClass('is-invalid');
                        }

                        if (errors.password) {
                            $("#password").siblings('p').addClass('invalid-feedback').html(errors.password);
                            $("#password").addClass('is-invalid');
                        }else {
                            $("#password").siblings('p').removeClass('invalid-feedback').html('');
                            $("#password").removeClass('is-invalid');
                        }
                    }else {
                        $("#first_name").siblings('p').removeClass('invalid-feedback').html('');
                        $("#first_name").removeClass('is-invalid');

                        $("#last_name").siblings('p').removeClass('invalid-feedback').html('');
                        $("#last_name").removeClass('is-invalid');

                        $("#email").siblings('p').removeClass('invalid-feedback').html('');
                        $("#email").removeClass('is-invalid');

                        $("#password").siblings('p').removeClass('invalid-feedback').html('');
                        $("#password").removeClass('is-invalid');

                        window.location.href = "{{ route('customer.login') }}"
                    }

                },
                error: function (jQXHR, execption){
                    console.log('Something went wrong')
                }
            })
        })
    </script>

    <script>
        const yearSelect = document.getElementById("year");
        const monthSelect = document.getElementById("month");
        const daySelect = document.getElementById("day");

        const months = ['January', 'February', 'March', 'April',
            'May', 'June', 'July', 'August', 'September', 'October',
            'November', 'December'];

        //Months are always the same
        (function populateMonths(){
            for(let i = 0; i < months.length; i++){
                const option = document.createElement('option');
                option.textContent = months[i];
                monthSelect.appendChild(option);
            }
            monthSelect.value = "January";
        })();

        let previousDay;

        function populateDays(month){
            //Delete all of the children of the day dropdown
            //if they do exist
            while(daySelect.firstChild){
                daySelect.removeChild(daySelect.firstChild);
            }
            //Holds the number of days in the month
            let dayNum;
            //Get the current year
            let year = yearSelect.value;

            if(month === 'January' || month === 'March' ||
                month === 'May' || month === 'July' || month === 'August'
                || month === 'October' || month === 'December') {
                dayNum = 31;
            } else if(month === 'April' || month === 'June'
                || month === 'September' || month === 'November') {
                dayNum = 30;
            }else{
                //Check for a leap year
                if(new Date(year, 1, 29).getMonth() === 1){
                    dayNum = 29;
                }else{
                    dayNum = 28;
                }
            }
            //Insert the correct days into the day <select>
            for(let i = 1; i <= dayNum; i++){
                const option = document.createElement("option");
                option.textContent = i;
                daySelect.appendChild(option);
            }
            if(previousDay){
                daySelect.value = previousDay;
                if(daySelect.value === ""){
                    daySelect.value = previousDay - 1;
                }
                if(daySelect.value === ""){
                    daySelect.value = previousDay - 2;
                }
                if(daySelect.value === ""){
                    daySelect.value = previousDay - 3;
                }
            }
        }

        function populateYears(){
            //Get the current year as a number
            let year = new Date().getFullYear();
            //Make the previous 100 years be an option
            for(let i = 0; i < 101; i++){
                const option = document.createElement("option");
                option.textContent = year - i;
                yearSelect.appendChild(option);
            }
        }

        populateDays(monthSelect.value);
        populateYears();

        yearSelect.onchange = function() {
            populateDays(monthSelect.value);
        }
        monthSelect.onchange = function() {
            populateDays(monthSelect.value);
        }
        daySelect.onchange = function() {
            previousDay = daySelect.value;
        }
    </script>
@endsection
