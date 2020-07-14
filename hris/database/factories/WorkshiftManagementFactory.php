<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\hris_work_shift_management;

$factory->define(App\hris_work_shift_management::class, function (Faker $faker) {
    $ti = strtotime(rand(0, 23) . ":" . str_pad(rand(0, 0), 2, "0", STR_PAD_LEFT));
    $to = $ti + 32400;
    $time_in = date('hi', $ti);
    $time_out = date('hi', $to);

    return [
        //
        'workshift_name' => $faker->numerify('Workshift ###'),
        'monday_shift' => '1',
        'monday_time_in' => $time_in,
        'monday_time_out' => $time_out,
        'tuesday_shift' => '1',
        'tuesday_time_in' => $time_in,
        'tuesday_time_out' => $time_out,
        'wednesday_shift' => '1',
        'wednesday_time_in' => $time_in,
        'wednesday_time_out' => $time_out,
        'thursday_shift' => '1',
        'thursday_time_in' => $time_in,
        'thursday_time_out' => $time_out,
        'friday_shift' => '1',
        'friday_time_in' => $time_in,
        'friday_time_out' => $time_out,
        'saturday_shift' => '1',
        'saturday_time_in' => $time_in,
        'saturday_time_out' => $time_out,
        'sunday_shift' => '1',
        'sunday_time_in' => $time_in,
        'sunday_time_out' => $time_out,

    ];
});
