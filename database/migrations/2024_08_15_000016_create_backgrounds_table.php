<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBackgroundsTable extends Migration
{
    public function up()
    {
        Schema::create('backgrounds', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('background_title');
            $table->longText('scene');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
