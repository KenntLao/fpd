<?php

use Illuminate\Database\Seeder;

class WorkshiftAssignmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(App\hris_workshift_assignment::class, 4)->create();
    }
}
