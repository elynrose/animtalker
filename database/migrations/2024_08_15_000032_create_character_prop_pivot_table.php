<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCharacterPropPivotTable extends Migration
{
    public function up()
    {
        Schema::create('character_prop', function (Blueprint $table) {
            $table->unsignedBigInteger('character_id');
            $table->foreign('character_id', 'character_id_fk_10029100')->references('id')->on('characters')->onDelete('cascade');
            $table->unsignedBigInteger('prop_id');
            $table->foreign('prop_id', 'prop_id_fk_10029100')->references('id')->on('props')->onDelete('cascade');
        });
    }
}
