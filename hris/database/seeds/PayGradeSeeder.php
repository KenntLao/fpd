<?php

use Illuminate\Database\Seeder;

class PayGradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('hris_pay_grades')->delete();

        $payGrade = array(

        	array('name' => '1', 'currency' => 'Philippine Peso', 'min_salary' => '13400.00', 'max_salary' => '14700.00'),
        	array('name' => '2', 'currency' => 'Philippine Peso', 'min_salary' => '14700.00', 'max_salary' => '16200.00'),
        	array('name' => '3', 'currency' => 'Philippine Peso', 'min_salary' => '16200.00', 'max_salary' => '18000.00'),

        );

        DB::table('hris_pay_grades')->insert($payGrade);
    }
}
