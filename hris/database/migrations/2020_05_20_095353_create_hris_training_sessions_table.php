<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrisTrainingSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hris_training_sessions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->string('course_id');
            $table->string('details')->nullable();
            $table->string('scheduled_time');
            $table->string('assignment_due_date')->nullable();
            $table->string('delivery_method');
            $table->string('delivery_location')->nullable();
            $table->string('attendance_type');
            $table->string('attachment')->nullable();
            $table->string('training_cert_required');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hris_training_sessions');
    }
}
