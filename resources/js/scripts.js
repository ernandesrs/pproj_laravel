$(function () {
    let messageAreas = $(".message-area");
    let modalConfirmation = $(".jsModalConfirmation");

    // BOOTSTRAP TOOLTIP
    $('[data-toggle="tooltip"]').tooltip();

    // CSRF TOKEN
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // PERCORRE CONTAINER DE MENSAGENS E MOSTRANDO/REMOVENDO OS ALERTAS
    $.each(messageAreas, function (k, v) {
        let alert = $(v).find(".alert");

        if (k == 0 && alert.length) {
            showAlert(alert);
        } else {
            alert.remove();
        }
    });

    // ALTERAÇÃO NO EVENTO PADRÃO
    $(".alert").on("close.bs.alert", function (e) {
        e.preventDefault();
        removeAlert($(this));
    });

    // SUBMISSÃO DE FORMULÁRIO
    $(document).on("submit", ".jsFormSubmit", function (e) {
        formSubmit($(this), e);
    });

    // BOTÃO DE CONFIRMAÇÃO
    $(".jsButtonConfirmation").on("click", function (e) {
        e.preventDefault();
        let button = $(this);

        modalConfirmation.find(".jsFormSubmit").attr("action", button.attr("data-action"));
        modalConfirmation.find(".confirmation-message").addClass(`text-${button.attr("data-type")}`).html(button.attr("data-message"));
        modalConfirmation.find(".confirmation-btn").addClass(`btn-${button.attr("data-type")}`);

        modalConfirmation.modal();
    });

    // LIMPA O MODAL DE CONFIRMAÇÃO AO FECHAR
    modalConfirmation.on("hidden.bs.modal", function (e) {
        $(this).find(".message-area").html("");
        $(this).find(".jsFormSubmit").attr("action", "");
        $(this).find(".confirmation-message")
            .removeClass(`text-danger text-success text-info text-warning text-secondary`)
            .html("");
        $(this).find(".confirmation-btn")
            .removeClass(`btn-danger btn-success btn-info btn-warning btn-secondary`);
    });
});



