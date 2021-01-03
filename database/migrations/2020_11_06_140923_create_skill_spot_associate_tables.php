<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSkillSpotAssociateTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('skill_spot', function (Blueprint $table) {
            $table->primary(['skillId', 'spotId']);
            $table->foreignId('skillId');
            $table->foreignId('spotId');
            $table->integer('level');
            $table->timestamps();
        });

        Schema::table('skill_spot', function (Blueprint $table) {
            $table->foreign('skillId')->references('id')->on('skill');
            $table->foreign('spotId')->references('id')->on('spot');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('skill_spot');
    }
}
