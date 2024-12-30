<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Attack extends Model
{
    use HasFactory;
    protected $table = 'attack';
    private $model = 'attack';

    protected $fillable = [
        'id', 'session_id', 'user_id', 'javascript_value'
    ];

    public static function insertOrUpdate(array $att, array $match)
    {
        return DB::table('attack')->updateOrInsert($match, $att);
        //dd($att);
        //return self::model->updateOrInsert($att, $match);
    }
}
