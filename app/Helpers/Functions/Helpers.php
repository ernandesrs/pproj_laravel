<?php

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
