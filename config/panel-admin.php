<?php

return [
    "sidebar" => [
        [
            "icon" => "bi bi-grid-fill",
            "text" => "Dashboard",
            "title" => "",
            "route" => "admin.home",
            "target" => "_self",
            "activeIn" => ["admin.home"],
        ],
        [
            "icon" => "bi bi-people-fill",
            "text" => "Gerenciar membros",
            "title" => "",
            "activeIn" => ["admin.users.index", "admin.users.create", "admin.users.edit"],
            "target" => "_self",
            "items" => [
                [
                    "icon" => "bi bi-list",
                    "text" => "Listar membros",
                    "title" => "",
                    "route" => "admin.users.index",
                    "target" => "_self",
                    "activeIn" => ["admin.users.index"]
                ],
                [
                    "icon" => "bi bi-person-plus-fill",
                    "text" => "Novo",
                    "title" => "",
                    "route" => "admin.users.create",
                    "target" => "_self",
                    "activeIn" => ["admin.users.create"]
                ],
                [
                    "icon" => "bi bi-pencil-square",
                    "text" => "Editar usuário",
                    "title" => "",
                    "route" => "",
                    "target" => "_self",
                    "activeIn" => ["admin.users.edit"],
                    "visibleIn" => ["admin.users.edit"]
                ]
            ]
        ],
        [
            "icon" => "bi bi-box-arrow-up-right",
            "text" => "Abrir o site",
            "title" => "",
            "route" => "front.home",
            "target" => "_blank",
            "activeIn" => [],
        ],
        [
            "icon" => "bi bi-box-arrow-left",
            "text" => "Logout",
            "title" => "",
            "route" => "auth.logout",
            "target" => "_self",
            "activeIn" => [],
        ],
    ],
];
