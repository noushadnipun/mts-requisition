<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Routelist extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'route_name', 'route_url', 'route_hash', 'route_description', 'route_note', 'route_grouping', 'to_role',
        'parent_menu_id', 'show_menu', 'skip_sub', 'dashboard_menu', 'font_awesome', 'bulma_class_icon_bg', 'is_active', 'created_at', 'updated_at'
    ];
}
