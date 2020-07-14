<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrisLeaveRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hris_leave_rules', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('leave_type_id');
            $table->string('leave_group_id')->nullable();
            $table->string('job_title_id')->nullable();
            $table->string('employment_status_id')->nullable();
            $table->string('employee_id')->nullable();
            $table->string('exp_days');
            $table->string('leave_period_id')->nullable();
            $table->string('default_per_year');
            $table->string('supervisor_assign_leave');
            $table->string('employee_can_apply');
            $table->string('apply_beyond_current');
            $table->string('leave_accrue');
            $table->string('carried_forward');
            $table->string('carried_forward_percentage');
            $table->string('max_carried_forward_amount');
            $table->string('carried_forward_leave_availability');
            $table->string('proportionate_on_joined_date');
            $table->string('employee_leave_period');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hris_leave_rules');
    }
}
