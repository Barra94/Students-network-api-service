<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student', function (Blueprint $table) {
            $table->id();
            $table->string('fontysId')->unique();
            $table->string('givenName');
            $table->string('surName');
            $table->string('initials');
            $table->string('displayName');
            $table->string('email')->unique();
            $table->string('photo')->nullable();
            $table->string('department')->nullable();
            $table->string('title')->nullable();
            $table->string('personalTitle')->nullable();
            $table->string('employeeId')->unique();
            $table->string('password')->nullable();
            $table->string('description')->nullable();
            $table->string('token')->nullable()->unique();
            $table->dateTime('tokenValidUntil')->nullable();
            $table->string('fontysToken', 10000)->nullable();
            $table->dateTime('fontysTokenValidUntil')->nullable();
            $table->string('resetPasswordCode')->nullable();
            $table->dateTime('resetPasswordCodeValidUntil')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student');
    }
}
