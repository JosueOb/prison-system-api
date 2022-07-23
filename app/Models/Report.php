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
     * Methods
     */
    public function getDefaultReportImagePath(): string
    {
        return env(
            'DEFAULT_REPORT_IMAGE_PATH',
            'DEFAULT_REPORT_IMAGE_PATH=https://lifeskillsaustralia.com.au/wp-content/uploads/2019/07/assessment.png'
        );
    }

    public function getImagePath(): string
    {
        if (!$this->image) {
            return $this->getDefaultReportImagePath();
        }
        return $this->image->path;
    }

    /**
     * Relationships
     *
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
