<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TuitionFeeSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'is_enabled',
        'seo_indexable',
    ];

    protected function casts(): array
    {
        return [
            'is_enabled' => 'boolean',
            'seo_indexable' => 'boolean',
        ];
    }
}
