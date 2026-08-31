<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EducationalStage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'icon',
        'age_from',
        'age_to',
        'features',
        'sort_order',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'status' => 'boolean',
            'age_from' => 'integer',
            'age_to' => 'integer',
            'features' => 'array',
        ];
    }

    public function grades(): HasMany
    {
        return $this->hasMany(Grade::class)
            ->orderBy('sort_order');
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(StudentRegistration::class);
    }
}
