<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Permission;
use App\Models\User;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'status' => 'boolean',
        ];
    }


    public function permissions()
{
    return $this->belongsToMany(
        Permission::class,
        'role_permissions'
    );
}

public function users()
{
    return $this->belongsToMany(
        User::class,
        'user_roles'
    );
}
}
