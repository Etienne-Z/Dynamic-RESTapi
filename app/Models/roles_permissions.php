<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class roles_permissions extends Model
{
    protected $fillable = [
        'role_id',
        'permission_id',
];
}
