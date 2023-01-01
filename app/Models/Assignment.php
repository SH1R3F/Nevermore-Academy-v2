<?php

namespace App\Models;

use App\Models\User;
use App\Models\Submission;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Assignment extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = ['title', 'requirement', 'teacher_id', 'deadline'];

    public $translatable = ['title', 'requirement'];

    protected $casts = [
        'deadline' => 'date:Y-m-d'
    ];

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function submissions(): HasMany
    {
        return $this->hasMany(Submission::class);
    }
}
