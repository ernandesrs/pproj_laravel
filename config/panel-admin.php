<?php

return [
    "sidebar" => [
        [
            "icon" => icon_class("grid"),
            "text" => "Dashboard",
            "title" => "",
            "route" => "admin.index",
            "target" => "_self",
            "activeIn" => ["admin.index"],
        ],
        [
            "icon" => icon_class("users"),
            "text" => "Usuários",
            "title" => "",
            "route" => "admin.users.index",
            "activeIn" => ["admin.users.index", "admin.users.create", "admin.users.edit"],
            "target" => "_self",
        ],
        [
            "icon" => icon_class("collection"),
            "text" => "Mídias",
            "title" => "",
            "target" => "_self",
            "activeIn" => ["admin.medias.images.index"],
            "items" => [
                [
                    "icon" => icon_class("images"),
                    "text" => "Imagens",
                    "title" => "",
                    "route" => "admin.medias.images.index",
                    "target" => "_self",
                    "activeIn" => ["admin.medias.images.index"],
                ],
            ],
        ],
        [
            "icon" => icon_class("grid1x2"),
            "text" => "Gerenciar " . config("app.name"),
            "title" => "",
            "target" => "_self",
            "activeIn" => ["admin.pages.index", "admin.pages.create", "admin.pages.edit"],
            "items" => [
                [
                    "icon" => icon_class("viewList"),
                    "text" => "Seções",
                    "title" => "",
                    "route" => "",
                    "activeIn" => [""],
                    "target" => "_self",
                ],
                [
                    "icon" => icon_class("pageEarmark"),
                    "text" => "Páginas",
                    "title" => "",
                    "route" => "admin.pages.index",
                    "activeIn" => ["admin.pages.index", "admin.pages.create", "admin.pages.edit"],
                    "target" => "_self",
                ]
            ]
        ],
        [
            "icon" => icon_class("linkExternalRight"),
            "text" => "Abrir o site",
            "title" => "",
            "route" => "front.index",
            "target" => "_blank",
            "activeIn" => [],
        ],
    ],
];
