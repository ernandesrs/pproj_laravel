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
                insertTextOnImageList("Não há nenhuma imagem");
                return;
            }

            listImages(response);

            modalImageTools.find(".modal-image-upload").find("button[type=submit]").text("Salvar imagem");
            modalImageTools.find(".modal-image-upload").find(".jsFormSubmit")
                .removeClass("jsFormSubmit")
                .addClass("jsImageToolsImageUploadFormSubmit")
                .attr("action", button.attr("data-action"));

            // END: SUCCESS FUNCTION
        }, function () {
            // beforeSend
            insertTextOnImageList("Carregando...");
            modalImageTools.modal();
        }, null, null, 'GET');

    });

    /**
     * Monitora clique nos links de navegação
     */
    modalImageTools.find(".modal-image-pagination").on("click", ".page-link", function (e) {
        e.preventDefault();

        ajaxRequest($(this).attr("href"), null, function (response) {
            listImages(response);
        }, null, null, null, 'GET');
    });

    /**
     * Monitora submissão do formulário de busca
     */
    modalImageTools.on("submit", ".jsImageToolsSearchFormSubmit", function (e) {
        formSubmit($(this), e, function (response) {
            if (response.images.data.length == 0) {
                insertTextOnImageList("Sem resultados para sua busca");
                modalImageTools.find(".modal-image-pagination").html(response.pagination);
                return;
            }

            listImages(response);
        }, null);

    });

    /**
     * Monitora submissão do formulário de upload de imagem do modal ImageTools
     */
    modalImageTools.on("submit", ".jsImageToolsImageUploadFormSubmit", function (e) {
        formSubmit($(this), e, function (response) {
            console.log("image uploaded");
        }, null);

    });

    /**
     * @param {*} response
     */
    function listImages(response) {
        modalImageTools.find(".modal-image-list .modal-list").html("");

        $.each(response.images.data, function (index, value) {
            let clone = modalImageTools.find(".model .modal-image-list-item").clone().hide();

            clone.find(".img-fluid").attr("src", value.thumb).attr("alt", value.name);
            clone.find("#image_id").val(value.id);
            clone.find("#image_name").val(value.name);
            clone.find("#image_url").val(value.url);
            clone.find("#image_thumb").val(value.thumb);

            modalImageTools.find(".modal-image-list .modal-list").append(clone.show("fade"));
        });

        modalImageTools.find(".modal-image-pagination").html(response.pagination);
    }

    /**
     * @param {String} text 
     */
    function insertTextOnImageList(text) {
        let textArea = modalImageTools.find(".modal-image-list-text");

        if (textArea.length == 0) {
            modalImageTools.find(".modal-image-list .modal-list").html(`<div class="col-12 text-center py-3 modal-image-list-text"></div>`);
            textArea = modalImageTools.find(".modal-image-list-text");
        }

        textArea.html(text);
    }
});
