<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FAQ extends Model
{
    use HasFactory;

    protected $table = 'faqs';

    protected $fillable = [
        'question',
        'answer',
        'category_id',
        'sort_order',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'category_id' => 'integer',
            'sort_order' => 'integer',
            'status' => 'boolean',
        ];
    }

    public function category()
    {
        return $this->belongsTo(FAQCategory::class, 'category_id');
    }
}