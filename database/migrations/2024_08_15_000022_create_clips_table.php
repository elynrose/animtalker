<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClipsTable extends Migration
{
    public function up()
    {
        Schema::create('clips', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->longText('script');
            $table->string('image_path')->nullable();
            $table->string('custom_prompt')->nullable();
            $table->boolean('i_own_music')->default(0)->nullable();
            $table->string('status')->nullable();
            $table->string('voice')->nullable();
            $table->string('audio_path')->nullable();
            $table->integer('saved')->nullable();
            $table->integer('cost')->nullable();
            $table->string('video_path')->nullable();
            $table->time('duration')->nullable();
            $table->integer('minutes')->nullable();
            $table->integer('seconds')->nullable();
            $table->string('video_id')->nullable();
            $table->string('privacy')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
