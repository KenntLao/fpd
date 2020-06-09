<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrisEmployeeEducationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hris_employee_educations', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('employee_id');
            $table->string('education_id');
            $table->string('institute');
            $table->date('start_date')->nullable();
            $table->date('completed')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hris_employee_educations');
    }
}
