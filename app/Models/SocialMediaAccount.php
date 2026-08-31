<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialMediaAccount extends Model
{
    protected $fillable = [
        'platform',
        'media_url',
        'embed_url',
        'link_url',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];
}
