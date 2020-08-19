<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrisEmployeeLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hris_employee_loans', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->bigInteger('employee_id');
            $table->bigInteger('loan_type_id');
            $table->date('loan_start_date');
            $table->date('last_installment_date');
            $table->integer('loan_period');
            $table->string('currency');
            $table->integer('loan_amount');
            $table->integer('monthly_installment');
            $table->string('status');
            $table->longText('details')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hris_employee_loans');
    }
}
