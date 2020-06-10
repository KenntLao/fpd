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

        	array('name' => 'Central Management Office (CMO)', 'details' => 'Central Management Office (CMO)', 'address' => '', 'type' => 'Head Office', 'country' => 'Philippines', 'timezone' => 'Asia/Manila', 'parent_structure' => ''),
        	array('name' => 'Engineering Services Divisions (ESD)', 'details' => 'Engineering Services Divisions (ESD)', 'address' => '', 'type' => 'Department', 'country' => 'Philippines', 'timezone' => 'Asia/Manila', 'parent_structure' => 'Central Management Office (CMO)'),
            array('name' => 'Executive Office (EO)', 'details' => 'Executive Office (EO)', 'address' => '', 'type' => 'Head Office', 'country' => 'Philippines', 'timezone' => 'Asia/Manila', 'parent_structure' => 'Central Management Office (CMO)'),
            array('name' => 'Property Operations Divisions (POD)', 'details' => 'Property Operations Divisions (POD)', 'address' => '', 'type' => 'Department', 'country' => 'Philippines', 'timezone' => 'Asia/Manila', 'parent_structure' => 'Central Management Office (CMO)'),
            array('name' => 'General Support Department (GSD)', 'details' => 'General Support Department (GSD)', 'address' => '', 'type' => 'Department', 'country' => 'Philippines', 'timezone' => 'Asia/Manila', 'parent_structure' => 'Corporate Support & Services Division (CSSD)'),
            array('name' => 'Business Development & Marketing Department (BDM)', 'details' => 'Business Development & Marketing Department (BDM)', 'address' => '', 'type' => 'Department', 'country' => 'Philippines', 'timezone' => 'Asia/Manila', 'parent_structure' => 'Executive Office (EO)'),
            array('name' => 'Internal Audit Department (IAD)', 'details' => 'Internal Audit Department (IAD)', 'address' => '', 'type' => 'Department', 'country' => 'Philippines', 'timezone' => 'Asia/Manila', 'parent_structure' => 'Executive Office (EO)'),
            array('name' => 'Quality, Environmental, Health and Safety Department (QEHS)', 'details' => 'Quality, Environmental, Health and Safety Department (QEHS)', 'address' => '', 'type' => 'Department', 'country' => 'Philippines', 'timezone' => 'Asia/Manila', 'parent_structure' => 'Executive Office (EO)'),
            array('name' => 'Technical & Safety Audit Department (TSAD)', 'details' => 'Technical & Safety Audit Department (TSAD)', 'address' => '', 'type' => 'Department', 'country' => 'Philippines', 'timezone' => 'Asia/Manila', 'parent_structure' => 'Engineering Services Divisions (ESD)'),
            array('name' => 'Technical Services Department (TSD)', 'details' => 'Technical Services Department (TSD)', 'address' => '', 'type' => 'Department', 'country' => 'Philippines', 'timezone' => 'Asia/Manila', 'parent_structure' => 'Engineering Services Divisions (ESD)'),
            array('name' => 'Corporate Accounting Department (CAD)', 'details' => 'Corporate Accounting Department (CAD)', 'address' => '', 'type' => 'Department', 'country' => 'Philippines', 'timezone' => 'Asia/Manila', 'parent_structure' => 'Finance & Accounting Department (FAD)'),
            array('name' => 'Project Accounting Department (PAD)', 'details' => 'Project Accounting Department (PAD)', 'address' => '', 'type' => 'Department', 'country' => 'Philippines', 'timezone' => 'Asia/Manila', 'parent_structure' => 'Finance & Accounting Department (FAD)'),
            array('name' => 'Strategic Business Unit (SBU)', 'details' => 'Strategic Business Unit (SBU)', 'address' => '', 'type' => 'Department', 'country' => 'Philippines', 'timezone' => 'Asia/Manila', 'parent_structure' => 'Property Operations Divisions (POD)'),
            array('name' => 'Corporate Support & Services Division (CSSD)', 'details' => 'Corporate Support & Services Division (CSSD)', 'address' => '', 'type' => 'Head Office', 'country' => 'Philippines', 'timezone' => 'Asia/Manila', 'parent_structure' => 'Central Management Office (CMO)'),
            array('name' => 'Human Resource Management Department (HRMD)', 'details' => 'Human Resource Management Department (HRMD)', 'address' => '', 'type' => 'Department', 'country' => 'Philippines', 'timezone' => 'Asia/Manila', 'parent_structure' => 'Corporate Support & Services Division (CSSD)'),
            array('name' => 'Information Technology Department (ITD)', 'details' => 'Information Technology Department (ITD)', 'address' => '', 'type' => 'Department', 'country' => 'Philippines', 'timezone' => 'Asia/Manila', 'parent_structure' => 'Corporate Support & Services Division (CSSD)'),
            array('name' => 'Legal Services Department (LSD)', 'details' => 'Legal Services Department (LSD)', 'address' => '', 'type' => 'Department', 'country' => 'Philippines', 'timezone' => 'Asia/Manila', 'parent_structure' => 'Corporate Support & Services Department (CSSD)'),
            array('name' => 'SBU 1', 'details' => 'SBU 1', 'address' => '', 'type' => 'Sub Unit', 'country' => 'Philippines', 'timezone' => 'Asia/Manila', 'parent_structure' => 'Property Operations Division (POD)'),
            array('name' => 'SBU 2', 'details' => 'SBU 2', 'address' => '', 'type' => 'Sub Unit', 'country' => 'Philippines', 'timezone' => 'Asia/Manila', 'parent_structure' => 'Property Operations Division (POD)'),
            array('name' => 'SBU 3', 'details' => 'SBU 3', 'address' => '', 'type' => 'Sub Unit', 'country' => 'Philippines', 'timezone' => 'Asia/Manila', 'parent_structure' => 'Property Operations Division (POD)'),
            array('name' => 'SBU 4', 'details' => 'SBU 4', 'address' => '', 'type' => 'Sub Unit', 'country' => 'Afghanistan', 'timezone' => 'Asia/Manila', 'parent_structure' => 'Property Operations Division (POD)'),
            array('name' => 'SBU 5', 'details' => 'SBU 5', 'address' => '', 'type' => 'Sub Unit', 'country' => 'Afghanistan', 'timezone' => 'Asia/Manila', 'parent_structure' => 'Property Operations Division (POD)'),
            array('name' => 'SBU 6', 'details' => 'SBU 6', 'address' => '', 'type' => 'Sub Unit', 'country' => 'Philippines', 'timezone' => 'Asia/Manila', 'parent_structure' => 'Property Operations Division (POD)'),
            array('name' => 'SBU 7', 'details' => 'SBU 7', 'address' => '', 'type' => 'Sub Unit', 'country' => 'Philippines', 'timezone' => 'Asia/Manila', 'parent_structure' => 'Property Operations Division (POD)'),
            array('name' => 'SBU 8', 'details' => 'SBU 8', 'address' => '', 'type' => 'Sub Unit', 'country' => 'Philippines', 'timezone' => 'Asia/Manila', 'parent_structure' => 'Property Operations Division (POD)'),
            array('name' => 'SBU 9', 'details' => 'SBU 9', 'address' => '', 'type' => 'Sub Unit', 'country' => 'Philippines', 'timezone' => 'Asia/Manila', 'parent_structure' => 'Property Operations Division (POD)'),

        );

        DB::table('hris_company_structures')->insert($company);
    }
}
