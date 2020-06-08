<?php

use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('hris_skills')->delete();

        $skill = array(

        	array('name' => 'Analytical and problem solving skills', 'description' => 'Employers want people who can use creativity, reasoning and past experiences to identify and solve problems effectively.'),
        	array('name' => 'Communication skills', 'description' => 'Listening, speaking and writing. Employers want people who can accurately interpret what others are saying and organize and express their thoughts clearly..'),
        	array('name' => 'Teamwork', 'description' => 'In today’s work environment, many jobs involve working in one or more groups. Employers want someone who can bring out the best in others.'),

        );

        DB::table('hris_skills')->insert($skill);
    }
}
