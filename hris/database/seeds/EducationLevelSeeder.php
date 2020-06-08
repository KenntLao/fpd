<?php

use Illuminate\Database\Seeder;

class EducationLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('hris_education_levels')->delete();

        $educationLevel = array(

        	array('name' => 'Unspecified'),
        	array('name' => 'High School or equivalent'),
        	array('name' => 'Certification'),
        	array('name' => 'Vocational'),

        );

        DB::table('hris_education_levels')->insert($educationLevel);
    }
}
