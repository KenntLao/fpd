<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrisWorkShiftManagementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hris_work_shift_managements', function (Blueprint $table) {
            $table->id();
            $table->string('workshift_name');
            $table->integer('monday_shift')->default('0')->nullable();
            $table->bigInteger('monday_time_in')->default('0')->nullable();
            $table->bigInteger('monday_time_out')->default('0')->nullable();
            $table->integer('tuesday_shift')->default('0')->nullable();
            $table->bigInteger('tuesday_time_in')->default('0')->nullable();
            $table->bigInteger('tuesday_time_out')->default('0')->nullable();
            $table->integer('wednesday_shift')->default('0')->nullable();
            $table->bigInteger('wednesday_time_in')->default('0')->nullable();
            $table->bigInteger('wednesday_time_out')->default('0')->nullable();
            $table->integer('thursday_shift')->default('0')->nullable();
            $table->bigInteger('thursday_time_in')->default('0')->nullable();
            $table->bigInteger('thursday_time_out')->default('0')->nullable();
            $table->integer('friday_shift')->default('0')->nullable();
            $table->bigInteger('friday_time_in')->default('0')->nullable();
            $table->bigInteger('friday_time_out')->default('0')->nullable();
            $table->integer('saturday_shift')->default('0')->nullable();
            $table->bigInteger('saturday_time_in')->default('0')->nullable();
            $table->bigInteger('saturday_time_out')->default('0')->nullable();
            $table->integer('sunday_shift')->default('0')->nullable();
            $table->bigInteger('sunday_time_in')->default('0')->nullable();
            $table->bigInteger('sunday_time_out')->default('0')->nullable();
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
        Schema::dropIfExists('hris_work_shift_managements');
    }
}
