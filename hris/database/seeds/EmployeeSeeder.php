<?php

use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */


    
    
    public function run()
    {
        factory(App\hris_employee::class, 4)->create();
    }
}
