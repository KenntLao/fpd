<?php

use Illuminate\Database\Seeder;

class CompanyTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('hris_company_types')->delete();

        $type = array(
        	array('name' => 'Company'),
        	array('name' => 'Head Office'),
    		array('name' => 'Regional Office'),
    		array('name' => 'Department'),
    		array('name' => 'Unit'),
    		array('name' => 'Sub Unit'),
    		array('name' => 'Other')
        );

        DB::table('hris_company_types')->insert($type);

    }
}
