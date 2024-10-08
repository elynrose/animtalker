<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCharactersTable extends Migration
{
    public function up()
    {
        Schema::create('characters', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->boolean('is_realistic')->nullable();
            $table->string('caption')->nullable();
            $table->longText('custom_prompt')->nullable();
            $table->string('avatar_url')->nullable();
            $table->string('aspect_ratio')->nullable();
            $table->string('art_style')->nullable();
            $table->integer('parent_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
