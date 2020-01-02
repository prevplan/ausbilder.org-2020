<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('name2')->nullable();
            $table->string('street')->nullable();
            $table->string('zipcode')->nullable();
            $table->string('location')->nullable();
            $table->string('reference', 6)->unique()->nullable();
            $table->text('qseh_password')->nullable();
            $table->string('doctor')->nullable();
            $table->text('sign')->nullable();
            $table->date('bg_eh_auth')->nullable();
            $table->date('bg_bs_auth')->nullable();
            $table->date('bg_lk_auth')->nullable();
            $table->boolean('bg_bsh_auth')->default(false);
            $table->date('fev_auth')->nullable();
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
        Schema::dropIfExists('companies');
    }
}
