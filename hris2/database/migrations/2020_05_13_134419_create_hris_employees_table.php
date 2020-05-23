<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrisEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hris_employees', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('employee_number');
            $table->string('firstname');
            $table->string('middlename');
            $table->string('lastname');
            $table->string('nationality');
            $table->date('birthday');
            $table->string('gender');
            $table->string('marital_status');
            $table->string('sss');
            $table->string('phic');
            $table->string('pagibig');
            $table->string('driving_license_no');
            $table->string('employee_status');
            $table->string('job_title');
            $table->integer('paygrade');
            $table->longText('current_address');
            $table->longText('permanent_address');
            $table->string('city');
            $table->string('country');
            $table->string('province');
            $table->string('zip_code');
            $table->string('home_no');
            $table->string('mobile_no');
            $table->string('work_no');
            $table->string('work_email');
            $table->string('private_email');
            $table->date('joined_date');
            $table->date('confirm_date');
            $table->date('termination_date');
            $table->string('department');
            $table->string('supervisor');
            $table->string('indirect_supervisor');
            $table->string('firstlevel_approver');
            $table->string('secondlevel_approver');
            $table->string('thirdlevel_approver');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hris_employees');
    }
}
