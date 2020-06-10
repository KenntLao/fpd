<?php

use Illuminate\Database\Seeder;

class OvertimeCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('hris_overtime_categories')->delete();

        $category = array(

        	array('name' => 'EXTENDED DUTY DUE TO NEW EMPLOYEE UNDER FAMILIARIZATION, TURNOVER'),
        	array('name' => 'AS PER SCHEDULE'),
        	array('name' => 'RELIEVER (LEAVE/ ABSENT/ LATE/ REST DAY OF EMPLOYEE)'),
        	array('name' => 'LACK OF MANPOWER'),
        	array('name' => 'REST DAY DUTY - SPECIAL HOLIDAY'),
        	array('name' => 'REST DAY DUTY - LEGAL HOLIDAY'),
        	array('name' => 'REST DAY DUTY - HOLIDAY ON REST DAY'),

        );

        DB::table('hris_overtime_categories')->insert($category);
    }
}
