<?php

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    public const TYPE_SECTION = "section";
    public const TYPE_BANNER = "banner";
    public const TYPES = [
        self::TYPE_SECTION,
        self::TYPE_BANNER
    ];

    public const ALIGNMENT_LEFT = "left";
    public const ALIGNMENT_CENTER = "center";
    public const ALIGNMENT_RIGHT = "right";
    public const ALIGNMENTS = [
        self::ALIGNMENT_LEFT,
        self::ALIGNMENT_CENTER,
        self::ALIGNMENT_RIGHT
    ];

    use HasFactory;
}
