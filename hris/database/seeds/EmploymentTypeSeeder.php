<?php

use Illuminate\Database\Seeder;

class EmploymentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('hris_employment_types')->delete();

        $employmentType = array(

        	array('name' => 'Regular'),
        	array('name' => 'Co-Terminus'),
        	array('name' => 'Probationary'),
        	array('name' => 'Fixed-Term')

        );

        DB::table('hris_employment_types')->insert($employmentType);
    }
}
