<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToCharactersTable extends Migration
{
    public function up()
    {
        Schema::table('characters', function (Blueprint $table) {
            $table->unsignedBigInteger('scene_id')->nullable();
            $table->foreign('scene_id', 'scene_fk_10029079')->references('id')->on('backgrounds');
            $table->unsignedBigInteger('gender_id')->nullable();
            $table->foreign('gender_id', 'gender_fk_10029080')->references('id')->on('genders');
            $table->unsignedBigInteger('age_group_id')->nullable();
            $table->foreign('age_group_id', 'age_group_fk_10029081')->references('id')->on('age_groups');
            $table->unsignedBigInteger('body_type_id')->nullable();
            $table->foreign('body_type_id', 'body_type_fk_10029082')->references('id')->on('body_types');
            $table->unsignedBigInteger('hair_color_id')->nullable();
            $table->foreign('hair_color_id', 'hair_color_fk_10029083')->references('id')->on('hair_colors');
            $table->unsignedBigInteger('hair_lenght_id')->nullable();
            $table->foreign('hair_lenght_id', 'hair_lenght_fk_10029084')->references('id')->on('hair_lengths');
            $table->unsignedBigInteger('hair_style_id')->nullable();
            $table->foreign('hair_style_id', 'hair_style_fk_10029085')->references('id')->on('hair_styles');
            $table->unsignedBigInteger('head_shape_id')->nullable();
            $table->foreign('head_shape_id', 'head_shape_fk_10029492')->references('id')->on('head_shapes');
            $table->unsignedBigInteger('nose_shape_id')->nullable();
            $table->foreign('nose_shape_id', 'nose_shape_fk_10029508')->references('id')->on('nose_shapes');
            $table->unsignedBigInteger('mouth_shape_id')->nullable();
            $table->foreign('mouth_shape_id', 'mouth_shape_fk_10029509')->references('id')->on('mouth_shapes');
            $table->unsignedBigInteger('eye_shape_id')->nullable();
            $table->foreign('eye_shape_id', 'eye_shape_fk_10029087')->references('id')->on('eye_shapes');
            $table->unsignedBigInteger('eye_color_id')->nullable();
            $table->foreign('eye_color_id', 'eye_color_fk_10029086')->references('id')->on('eye_colors');
            $table->unsignedBigInteger('skin_tone_id')->nullable();
            $table->foreign('skin_tone_id', 'skin_tone_fk_10029088')->references('id')->on('skin_tones');
            $table->unsignedBigInteger('facial_expression_id')->nullable();
            $table->foreign('facial_expression_id', 'facial_expression_fk_10029089')->references('id')->on('facial_expressions');
            $table->unsignedBigInteger('emotion_id')->nullable();
            $table->foreign('emotion_id', 'emotion_fk_10029096')->references('id')->on('emotions');
            $table->unsignedBigInteger('dress_style_id')->nullable();
            $table->foreign('dress_style_id', 'dress_style_fk_10029090')->references('id')->on('dress_styles');
            $table->unsignedBigInteger('posture_id')->nullable();
            $table->foreign('posture_id', 'posture_fk_10029551')->references('id')->on('postures');
            $table->unsignedBigInteger('character_zoom_id')->nullable();
            $table->foreign('character_zoom_id', 'character_zoom_fk_10029545')->references('id')->on('zooms');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id', 'user_fk_10029092')->references('id')->on('users');
        });
    }
}
