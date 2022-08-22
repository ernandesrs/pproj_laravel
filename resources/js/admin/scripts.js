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

});
