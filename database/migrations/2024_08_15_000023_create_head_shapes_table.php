<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHeadShapesTable extends Migration
{
    public function up()
    {
        Schema::create('head_shapes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('shape')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
