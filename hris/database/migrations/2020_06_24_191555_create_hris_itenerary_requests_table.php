<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrisIteneraryRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hris_itenerary_requests', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->bigInteger('employee_id');
            $table->bigInteger('supervisor_id')->nullable();
            $table->string('role_id')->nullable();
            $table->string('transportation');
            $table->string('purpose');
            $table->string('travel_from');
            $table->string('travel_to');
            $table->string('travel_date');
            $table->string('return_date');
            $table->string('notes')->nullable();
            $table->bigInteger('currency_id');
            $table->string('total_funding_proposed');
            $table->string('attachment_1')->nullable();
            $table->string('attachment_2')->nullable();
            $table->string('attachment_3')->nullable();
            $table->bigInteger('status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hris_itenerary_requests');
    }
}
