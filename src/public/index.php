<?php

// use Illuminate\Http\Request;

// define("LARAVEL_START", microtime(true));

// // Determine if the application is in maintenance mode...
// if (file_exists($maintenance = __DIR__ . "/../storage/framework/maintenance.php")) {
//     require $maintenance;
// }

// // Register the Composer autoloader...
// require __DIR__ . "/../vendor/autoload.php";

// // Bootstrap Laravel and handle the request...
// (require_once __DIR__ . '/../bootstrap/app.php')
//     ->handleRequest(Request::capture());

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../resources/css/landingPage.css">
</head>

<body>
    <header class="site-header">
        <div class="container d-flex justify-content-center">
            <h1 class="site-title">TeachRate</h1>
        </div>
    </header>
    <!-- <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="main-content p-4 shadow">
                    <h2 class="mb-3 fs-3 fw-bold">Enter Access Code</h2>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Enter Code" id="access-code">
                        <button class="btn btn-outline-secondary btn-submit" type="button" id="submit-code">Submit</button>
                    </div>
                </div>
                <div class="main-content p-4 mt-4 shadow">
                    <h2 class="mb-3 fs-3 fw-bold">Scan QR Code</h2>
                    <div id="qr-reader2" style="width: 100%"></div>
                    <div id="qr-result2" class="alert alert-success mt-3 d-none"></div>
                </div>
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
    </div> -->
    <div class="container mt-5">
        <div class="accordion" id="accordionExample">
            <div class="accordion-item m-4">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Enter Access Code
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne">
                    <div class="accordion-body">
                        <div class="main-content p-4 shadow">
                            <h2 class="mb-3 fs-3 fw-bold">Enter Access Code</h2>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Enter Code" id="access-code">
                                <button class="btn btn-outline-secondary btn-submit" type="button" id="submit-code">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="accordion-item m-4">
                <h2 class="accordion-header" id="headingTwo">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        Scan QR Code

                    </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo">
                    <div class="accordion-body">
                        <div class="main-content p-4 mt-4 shadow">
                            <h2 class="mb-3 fs-3 fw-bold">Scan QR Code</h2>
                            <div id="qr-reader" style="width: 100%"></div>
                            <div id="qr-result" class="alert alert-success mt-3 d-none"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="accordion-item m-4">
                <h2 class="accordion-header" id="headingThree">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                        Login for More Options
                    </button>
                </h2>
                <div id="collapseThree" class="accordion-collapse collapse show" aria-labelledby="headingThree">
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

    <script src="https://cdn.jsdelivr.net/npm/html5-qrcode/minified/html5-qrcode.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function onScanSuccess(decodedText, decodedResult) {
            // Handle on success condition with the decoded text or result.
            document.getElementById('qr-result').textContent = 'QR Code result: ' + decodedText;
            document.getElementById('qr-result').classList.remove('d-none');
        }

        function onScanError(errorMessage) {
            // handle on error condition, with error message
        }

        var html5QrcodeScanner = new Html5QrcodeScanner(
            "qr-reader", {
                fps: 10,
                qrbox: 250
            }, /* verbose= */ false);
        html5QrcodeScanner.render(onScanSuccess, onScanError);
    </script>
</body>

</html>