<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slug extends Model
{
    use HasFactory;

    /**
     * @param string $slug
     * @param string $lang
     * @return Slug
     */
    public function set(string $slug, string $lang): Slug
    {
        $slugs = [];
        if (!empty($this->id))
            $slugs = (array) json_decode($this->slugs);

        $slugs[$lang] = $slug;

        $this->slugs = json_encode($slugs);

        return $this;
    }

    /**
     * @param string $lang
     * @return string|null
     */
    public function slug(string $lang): ?string
    {
        if (empty($this->id)) return null;

        $slugs = (array) json_decode($this->slugs);

        return $slugs[$lang] ?? null;
    }
}
