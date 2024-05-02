<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Laravel's default font setup -->
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/landingPage.css') }}">
    <!-- Laravel default style (Adjust or extend as needed) -->
    <style>
        body {
            font-family: 'Figtree', sans-serif;
        }
        /* Add more styles here */
    </style>
</head>
<body>
    <header class="site-header">
        <div class="container d-flex justify-content-center">
            <h1 class="site-title">TeachRate</h1>
        </div>
    </header>
    <div class="container mt-5">
        <div class="accordion" id="accordionExample">
            <div class="accordion-item m-4 mb-0">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Enter Access Code
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <div class="main-content p-4 shadow">
                            <h2 class="mb-3 fs-3 fw-bold">Enter Access Code</h2>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Enter Code" id="access-code">
                                <button class="btn btn-primary" type="button" id="submit-code">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="accordion-item m-4 mt-0">
                <h2 class="accordion-header" id="headingTwo">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        Scan QR Code
                    </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <div class="main-content p-4 mt-4 shadow">
                            <h2 class="mb-3 fs-3 fw-bold">Scan QR Code</h2>
                            <div id="qr-reader" style="width: 100%"></div>
                            <div id="qr-result" class="alert alert-success mt-3 d-none"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="accordion" id="accordionExample2">
            <div class="accordion-item m-4">
                <h2 class="accordion-header" id="headingThree">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                        Login for More Options
                    </button>
                </h2>
                <div id="collapseThree" class="accordion-collapse collapse show">
                    <div class="accordion-body">
                        <div class="login-form mt-4 p-4 shadow-sm">
                            <h4 class="mb-4 fw-bold">Login for More Options</h4>
                            <form>
                                <div class="mb-2">
                                    <label for="username" class="form-label mb-1 fs-6">Username:</label>
                                    <input type="text" class="form-control" id="username" placeholder="Username">
                                </div>
                                <div class="mb-2">
                                    <label for="password" class="form-label mb-1 fs-6">Password:</label>
                                    <input type="password" class="form-control" id="password" placeholder="Password">
                                </div>
                                <div class="d-flex justify-content-center align-items-center login-container mt-4">
                                    <div class="w-50 d-flex flex-column align-items-center">
                                        <button type="submit" class="btn btn-primary w-100 mb-3">Login</button>
                                        <hr class="m-1" style="background-color: #000; width: 75%;">
                                        <a href="/register" class="btn btn-link w-100 mt-3">Register</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/html5-qrcode/minified/html5-qrcode.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // QR code and other functionality scripts here
        function onScanSuccess(decodedText, decodedResult) {
            // handle success
            document.getElementById('qr-result').textContent = 'QR Code result: ' + decodedText;
            document.getElementById('qr-result').classList.remove('d-none');
        }

        function onScanError(errorMessage) {
            // handle error
        }

        var html5QrcodeScanner = new Html5QrcodeScanner(
            "qr-reader", { fps: 10, qrbox: 250 }, false);
        html5QrcodeScanner.render(onScanSuccess, onScanError);
    </script>
</body>
</html>