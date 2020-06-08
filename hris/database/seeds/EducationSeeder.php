<?php

use Illuminate\Database\Seeder;

class EducationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('hris_educations')->delete();

        $education = array(

        	array('name' => 'Bachelors Degree', 'description' => 'Bachelors Degree'),
        	array('name' => 'Diploma', 'description' => 'Diploma'),
        	array('name' => 'Masters Degree', 'description' => 'Masters Degree'),
        	array('name' => 'Doctorate', 'description' => 'Doctorate'),
        	array('name' => 'Vocational Course Graduate', 'description' => 'Vocational Course Graduate'),

        );

        DB::table('hris_educations')->insert($education);
    }
}
