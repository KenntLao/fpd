<?php

use Illuminate\Database\Seeder;

class EmploymentStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('hris_employment_statuses')->delete();

        $employmentStatus = array(

        	array('name' => 'REGULAR', 'description' => 'REGULAR'),
        	array('name' => 'CO-TERMINUS', 'description' => 'CO-TERMINUS'),
        	array('name' => 'PROBATIONARY', 'description' => 'PROBATIONARY'),
        	array('name' => 'FIXED-TERM', 'description' => 'FIXED-TERM'),

        );

        DB::table('hris_employment_statuses')->insert($employmentStatus);
    }
}
