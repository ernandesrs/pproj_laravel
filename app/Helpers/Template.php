<?php

namespace App\Helpers;

class Template
{
    /**
     * @param string $style
     * @param string $class
     * @param string $message
     * @param string $action
     * @param string|null $icon
     * @param string|null $text
     * @return array
     */
    public static function button_confirmation(string $style, string $class, string $message, string $action, ?string $icon = null, ?string $text = null): array
    {
        return self::button_confirmation_data("button", $style, $class, $message, $action, $icon, $text);
    }

    /**
     * @param string $style
     * @param string $class
     * @param string $message
     * @param string $action
     * @param string|null $icon
     * @param string|null $text
     * @return array
     */
    public static function button_link_confirmation(string $style, string $class, string $message, string $action, ?string $icon = null, ?string $text = null): array
    {
        return self::button_confirmation_data("link", $style, $class, $message, $action, $icon, $text);
    }

    /**
     * @param string $type
     * @param string $style
     * @param string $class
     * @param string $message
     * @param string $action
     * @param string|null $icon
     * @param string|null $text
     * @return array
     */
    private static function button_confirmation_data(string $type, string $style, string $class, string $message, string $action, ?string $icon = null, ?string $text = null): array
    {
        return [
            "btnType" => $type,
            "btnStyle" => $style,
            "btnClass" => $class,
            "btnMessage" => $message,
            "btnAction" => $action,
            "btnIcon" => $icon,
            "btnText" => $text,
        ];
    }
}
