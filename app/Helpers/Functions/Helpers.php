<?php

use App\Helpers\Message\Message;

/**
 * Obtém valor de $data
 * @param [type] $data
 * @param [type] $key
 * @return null|string
 */
function input_value($data, $key)
{
    if (!$data) return null;

    $data = is_array($data) ? (object) $data : $data;

    return $data->$key ?? null;
}

/**
 * @param string $name
 * @return string
 */
function icon_class(string $name): string
{
    return "icon " . config("icons." . $name);
}

/**
 * @param string $name
 * @param string|null $alt
 * @return string
 */
function icon_elem(string $name, ?string $alt = null): string
{
    $activeIcon = icon_class($name);
    $altIcon = $alt ? "data-active-icon='{$activeIcon}' data-alt-icon='" . icon_class($alt) . "'" : null;
    echo "<span class='{$activeIcon}' {$altIcon}></span>";
    return "";
}

/**
 * @return Message
 */
function message(): Message
{
    return (new Message());
}
