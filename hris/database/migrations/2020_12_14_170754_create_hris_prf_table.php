<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrisPrfTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hris_prf', function (Blueprint $table) {
            $table->id();
            $table->integer('department_id')->nullable();
            $table->integer('project_id')->nullable();
            $table->date('date_filed')->nullable();
            $table->string('control_no')->nullable();
            $table->string('education')->nullable();
            $table->string('work_exp')->nullable();
            $table->string('skills')->nullable();
            $table->string('age')->nullable();
            $table->longText('duty_desc')->nullable();
            $table->string('reason')->nullable();
            $table->double('basic_rate')->nullable();
            $table->double('allowance')->nullable();
            $table->double('cola')->nullable();
            $table->string('project_based')->nullable();
            $table->string('client_approval_file')->nullable();
            $table->string('labor_approval_file')->nullable();
            $table->string('cmo_based')->nullable();
            $table->string('cmo_remarks')->nullable();
            $table->string('employee_id')->nullable();
            $table->string('employee_position_id')->nullable();
            $table->string('employee_department_id')->nullable();
            $table->string('supervisor_id')->nullable();
            $table->integer('iniitial_status')->nullable();
            $table->integer('action')->nullable();
            $table->integer('employment_status_id')->nullable();
            $table->date('duration_from')->nullable();
            $table->date('duration_to')->nullable();
            $table->string('candidate_id')->nullable();
            $table->string('candidate_position')->nullable();
            $table->date('candidate_hire_date')->nullable();
            $table->date('candidate_salary')->nullable();
            $table->integer('hr_id')->nullable();
            $table->date('pod_date')->nullable();
            $table->integer('pod_receiver_id')->nullable();
            $table->string('pod_type')->nullable();
            $table->string('reject_remarks')->nullable();
            $table->timestamps();
            $table->integer('del_status')->default(0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hris_prf');
    }
}
