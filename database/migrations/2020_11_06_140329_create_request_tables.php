<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request', function (Blueprint $table) {
            $table->id();
            $table->foreignId('studentId');
            $table->foreignId('projectId');
            $table->foreignId('spotId');
            $table->timestamps();
        });

        Schema::table('request', function (Blueprint $table) {
            $table->foreign('studentId')->references('id')->on('student');
            $table->foreign('projectId')->references('id')->on('project');
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
        Schema::dropIfExists('request');
    }
}
