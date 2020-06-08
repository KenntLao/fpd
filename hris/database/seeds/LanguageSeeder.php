<?php

use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('hris_languages')->delete();

        $language = array(

        	array('name' => 'Filipino', 'description' => 'Filipino'),
        	array('name' => 'English', 'description' => 'English'),
        	array('name' => 'Visayan Language', 'description' => 'Visayan Language'),

        );

        DB::table('hris_languages')->insert($language);
    }
}
