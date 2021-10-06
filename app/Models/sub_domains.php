<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sub_domains extends Model
{
    protected $fillable = [
        'domain_name',
        'user_id',
        'domain_id',
        'domain_type',
];}
