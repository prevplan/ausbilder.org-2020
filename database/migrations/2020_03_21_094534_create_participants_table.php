<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParticipantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('participants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('course_id');
            $table->string('lastname');
            $table->string('firstname');
            $table->date('date_of_birth');
            $table->string('company')->nullable();
            $table->string('street')->nullable();
            $table->string('zipcode', 5)->nullable();
            $table->string('location')->nullable();
            $table->string('email')->nullable();
            $table->dateTime('email_reminder')->nullable();
            $table->string('payee')->nullable();
            $table->boolean('participated')->default(0);
            $table->boolean('payed')->default(0);
            $table->timestamps();

            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('participants');
    }
}
