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
        Schema::create('cases', function (Blueprint $table) {
            $table->id();
            $table->integer('court');
            $table->integer('highcourt')->nullable();
            $table->integer('bench')->nullable();
            $table->string('casetype')->nullable();
            $table->string('casenumber')->nullable();
            $table->bigInteger('diarybumber')->nullable();
            $table->integer('year')->nullable();
            $table->bigInteger('case_number')->nullable();
            $table->date('filing_date')->nullable();
            $table->bigInteger('court_hall')->nullable();
            $table->bigInteger('floor')->nullable();
            $table->string('title');
            $table->longText('description');
            $table->string('before_judges');
            $table->string('referred_by');
            $table->string('section');
            $table->string('priority');
            $table->string('under_acts');
            $table->string('under_sections');
            $table->string('FIR_police_station');
            $table->bigInteger('FIR_number');
            $table->integer('FIR_year');
            $table->date('hearing_date');
            $table->string('stage');
            $table->string('session');
            $table->string('your_advocates');
            $table->string('your_team');
            $table->longText('opponents');
            $table->longText('opponent_advocates');
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
        Schema::dropIfExists('cases');
    }
};
