<?php

return [
    "sidebar" => [
        [
            "icon" => "bi bi-grid-fill",
            "text" => "Dashboard",
            "title" => "",
            "route" => "member.index",
            "target" => "_self",
            "activeIn" => ["member.index"],
        ],
        [
            "icon" => "bi bi-diagram-3-fill",
            "text" => "Example",
            "title" => "",
            "target" => "_self",
            "activeIn" => ['member.example', 'member.exampleTwo'],
            "items" => [
                [
                    "icon" => "bi bi-app-indicator",
                    "text" => "Account Information",
                    "title" => "",
                    "route" => "member.example",
                    "target" => "_self",
                    "activeIn" => ['member.example'],
                ],
                [
                    "icon" => "bi bi-app-indicator",
                    "text" => "Direct Refferals",
                    "title" => "",
                    "route" => "member.exampleTwo",
                    "target" => "_self",
                    "activeIn" => ['member.exampleTwo'],
                ],
                [
                    "icon" => "bi bi-app-indicator",
                    "text" => "Binary Log",
                    "title" => "",
                    "route" => "member.example",
                    "target" => "_self",
                    "activeIn" => ['member.example'],
                ]
            ],
        ],
        [
            "icon" => "bi bi-person-lines-fill",
            "text" => "Profile",
            "title" => "",
            "route" => "member.profile",
            "target" => "_self",
            "activeIn" => ["member.profile"],
        ],
        [
            "icon" => "bi bi-box-arrow-up-right",
            "text" => "Abrir o site",
            "title" => "",
            "route" => "front.index",
            "target" => "_blank",
            "activeIn" => [],
        ]
    ],
];
