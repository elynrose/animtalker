<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEyeShapesTable extends Migration
{
    public function up()
    {
        Schema::create('eye_shapes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('shape')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
