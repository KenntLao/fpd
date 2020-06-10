<?php

use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		DB::table('hris_payment_methods')->delete();

        $payment = array(

        	array('name' => 'Cash'),
        	array('name' => 'Check'),
        	array('name' => 'Credit Card'),
        	array('name' => 'Debit Card'),

        );

        DB::table('hris_payment_methods')->insert($payment);
    }
}
