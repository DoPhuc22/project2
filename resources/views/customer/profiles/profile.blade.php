@extends('layouts.customer-nav')
@section('content')
    @vite(["resources/sass/app.scss", "resources/js/app.js"])
    <head>
        <title>Hồ sơ</title>
        <link rel="stylesheet" href="{{asset('frontend/css/main.css')}}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>
    <body style="background-color: #00001c">
    <hr class="text-white">
    <div class="container d-flex align-items-center mt-5 h-80 overflow-hidden">
        <div class="border w-20 rounded-start p-3 h-100 text-white" style="background-color: #191c33">
            @include('layouts/profile_menu')
        </div>
        <div class="border w-80 rounded-end p-3 h-100 text-white" style="background-color: #191c33">
            <div class="col-md-12">
                @include('admin.message')
            </div>
            <div class="fs-5">
                Hồ sơ
            </div>
            <div>
                Quản lý thông tin hồ sơ để bảo mật tài khoản của bạn
            </div>
            <hr>
            <div>
                <form action="" name="profileForm" id="profileForm"
                      class="row text-white g-3">
                    <div class="col-md-6">
                        <label for="first_name" class="form-label">Họ</label>
                        <input type="text" class="form-control text-white bg-dark border-0" id="first_name"
                               name="first_name"
                               value="{{$customer->first_name}}">
                        <p></p>
                    </div>
                    <div class="col-md-6">
                        <label for="last_name" class="form-label">Tên</label>
                        <input type="text" class="form-control text-white bg-dark border-0" id="last_name"
                               name="last_name"
                               value="{{$customer->last_name}}">
                        <p></p>
                    </div>

                    <div class="col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control text-white bg-dark border-0" id="email"
                               name="email"
                               value="{{$customer->email}}">
                        <p></p>
                    </div>
                    <div class="col-md-6">
                        <label for="phone_number" class="form-label">Số điện thoại</label>
                        <input type="number" class="form-control text-white bg-dark border-0" id="phone_number"
                               name="phone_number"
                               value="{{$customer->phone_number}}">
                        <p></p>
                    </div>

{{--                    <div class="col-md-12">--}}
{{--                        <label for="birthday" class="form-label col-12">Birthday</label>--}}
{{--                        <div>--}}
{{--                            <form name="birthday" id="birthday">--}}
{{--                                <span name="birthday" id="birthday">--}}
{{--                                    <label for="day">Day:</label>--}}
{{--                                    <select class="btn bg-dark text-white text-start w-25" name="day" id="day" value="{{$customer->birthday}}"></select>--}}
{{--                                </span>--}}
{{--                                <span name="birthday" id="birthday">--}}
{{--                                    <label for="month">Month:</label>--}}
{{--                                    <select class="btn bg-dark text-white text-start w-25" name="month" id="month" value="{{$customer->birthday}}"></select>--}}
{{--                                </span>--}}
{{--                                <span name="birthday" id="birthday">--}}
{{--                                    <label for="year">Year:</label>--}}
{{--                                    <select class="btn bg-dark text-white text-start w-25" name="year" id="year">Year:</select>--}}
{{--                                </span>--}}
{{--                            </form>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                    <div class="col-md-2 mt-2">
                        <label for="gender" class="form-label">Giới tính</label>
                        <select name="gender" id="gender" class="btn btn-dark bi bi-caret-down">
                            <option {{($customer->gender == 1) ? 'selected' : ''}} value="1" >Nam</option>
                            <option {{($customer->gender == 0) ? 'selected' : ''}} value="0" >Nữ</option>
                        </select>
                    </div>

                    <div class="col-md-6 mt-3">
                        <label for="address" class="form-label">Địa chỉ</label>
                        <input type="text" class="form-control text-white bg-dark border-0" id="address"
                               name="address"
                               value="{{$customer->address}}">
                        <p></p>
                    </div>

                    <div class="col-12 mt-3 text-center">
                        <button type="submit" class="btn btn-primary rounded-5 px-4">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </body>
@endsection

@section('customJs')
    <script type="text/javascript">
        $("#profileForm").submit(function (event){
            event.preventDefault()
            $("button[type='submit']").prop('disabled', true);
            $.ajax({
                url: '{{ route("updateProfile") }}',
                type: 'post',
                data: $(this).serializeArray(),
                dataType: 'json',
                success: function (response){
                    $("button[type='submit']").prop('disabled', false);
                    if (response.status == true){
                        $("#first_name").siblings('p').removeClass('invalid-feedback').html('');
                        $("#first_name").removeClass('is-invalid');
                        $("#last_name").siblings('p').removeClass('invalid-feedback').html('');
                        $("#last_name").removeClass('is-invalid');
                        $("#email").siblings('p').removeClass('invalid-feedback').html('');
                        $("#email").removeClass('is-invalid');
                        $("#phone_number").siblings('p').removeClass('invalid-feedback').html('');
                        $("#phone_number").removeClass('is-invalid');
                        $("#address").siblings('p').removeClass('invalid-feedback').html('');
                        $("#address").removeClass('is-invalid');

                        window.location.href = '{{ route("profile") }}'
                    }else {
                        var errors = response.errors;
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

                        if (errors.phone_number) {
                            $("#phone_number").siblings('p').addClass('invalid-feedback').html(errors.password);
                            $("#phone_number").addClass('is-invalid');
                        }else {
                            $("#phone_number").siblings('p').removeClass('invalid-feedback').html('');
                            $("#phone_number").removeClass('is-invalid');
                        }
                        if (errors.address) {
                            $("#address").siblings('p').addClass('invalid-feedback').html(errors.password);
                            $("#address").addClass('is-invalid');
                        }else {
                            $("#address").siblings('p').removeClass('invalid-feedback').html('');
                            $("#address").removeClass('is-invalid');
                        }
                    }
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
