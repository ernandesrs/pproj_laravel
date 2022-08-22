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
            "route" => "admin.pages.index",
            "activeIn" => ["admin.pages.index", "admin.pages.create", "admin.pages.edit"],
            "target" => "_self",
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
