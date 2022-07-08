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

                if (response.message) {
                    messageArea.html(response.message);
                }

                addFormErrors(form, response.errors);
            }
        });
    };


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

}(jQuery));
