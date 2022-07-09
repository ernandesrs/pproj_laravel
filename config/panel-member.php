<?php

return [
    "sidebar" => [
        [
            "icon" => "bx bxs-dashboard",
            "text" => "Dashboard",
            "title" => "",
            "route" => "member.home",
            "target" => "_self",
            "activeIn" => ["member.home"],
        ],
        [
            "icon" => "bx bxs-network-chart",
            "text" => "Example",
            "title" => "",
            "activeIn" => ['member.example', 'member.exampleTwo'],
            "items" => [
                [
                    "icon" => "bx bxs-square-rounded",
                    "text" => "Account Information",
                    "title" => "",
                    "route" => "member.example",
                    "target" => "_self",
                    "activeIn" => ['member.example'],
                ],
                [
                    "icon" => "bx bxs-square-rounded",
                    "text" => "Direct Refferals",
                    "title" => "",
                    "route" => "member.exampleTwo",
                    "target" => "_self",
                    "activeIn" => ['member.exampleTwo'],
                ],
                [
                    "icon" => "bx bxs-square-rounded",
                    "text" => "Binary Log",
                    "title" => "",
                    "route" => "member.example",
                    "target" => "_self",
                    "activeIn" => ['member.example'],
                ]
            ],
        ],
        [
            "icon" => "bx bxs-square-rounded",
            "text" => "Example 2",
            "title" => "",
            "activeIn" => [],
            "items" => [
                [
                    "icon" => "bx bx-square-rounded",
                    "text" => "Account Information",
                    "title" => "",
                    "route" => "",
                    "target" => "_self",
                    "activeIn" => [],
                ],
                [
                    "icon" => "bx bx-square-rounded",
                    "text" => "Direct Refferals",
                    "title" => "",
                    "route" => "",
                    "target" => "_self",
                    "activeIn" => [],
                ]
            ],
        ],
        [
            "icon" => "bx bxs-user-detail",
            "text" => "Profile",
            "title" => "",
            "route" => "front.home",
            "target" => "_self",
            "activeIn" => [],
        ],
        [
            "icon" => "bx bx-log-out",
            "text" => "Logout",
            "title" => "",
            "route" => "front.home",
            "target" => "_self",
            "activeIn" => [],
        ],
    ],
];
