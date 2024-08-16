<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgeGroupsTable extends Migration
{
    public function up()
    {
        Schema::create('age_groups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('age')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
