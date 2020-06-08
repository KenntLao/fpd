<?php

use Illuminate\Database\Seeder;

class JobTitleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('hris_job_titles')->delete();

        $jobTitle = array(

        	array('code' => 'ESD-CO', 'name' => 'Account Engineer I', 'description' => 'Account Engineer I', 'specification' => 'Account Engineer I'),
        	array('code' => 'ESD-CO', 'name' => 'Account Engineer III', 'description' => 'Account Engineer III', 'specification' => 'Account Engineer III'),
        	array('code' => 'AA', 'name' => 'Accounting Assistant', 'description' => 'Accounting Assistant', 'specification' => 'Accounting Assistant'),

        );

        DB::table('hris_job_titles')->insert($jobTitle);
    }
}
