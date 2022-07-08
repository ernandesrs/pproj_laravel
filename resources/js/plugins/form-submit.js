(function ($) {
    let messageArea = $(".message-area");

    $.fn.submited = function (e) {
        e.preventDefault();

        let form = $(this);
        let data = new FormData(form[0]);
        let action = form.attr("action");

        messageArea = form.find(".message-area").length ? form.find(".message-area") : messageArea;

        $.ajax({
            type: "POST",
            url: action,
            data: data,
            dataType: "json",
            contentType: false,
            processData: false,

            success: function (response) {
                if (response.reload) {
                    window.location.reload();
                    return;
                }

                if (response.redirect) {
                    window.location.href = response.redirect;
                    return;
                }

                form.find(".message-area").html($(
                    `<div class="alert alert-danger text-center">${response.message}</div>`)
                    .hide().fadeIn());
            }
        });
    };

}(jQuery));
