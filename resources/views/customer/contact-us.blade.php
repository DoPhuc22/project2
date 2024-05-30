@extends('layouts.customer-nav')
@section('content')
    <head>
        <title>Liên hệ - Paradise Theatre</title>
        <link rel="stylesheet" href="{{asset('frontend/css/main.css')}}">
    </head>
    @vite(["resources/sass/app.scss", "resources/js/app.js"])
    <hr class="text-white">
    <body style="background-color: #00001c;">
    <div class="container mt-5 justify-content-center align-items-center">
        <section class="section-5 pt-3 pb-3 mb-3">
            <div class="container">
                <div class="light-font">
                    <ol class="breadcrumb  mb-0">
                        <li class="breadcrumb-item"><a class="text-white nav-link" href="{{ route('home') }}">Trang chủ</a></li>
                        <li class="bi bi-slash-lg text-white">Liên hệ</li>
                    </ol>
                </div>
            </div>
        </section>

        <section class=" section-10">
            <div class="container">
                <div class="col-md-12">
                    @if(\Illuminate\Support\Facades\Session::has('success'))
                        <div class="alert alert-success">
                            {{ \Illuminate\Support\Facades\Session::get('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                </div>
                <div class="section-title mt-5 text-white">
                    <h2>Love to Hear From You</h2>
                </div>
            </div>
        </section>

        <section class="text-white">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 mt-3 pe-lg-5 text-justify">
                        <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.
                            The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using Content.</p>
                        <address>
                            Hà Nội <br>
                            711-2880 Nulla St.<br><br>
                            <a href="tel:+xxxxxxxx">(XXX) 555-2368</a><br>
                            <a href="mailto:phucsonmai999@gmail.com">phucsonmai999@gmail.com</a>
                        </address>
                    </div>

                    <div class="col-md-6">
                        <form class="shake" role="form" method="post" id="contactForm" name="contact-form">
                            <div class="mb-3">
                                <label class="mb-2" for="name">Họ & Tên</label>
                                <input class="form-control" id="name" type="text" name="name"  data-error="Please enter your name">
                                <p class="help-block with-errors"></p>
                            </div>

                            <div class="mb-3">
                                <label class="mb-2" for="email">Email</label>
                                <input class="form-control" id="email" type="email" name="email"  data-error="Please enter your Email">
                                <p class="help-block with-errors"></p>
                            </div>

                            <div class="mb-3">
                                <label class="mb-2">Chủ đề</label>
                                <input class="form-control" id="subject" type="text" name="subject"  data-error="Please enter your message subject">
                                <p class="help-block with-errors"></p>
                            </div>

                            <div class="mb-3">
                                <label for="message" class="mb-2">Tin nhắn</label>
                                <textarea class="form-control" rows="3" id="message" name="message"  data-error="Write your message"></textarea>
                                <p class="help-block with-errors"></p>
                            </div>

                            <div class="form-submit">
                                <button class="btn btn-danger" type="submit" id="form-submit"><i class="material-icons mdi mdi-message-outline"></i> Gửi ⤴️</button>
                                <div id="msgSubmit" class="h3 text-center hidden"></div>
                                <div class="clearfix"></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>

@endsection

@section('customJs')
    <script>
        $('#contactForm').submit(function (event){
            event.preventDefault();
            $('#form-submit').prop('disabled', true)
            $.ajax({
                url: '{{route("sendContactEmail")}}',
                type: 'post',
                data: $(this).serializeArray(),
                dataType: 'json',
                success: function (response){
                    $('#form-submit').prop('disabled', false)
                    if (response.status == true){
                        window.location.href = "{{ route('contact_us') }}"
                    }else {
                        var errors = response.errors;
                        if (errors.name) {
                            $("#name").siblings('p').addClass('invalid-feedback').html(errors.name);
                            $("#name").addClass('is-invalid');
                        }else {
                            $("#name").siblings('p').removeClass('invalid-feedback').html('');
                            $("#name").removeClass('is-invalid');
                        }

                        if (errors.subject) {
                            $("#subject").siblings('p').addClass('invalid-feedback').html(errors.subject);
                            $("#subject").addClass('is-invalid');
                        }else {
                            $("#subject").siblings('p').removeClass('invalid-feedback').html('');
                            $("#subject").removeClass('is-invalid');
                        }

                        if (errors.email) {
                            $("#email").siblings('p').addClass('invalid-feedback').html(errors.email);
                            $("#email").addClass('is-invalid');
                        }else {
                            $("#email").siblings('p').removeClass('invalid-feedback').html('');
                            $("#email").removeClass('is-invalid');
                        }
                    }
                }
            })
        })
    </script>
@endsection
