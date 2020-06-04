<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

<<<<<<< HEAD:hris/database/migrations/2020_06_02_162137_create_hris_time_overtime_requests_table.php
class CreateHrisTimeOvertimeRequestsTable extends Migration
=======
class CreateHrisLeaveRulesTable extends Migration
>>>>>>> anthony-update:hris/database/migrations/2020_06_04_113043_create_hris_leave_rules_table.php
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
<<<<<<< HEAD:hris/database/migrations/2020_06_02_162137_create_hris_time_overtime_requests_table.php
        Schema::create('hris_time_overtime_requests', function (Blueprint $table) {
=======
        Schema::create('hris_leave_rules', function (Blueprint $table) {
>>>>>>> anthony-update:hris/database/migrations/2020_06_04_113043_create_hris_leave_rules_table.php
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
            $table->string('default_per_year');
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
<<<<<<< HEAD:hris/database/migrations/2020_06_02_162137_create_hris_time_overtime_requests_table.php
        Schema::dropIfExists('hris_time_overtime_requests');
=======
        Schema::dropIfExists('hris_leave_rules');
>>>>>>> anthony-update:hris/database/migrations/2020_06_04_113043_create_hris_leave_rules_table.php
    }
}
