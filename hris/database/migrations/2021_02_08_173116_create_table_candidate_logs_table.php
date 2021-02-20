<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableCandidateLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('table_candidate_logs', function (Blueprint $table) {
            $table->id();
            $table->string('date_type')->nullable();
            $table->integer('candidate_id')->nullable();
            $table->integer('hr_id')->nullable();
            $table->integer('manager_id')->nullable();
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
        Schema::dropIfExists('table_candidate_logs');
    }
}
