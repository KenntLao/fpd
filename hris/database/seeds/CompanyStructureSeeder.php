<?php

use Illuminate\Database\Seeder;

class CompanyStructureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('hris_company_structures')->delete();

        $company = array(

        	array('code' => 'CMO', 'name' => 'Central Management Office', 'details' => 'Central Management Office', 'address' => '', 'type' => 'Head Office', 'country' => 'Philippines', 'timezone' => 'Asia/Manila', 'parent_structure' => ''),
        	array('code' => 'ESD', 'name' => 'Engineering Services Divisions', 'details' => 'Engineering Services Divisions', 'address' => '', 'type' => 'Department', 'country' => 'Philippines', 'timezone' => 'Asia/Manila', 'parent_structure' => 'Central Management Office'),
            array('code' => 'EO', 'name' => 'Executive Office', 'details' => 'Executive Office', 'address' => '', 'type' => 'Head Office', 'country' => 'Philippines', 'timezone' => 'Asia/Manila', 'parent_structure' => 'Central Management Office'),
            array('code' => 'POD', 'name' => 'Property Operations Divisions', 'details' => 'Property Operations Divisions', 'address' => '', 'type' => 'Department', 'country' => 'Philippines', 'timezone' => 'Asia/Manila', 'parent_structure' => 'Central Management Office'),
            array('code' => 'GSD', 'name' => 'General Support Department', 'details' => 'General Support Department', 'address' => '', 'type' => 'Department', 'country' => 'Philippines', 'timezone' => 'Asia/Manila', 'parent_structure' => 'Corporate Support & Services Division'),
            array('code' => 'BDM', 'name' => 'Business Development & Marketing Department', 'details' => 'Business Development & Marketing Department', 'address' => '', 'type' => 'Department', 'country' => 'Philippines', 'timezone' => 'Asia/Manila', 'parent_structure' => 'Executive Office'),
            array('code' => 'IAD', 'name' => 'Internal Audit Department', 'details' => 'Internal Audit Department', 'address' => '', 'type' => 'Department', 'country' => 'Philippines', 'timezone' => 'Asia/Manila', 'parent_structure' => 'Executive Office'),
            array('code' => 'QEHS', 'name' => 'Quality, Environmental, Health and Safety Department', 'details' => 'Quality, Environmental, Health and Safety Department', 'address' => '', 'type' => 'Department', 'country' => 'Philippines', 'timezone' => 'Asia/Manila', 'parent_structure' => 'Executive Office'),
            array('code' => 'TSAD', 'name' => 'Technical & Safety Audit Department', 'details' => 'Technical & Safety Audit Department', 'address' => '', 'type' => 'Department', 'country' => 'Philippines', 'timezone' => 'Asia/Manila', 'parent_structure' => 'Engineering Services Divisions'),
            array('code' => 'TSD', 'name' => 'Technical Services Department', 'details' => 'Technical Services Department', 'address' => '', 'type' => 'Department', 'country' => 'Philippines', 'timezone' => 'Asia/Manila', 'parent_structure' => 'Engineering Services Divisions'),
            array('code' => 'CAD', 'name' => 'Corporate Accounting Department', 'details' => 'Corporate Accounting Department', 'address' => '', 'type' => 'Department', 'country' => 'Philippines', 'timezone' => 'Asia/Manila', 'parent_structure' => 'Finance & Accounting Department'),
            array('code' => 'PAD', 'name' => 'Project Accounting Department', 'details' => 'Project Accounting Department', 'address' => '', 'type' => 'Department', 'country' => 'Philippines', 'timezone' => 'Asia/Manila', 'parent_structure' => 'Finance & Accounting Department'),
            array('code' => 'SBU', 'name' => 'Strategic Business Unit', 'details' => 'Strategic Business Unit', 'address' => '', 'type' => 'Department', 'country' => 'Philippines', 'timezone' => 'Asia/Manila', 'parent_structure' => 'Property Operations Divisions'),
            array('code' => 'CSSD', 'name' => 'Corporate Support & Services Division', 'details' => 'Corporate Support & Services Division', 'address' => '', 'type' => 'Head Office', 'country' => 'Philippines', 'timezone' => 'Asia/Manila', 'parent_structure' => 'Central Management Office'),
            array('code' => 'HRMD', 'name' => 'Human Resource Management Department', 'details' => 'Human Resource Management Department', 'address' => '', 'type' => 'Department', 'country' => 'Philippines', 'timezone' => 'Asia/Manila', 'parent_structure' => 'Corporate Support & Services Division'),
            array('code' => 'ITD', 'name' => 'Information Technology Department', 'details' => 'Information Technology Department', 'address' => '', 'type' => 'Department', 'country' => 'Philippines', 'timezone' => 'Asia/Manila', 'parent_structure' => 'Corporate Support & Services Division'),
            array('code' => 'LSD', 'name' => 'Legal Services Department', 'details' => 'Legal Services Department (LSD)', 'address' => '', 'type' => 'Department', 'country' => 'Philippines', 'timezone' => 'Asia/Manila', 'parent_structure' => 'Corporate Support & Services Department'),
            array('code' => 'SBU-1', 'name' => 'SBU 1', 'details' => 'SBU 1', 'address' => '', 'type' => 'Sub Unit', 'country' => 'Philippines', 'timezone' => 'Asia/Manila', 'parent_structure' => 'Property Operations Division'),
            array('code' => 'SBU-2', 'name' => 'SBU 2', 'details' => 'SBU 2', 'address' => '', 'type' => 'Sub Unit', 'country' => 'Philippines', 'timezone' => 'Asia/Manila', 'parent_structure' => 'Property Operations Division'),
            array('code' => 'SBU-3', 'name' => 'SBU 3', 'details' => 'SBU 3', 'address' => '', 'type' => 'Sub Unit', 'country' => 'Philippines', 'timezone' => 'Asia/Manila', 'parent_structure' => 'Property Operations Division'),
            array('code' => 'SBU-4', 'name' => 'SBU 4', 'details' => 'SBU 4', 'address' => '', 'type' => 'Sub Unit', 'country' => 'Afghanistan', 'timezone' => 'Asia/Manila', 'parent_structure' => 'Property Operations Division'),
            array('code' => 'SBU-5', 'name' => 'SBU 5', 'details' => 'SBU 5', 'address' => '', 'type' => 'Sub Unit', 'country' => 'Afghanistan', 'timezone' => 'Asia/Manila', 'parent_structure' => 'Property Operations Division'),
            array('code' => 'SBU-6', 'name' => 'SBU 6', 'details' => 'SBU 6', 'address' => '', 'type' => 'Sub Unit', 'country' => 'Philippines', 'timezone' => 'Asia/Manila', 'parent_structure' => 'Property Operations Division'),
            array('code' => 'SBU-7', 'name' => 'SBU 7', 'details' => 'SBU 7', 'address' => '', 'type' => 'Sub Unit', 'country' => 'Philippines', 'timezone' => 'Asia/Manila', 'parent_structure' => 'Property Operations Division'),
            array('code' => 'SBU-8', 'name' => 'SBU 8', 'details' => 'SBU 8', 'address' => '', 'type' => 'Sub Unit', 'country' => 'Philippines', 'timezone' => 'Asia/Manila', 'parent_structure' => 'Property Operations Division'),
            array('code' => 'SBU-9', 'name' => 'SBU 9', 'details' => 'SBU 9', 'address' => '', 'type' => 'Sub Unit', 'country' => 'Philippines', 'timezone' => 'Asia/Manila', 'parent_structure' => 'Property Operations Division'),

        );

        DB::table('hris_company_structures')->insert($company);
    }
}
