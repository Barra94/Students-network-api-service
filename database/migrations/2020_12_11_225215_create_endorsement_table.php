<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEndorsementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('endorsement', function (Blueprint $table) {
            $table->primary(['studentId', 'skillId', 'endorserId']);
            $table->foreignId('studentId');
            $table->foreignId('skillId');
            $table->foreignId('endorserId');
            $table->timestamps();
        });

        Schema::table('endorsement', function (Blueprint $table) {
            $table->foreign(['studentId', 'skillId'])->references(['studentId', 'skillId'])->on('student_skill');
            //$table->foreign('skillId')->references('id')->on('student_skill');
            $table->foreign('endorserId')->references('id')->on('student');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('endorsement');
    }
}
