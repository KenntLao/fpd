<?php

use Illuminate\Database\Seeder;

class JobFunctionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('hris_job_functions')->delete();

    	$jobFunction = array(

    		array('name' => 'Accounting/Auditing'),
    		array('name' => 'Administrative and Support Services'),
    		array('name' => 'Advertising'),
    		array('name' => 'Business Analyst'),
    		array('name' => 'Financial Analyst'),
    		array('name' => 'Data Analyst'),
    		array('name' => 'Art/Creative'),

    	);

    	DB::table('hris_job_functions')->insert($jobFunction);
    }
}
