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
            $table->string('position_applied');
            $table->string('hiring_stage');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('profile_image');
            $table->string('gender');
            $table->string('city');
            $table->string('country');
            $table->string('telephone');
            $table->string('email');
            $table->string('resume');
            $table->string('resume_headline');
            $table->string('profile_summary');
            $table->string('total_years_exp');
            $table->string('work_history');
            $table->string('education');
            $table->string('skills');
            $table->string('referees');
            $table->string('prefered_industry');
            $table->string('expected_salary');
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
