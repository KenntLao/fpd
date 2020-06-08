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

        );

        DB::table('hris_company_structures')->insert($company);
    }
}
