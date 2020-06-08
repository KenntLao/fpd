<?php

use Illuminate\Database\Seeder;

class BenefitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('hris_benefits')->delete();

    	$benefit = array(

    		array('name' => 'Paid Vacations'),
    		array('name' => 'Mandatory Benefits (SSS, HDMF, Philhealth)')

    	);

    	DB::table('hris_benefits')->insert($benefit);

    }
}
