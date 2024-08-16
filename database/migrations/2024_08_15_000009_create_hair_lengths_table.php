<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHairLengthsTable extends Migration
{
    public function up()
    {
        Schema::create('hair_lengths', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('lenght')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
