<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSkinTonesTable extends Migration
{
    public function up()
    {
        Schema::create('skin_tones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tone')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
