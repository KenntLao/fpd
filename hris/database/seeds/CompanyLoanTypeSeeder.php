<?php

use Illuminate\Database\Seeder;

class CompanyLoanTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('hris_company_loan_types')->delete();

    	$type = array(

    		array('name' => 'SSS Loan (first loan)', 'details' => 'should have total of 36 months premium contribution'),
    		array('name' => 'SSS Loan (renewal)', 'details' => 'should have paid at least half of the existing loan or paid at least 12 months'),
    		array('name' => 'Pag-IBIG (first loan)', 'details' => 'should have total of 24 months premium contribution'),
    		array('name' => 'Pag-IBIG (renewal)', 'details' => 'should have paid at least 6 months'),
    		array('name' => 'FEMCO Educ. Loan', 'details' => 'should have at least paid half of the loan balance'),
    		array('name' => 'FEMCO Quick Loan', 'details' => 'should have at least paid half of the loan balance'),
    		array('name' => 'FEMCO Regular Loan', 'details' => 'should have at least paid half of the loan balance'),

    	);

    	DB::table('hris_company_loan_types')->insert($type);
    }
}
