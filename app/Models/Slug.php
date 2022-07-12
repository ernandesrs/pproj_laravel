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
            $slugs = json_decode($this->slugs);

        $slugs[$lang] = $slug;

        $this->slugs = json_encode($slugs);

        return $this;
    }
}
