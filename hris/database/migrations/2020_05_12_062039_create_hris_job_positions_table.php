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
            $table->string('company_name')->nullable();
            $table->string('hiring_manager')->nullable();
            $table->string('show_hiring_manager_name');
            $table->string('short_description');
            $table->string('job_description');
            $table->string('requirements')->nullable();
            $table->string('benefits');
            $table->string('country');
            $table->string('city');
            $table->string('postal_code');
            $table->string('department')->nullable();
            $table->string('employment_type')->nullable();
            $table->string('exp_level')->nullable();
            $table->string('job_function')->nullable();
            $table->string('education_level')->nullable();
            $table->string('show_salary');
            $table->string('currency');
            $table->string('salary_min')->nullable();
            $table->string('salary_max')->nullable();
            $table->string('keywords')->nullable();
            $table->string('status');
            $table->date('closing_date')->nullable();
            $table->string('image')->nullable();
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
