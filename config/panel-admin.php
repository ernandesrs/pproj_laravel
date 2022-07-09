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
