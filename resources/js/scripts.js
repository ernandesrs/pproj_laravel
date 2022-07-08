$(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).on("submit", ".jsFormSubmit", function (e) {
        $(this).submited(e);
    });

});
