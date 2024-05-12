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
        modal.removeClass("hidden");
    });
});
