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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../resources/css/app.css">
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="main-content p-4 shadow">
                    <h2 class="mb-3">Enter Access Code</h2>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Enter Code" id="access-code">
                        <button class="btn btn-outline-secondary" type="button" id="submit-code">Submit</button>
                    </div>
                        <h2 class="mb-3">Scan QR Code</h2>
                        <div id="qr-reader" style="width: 100%"></div>
                        <div id="qr-result" class="alert alert-success mt-3 d-none"></div>
                    </div>
                    <div class="login-form mt-4 p-2 shadow-sm">
                        <h4>Login for More Options</h4>
                        <form>
                            <div class="mb-2">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" required>
                            </div>
                            <div class="mb-2">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm">Login</button>
                            <a href="/register" class="btn btn-link btn-sm">Register</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/html5-qrcode/minified/html5-qrcode.min.js"></script>
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