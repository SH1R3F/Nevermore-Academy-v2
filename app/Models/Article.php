<?php

namespace App\Models;

use App\Models\Tag;
use App\Models\User;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

class Article extends Model implements TranslatableContract, HasMedia
{
    use HasFactory, Translatable, InteractsWithMedia;

    public $translatedAttributes = ['title', 'content'];
    protected $fillable = ['slug', 'author_id'];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public static function generateUniqueSlug($slug)
    {
        $n = static::where('slug', 'regexp', "^$slug(-\d+)?$")->count();
        return $n ? "$slug-$n" : $slug;
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }
}
