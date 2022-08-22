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
            "icon" => icon_class("pageEarmarkText"),
            "text" => "Páginas",
            "title" => "",
            "activeIn" => ["admin.pages.index", "admin.pages.create", "admin.pages.edit"],
            "target" => "_self",
            "items" => [
                [
                    "icon" => icon_class("list"),
                    "text" => "Listar páginas",
                    "title" => "",
                    "route" => "admin.pages.index",
                    "target" => "_self",
                    "activeIn" => ["admin.pages.index"]
                ],
                [
                    "icon" => icon_class("pagePlus"),
                    "text" => "Nova página",
                    "title" => "",
                    "route" => "admin.pages.create",
                    "target" => "_self",
                    "activeIn" => ["admin.pages.create"]
                ],
                [
                    "icon" => icon_class("pencilSquare"),
                    "text" => "Editar usuário",
                    "title" => "",
                    "route" => "",
                    "target" => "_self",
                    "activeIn" => ["admin.users.edit"],
                    "visibleIn" => ["admin.users.edit"]
                ]
            ],
        ],
        [
            "icon" => icon_class("linkExternalRight"),
            "text" => "Abrir o site",
            "title" => "",
            "route" => "front.index",
            "target" => "_blank",
            "activeIn" => [],
        ],
        [
            "icon" => icon_class("logout"),
            "text" => "Logout",
            "title" => "",
            "route" => "auth.logout",
            "target" => "_self",
            "activeIn" => [],
        ],
    ],
];
