<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrisCandidatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hris_candidates', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('job_position_id');
            $table->string('hiring_stage');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('profile_image')->nullable();
            $table->string('gender');
            $table->string('city')->nullable();
            $table->string('country');
            $table->string('telephone');
            $table->string('email');
            $table->string('resume');
            $table->string('resume_headline')->nullable();
            $table->string('profile_summary')->nullable();
            $table->string('total_years_exp')->nullable();
            $table->string('work_history')->nullable();
            $table->string('education')->nullable();
            $table->string('skills')->nullable();
            $table->string('referees')->nullable();
            $table->string('prefered_industry');
            $table->string('expected_salary')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hris_candidates');
    }
}
