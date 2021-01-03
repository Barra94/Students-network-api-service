<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpotTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spot', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->foreignId('projectId');
            $table->foreignId('roleId')->nullable()->unsigned();
            $table->foreignId('studentId')->nullable()->unsigned();
            $table->timestamps();
        });

        Schema::table('spot', function (Blueprint $table) {
            $table->foreign('projectId')->references('id')->on('project');
            $table->foreign('roleId')->references('id')->on('role');
            $table->foreign('studentId')->references('id')->on('student');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('spot');
    }
}
