let timeoutHandler = null;

/**
 * Função para submissão de formulários
 * 
 * @param {JQuery} form 
 * @param {JQuery.SubmitEvent} event 
 * @param {Function|null} success
 * @param {Function|null} complete
 */
function formSubmit(form, event, success = null, complete = null) {
    event.preventDefault();

    let formMessageArea = form.find(".message-area");
    let globalMessageArea = $("body").find(".message-area");
    let action = form.attr("action");
    let method = form.attr("method");
    let data = new FormData(form[0]);
    let submitter = $(event.originalEvent.submitter);

    ajaxRequest(action, data, function (response) {
        // success

        if (response.redirect) {
            window.location.href = response.redirect;
            return;
        }

        if (response.reload) {
            window.location.reload();
            return;
        }

        if (response.message) {
            let message = $(response.message);

            if (formMessageArea.length)
                addAlert(message, formMessageArea);
            else if (globalMessageArea.length)
                addAlert(message, globalMessageArea);
        }

        success ? success(response) : null;
    }, function () {
        // before

        addLoadingMode(submitter);
        addBackdrop("formSubmitBkdp", "absolute", form.parent());
    }, function (response) {
        // complete

        let responseJSON = response.responseJSON ?? null;

        if (responseJSON && (responseJSON.errors ?? null)) {
            let message = (responseJSON.errors.message ?? null) ? responseJSON.errors.message : null;

            if (message) {
                let message = $(response.message);

                if (formMessageArea.length)
                    addAlert(message, formMessageArea);
                else if (globalMessageArea.length)
                    addAlert(message, globalMessageArea);
            }

            addFormErrors(form, responseJSON.errors);
        }

        removeLoadingMode(submitter);
        removeBackdrop("formSubmitBkdp");

        complete ? complete(response) : null;
    }, function (response) {
        // error
    }, method);
}

/**
 * Função para requisição ajax
 * 
 * @param {String} url 
 * @param {FormData} data 
 * @param {Function} success 
 * @param {Function} before 
 * @param {Function} complete 
 * @param {Function} error 
 * @param {String} method 
 */
function ajaxRequest(url, data = null, success = null, before = null, complete = null, error = null, method = 'POST') {
    $.ajax({
        type: method,
        url: url,
        data: data,
        dataType: "json",
        processData: false,
        contentType: false,
        timeout: 60000,

        beforeSend: function () {
            before ? before() : null;
        },

        success: function (response) {
            success(response);
        },

        complete: function (response) {
            complete ? complete(response) : null;
        },

        error: function (response) {
            complete ? error(response) : null;
        }
    });
}

/**
 * 
 * FUNÇÕES: ALERTS/MENSAGENS
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

    if (timeoutHandler)
        clearTimeout(timeoutHandler);
}

/**
 * @param {jQuery} alert
 */
function runTimer(alert) {
    timeoutHandler = setTimeout(function () {
        removeAlert(alert);
    }, timer * 1000);
}

/**
 *
 * FUNÇÕES: BACKDROP
 *
 */

/**
 * @param {String} id id para o backdrop
 * @param {String} position tipo de posicionamento. Padrão é 'absolute'
 * @param {jQuery} container onde inserir o backdrop.
 * @param {String} effect efeito do jquery-ui. Padrão é 'fade'
 */
function addBackdrop(id, position, container, effect) {
    let cntnr = container ?? $("body");
    let efct = effect ?? "fade";
    let bkdrop = $(`<div class="mbackdrop loading rounded" id="${id}"></div>`).css({
        "background-color": "rgb(0, 0, 0, 0.125)",
        width: "100%",
        height: "100%",
        position: position ?? "absolute",
        top: 0,
        left: 0,
        "z-index": 998,
    }).hide();

    cntnr.append(bkdrop.show(efct));
}

/**
 * @param {String} id id do backdrop a ser removido
 * @param {String} container local onde procurar o backdrop. Por padrão busca por todo o 'body'
 * @param {String} effect efeito do jquery-ui. Padrão é 'fade'
 */
function removeBackdrop(id, container, effect) {
    let cntnr = $(container ?? "body");
    let efct = effect ?? "fade";

    cntnr.find("#" + id).hide(efct, function () {
        $(this).remove();
    });
}

/**
 *
 * FUNÇÕES: BOTÕES
 *
 */

/**
 * @param {jQuery} buttonObject objeto jQuery do botão
 */
function addLoadingMode(buttonObject) {
    buttonObject
        .removeClass(buttonObject.attr("data-active-icon"))
        .addClass(buttonObject.attr("data-alt-icon"))
        .prop("disabled", true);
}

/**
 * @param {jQuery} buttonObject objeto jQuery do botão
 */
function removeLoadingMode(buttonObject) {
    buttonObject
        .addClass(buttonObject.attr("data-active-icon"))
        .removeClass(buttonObject.attr("data-alt-icon"))
        .prop("disabled", false);
}

/**
 * @param {jQuery} formObject
 * @param {Array} errs
 */
function addFormErrors(formObject, errs) {
    let fields = formObject.find("input, select, textarea");
    let errors = errs ?? [];

    if (!fields.length) return;

    $.each(fields, function (fieldKey, field) {
        let fieldObj = $(field);
        let fieldName = fieldObj.attr("name");

        if (errors[fieldName]) {
            let invalid = fieldObj.parent().find(".invalid-feedback");

            if (invalid.length) invalid.html(errors[fieldName]);
            else fieldObj.parent().append(`<div class="invalid-feedback">${errors[fieldName]}</div>`);

            fieldObj.addClass("is-invalid");
        } else {
            fieldObj
                .removeClass("is-invalid")
                .parent().find(".invalid-feedback").hide("fade", function () {
                    $(this).remove();
                });
        }
    });
}

/**
 * Alterna entre os ícones do botão
 * @param {JQuery} buttonObj 
 */
function altIcon(buttonObj) {
    let aci = buttonObj.attr("data-active-icon");
    let ali = buttonObj.attr("data-alt-icon");

    buttonObj.attr("data-active-icon", ali)
        .attr("data-alt-icon", aci)
        .removeClass(aci)
        .addClass(ali);
}