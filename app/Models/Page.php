<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Rolandstarke\Thumbnail\Facades\Thumbnail;

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

    public $errors;

    /**
     * @param array $data
     * @param null|User $author
     * @return Page
     */
    public function set(array $data, ?User $author = null): Page
    {
        $validator = $this->validate($data);

        if (!$this->errors = $validator->errors()->messages()) {

            $filtered = $validator->validated();

            $this->title = $filtered["title"];
            $this->description = $filtered["description"];
            $this->lang = $filtered["lang"] ?? config("app.locale");

            // COVER
            $this->cover = $filtered["cover"] ?? null;

            $this->content_type = $filtered["content_type"];
            if ($this->content_type == self::CONTENT_TYPE_VIEW) {
                $this->content = json_encode([
                    "view_path" => ""
                ]);
            } elseif ($this->content_type == self::CONTENT_TYPE_TEXT) {
                $this->content = $filtered["content"] ?? null;
            }

            $this->status = $filtered["status"];
            if (empty($this->id))
                $this->author = $author->id;

            if ($this->status == self::STATUS_PUBLISHED) {
                $this->published_at = date("Y-m-d H:i:s");
                $this->scheduled_to = null;
            } elseif ($this->status == self::STATUS_SCHEDULED) {
                $this->published_at = null;
                $this->scheduled_to = $filtered["scheduled_to"];
            } else {
                $this->published_at = null;
                $this->scheduled_to = null;
            }
        }

        return $this;
    }

    /**
     * @param array $options
     * @return boolean
     */
    public function save(array $options = []): bool
    {
        if (empty($this->id))
            $slugs = new Slug();
        else
            $slugs = (new Slug())->find("id", $this->slug)->first();

        $slugs->set(\Illuminate\Support\Str::slug($this->title, "-"), $this->lang);
        if (!$slugs->save()) {
            $this->errors["slug"] = "Houve um erro ao salvar o slug";
            return false;
        }

        $this->slug = $slugs->id;

        if ($this->cover) {
            if ($this->original["cover"] ?? null) {
                Thumbnail::src(Storage::path($this->original["cover"]))->delete();
                Storage::delete($this->original["cover"]);
            }

            $path = $this->cover->store("public/pages/covers");
            $this->cover = $path;
        }

        if (!parent::save($options)) {
            Storage::delete($this->cover);
            return false;
        }

        return true;
    }

    /**
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validate(array $data): \Illuminate\Contracts\Validation\Validator
    {
        $rules = [
            "title" => ["required", "max:255"],
            "description" => ["required", "max:255"],
            "cover" => ["mimes:jpg,png,webp", "max:2048", Rule::dimensions()->minWidth(800)->minHeight(600)],
            "lang" => [Rule::in(config("app.locales") ?? [config("app.locale")])],
            "content_type" => ["required", Rule::in(self::CONTENT_TYPES)],
            "content" => [],
            "status" => ["required", Rule::in(self::STATUS)],
            "published_at" => ["date"],
            "scheduled_to" => ["required_if:status," . self::STATUS_SCHEDULED, "date"],
        ];
        return Validator::make($data, $rules);
    }
}
