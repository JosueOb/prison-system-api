<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Ward extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'location', 'description'];

    protected $hidden = ['created_at', 'updated_at'];

    /**
     * Relations
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->wherePivot('state', true)
            ->withTimestamps();
    }
}
