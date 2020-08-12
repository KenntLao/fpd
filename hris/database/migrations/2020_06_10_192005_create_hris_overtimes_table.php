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
            $table->string('acc_mode');
            $table->bigInteger('sender_id');
            $table->bigInteger('department_id');
            $table->bigInteger('employee_id');
            $table->string('ot_difference');
            $table->string('ot_date');
            $table->string('ot_time_in');
            $table->string('ot_time_out');
            $table->bigInteger('overtime_category_id');
            $table->string('employee_remarks');
            $table->string('overtime_type_id')->nullable();
            $table->string('supervisor_remarks')->nullable();
            $table->bigInteger('supervisor_id')->nullable();
            $table->string('role_id')->nullable();
            $table->string('approved_date')->nullable();
            $table->string('approved_by_id')->nullable();
            $table->string('status')->nullable();
            $table->string('REG')->nullable();
            $table->string('REG_8')->nullable();
            $table->string('REG_ND1')->nullable();
            $table->string('REG_ND2')->nullable();
            $table->string('RST')->nullable();
            $table->string('RST_8')->nullable();
            $table->string('RST_ND1')->nullable();
            $table->string('RST_ND2')->nullable();
            $table->string('LGL')->nullable();
            $table->string('LGL_8')->nullable();
            $table->string('LGL_ND1')->nullable();
            $table->string('LGL_ND2')->nullable();
            $table->string('LGLRST')->nullable();
            $table->string('LGLRST_8')->nullable();
            $table->string('LGLRST_ND1')->nullable();
            $table->string('LGLRST_ND2')->nullable();
            $table->string('SPL')->nullable();
            $table->string('SPL_8')->nullable();
            $table->string('SPL_ND1')->nullable();
            $table->string('SPL_ND2')->nullable();
            $table->string('SPLRST')->nullable();
            $table->string('SPLRST_8')->nullable();
            $table->string('SPLRST_ND1')->nullable();
            $table->string('SPLRST_ND2')->nullable();
            $table->string('SPRS_CLIEN')->nullable();
            $table->string('SPRS_CLIEN_8')->nullable();
            $table->string('SPRS_CLIEN_ND1')->nullable();
            $table->string('SPRS_CLIEN_ND2')->nullable();
            $table->string('LGRS_CLIEN')->nullable();
            $table->string('LGRS_CLIEN_8')->nullable();
            $table->string('LGRS_CLIEN_ND1')->nullable();
            $table->string('LGRS_CLIEN_ND2')->nullable();
            $table->string('SPL_CLIENT')->nullable();
            $table->string('SPL_CLIENT_8')->nullable();
            $table->string('SPL_CLIENT_ND1')->nullable();
            $table->string('SPL_CLIENT_ND2')->nullable();
            $table->string('RST_CLIENT')->nullable();
            $table->string('RST_CLIENT_8')->nullable();
            $table->string('RST_CLIENT_ND1')->nullable();
            $table->string('RST_CLIENT_ND2')->nullable();
            $table->string('REG_CLIENT')->nullable();
            $table->string('REG_CLIENT_8')->nullable();
            $table->string('REG_CLIENT_ND1')->nullable();
            $table->string('REG_CLIENT_ND2')->nullable();
            $table->string('REGND_CLIE')->nullable();
            $table->string('REGND_CLIE_8')->nullable();
            $table->string('REGND_CLIE_ND1')->nullable();
            $table->string('REGND_CLIE_ND2')->nullable();
            $table->string('LG_CLIENT')->nullable();
            $table->string('LG_CLIENT_8')->nullable();
            $table->string('LG_CLIENT_ND1')->nullable();
            $table->string('LG_CLIENT_ND2')->nullable();
            $table->string('LGLSPL')->nullable();
            $table->string('LGLSPL_8')->nullable();
            $table->string('LGLSPL_ND1')->nullable();
            $table->string('LGLSPL_ND2')->nullable();
            $table->string('LGLSPLRST')->nullable();
            $table->string('LGLSPLRST_8')->nullable();
            $table->string('LGLSPLRST_ND1')->nullable();
            $table->string('LGLSPLRST_ND2')->nullable();
            $table->string('LGLSPL_CLI')->nullable();
            $table->string('LGLSPL_CLI_8')->nullable();
            $table->string('LGLSPL_CLI_ND1')->nullable();
            $table->string('LGLSPL_CLI_ND2')->nullable();
            $table->string('LGLSPL_ND1_2')->nullable();
            $table->string('LGLSPL_ND1_2_8')->nullable();
            $table->string('LGLSPL_ND1_2_ND1')->nullable();
            $table->string('LGLSPL_ND1_2_ND2')->nullable();
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