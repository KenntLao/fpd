<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrisLeaveEntitlementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hris_leave_entitlements', function (Blueprint $table) {
            $table->id();
            $table->integer('leave_type_id');
            $table->integer('leave_group_id');
            $table->integer('leave_credit');
            $table->integer('employee_id');
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
        Schema::dropIfExists('hris_leave_entitlements');
    }
}
