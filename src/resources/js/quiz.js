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
        document.getElementById("code").innerHTML = id;
        modal.removeClass("hidden");

        var qrcodeElement = document.getElementById('qr-code');
        qrcodeElement.innerHTML = "";
        new QRCode(qrcodeElement, {
            text: id,
            width: 250,
            height: 250,
            colorDark: "#000000",
            colorLight: "#ffffff",
            correctLevel: QRCode.CorrectLevel.H
        });
    });

    $('#statusSelect').on('change', function() {
        var sortOrder = $(this).val();

        var tbody = $('table tbody');
        var rows = tbody.find('tr').get();

        rows.sort(function(a, b) {
            var dateA = $(a).find('td').eq(3).text().trim();
            var dateB = $(b).find('td').eq(3).text().trim();

            var dateAParts = dateA.split('.');
            var dateBParts = dateB.split('.');

            var dateAObj = new Date(dateAParts[2], dateAParts[1] - 1, dateAParts[0]);
            var dateBObj = new Date(dateBParts[2], dateBParts[1] - 1, dateBParts[0]);

            if (sortOrder === 'newest') {
                return dateBObj - dateAObj;
            } else {
                return dateAObj - dateBObj;
            }
        });

        $.each(rows, function(index, row) {
            tbody.append(row);
        });

        var mobileContainer = $('#mobileTable');
        var cards = mobileContainer.find('> div').get();

        cards.sort(function(a, b) {
            var idA = $(a).attr('id');
            var idB = $(b).attr('id');

            var dateA = idA.split('-').slice(1).join('-');
            var dateB = idB.split('-').slice(1).join('-');

            var dateAParts = dateA.split('.');
            var dateBParts = dateB.split('.');

            var dateAObj = new Date(dateAParts[2], dateAParts[1] - 1, dateAParts[0]);
            var dateBObj = new Date(dateBParts[2], dateBParts[1] - 1, dateBParts[0]);

            if (sortOrder === 'newest') {
                return dateBObj - dateAObj;
            } else {
                return dateAObj - dateBObj;
            }
        });

        $.each(cards, function(index, card) {
            mobileContainer.append(card);
        });
    });
});
