<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;

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
            $hashed = Hash::make(1234);
            $table->id();
            $table->bigInteger('employee_number');
            $table->string('employee_photo')->nullable();
            $table->string('username');
            $table->string('password')->default($hashed);
            $table->string('firstname');
            $table->string('middlename')->nullable();
            $table->string('lastname');
            $table->string('nationality')->nullable();
            $table->date('birthday')->nullable();
            $table->string('gender')->nullable();
            $table->string('place_birth')->nullable();
            $table->integer('dependant')->nullable();
            $table->string('marital_status')->nullable();
            $table->longText('work_address')->nullable();
            $table->longText('home_address')->nullable();
            $table->integer('home_distance')->nullable();
            $table->string('emergency_contact')->nullable();
            $table->string('emergency_no')->nullable();
            $table->string('cert_level')->nullable();
            $table->string('field_study')->nullable();
            $table->string('school')->nullable();
            $table->string('tin')->nullable();
            $table->string('pagibig')->nullable();
            $table->string('sss')->nullable();
            $table->string('phic')->nullable();
            $table->string('employment_status')->nullable();
            $table->string('work_no')->nullable();
            $table->string('work_phone')->nullable();
            $table->string('work_email')->nullable();
            $table->string('private_email')->nullable();
            $table->date('joined_date')->nullable();
            $table->date('termination_date')->nullable();
            $table->integer('job_title_id')->nullable();
            $table->integer('department_id')->default(0);
            $table->string('supervisor')->nullable();
            $table->integer('pay_grade')->nullable();
            $table->string('role_id', 500)->default(',');
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
