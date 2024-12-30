<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoutelistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('routelists', function (Blueprint $table) {
            $table->id();
            $table->string('route_name');
            $table->string('route_url')->unique();
            $table->string('route_hash')->unique();
            $table->text('route_description');
            $table->text('route_note')->nullable();
            $table->integer('route_grouping')->nullable();
            $table->string('to_role')->nullable();
            $table->integer('parent_menu_id')->nullable();
            $table->boolean('show_menu')->nullable();
            $table->boolean('skip_sub')->nullable();
            $table->boolean('dashboard_menu')->nullable();
            $table->string('font_awesome');
            $table->string('bulma_class_icon_bg');
            $table->integer('is_active')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('routelists');
    }
}
