<?php

namespace App\Models;

use App\Models\Article;
use App\Models\Assignment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function articles()
    {
        return $this->morphedByMany(Article::class, 'taggable');
    }

    public function assignments()
    {
        return $this->morphedByMany(Assignment::class, 'taggable');
    }
}
