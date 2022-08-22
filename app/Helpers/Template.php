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
    public static function buttonConfirmation(string $style, string $class, string $message, string $action, ?string $icon = null, ?string $text = null): array
    {
        return self::buttonConfirmationData("button", $style, $class, $message, $action, $icon, $text);
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
    public static function buttonLinkConfirmation(string $style, string $class, string $message, string $action, ?string $icon = null, ?string $text = null): array
    {
        return self::buttonConfirmationData("link", $style, $class, $message, $action, $icon, $text);
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
    private static function buttonConfirmationData(string $type, string $style, string $class, string $message, string $action, ?string $icon = null, ?string $text = null): array
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

    /**
     * @param string $class
     * @param string $action
     * @param string|null $id
     * @param string|null $icon
     * @param string|null $text
     * @param string|null $altIcon
     * @return array
     */
    public static function button(string $class, string $action, ?string $id = null, ?string $icon = null, ?string $text = null, ?string $altIcon = null): array
    {
        return self::buttonData("button", $class, $action, $id, $icon, $text, $altIcon);
    }

    /**
     * @param string $class
     * @param string $action
     * @param string|null $id
     * @param string|null $icon
     * @param string|null $text
     * @param string|null $altIcon
     * @return array
     */
    public static function buttonLink(string $class, string $action, ?string $id = null, ?string $icon = null, ?string $text = null, ?string $altIcon = null): array
    {
        return self::buttonData("link", $class, $action, $id, $icon, $text, $altIcon);
    }

    /**
     * @param string $type
     * @param string $class
     * @param string $action
     * @param string|null $id
     * @param string|null $icon
     * @param string|null $text
     * @param string|null $altIcon
     * @return array
     */
    private function buttonData(string $type, string $class, string $action, ?string $id = null, ?string $icon = null, ?string $text = null, ?string $altIcon = null): array
    {
        return [
            "btnType" => $type,
            "btnClass" => $class,
            "btnAction" => $action,
            "btnId" => $id,
            "btnIcon" => $icon,
            "btnText" => $text,
            "btnAltIcon" => $altIcon,
        ];
    }
}
