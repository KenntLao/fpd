<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrisSystemLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hris_system_logs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('user');
            $table->string('account_mode');
            $table->string('action');
            $table->string('description', 10000);
            $table->datetime('log_date_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hris_system_logs');
    }
}
