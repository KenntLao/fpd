<?php

use Illuminate\Database\Seeder;

class JobPositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('hris_job_positions')->delete();

    	$company = array(

    		array(
    			'job_code' => '0001', 
    			'job_title' => 'Accounting Assistant', 
    			'company_name' => 'FPD Asia', 
    			'hiring_manager' => 'Not Selected', 
    			'show_hiring_manager_name' => 'No', 
    			'short_description' => 'lorem ipsum', 
    			'job_description' => 'lorem ipsum', 
    			'requirements' => '', 
    			'benefit_id' => '2', 
    			'country' => 'Philippines', 
    			'city' => 'Makati', 
    			'postal_code' => '1204', 
    			'department_id' => '', 
    			'employment_type_id' => '', 
    			'exp_level_id' => '', 
    			'job_function_id' => '', 
    			'education_level_id' => '', 
    			'show_salary' => 'Yes', 
    			'currency' => 'Philippine Peso', 
    			'salary_min' => '', 
    			'salary_max' => '', 
    			'keywords' => '', 
    			'status' => 'Active', 
    			'closing_date' => NULL, 
    			'image' => '', 
    			'display_type' => 'Text Only'
    		),
    		array(
    			'job_code' => '0002', 
    			'job_title' => 'Accounting Officer – Project', 
    			'company_name' => 'FPD Asia', 
    			'hiring_manager' => 'Not Selected', 
    			'show_hiring_manager_name' => 'No', 
    			'short_description' => 'lorem ipsum', 
    			'job_description' => 'lorem ipsum', 
    			'requirements' => '', 
    			'benefit_id' => '2', 
    			'country' => 'Philippines', 
    			'city' => 'Makati', 
    			'postal_code' => '1204', 
    			'department_id' => '', 
    			'employment_type_id' => '', 
    			'exp_level_id' => '', 
    			'job_function_id' => '', 
    			'education_level_id' => '', 
    			'show_salary' => 'Yes', 
    			'currency' => 'Philippine Peso', 
    			'salary_min' => '', 
    			'salary_max' => '', 
    			'keywords' => '', 
    			'status' => 'Active', 
    			'closing_date' => NULL, 
    			'image' => '', 
    			'display_type' => 'Text Only'
    		),
    		array(
    			'job_code' => '0003', 
    			'job_title' => 'Administrative Assistant', 
    			'company_name' => 'FPD Asia', 
    			'hiring_manager' => 'Not Selected', 
    			'show_hiring_manager_name' => 'No', 
    			'short_description' => 'lorem ipsum', 
    			'job_description' => 'lorem ipsum', 
    			'requirements' => '', 
    			'benefit_id' => '2', 
    			'country' => 'Philippines', 
    			'city' => 'Makati', 
    			'postal_code' => '1204', 
    			'department_id' => '', 
    			'employment_type_id' => '', 
    			'exp_level_id' => '', 
    			'job_function_id' => '', 
    			'education_level_id' => '', 
    			'show_salary' => 'Yes', 
    			'currency' => 'Philippine Peso', 
    			'salary_min' => '', 
    			'salary_max' => '', 
    			'keywords' => '', 
    			'status' => 'Active', 
    			'closing_date' => NULL, 
    			'image' => '', 
    			'display_type' => 'Text Only'
    		),

    	);

    	DB::table('hris_job_positions')->insert($company);
    }
}
