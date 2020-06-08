<?php

use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('hris_courses')->delete();

        $course = array(

        	array('code' => '101', 'name' => 'Course Test 01', 'coordinator' => 'SocialConz Digital', 'trainer' => '', 'trainer_details' => '', 'payment_type' => 'Company Sponsored', 'currency' => 'Philippine Peso', 'cost' => '0.00', 'status' => 'Active'),
        	array('code' => '102', 'name' => 'Course Test 02', 'coordinator' => 'SocialConz Digital', 'trainer' => '', 'trainer_details' => '', 'payment_type' => 'Company Sponsored', 'currency' => 'Philippine Peso', 'cost' => '0.00', 'status' => 'Active'),
        	array('code' => '103', 'name' => 'Course Test 03', 'coordinator' => 'SocialConz Digital', 'trainer' => '', 'trainer_details' => '', 'payment_type' => 'Company Sponsored', 'currency' => 'Philippine Peso', 'cost' => '0.00', 'status' => 'Active'),

        );

        DB::table('hris_courses')->insert($course);
    }
}
