<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SocialMediaAccount extends Model
{
    protected $fillable = [
        'platform',
        'username',
        'url',
        'access_token',
        'status',
        'last_synced_at',
    ];

    protected $casts = [
        'status' => 'boolean',
        'last_synced_at' => 'datetime',
        'access_token' => 'encrypted',
    ];

    protected $hidden = [
        'access_token',
    ];

    public function posts(): HasMany
    {
        return $this->hasMany(
            SocialMediaPost::class
        );
    }
}
