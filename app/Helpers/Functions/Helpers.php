<?php

/**
 * @param [type] $data
 * @param [type] $key
 * @return null|string
 */
function input_value($data, $key)
{
    if (!$data) {
        return null;
    }
    $data = is_array($data) ? (object) $data : $data;
    return $data->$key;
}


/**
 *
 * MODELS
 *
 *
 */

/**
 * @return array
 */
function m_user_genders(): array
{
    return \App\Models\User::GENDERS;
}

/**
 * @return array
 */
function m_user_levels(): array
{
    return \App\Models\User::LEVELS;
}
