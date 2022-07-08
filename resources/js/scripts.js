$(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(".jsFormSubmit").on("submit", function (e) {
        $(this).submited(e);
    });

});
