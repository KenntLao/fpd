<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrisLeaveTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hris_leave_types', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->string('leaves_per_period');
            $table->string('supervisor_leave_assign');
            $table->string('employee_can_apply');
            $table->string('apply_beyond_current');
            $table->string('leave_accrue');
            $table->string('carried_forward');
            $table->string('carried_forward_percentage');
            $table->string('max_carried_forward_amount');
            $table->string('carried_forward_leave_availability');
            $table->string('proportionate_on_joined_date');
            $table->string('employee_leave_period');
            $table->string('send_notification_emails');
            $table->string('leave_group')->nullable();
            $table->string('leave_color');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hris_leave_types');
    }
}
