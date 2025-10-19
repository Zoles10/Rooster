document.addEventListener('DOMContentLoaded', function() {
    // Get the language messages from data attributes
    const qrCodeResultMessage = document.getElementById('qr-reader')?.dataset.qrResultMessage || 'QR Code result: ';

    const submitButton = document.getElementById('submit-code');
    const accessCodeInput = document.getElementById('access-code');

    if (submitButton && accessCodeInput) {
        submitButton.addEventListener('click', function() {
            var code = accessCodeInput.value;
            if (code) {
                window.location.href = '/' + code;
            }
        });

        accessCodeInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                submitButton.click();
            }
        });
    }

    function onScanSuccess(decodedText, decodedResult) {
        const resultElement = document.getElementById('qr-result');
        if (resultElement) {
            resultElement.style.display = 'block';
            resultElement.innerHTML = qrCodeResultMessage + decodedText;
        }
        window.location.href = '/' + decodedText;
    }

    function onScanFailure(error) {
        // Handle scan failure silently
    }

    // Initialize QR scanner if the element exists
    const qrReaderElement = document.getElementById('qr-reader');
    if (qrReaderElement && typeof Html5QrcodeScanner !== 'undefined') {
        let html5QrcodeScanner = new Html5QrcodeScanner(
            "qr-reader",
            { fps: 10, qrbox: {width: 250, height: 250} },
            false
        );
        html5QrcodeScanner.render(onScanSuccess, onScanFailure);
    }
});
