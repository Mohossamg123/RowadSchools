<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnnouncementBar extends Model
{
    use HasFactory;

    protected $fillable = [
        'message',
        'link_text',
        'link_url',
        'start_date',
        'end_date',
        'sort_order',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'datetime',
            'end_date' => 'datetime',
            'status' => 'boolean',
        ];
    }
}
