<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHairColorsTable extends Migration
{
    public function up()
    {
        Schema::create('hair_colors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('color')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
