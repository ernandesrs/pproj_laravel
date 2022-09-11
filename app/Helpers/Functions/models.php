<?php

use App\Models\User;
use App\Models\Page;

/**************************************************************
 * MODEL USER
 **************************************************************/

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

/**************************************************************
 * MODEL PAGE
 **************************************************************/

/**
 * Obtém array de tipos de conteúdo do modelo Page
 * @return array
 */
function m_page_content_types(): array
{
    return Page::CONTENT_TYPES;
}

/**
 * Obtém array de status de página do modelo Page
 * @return array
 */
function m_page_status(): array
{
    return Page::STATUS;
}

/**
 * Obtém array de tipos de proteção
 * @return array
 */
function m_page_protections(): array
{
    return Page::PROTECTIONS;
}
