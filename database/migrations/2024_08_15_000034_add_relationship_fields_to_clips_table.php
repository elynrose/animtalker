<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToClipsTable extends Migration
{
    public function up()
    {
        Schema::table('clips', function (Blueprint $table) {
            $table->unsignedBigInteger('character_id')->nullable();
            $table->foreign('character_id', 'character_fk_10029474')->references('id')->on('characters');
        });
    }
}
