<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrisJobPositionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
public function up()
    {
        Schema::create('hris_job_positions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('job_code');
            $table->string('job_title');
            $table->string('company_name');
            $table->string('hiring_manager');
            $table->string('show_hiring_manager_name');
            $table->string('short_description');
            $table->string('job_description');
            $table->string('requirements');
            $table->string('benefits');
            $table->string('country');
            $table->string('city');
            $table->string('postal_code');
            $table->string('department');
            $table->string('employment_type');
            $table->string('exp_level');
            $table->string('job_function');
            $table->string('education_level');
            $table->string('show_salary');
            $table->string('currency');
            $table->string('salary_min');
            $table->string('salary_max');
            $table->string('keywords');
            $table->string('status');
            $table->date('closing_date');
            $table->string('image');
            $table->string('display_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hris_job_positions');
    }
}
