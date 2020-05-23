<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrisEmployeeExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hris_employee_expenses', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('employee');
            $table->date('expense_date');
            $table->string('payment_method');
            $table->string('ref_number')->nullable();
            $table->string('payee');
            $table->string('expense_category');
            $table->string('notes');
            $table->string('currency');
            $table->string('amount');
            $table->string('receipt')->nullable();
            $table->string('attachment_1')->nullable();
            $table->string('attachment_2')->nullable();
            $table->string('status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hris_employee_expenses');
    }
}
