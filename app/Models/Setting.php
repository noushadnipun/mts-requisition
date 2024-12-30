<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'settings', 'is_active', 'created_at', 'updated_at'
    ];
  
  public static function timeSettings($fieldName){
  	$setting = Setting::where('id', 3)->first();
  	 if (!empty($setting)) {
       $fields = json_decode($setting->settings);
       return $fields->$fieldName ?? null;
     }
  }
  
    public static function otherSettings($fieldName){
  	$setting = Setting::where('id', 5)->first();
  	 if (!empty($setting)) {
       $fields = json_decode($setting->settings);
       return $fields->$fieldName ?? null;
     }
  }
}
