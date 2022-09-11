<?php

use App\Models\Page;

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
