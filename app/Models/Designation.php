<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'name', 'description', 'is_group', 'is_active', 'created_at', 'updated_at'
    ];
}
