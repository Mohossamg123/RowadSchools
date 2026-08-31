<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SpecialOfferPage extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'is_active',
        'noindex',
        'nofollow',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'noindex' => 'boolean',
        'nofollow' => 'boolean',
    ];

    public function images(): HasMany
    {
        return $this->hasMany(
            SpecialOfferPageImage::class
        )->orderBy('sort_order');
    }
}
