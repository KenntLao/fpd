<?php

use Illuminate\Database\Seeder;

class CertificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('hris_certifications')->delete();

        $certification = array(

        	array('name' => 'TESDA Certification', 'description' => 'TESDA Certification'),
        	array('name' => 'Special Course Certification', 'description' => 'Special Course Certification'),

        );

        DB::table('hris_certifications')->insert($certification);
    }
}
