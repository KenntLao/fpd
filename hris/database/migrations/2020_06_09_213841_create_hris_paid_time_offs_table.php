<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrisPaidTimeOffsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hris_paid_time_offs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('leave_type_id');
            $table->string('employee_id');
            $table->string('leave_period_id');
            $table->string('amount');
            $table->string('note')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hris_paid_time_offs');
    }
}
