<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDressColorsTable extends Migration
{
    public function up()
    {
        Schema::create('dress_colors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('color')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
