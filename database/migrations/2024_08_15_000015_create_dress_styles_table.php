<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDressStylesTable extends Migration
{
    public function up()
    {
        Schema::create('dress_styles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('style')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
