<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SocialMediaPost extends Model
{
    protected $fillable = [
        'social_media_account_id',
        'external_id',
        'content',
        'post_url',
        'media_url',
        'published_at',
        'status',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'status' => 'boolean',
    ];

    public function account(): BelongsTo
    {
        return $this->belongsTo(
            SocialMediaAccount::class,
            'social_media_account_id'
        );
    }
}
