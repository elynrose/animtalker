<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCharacterDressColorPivotTable extends Migration
{
    public function up()
    {
        Schema::create('character_dress_color', function (Blueprint $table) {
            $table->unsignedBigInteger('character_id');
            $table->foreign('character_id', 'character_id_fk_10029562')->references('id')->on('characters')->onDelete('cascade');
            $table->unsignedBigInteger('dress_color_id');
            $table->foreign('dress_color_id', 'dress_color_id_fk_10029562')->references('id')->on('dress_colors')->onDelete('cascade');
        });
    }
}
