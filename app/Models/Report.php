<?php

namespace App\Models;

use App\Traits\HasImage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Report extends Model
{
    use HasFactory, HasImage;

    protected $fillable = ['title', 'description'];

    /**
     * Relationships
     *
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)
            ->where('state', true);
    }
}
