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
            array('code' => 'RAA', 'name' => 'Accounting Assistant', 'description' => 'Accounting Assistant', 'specification' => 'Accounting Assistant'),
            array('code' => 'AA', 'name' => 'Accounting Assistant', 'description' => 'Accounting Assistant', 'specification' => 'Accounting Assistant'),
            array('code' => 'RAA', 'name' => 'Accounting Assistant - Reliever', 'description' => 'Accounting Assistant - Reliever', 'specification' => 'Accounting Assistant - Reliever'),
            array('code' => 'SSA', 'name' => 'Accounting Assistant II', 'description' => 'Accounting Assistant II', 'specification' => 'Accounting Assistant II'),
            array('code' => 'ACS-CO', 'name' => 'Accounting Officer', 'description' => 'Accounting Officer', 'specification' => 'Accounting Officer'),
            array('code' => 'ACS', 'name' => 'Accounting Supervisor', 'description' => 'Accounting Supervisor', 'specification' => 'Accounting Supervisor'),
            array('code' => 'AS', 'name' => 'Administrative Assistant', 'description' => 'Administrative Assistant', 'specification' => 'Administrative Assistant'),
            array('code' => 'RAS', 'name' => 'Administrative Assistant', 'description' => 'Administrative Assistant', 'specification' => 'Administrative Assistant'),
            array('code' => 'SSA-CO', 'name' => 'Administrative Assistant (Marketing)', 'description' => 'Administrative Assistant (Marketing)', 'specification' => 'Administrative Assistant (Marketing)'),
            array('code' => 'SSA-CO', 'name' => 'Administrative Supervisor', 'description' => 'Administrative Supervisor', 'specification' => 'Administrative Supervisor'),
            array('code' => 'BM', 'name' => 'Assistant Building Manager', 'description' => 'Assistant Building Manager', 'specification' => 'Assistant Building Manager'),
            array('code' => 'ABM', 'name' => 'Assistant Building Manager', 'description' => 'Assistant Building Manager', 'specification' => 'Assistant Building Manager'),
            array('code' => 'ESD-CO', 'name' => 'Assistant Department Manager', 'description' => 'Assistant Department Manager', 'specification' => 'Assistant Department Manager'),
            array('code' => 'B & C', 'name' => 'Biling and Collection Assistant', 'description' => 'Biling and Collection Assistant', 'specification' => 'Biling and Collection Assistant'),
            array('code' => 'SSA', 'name' => 'BMS Operator', 'description' => 'BMS Operator', 'specification' => 'BMS Operator'),
            array('code' => 'SSA-CO', 'name' => 'Bookkeeper', 'description' => 'Bookkeeper', 'specification' => 'Bookkeeper'),
            array('code' => 'BE', 'name' => 'Building Administrator', 'description' => 'Building Administrator', 'specification' => 'Building Administrator'),
            array('code' => 'RBE', 'name' => 'Building Engineer', 'description' => 'Building Engineer', 'specification' => 'Building Engineer'),
            array('code' => 'RBE', 'name' => 'Building Engineer - Reliever', 'description' => 'Building Engineer - Reliever', 'specification' => 'Building Engineer - Reliever'),
            array('code' => 'BE', 'name' => 'Building Engineer I', 'description' => 'Building Engineer I', 'specification' => 'Building Engineer I'),
            array('code' => 'RBM', 'name' => 'Building Manager', 'description' => 'Building Manager', 'specification' => 'Building Manager'),
            array('code' => 'RBM', 'name' => 'Building Manager - Reliever (Ocean Tower)', 'description' => 'Building Manager - Reliever (Ocean Tower)', 'specification' => 'Building Manager - Reliever (Ocean Tower)'),
            array('code' => 'BM', 'name' => 'Building Manager II', 'description' => 'Building Manager II', 'specification' => 'Building Manager II'),
            array('code' => 'BM', 'name' => 'Building Manager III', 'description' => 'Building Manager III', 'specification' => 'Building Manager III'),
            array('code' => 'T', 'name' => 'Carpenter/Plumber', 'description' => 'Carpenter/Plumber', 'specification' => 'Carpenter/Plumber'),
            array('code' => 'SSA', 'name' => 'Cashier', 'description' => 'Cashier', 'specification' => 'Cashier'),
            array('code' => 'T', 'name' => 'Chiller Operator', 'description' => 'Chiller Operator', 'specification' => 'Chiller Operator'),
            array('code' => 'SSA-CO', 'name' => 'Company Driver', 'description' => 'Company Driver', 'specification' => 'Company Driver'),
            array('code' => 'BM', 'name' => 'Complex Manager', 'description' => 'Complex Manager', 'specification' => 'Complex Manager'),
            array('code' => 'MT', 'name' => 'Director for Engineering Services', 'description' => 'Director for Engineering Services', 'specification' => 'Director for Engineering Services'),
            array('code' => 'DH', 'name' => 'Director for HRCSD', 'description' => 'Director for HRCSD', 'specification' => 'Director for HRCSD'),
            array('code' => 'MT', 'name' => 'Director for Property Operations', 'description' => 'Director for Property Operations', 'specification' => 'Director for Property Operations'),
            array('code' => 'SSA-CO', 'name' => 'Encoder', 'description' => 'Encoder', 'specification' => 'Encoder'),
            array('code' => 'DH', 'name' => 'Engineering Operations Manager', 'description' => 'Engineering Operations Manager', 'specification' => 'Engineering Operations Manager'),
            array('code' => 'ESD-CO', 'name' => 'Facilities Engineer', 'description' => 'Facilities Engineer', 'specification' => 'Facilities Engineer'),
            array('code' => 'BM', 'name' => 'Facilities Manager', 'description' => 'Facilities Manager', 'specification' => 'Facilities Manager'),
            array('code' => 'MT', 'name' => 'Finance and IT Associate Director', 'description' => 'Finance and IT Associate Director', 'specification' => 'Finance and IT Associate Director'),
            array('code' => 'BM', 'name' => 'Fit-Out Manager', 'description' => 'Fit-Out Manager', 'specification' => 'Fit-Out Manager'),
            array('code' => 'SSA-CO', 'name' => 'General Services Officer', 'description' => 'General Services Officer', 'specification' => 'General Services Officer'),
            array('code' => 'SSA', 'name' => 'Gondola Operator', 'description' => 'Gondola Operator', 'specification' => 'Gondola Operator'),
            array('code' => 'SSA', 'name' => 'GSD Assistant', 'description' => 'GSD Assistant', 'specification' => 'GSD Assistant'),
            array('code' => 'SSA-CO', 'name' => 'HR Assistant', 'description' => 'HR Assistant', 'specification' => 'HR Assistant'),
            array('code' => 'SSA-CO', 'name' => 'HR Officer', 'description' => 'HR Officer', 'specification' => 'HR Officer'),
            array('code' => 'SSA-CO', 'name' => 'Internal Auditor', 'description' => 'Internal Auditor', 'specification' => 'Internal Auditor'),
            array('code' => 'SSA-CO', 'name' => 'IT Assistant', 'description' => 'IT Assistant', 'specification' => 'IT Assistant'),
            array('code' => 'T', 'name' => 'Lead Technician', 'description' => 'Lead Technician', 'specification' => 'Lead Technician'),
            array('code' => 'SSA', 'name' => 'Liason Officer', 'description' => 'Liason Officer', 'specification' => 'Liason Officer'),
            array('code' => 'SSA', 'name' => 'Lift Attendant', 'description' => 'Lift Attendant', 'specification' => 'Lift Attendant'),
            array('code' => 'SSA-CO', 'name' => 'Marketing Assistant', 'description' => 'Marketing Assistant', 'specification' => 'Marketing Assistant'),
            array('code' => 'SSA', 'name' => 'Messenger', 'description' => 'Messenger', 'specification' => 'Messenger'),
            array('code' => 'T', 'name' => 'Multi-skilled Technician', 'description' => 'Multi-skilled Technician', 'specification' => 'Multi-skilled Technician'),
            array('code' => 'RT', 'name' => 'Multi-skilled Technician', 'description' => 'Multi-skilled Technician', 'specification' => 'Multi-skilled Technician'),
            array('code' => 'T', 'name' => 'Multi-skilled Technician - Reliever', 'description' => 'Multi-skilled Technician - Reliever', 'specification' => 'Multi-skilled Technician - Reliever'),
            array('code' => 'ESD-AT', 'name' => 'Multi-skilled Technician I', 'description' => 'Multi-skilled Technician I', 'specification' => 'Multi-skilled Technician I'),
            array('code' => 'ESD-AT', 'name' => 'Multi-skilled Technician II', 'description' => 'Multi-skilled Technician II', 'specification' => 'Multi-skilled Technician II'),
            array('code' => 'SSA-CO', 'name' => 'Officer I (FITD)', 'description' => 'Officer I (FITD)', 'specification' => 'Officer I (FITD)'),
            array('code' => 'ASC-CO', 'name' => 'Officer II (FITD)', 'description' => 'Officer II (FITD)', 'specification' => 'Officer II (FITD)'),
            array('code' => 'CH', 'name' => 'Operations Manager', 'description' => 'Operations Manager', 'specification' => 'Operations Manager'),
            array('code' => 'CH', 'name' => 'Operations Manager II', 'description' => 'Operations Manager II', 'specification' => 'Operations Manager II'),
            array('code' => 'ACS-CO', 'name' => 'Project Accounting Supervisor', 'description' => 'Project Accounting Supervisor', 'specification' => 'Project Accounting Supervisor'),
            array('code' => 'ACS-CO', 'name' => 'QEHS Assistant', 'description' => 'QEHS Assistant', 'specification' => 'QEHS Assistant'),
            array('code' => 'DH', 'name' => 'QEHS Manager', 'description' => 'QEHS Manager', 'specification' => 'QEHS Manager'),
            array('code' => 'R', 'name' => 'Receptionist', 'description' => 'Receptionist', 'specification' => 'Receptionist'),
            array('code' => 'BE', 'name' => 'Shift Engineer', 'description' => 'Shift Engineer', 'specification' => 'Shift Engineer'),
            array('code' => 'SSA', 'name' => 'Shift Engineer', 'description' => 'Shift Engineer', 'specification' => 'Shift Engineer'),
            array('code' => 'SE', 'name' => 'Shift Engineer', 'description' => 'Shift Engineer', 'specification' => 'Shift Engineer'),
            array('code' => 'SSA', 'name' => 'Technical Assistant', 'description' => 'Technical Assistant', 'specification' => 'Technical Assistant'),
            array('code' => 'T', 'name' => 'Technical Assistant', 'description' => 'Technical Assistant', 'specification' => 'Technical Assistant'),
            array('code' => 'ESD-CO', 'name' => 'Technical Safety Auditor', 'description' => 'Technical Safety Auditor', 'specification' => 'Technical Safety Auditor'),
            array('code' => 'TS', 'name' => 'Technical Supervisor', 'description' => 'Technical Supervisor', 'specification' => 'Technical Supervisor'),
            array('code' => 'ESD-AT', 'name' => 'Technical Supervisor', 'description' => 'Technical Supervisor', 'specification' => 'Technical Supervisor'),
            array('code' => 'SSA', 'name' => 'Valet Driver', 'description' => 'Valet Driver', 'specification' => 'Valet Driver'),
            array('code' => 'BM', 'name' => 'Village Manager', 'description' => 'Village Manager', 'specification' => 'Village Manager'),

        );

        DB::table('hris_job_titles')->insert($jobTitle);
    }
}
