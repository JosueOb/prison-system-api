<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Jail extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'code', 'type', 'capacity', 'description', 'ward_id'];

    protected $hidden = ['created_at', 'updated_at', 'code', 'description', 'ward_id'];

    /**
     * Relationships
     *
     */
    public function ward(): BelongsTo
    {
        return $this->belongsTo(Ward::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->wherePivot('state', true)
            ->withTimestamps();
    }
}
