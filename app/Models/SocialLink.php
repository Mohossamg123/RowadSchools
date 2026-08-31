<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SocialLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'url',
        'icon',
        'type',
        'sort_order',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'status' => 'boolean',
        ];
    }
    
    public function clicks(): HasMany
{
    return $this->hasMany(LinkClick::class);
}

}
