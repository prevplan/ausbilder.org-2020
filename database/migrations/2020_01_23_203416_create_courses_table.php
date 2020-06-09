<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('type');
            $table->string('internal_number');
            $table->string('registration_number')->nullable();
            $table->boolean('registered')->default(false);
            $table->text('seminar_location');
            $table->text('street');
            $table->text('zipcode');
            $table->text('location');
            $table->dateTime('start');
            $table->dateTime('end');
            $table->unsignedBigInteger('responsible');
            $table->string('seats', 10);
            $table->boolean('bookable');
            $table->unsignedBigInteger('running')->nullable();
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('type')->references('id')->on('course_types')->onDelete('cascade');
            $table->foreign('responsible')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('courses');
    }
}
