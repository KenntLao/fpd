<?php

use Illuminate\Database\Seeder;

class ExpensesCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('hris_expenses_categories')->delete();

        $category = array(

        	array('name' => 'Auto - Gas'),
        	array('name' => 'Auto - Insurance'),
        	array('name' => 'Maintenance'),
        	array('name' => 'Repair'),
        	array('name' => 'Transportation'),
        	array('name' => 'Bank fees'),
        	array('name' => 'Dining Out'),
        	array('name' => 'Entertainment'),
        	array('name' => 'Hotel / Motel'),
        	array('name' => 'Insurance'),
        	array('name' => 'Interest Charges'),
        	array('name' => 'Loan Payment'),
        	array('name' => 'Medical'),
        	array('name' => 'Mileage'),
        	array('name' => 'Rent'),
        	array('name' => 'Rental Car'),
        	array('name' => 'Utility'),
        	array('name' => 'Clothing'),

        );

        DB::table('hris_expenses_categories')->insert($category);
    }
}
