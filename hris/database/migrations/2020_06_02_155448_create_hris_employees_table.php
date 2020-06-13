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
            $table->string('employee_photo');
            $table->string('username');
            $table->string('password');
            $table->string('firstname');
            $table->string('middlename')->nullable();
            $table->string('lastname');
            $table->string('nationality');
            $table->date('birthday');
            $table->string('gender');
            $table->string('place_birth');
            $table->integer('dependant')->nullable();
            $table->string('marital_status');
            $table->longText('work_address');
            $table->longText('home_address');
            $table->integer('home_distance')->nullable();
            $table->string('emergency_contact');
            $table->string('emergency_no');
            $table->string('cert_level');
            $table->string('field_study');
            $table->string('school');
            $table->string('visa_no')->nullable();
            $table->string('work_permit')->nullable();
            $table->date('visa_expire')->nullable();
            $table->string('passport_no')->nullable();
            $table->string('pagibig')->nullable();
            $table->string('sss')->nullable();
            $table->string('phic')->nullable();
            $table->bigInteger('bank_acc');
            $table->string('employment_status');
            $table->string('work_no');
            $table->string('work_phone')->nullable();
            $table->string('work_email');
            $table->string('private_email');
            $table->date('joined_date');
            $table->date('termination_date')->nullable();
            $table->string('department');
            $table->string('supervisor');
            $table->string('role_ids', 500)->default(',');
            $table->bigInteger('last_login')->default(0);
            $table->string('status')->default('active')->nullable();
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
