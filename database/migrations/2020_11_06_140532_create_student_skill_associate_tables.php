<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentSkillAssociateTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_skill', function (Blueprint $table) {
            $table->primary(['studentId', 'skillId']);
            $table->foreignId('studentId');
            $table->foreignId('skillId');
            $table->integer('level')->nullable();
            $table->timestamps();
        });

        Schema::table('student_skill', function (Blueprint $table) {
            $table->foreign('studentId')->references('id')->on('student');
            $table->foreign('skillId')->references('id')->on('skill');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_skill');
    }
}
