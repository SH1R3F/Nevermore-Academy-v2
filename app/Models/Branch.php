<?php

namespace App\Models;

use App\Casts\Location;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'location'
    ];

    protected $casts = [
        'location' => Location::class
    ];
}
