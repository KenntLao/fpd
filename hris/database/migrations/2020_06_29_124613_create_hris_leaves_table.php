<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrisLeavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hris_leaves', function (Blueprint $table) {
            $table->id();
            $table->integer('leave_type_id');
            $table->integer('employee_id');
            $table->bigInteger('leave_start_date');
            $table->bigInteger('leave_end_date');
            $table->bigInteger('approved_date')->nullable();
            $table->bigInteger('approved_by_id')->nullable();
            $table->bigInteger('supervisor_id')->nullable();
            $table->longText('remarks')->nullable();
            $table->longText('reason');
            $table->integer('status');
            $table->timestamps();
            $table->integer('del_status')->default(0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hris_leaves');
    }
}
