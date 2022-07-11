<?php

use Illuminate\Support\Facades\Storage;

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
    return "icon " . config("app-icons." . $name);
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
 * @param \App\Models\User $user
 * @param string|array $size pode ser 'small', 'normal', 'medium', 'large', ou array com as dimensões desejadas, exemplo: [100, 100]
 * @return string
 */
function m_user_photo_thumb(\App\Models\User $user, $size = "normal"): string
{
    $predefinedDimensions = [
        "small" => [75, 75],
        "normal" => [250, 250],
        "medium" => [500, 500],
        "large" => [720, 720],
    ];

    $dimensions = is_array($size) ? $size : $predefinedDimensions[$size] ?? $predefinedDimensions["normal"];

    $width = $dimensions[0];
    $height = $dimensions[1];

    if ($user->photo && file_exists(Storage::path($user->photo))) {
        $photo = Storage::path($user->photo);
        $thumb = \Rolandstarke\Thumbnail\Facades\Thumbnail::src($photo)->crop($width, $height);
        return $thumb->url();
    }

    $hash = md5(strtolower(trim($user->email)));

    return "https://www.gravatar.com/avatar/{$hash}?s={$width}&d=robohash";
}

/**
 *
 * Funções helpers para o modelo User
 * MODELS
 *
 */

/**
 * Obtém array de gêneros do modelo User
 * @return array
 */
function m_user_genders(): array
{
    return \App\Models\User::GENDERS;
}

/**
 * Obtém array de níveis de usuário do modelo User
 * @return array
 */
function m_user_levels(): array
{
    return \App\Models\User::LEVELS;
}
