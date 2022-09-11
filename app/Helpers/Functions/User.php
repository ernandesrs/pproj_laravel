<?php

use App\Models\User;

/**
 * Obtém array de gêneros do modelo User
 * @return array
 */
function m_user_genders(): array
{
    return User::GENDERS;
}

/**
 * Obtém array de níveis de usuário do modelo User
 * @return array
 */
function m_user_levels(): array
{
    return User::LEVELS;
}
