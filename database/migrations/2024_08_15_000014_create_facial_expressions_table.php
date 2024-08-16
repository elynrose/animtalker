<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacialExpressionsTable extends Migration
{
    public function up()
    {
        Schema::create('facial_expressions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('expression')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
