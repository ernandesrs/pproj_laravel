<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    public const CONTENT_TYPE_TEXT = "text";
    public const CONTENT_TYPE_VIEW = "view";

    public const STATUS_DRAFT = "draft";
    public const STATUS_SCHEDULED = "scheduled";
    public const STATUS_PUBLISHED = "published";

    /**
     * Allowed content types
     * @param array<string>
     */
    public const CONTENT_TYPES = [self::CONTENT_TYPE_TEXT, self::CONTENT_TYPE_VIEW];

    /**
     * Allowed status
     * @param array<string>
     */
    public const STATUS = [self::STATUS_DRAFT, self::STATUS_SCHEDULED, self::STATUS_PUBLISHED];
}
