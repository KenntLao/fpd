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
            array('name' => 'Personal management skills', 'description' => 'The ability to plan and manage multiple assignments and tasks, set priorities and adapt to changing conditions and work assignments.'),
            array('name' => 'Interpersonal effectiveness', 'description' => 'Employers usually note whether an employee can relate to co-workers and build relationships with others in the organization.'),
            array('name' => 'Computer/technical literacy', 'description' => 'Although employers expect to provide training on job-specific software, they also expect employees to be proficient with basic computer skills.'),
            array('name' => 'Leadership/management skills', 'description' => 'The ability to take charge and manage your co-workers, if required, is a welcome trait. Most employers look for signs of leadership qualities.'),
            array('name' => 'Learning skills', 'description' => 'Jobs are constantly changing and evolving, and employers want people who can grow and learn as changes come.'),
            array('name' => 'Academic competence in reading and math', 'description' => 'Although most jobs don’t require calculus, almost all jobs require the ability to read and comprehend  instructions and perform basic math.'),
            array('name' => 'Strong work values', 'description' => 'Dependability, honesty, selfconfidence and a positive attitude are prized qualities in any profession. Employers look for personal integrity.'),
            array('name' => 'Conceptual skills', 'description' => 'Conceptual skills'),
            array('name' => 'Creative thinking skills', 'description' => 'Creative thinking skills'),
            array('name' => 'Critical thinking skills', 'description' => 'Critical thinking skills'),
            array('name' => 'Decision-making skills', 'description' => 'Decision-making skills'),
            array('name' => 'Employability skills', 'description' => 'Employability skills'),
            array('name' => 'Marketing skills', 'description' => 'Marketing skills'),
            array('name' => 'Organizational skills', 'description' => 'Organizational skills'),
            array('name' => 'Project management skills', 'description' => 'Project management skills'),
            array('name' => 'Soft skills and hard skills', 'description' => 'Soft skills and hard skills'),
            array('name' => 'Time management skills', 'description' => 'Time management skills'),
            array('name' => 'Transferable skills', 'description' => 'Transferable skills'),
            array('name' => 'Effective communication', 'description' => 'Effective communication'),
            array('name' => 'Adaptability skills', 'description' => 'Adaptability skills'),

        );

        DB::table('hris_skills')->insert($skill);
    }
}
