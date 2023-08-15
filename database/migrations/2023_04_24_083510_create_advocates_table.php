<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advocates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->bigInteger('phone_number');
            $table->integer('age');
            $table->string('father_name');
            $table->string('company_name');
            $table->string('website');
            $table->string('tin');
            $table->string('gstin');
            $table->string('pan_number');
            $table->bigInteger('hourly_rate');
            $table->string('ofc_address_line_1');
            $table->string('ofc_address_line_2');
            $table->bigInteger('ofc_country');
            $table->bigInteger('ofc_state');
            $table->string('ofc_city')->default(null);
            $table->bigInteger('ofc_zip_code');
            $table->string('home_address_line_1');
            $table->string('home_address_line_2');
            $table->string('home_country')->default(null);
            $table->string('home_state')->default(null);
            $table->string('home_city')->default(null);
            $table->string('home_zip_code')->default(null);
            $table->integer('created_by');
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
        Schema::dropIfExists('advocates');
    }
};
