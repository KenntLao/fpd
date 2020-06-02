<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrisOvertimeRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hris_overtime_requests', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('employee');
            $table->string('category');
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->string('project')->nullable();
            $table->string('notes')->nullable();
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
        Schema::dropIfExists('hris_overtime_requests');
    }
}
