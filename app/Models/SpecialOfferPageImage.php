<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SpecialOfferPageImage extends Model
{
    protected $fillable = [
        'special_offer_page_id',
        'image',
        'alt_text',
        'sort_order',
    ];

    public function page(): BelongsTo
    {
        return $this->belongsTo(
            SpecialOfferPage::class,
            'special_offer_page_id'
        );
    }
}
