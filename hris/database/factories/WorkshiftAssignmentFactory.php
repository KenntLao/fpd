<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\hris_employee;
use App\hris_work_shift_management;
use App\Model;
use Faker\Generator as Faker;

$factory->define(App\hris_workshift_assignment::class, function (Faker $faker) {
    $date_from = date('Y-m-d');
    $date_to = date('Y-m-d', strtotime("+3 months", strtotime($date_from)));
    $employee = hris_employee::all()->pluck('id')->toArray();
    $workshift = hris_work_shift_management::all()->pluck('id')->toArray();
    return [
        //
        'employee_id' => $faker->randomElement($employee),

        'workshift_id' => $faker->randomElement($workshift),
        
        'date_from' => $date_from,

        'date_to' => $date_to
    ];
});
