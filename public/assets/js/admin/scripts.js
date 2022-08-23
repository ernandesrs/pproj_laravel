$(function () {

    $(document).on("click", ".jsBtnMenuToggler", function (e) {
        e.preventDefault();
        let button = $(this);
        let sidebar = $("#sidebar");

        if (sidebar.hasClass("sidebar-visible")) {
            button.remove();

            sidebar.hide("slide", 125, function () {
                sidebar.removeClass("sidebar-visible").attr("style", "");
            });

            $(document).find("#sidebarBkdrop").hide("fade", 250, function () {
                $(this).remove();
            });
        } else {
            let buttonClone = button.clone();

            sidebar.show("slide", 250, function () {
                $(this).addClass("sidebar-visible").attr("style", "");

                $("body").prepend(buttonClone.css({
                    "position": "fixed",
                    "z-index": 999,
                    "left": sidebar.width(),
                    "top": "0",
                    "color": "#fcfcfc"
                }));

                altIcon(buttonClone);
            });

            $("body").prepend($(`<div class="mbackdrop fixed" id="sidebarBkdrop"></div>`).hide().show("fade", 250));
        }

    });

    $(".jsShowMoreFilters").on("click", function (e) {
        e.preventDefault();
        altIcon($(this));
    });

    /**
     * 
     * ImageToolsModal Scripts
     * 
     */

    let modalImageTools = $("#jsImageToolsModal");

    /**
     * Botão de abrir o modal
     */
    $(".jsOpenImageToolsModal").on("click", function (e) {
        let button = $(this);

        ajaxRequest(button.attr("data-action"), null, function (response) {
            // START: SUCCESS FUNCTION
            if (response.images.total == 0) {
                modalImageTools.find(".modal-image-list .modal-list .loading-images").text("Não há nenhuma imagem");
                return;
            }

            modalImageTools.find(".modal-image-list .modal-list .loading-images").remove();
            $.each(response.images.data, function (index, value) {
                let clone = modalImageTools.find(".model .modal-image-list-item").clone().hide();

                clone.find(".img-fluid").attr("src", value.thumb).attr("alt", value.name);

                modalImageTools.find(".modal-image-list .modal-list").append(clone.show("fade"));
            });

            modalImageTools.find(".modal-image-pagination").html(response.pagination);
            modalImageTools.find(".modal-image-upload").find("button[type=submit]").text("Salvar imagem");
            modalImageTools.find(".modal-image-upload").find(".jsFormSubmit")
                .removeClass("jsFormSubmit")
                .addClass("jsImageToolsImageUploadFormSubmit")
                .attr("action", button.attr("data-action"));

            modalImageTools.modal();
            // END: SUCCESS FUNCTION
        }, function () {
            // beforeSend
            modalImageTools.find(".modal-image-list").find(".modal-list").html(`<div class="col-12 text-center py-3 loading-images">Carregando...</div>`);
        }, null, null, 'GET');

    });

    /**
     * Monitora submissão do formulário de upload de imagem do modal ImageTools
     */
    modalImageTools.on("submit", ".jsImageToolsImageUploadFormSubmit", function (e) {

        formSubmit($(this), e, function (response) {

        }, null);

    });

});
