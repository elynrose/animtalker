<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBodyTypesTable extends Migration
{
    public function up()
    {
        Schema::create('body_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('body')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
