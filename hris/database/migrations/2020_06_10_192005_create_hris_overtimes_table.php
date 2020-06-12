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
            $table->bigInteger('employee_id');
            $table->string('ot_date');
            $table->bigInteger('ot_time_in');
            $table->bigInteger('ot_time_out');
            $table->string('ot_request_date');
            $table->string('employee_remarks');
            $table->string('supervisor_remarks');
            $table->string('approved_by');
            $table->string('approved_date');
            $table->integer('status');
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
        Schema::dropIfExists('hris_overtimes');
    }
}
