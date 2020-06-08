<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrisEmployeeCertificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hris_employee_certifications', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('certification_id');
            $table->string('institute');
            $table->date('granted_on')->nullable();
            $table->date('valid_thru')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hris_employee_certifications');
    }
}
