<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrisOvertimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hris_overtimes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->bigInteger('employee_id');
            $table->string('ot_date');
            $table->string('ot_time_in');
            $table->string('ot_time_out');
            $table->string('employee_remarks');
            $table->string('type')->nullable();
            $table->string('supervisor_remarks')->nullable();
            $table->bigInteger('supervisor_id')->nullable();
            $table->bigInteger('role_id')->nullable();
            $table->string('approved_date')->nullable();
            $table->string('status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hris_overtimes');
    }
}
