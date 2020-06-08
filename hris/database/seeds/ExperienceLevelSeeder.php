<?php

use Illuminate\Database\Seeder;

class ExperienceLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('hris_experience_levels')->delete();

        $experienceLevel = array(

        	array('name' => 'Not Applicable'),
        	array('name' => 'Internship'),
        	array('name' => 'Entry Level'),
        	array('name' => 'Associate'),
        	array('name' => 'Mid-Senior Level'),
        	array('name' => 'Director'),
        	array('name' => 'Executive'),
        	array('name' => '2 - 3 years'),
        	array('name' => '3 - 5 years'),
        	array('name' => '1 - 2 years'),
        	array('name' => 'At least 3 years'),
        	array('name' => 'Less than 6 months'),
        	array('name' => '1 year'),
        	array('name' => '3 - 4 years'),
        	array('name' => '2 years'),

        );

        DB::table('hris_experience_levels')->insert($experienceLevel);
    }
}
