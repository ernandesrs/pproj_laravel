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

    public const PROTECTION_NONE = 1;
    public const PROTECTION_AUTHOR = 2;
    public const PROTECTION_SYSTEM = 9;

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

    public const PROTECTIONS = [self::PROTECTION_NONE, self::PROTECTION_AUTHOR, self::PROTECTION_SYSTEM];

    /**
     * @return Slug|null
     */
    public function slugs(): ?Slug
    {
        return $this->hasOne(Slug::class, "id", "slug")->get()->first();
    }

    /**
     * @return User|null
     */
    public function author(): ?User
    {
        return $this->hasOne(User::class, "id", "author")->get()->first();
    }
}
