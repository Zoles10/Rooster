<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TeachRate</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Laravel's default font setup -->
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/landingPage.css') }}">
    <!-- Laravel default style (Adjust or extend as needed) -->
    <style>
        /* COLOR PALLETTE */
        /* https://coolors.co/31334d-93acb5-96c5f7-a9d3ff-f2f4ff */
        body {
            background-color: #f3f4f6;
            color: #31334d;
            font-family: 'Figtree', sans-serif;
        }

        .site-title {
            font-size: 3rem;
            font-weight: bold;
            color: #F2F4FF;
        }

        .site-header {
            background-color: #ffffff;
            color: white;
            padding: 0;
        }

        .main-content {
            background-color: #cfe2ff;
            border-radius: .4rem;
            border: .2rem solid #31334D;
        }

        .login-form {
            background-color: #cfe2ff;
            border-radius: .4rem;
            font-size: 0.9rem;
            border: .2rem solid #31334D;
        }

        .form-label {
            font-weight: bold;
        }

        .qr-code-container img {
            max-width: 100%;
            height: auto;
        }

        .btn-submit {
            background-color: rgb(79, 70, 229);
            color: #F2F4FF;
            border: none;
            padding: 10px 20px;
            border-radius: .4rem;
            cursor: pointer;
        }

        .btn-link {
            color: rgb(79, 70, 229);
            border: dashed .15rem rgb(79, 70, 229);
            font-weight: bolder;
            letter-spacing: .2rem;
            text-decoration: none;
            border-radius: .3rem;
        }

        .btn-link:hover {
            color: #F2F4FF;
            border: dashed .15rem #F2F4FF;
        }

        .btn-primary {
            background-color: rgb(79, 70, 229);
            font-weight: bold;
            letter-spacing: .2rem;
            color: #F2F4FF;
            border: rgb(79, 70, 229);
        }

        .btn-primary:hover {
            background-color: #F2F4FF;
            color: rgb(79, 70, 229);
            border: rgb(79, 70, 229);
        }

        #qr-reader a {
            color: rgb(79, 70, 229);
            font-size: 1.2rem;
            margin: .3rem !important;
        }

        #qr-reader a:hover {
            color: #F2F4FF;
        }

        #qr-reader button,
        input {
            background-color: rgb(79, 70, 229);
            color: #F2F4FF;
            border: none;
            padding: 10px 20px;
            border-radius: .4rem;
            cursor: pointer;
        }

        #qr-reader img {
            display: none;
        }

        .dropdown-toggle {
            background-color: rgb(79, 70, 229);
            color: #F2F4FF;
            border: none;
            font-weight: bold;
            letter-spacing: .1rem;
        }

        .dropdown-toggle:hover {
            background-color: #F2F4FF;
            color: rgb(79, 70, 229);
        }

        /* Add these new rules to fix the invisible button issue */
        .dropdown-toggle:focus,
        .dropdown-toggle:active,
        .dropdown-toggle.show {
            background-color: rgb(79, 70, 229) !important;
            color: #F2F4FF !important;
            border: none !important;
            box-shadow: none !important;
        }

        .dropdown-toggle:focus:hover,
        .dropdown-toggle:active:hover,
        .dropdown-toggle.show:hover {
            background-color: #F2F4FF !important;
            color: rgb(79, 70, 229) !important;
        }

        .dropdown-menu {
            background-color: rgb(79, 70, 229);
            color: #F2F4FF;
            border: none;
        }

        .dropdown-item {
            color: #F2F4FF;
            padding: 10px 20px;
        }

        .dropdown-item:hover {
            background-color: #F2F4FF;
            color: rgb(79, 70, 229);
        }
    </style>
</head>

<body>
    <!-- @Jakub fix boostrap+tailwind errors vymaztentotextpredat@include('layouts.navigation') --->
    <header class="site-header d-flex justify-content-center align-items-center py-3">
        <div class="d-flex justify-content-center flex-grow-1">
            <a href="{{ url('/') }}">
                <x-application-logo class="block h-full w-auto fill-current text-gray-800"
                    style="width: 15vh!important; height: auto;" />
            </a>
        </div>
        <!-- Language Dropdown -->
        <div class="dropdown ms-auto me-3">
            <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                @lang('messages.language')
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="locale/en">@lang('messages.english')</a>
                <a class="dropdown-item" href="locale/sk">@lang('messages.slovak')</a>
            </div>
        </div>
    </header>

    <div class="container mt-5">
        <div class="accordion" id="accordionExample">
            <div class="accordion-item m-4 mb-0">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        @lang('messages.enterAccessCode')
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                    data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <div class="main-content p-4 shadow">
                            <h2 class="mb-3 fs-3 fw-bold">@lang('messages.enterAccessCode')</h2>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="@lang('messages.enterAccessCode')"
                                    id="access-code">
                                <button class="btn btn-primary" type="button"
                                    id="submit-code">@lang('messages.submit')</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="accordion-item m-4 mt-0">
                <h2 class="accordion-header" id="headingTwo">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        @lang('messages.scanQrCode')
                    </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                    data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <div class="main-content p-4 mt-4 shadow">
                            <h2 class="mb-3 fs-3 fw-bold">@lang('messages.scanQrCode')</h2>
                            <div id="qr-reader" style="width: 100%"></div>
                            <div id="qr-result" class="alert alert-success mt-3 d-none"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if (Auth::guest())
        <div class="accordion" id="accordionExample2">
            <div class="accordion-item m-4">
                <h2 class="accordion-header" id="headingThree">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                        @lang('messages.loginForMoreOptions')
                    </button>
                </h2>
                <div id="collapseThree" class="accordion-collapse collapse show">
                    <div class="accordion-body">
                        <div class="login-form mt-4 p-4 shadow-sm">
                            <div class="d-flex justify-content-center align-items-center login-container mt-4">
                                <div class="w-50 d-flex flex-column align-items-center">
                                    <a href="{{ route('login') }}" class="btn btn-primary w-100 mb-3">@lang('messages.login')</a>
                                    <hr class="m-1" style="background-color: #000; width: 75%;">
                                    <a href="{{ route('register') }}"
                                        class="btn btn-primary w-100 mt-3 mb-3">@lang('messages.register')</a>
                                    <hr class="m-1" style="background-color: #000; width: 75%;">
                                    <a href="{{ route('manual') }}"
                                        class="btn btn-primary w-100 mt-3 mb-3">@lang('messages.manual')</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="accordion" id="accordionExample2">
            <div class="accordion-item m-4">
                <h2 class="accordion-header" id="headingFour">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseFour" aria-expanded="true" aria-controls="collapseThree">
                        @lang('messages.myProfile')
                    </button>
                </h2>
                <div id="collapseFour" class="accordion-collapse collapse show">
                    <div class="accordion-body">
                        <div class="login-form mt-4 p-4 shadow-sm">
                            <div class="d-flex justify-content-center align-items-center login-container mt-4">
                                <div class="w-50 d-flex flex-column align-items-center">
                                    <a href="{{ route('dashboard') }}" class="btn btn-primary w-100 mb-3">@lang('messages.dashboard')</a>
                                    <hr class="m-1" style="background-color: #000; width: 75%;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/html5-qrcode/minified/html5-qrcode.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        var qrCodeResultMessage = '@lang("messages.qrCodeResult")';
        var submitCodeMessage = '@lang("messages.submitCode")';
        var accessCodeMessage = '@lang("messages.accessCode")';

        document.getElementById('submit-code').addEventListener('click', function() {
            var code = document.getElementById('access-code').value;
            window.location.href = '/' + code;
        });

        // QR code and other functionality scripts here
        function onScanSuccess(decodedText, decodedResult) {
            // handle success
            document.getElementById('qr-result').textContent = qrCodeResultMessage + decodedText;
            document.getElementById('qr-result').classList.remove('d-none');
            window.location.href = '/' + decodedText;
        }

        function onScanError(errorMessage) {
            // handle error
        }

        var html5QrcodeScanner = new Html5QrcodeScanner(
            "qr-reader", {
                fps: 10,
                qrbox: 250
            }, false);
        html5QrcodeScanner.render(onScanSuccess, onScanError);
    </script>
</body>

</html>
