let timeoutHandler = null;

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


/**
 *
 * FUNÇÕES: ALERTS/MESSAGES
 *
 */

/**
 * @param {jQuery} alert objeto jquery do elemento de mensagem
 * @param {jQuery|null} container objeto jquery do container de mensagem. Padrão será o primeiro .message-area encontrado
 */
function addAlert(alert, container = null) {
    let cntnr = container ?? $(".message-area");
    cntnr.html(alert);
    showAlert(alert);
}

/**
 * @param {jQuery} alert
 */
function showAlert(alert) {
    if (alert.hasClass("alert-float")) {
        alert.show("blind", function () {
            $(this).effect("bounce");
        });
    } else {
        alert.show("fade");
    }

    if (timer = alert.attr("data-timer")) {
        if (timeoutHandler)
            clearTimeout(timeoutHandler);
        runTimer(alert);
    }
}

/**
 * @param {jQuery} alert
 */
function removeAlert(alert) {
    if (alert.hasClass("alert-float")) {
        alert.effect("bounce", function () {
            $(this).hide("blind", function () {
                $(this).remove();
            });
        });
    } else {
        alert.hide("fade", function () {
            $(this).remove();
        });
    }
}

/**
 * @param {jQuery} alert
 */
function runTimer(alert) {
    timeoutHandler = setTimeout(function () {
        removeAlert(alert);
    }, timer * 1000);
}
