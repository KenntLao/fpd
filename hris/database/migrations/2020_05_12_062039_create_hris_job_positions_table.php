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
            $table->bigInteger('job_title_id');
            $table->string('company_name')->nullable();
            $table->string('hiring_manager')->nullable();
            $table->string('show_hiring_manager_name');
            $table->longText('short_description');
            $table->longText('requirements')->nullable();
            $table->bigInteger('benefit_id');
            $table->string('country');
            $table->string('city');
            $table->string('postal_code');
            $table->bigInteger('department_id')->nullable();
            $table->bigInteger('employment_type_id')->nullable();
            $table->bigInteger('exp_level_id')->nullable();
            $table->bigInteger('job_function_id')->nullable();
            $table->bigInteger('education_level_id')->nullable();
            $table->string('show_salary');
            $table->string('currency');
            $table->integer('salary_min')->nullable();
            $table->integer('salary_max')->nullable();
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
