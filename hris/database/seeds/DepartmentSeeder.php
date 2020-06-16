<?php

use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('hris_departments')->delete();
        $department = array(
        	array('department_code' => 'ESD', 'department_name' => 'Engineering Services Department', 'status' => '0'),
        	array('department_code' => 'TSAD', 'department_name' => 'Technical & Safety Audit Department', 'status' => '0'),
        	array('department_code' => 'TSD', 'department_name' => 'Technical Services Department', 'status' => '0'),
        	array('department_code' => 'EO', 'department_name' => 'Executive Office', 'status' => '0'),
        	array('department_code' => 'BDM', 'department_name' => 'Business Development & Marketing Department', 'status' => '0'),
        	array('department_code' => 'IAD', 'department_name' => 'Internal Audit Department', 'status' => '0'),
        	array('department_code' => 'QEHS', 'department_name' => 'Quality, Environmental, Health and Safety Department', 'status' => '0'),
        	array('department_code' => 'POD', 'department_name' => 'Property Operations Division', 'status' => '0'),
        	array('department_code' => 'POD', 'department_name' => 'SBU1', 'status' => '0'),
        	array('department_code' => 'POD', 'department_name' => 'SBU2', 'status' => '0'),
        	array('department_code' => 'POD', 'department_name' => 'SBU3', 'status' => '0'),
        	array('department_code' => 'POD', 'department_name' => 'SBU4', 'status' => '0'),
        	array('department_code' => 'POD', 'department_name' => 'SBU5', 'status' => '0'),
        	array('department_code' => 'POD', 'department_name' => 'SBU6', 'status' => '0'),
        	array('department_code' => 'POD', 'department_name' => 'SBU7', 'status' => '0'),
        	array('department_code' => 'POD', 'department_name' => 'SBU8', 'status' => '0'),
        	array('department_code' => 'POD', 'department_name' => 'SBU9', 'status' => '0'),
        	array('department_code' => 'POD', 'department_name' => 'SBU10', 'status' => '0'),
        	array('department_code' => 'FAD', 'department_name' => 'Finance & Accounting Department', 'status' => '0'),
        	array('department_code' => 'CAD', 'department_name' => 'Corporate Accounting Department', 'status' => '0'),
        	array('department_code' => 'PAD', 'department_name' => 'Project Accounting Department', 'status' => '0'),
        	array('department_code' => 'CSSD', 'department_name' => 'Corporate Support & Services Division', 'status' => '0'),
        	array('department_code' => 'GSD', 'department_name' => 'General Support Department', 'status' => '0'),
        	array('department_code' => 'HRMD', 'department_name' => 'Human Resources Management Department', 'status' => '0'),
        	array('department_code' => 'ITD', 'department_name' => 'Information Technology Department', 'status' => '0'),
        	array('department_code' => 'LSD', 'department_name' => 'Legal Services Department', 'status' => '0'),
        );
		DB::table('hris_departments')->insert($department);
    }
}
