<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Interfaces\MustVerifyMobile as MustVerifyMobileInterface;
use App\Models\Role;
use App\Traits\HasRoles;
use App\Models\Assignment;
use App\Traits\MustVerifyMobile;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyMobileInterface, MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, MustVerifyMobile;

    const MOBILE_FORMAT = "/^01[0125][0-9]{8}$/";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'mobile',
        'password',
        'mobile_verification_code',
        'role_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'mobile_verification_code'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'mobile_verified_at' => 'datetime',
    ];

    public function getPhoneNumberAttribute()
    {
        // We suppose all our users are Egyptian.
        // Otherwise I would add another column and ask user to enter his country code.
        return "+2{$this->mobile}"; // Ex; +201003322304
    }

    /**
     * Tell twilio the notifiable (user) phone number
     */
    public function routeNotificationForTwilio()
    {
        return $this->phone_number;
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(Assignment::class, 'teacher_id');
    }
}
