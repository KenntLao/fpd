<?php

use Illuminate\Database\Seeder;

class Workshift1ManagementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(App\hris_work_shift_management::class, 4)->create();
    }
}
