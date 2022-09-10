<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    public const CONTENT_TYPE_TEXT = 1;
    public const CONTENT_TYPE_VIEW = 2;

    public const STATUS_DRAFT = 1;
    public const STATUS_SCHEDULED = 2;
    public const STATUS_PUBLISHED = 3;

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
     * @param string $slug
     * @param string $lang
     * @return Page|null
     */
    public static function findBySlug(string $slug, string $lang): ?Page
    {
        $slug = Slug::where($lang, $slug)->first();
        if (!$slug) return null;

        $page = Page::where("slug_id", $slug->id)->where("lang", $lang)->first();
        if (!$page) return null;

        if ($page->content_type == self::CONTENT_TYPE_VIEW)
            $page->content = json_decode($page->content);

        return $page;
    }


    /**
     * @param array $validatedData
     * @return string
     */
    public function getContent(array $validatedData): string
    {
        if ($validatedData["content_type"] == self::CONTENT_TYPE_VIEW) {
            $content = [
                "view_path" => $validatedData["view_path"]
            ];
            return json_encode($content);
        }

        return $validatedData["content"];
    }

    /**
     * @return Slug|null
     */
    public function slugs(): ?Slug
    {
        return $this->hasOne(Slug::class, "id", "slug_id")->get()->first();
    }

    /**
     * @return User|null
     */
    public function author(): ?User
    {
        return $this->hasOne(User::class, "id", "author_id")->get()->first();
    }
}
