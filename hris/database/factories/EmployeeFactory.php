<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\hris_employee;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Faker\Generator as Faker;

$factory->define(App\hris_employee::class, function (Faker $faker) {
	$gender = $faker->randomElement(['male', 'female']);
	$g = $gender[0];
	$firstname = $faker->firstName($gender);
	$lastname = $faker->lastName;
	$fn = substr($firstname, 0, 1);
	$ln = substr($lastname, 0, 1);
	$employee_number = $faker->unique()->numerify('####');
	$username = $fn.''.$ln.''.$employee_number;
    $role_id = ''.$faker->randomElement([',4,', ',5,']);
    
    $path = public_path('assets/images/employees/employee_photos');
    
	if ( $g == 'm' ) {
		$image = $faker->file($path.'/male/tmp', $path, false);
	} else {
		$image = $faker->file($path.'/female/tmp', $path, false);
	}
    return [
        //
        'employee_number' => $employee_number,
        'employee_photo' => $image,
        'username' => $username,
        'password' => Hash::make(1234),
        'firstname' => $firstname,
        'middlename' => NULL,
        'lastname' => $lastname,
        'nationality' => 'Filipino',
        'birthday' => $faker->date('Y-m-d'),
        'gender' => $gender,
        'place_birth' => $faker->address,
        'dependant' => NULL,
        'marital_status' => $faker->randomElement(['single', 'married', 'widower', 'divorced']),
        'work_address' => $faker->address,
        'home_address' => $faker->address,
        'home_distance' => NULL,
        'emergency_contact' => $faker->name,
        'emergency_no' => $faker->phoneNumber,
        'cert_level' => $faker->randomElement(['bachelor', 'master', 'doctoral']),
        'field_study' => $faker->randomElement(['Lorem', 'Ipsum', 'Dolor']),
        'school' => $faker->randomElement(['Lorem', 'Ipsum', 'Dolor']),
        'tin' => NULL,
        'pagibig' => NULL,
        'sss' => NULL,
        'phic' => NULL,
        'employment_status' => $faker->randomElement(['regular', 'co-terminus', 'probationary', 'fixed-term']),
        'work_no' => $faker->phoneNumber,
        'work_phone' => $faker->phoneNumber,
        'work_email' => $faker->companyEmail,
        'private_email' => $faker->freeEmail,
        'joined_date' => $faker->date('Y-m-d'),
        'termination_date' => NULL,
        'job_title_id' => $faker->numberBetween($min = 1, $max = 75),
        'department_id' => $faker->numberBetween($min = 1, $max = 26),
        'supervisor' => NULL,
        'pay_grade' => $faker->numberBetween($min = 1, $max = 3),
        'role_id' => $role_id,
        'last_login' => '0',
        'status' => 'active'


    ];
});
