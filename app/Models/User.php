<?php

namespace App\Models;

use App\Traits\HasImage;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasImage;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email', 'username', 'first_name', 'last_name', 'phone_number', 'home_phone_number',
        'address', 'password', 'birthdate',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Methods
     */
    public function getFullName(): string
    {
        return "$this->first_name $this->last_name";
    }

    public function getDefaultAvatarPath(): string
    {
        return env(
            'DEFAULT_USER_AVATAR',
            'https://cdn-icons-png.flaticon.com/512/711/711769.png'
        );
    }

    public function getAvatarPath(): string
    {
        if (!$this->image) {
            return $this->getDefaultAvatarPath();
        }
        return $this->image->path;
    }

    public function hasRole(string $role_slug): bool
    {
        return $this->role->slug === $role_slug;
    }


    /**
     * Relationships
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }
}
