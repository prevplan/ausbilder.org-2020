<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseDaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_days', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('start_id');
            $table->dateTime('startDay');
            $table->dateTime('startReal');
            $table->unsignedBigInteger('end_id')->nullable();
            $table->dateTime('endDay')->nullable();
            $table->dateTime('endReal')->nullable();
            $table->mediumInteger('lessonsDay')->nullable();
            $table->timestamps();

            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
            $table->foreign('start_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('end_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_days');
    }
}
