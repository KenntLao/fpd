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
            $table->integer('ot_difference');
            $table->string('ot_date');
            $table->string('ot_time_in');
            $table->string('ot_time_out');
            $table->bigInteger('overtime_category_id');
            $table->longText('employee_remarks');
            $table->bigInteger('overtime_type_id')->nullable();
            $table->longText('supervisor_remarks')->nullable();
            $table->bigInteger('supervisor_id')->nullable();
            $table->string('role_id')->nullable();
            $table->string('approved_date')->nullable();
            $table->bigInteger('approved_by_id')->nullable();
            $table->integer('status')->nullable();
            $table->integer('REG')->nullable();
            $table->integer('REG_8')->nullable();
            $table->integer('REG_ND1')->nullable();
            $table->integer('REG_ND2')->nullable();
            $table->integer('RST')->nullable();
            $table->integer('RST_8')->nullable();
            $table->integer('RST_ND1')->nullable();
            $table->integer('RST_ND2')->nullable();
            $table->integer('LGL')->nullable();
            $table->integer('LGL_8')->nullable();
            $table->integer('LGL_ND1')->nullable();
            $table->integer('LGL_ND2')->nullable();
            $table->integer('LGLRST')->nullable();
            $table->integer('LGLRST_8')->nullable();
            $table->integer('LGLRST_ND1')->nullable();
            $table->integer('LGLRST_ND2')->nullable();
            $table->integer('SPL')->nullable();
            $table->integer('SPL_8')->nullable();
            $table->integer('SPL_ND1')->nullable();
            $table->integer('SPL_ND2')->nullable();
            $table->integer('SPLRST')->nullable();
            $table->integer('SPLRST_8')->nullable();
            $table->integer('SPLRST_ND1')->nullable();
            $table->integer('SPLRST_ND2')->nullable();
            $table->integer('SPRS_CLIEN')->nullable();
            $table->integer('SPRS_CLIEN_8')->nullable();
            $table->integer('SPRS_CLIEN_ND1')->nullable();
            $table->integer('SPRS_CLIEN_ND2')->nullable();
            $table->integer('LGRS_CLIEN')->nullable();
            $table->integer('LGRS_CLIEN_8')->nullable();
            $table->integer('LGRS_CLIEN_ND1')->nullable();
            $table->integer('LGRS_CLIEN_ND2')->nullable();
            $table->integer('SPL_CLIENT')->nullable();
            $table->integer('SPL_CLIENT_8')->nullable();
            $table->integer('SPL_CLIENT_ND1')->nullable();
            $table->integer('SPL_CLIENT_ND2')->nullable();
            $table->integer('RST_CLIENT')->nullable();
            $table->integer('RST_CLIENT_8')->nullable();
            $table->integer('RST_CLIENT_ND1')->nullable();
            $table->integer('RST_CLIENT_ND2')->nullable();
            $table->integer('REG_CLIENT')->nullable();
            $table->integer('REG_CLIENT_8')->nullable();
            $table->integer('REG_CLIENT_ND1')->nullable();
            $table->integer('REG_CLIENT_ND2')->nullable();
            $table->integer('REGND_CLIE')->nullable();
            $table->integer('REGND_CLIE_8')->nullable();
            $table->integer('REGND_CLIE_ND1')->nullable();
            $table->integer('REGND_CLIE_ND2')->nullable();
            $table->integer('LG_CLIENT')->nullable();
            $table->integer('LG_CLIENT_8')->nullable();
            $table->integer('LG_CLIENT_ND1')->nullable();
            $table->integer('LG_CLIENT_ND2')->nullable();
            $table->integer('LGLSPL')->nullable();
            $table->integer('LGLSPL_8')->nullable();
            $table->integer('LGLSPL_ND1')->nullable();
            $table->integer('LGLSPL_ND2')->nullable();
            $table->integer('LGLSPLRST')->nullable();
            $table->integer('LGLSPLRST_8')->nullable();
            $table->integer('LGLSPLRST_ND1')->nullable();
            $table->integer('LGLSPLRST_ND2')->nullable();
            $table->integer('LGLSPL_CLI')->nullable();
            $table->integer('LGLSPL_CLI_8')->nullable();
            $table->integer('LGLSPL_CLI_ND1')->nullable();
            $table->integer('LGLSPL_CLI_ND2')->nullable();
            $table->integer('LGLSPL_ND1_2')->nullable();
            $table->integer('LGLSPL_ND1_2_8')->nullable();
            $table->integer('LGLSPL_ND1_2_ND1')->nullable();
            $table->integer('LGLSPL_ND1_2_ND2')->nullable();
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
