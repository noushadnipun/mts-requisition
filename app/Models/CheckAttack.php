<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class CheckAttack extends Model
{
    use HasFactory;
    protected $table = 'check_attack';

    protected $fillable = [
        'id', 'attack_name', 'attack_content', 'attack_by'
    ];
}