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
            $table->string('leave_type');
            $table->string('leave_group');
            $table->string('job_title');
            $table->string('employment_status');
            $table->string('employee');
            $table->string('exp_days');
            $table->string('department');
            $table->string('leave_period');
            $table->string('supervisor_leave_assign');
            $table->string('employee_can_apply');
            $table->string('apply_beyond_current');
            $table->string('leave_accrue');
            $table->string('carried_forward');
            $table->string('carried_forward_percentage');
            $table->string('max_carried_forward_amount');
            $table->string('carried_forward_leave_availability');
            $table->string('proportionate_on_joined_date');
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
