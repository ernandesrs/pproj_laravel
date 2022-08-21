

$(function () {
    let modal = $(".jsModalConfirmation");

    $('[data-toggle="tooltip"]').tooltip()

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).on("submit", ".jsFormSubmit", function (e) {
        formSubmit($(this), e);
    });

    $(".jsButtonConfirmation").on("click", function (e) {
        e.preventDefault();
        let button = $(this);

        modal.find(".jsFormSubmit").attr("action", button.attr("data-action"));
        modal.find(".confirmation-message")
            .addClass(`text-${button.attr("data-type")}`)
            .html(button.attr("data-message"));
        modal.find(".confirmation-btn")
            .addClass(`btn-${button.attr("data-type")}`);

        modal.modal();
    });

    $(modal).on("hidden.bs.modal", function (e) {
        modal.find(".message-area").html("");
        modal.find(".jsFormSubmit").attr("action", "");
        modal.find(".confirmation-message")
            .removeClass(`text-danger text-success text-info text-warning text-secondary`)
            .html("");
        modal.find(".confirmation-btn")
            .removeClass(`btn-danger btn-success btn-info btn-warning btn-secondary`);
    });

});

/**
* ALERTA/MENSAGENS
*/
$(function () {
    let messageAreas = $(".message-area");

    $.each(messageAreas, function (k, v) {
        let alert = $(v).find(".alert");

        if (alert.length) {
            showAlert(alert);
        }
    });

    $(".alert").on("close.bs.alert", function () {
        if (timeoutHandler)
            clearTimeout(timeoutHandler);
    });
});



