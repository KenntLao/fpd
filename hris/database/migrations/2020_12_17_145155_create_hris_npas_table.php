<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrisNpasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hris_npas', function (Blueprint $table) {
            $table->id();
            $table->string('account_mode');
            $table->date('request_date');
            $table->string('attention');
            $table->string('ref_no');
            $table->integer('sender_id');
            $table->integer('project_id');
            $table->integer('employee_id');
            $table->string('reason', 300);
            $table->integer('designation_from_id')->default(0)->nullable();
            $table->integer('designation_to_id');
            $table->integer('bs_from')->default(0)->nullable();
            $table->integer('bs_to');
            $table->integer('a_from')->default(0)->nullable();
            $table->integer('a_to');
            $table->integer('cola_from')->default(0)->nullable();
            $table->integer('cola_to');
            $table->date('effectivity_date');
            $table->longText('remarks')->nullable();
            $table->integer('status')->default(0)->nullable();
            $table->integer('process_id')->default(0)->nullable();
            $table->integer('approve_id')->default(0)->nullable();
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
        Schema::dropIfExists('hris_npas');
    }
}
