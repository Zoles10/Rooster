import $ from "jquery";

$(function() {
    console.log( "ready!" );
    let modal = $("#codeModal");
    let modalBtn = $("#hideModalButton");
    console.log(modal);

    modalBtn.on("click", function() {
        modal.addClass("hidden");
    });

    $(document).on('click', '[id$="btn"]', function() {
        var id = $(this).attr('id').replace('btn', '');
        console.log('Button with id ' + id + ' was clicked.');
        document.getElementById("code").innerHTML = id; // Sets the code text in the modal
        modal.removeClass("hidden");

        // Generate QR code for the id
        var qrcodeElement = document.getElementById('qr-code');
        qrcodeElement.innerHTML = ""; // Clear previous QR code
        new QRCode(qrcodeElement, {
            text: id,
            width: 250,
            height: 250,
            colorDark: "#000000",
            colorLight: "#ffffff",
            correctLevel: QRCode.CorrectLevel.H
        });
    });
});
