@extends('layouts.customer-nav')
@section('content')
    @vite(["resources/sass/app.scss", "resources/js/app.js"])
    <head>
        <title>Thay đổi mật khẩu - Paradise Theatre</title>
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
                Thông tin của tôi
            </div>
            <div>
                Quản lý thông tin hồ sơ để bảo mật tài khoản của bạn
            </div>
            <hr>
            <div>
                <form action="" id="changePasswordForm" name="changePasswordForm" class="row g-3 text-white">
                    <div class="col-md-12">
                        <label for="old_pwd" class="form-label">Mật khẩu cũ</label>
                        <input type="password" class="form-control bg-dark border-0 text-white w-40" id="old_password"
                               name="old_password" placeholder="Old Password">
                        <p></p>
                    </div>

                    <div class="col-md-12">
                        <label for="new_pwd" class="form-label">Mật khẩu mới</label>
                        <input type="password" class="form-control bg-dark border-0 text-white w-40" id="new_password"
                               name="new_password" placeholder="New Password">
                        <p></p>
                    </div>

                    <div class="col-md-12">
                        <label for="new_pwd2" class="form-label">Nhập lại mật khẩu mới</label>
                        <input type="password" class="form-control bg-dark border-0 text-white w-40" id="confirm_password"
                               name="confirm_password" placeholder="Re-enter new password">
                        <p></p>
                    </div>
                    <div class="col-12">
                        <button id="submit" name="submit" type="submit" class="btn btn-primary rounded-5 px-4">Lưu</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
    </body>
@endsection

@section('customJs')
    <script type="text/javascript">
        $("#changePasswordForm").submit(function (e){
            e.preventDefault()
            $('#submit').prop('disabled', true)
            $.ajax({
                url: '{{ route("customer.process_change_password") }}',
                type: 'post',
                data: $(this).serializeArray(),
                dataType: 'json',
                success: function (response){
                    $('#submit').prop('disabled', false)
                    if (response.status == true){
                        $("#old_password").siblings('p').removeClass('invalid-feedback').html('');
                        $("#old_password").removeClass('is-invalid');
                        $("#new_password").siblings('p').removeClass('invalid-feedback').html('');
                        $("#new_password").removeClass('is-invalid');
                        $("#confirm_password").siblings('p').removeClass('invalid-feedback').html('');
                        $("#confirm_password").removeClass('is-invalid');
                        window.location.href = "{{ route('customer.change_password') }}"
                    }else {
                        var errors = response.errors

                        if (errors.old_password) {
                            $("#old_password").siblings('p').addClass('invalid-feedback').html(errors.old_password);
                            $("#old_password").addClass('is-invalid');
                        }else {
                            $("#old_password").siblings('p').removeClass('invalid-feedback').html('');
                            $("#old_password").removeClass('is-invalid');
                        }

                        if (errors.new_password) {
                            $("#new_password").siblings('p').addClass('invalid-feedback').html(errors.new_password);
                            $("#new_password").addClass('is-invalid');
                        }else {
                            $("#new_password").siblings('p').removeClass('invalid-feedback').html('');
                            $("#new_password").removeClass('is-invalid');
                        }

                        if (errors.confirm_password) {
                            $("#confirm_password").siblings('p').addClass('invalid-feedback').html(errors.confirm_password);
                            $("#confirm_password").addClass('is-invalid');
                        }else {
                            $("#confirm_password").siblings('p').removeClass('invalid-feedback').html('');
                            $("#confirm_password").removeClass('is-invalid');
                        }
                    }
                }
            })
        })
    </script>
@endsection
