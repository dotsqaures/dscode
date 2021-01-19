<?php

use Faker\Generator as Faker;
use Carbon\Carbon;

$factory->define(\Modules\AdminUserManager\Entities\AdminUser::class, function (Faker $faker) {
    $gender = ['male','female'];
    $genderIndex = array_rand($gender);

    $type = [1,2];
    $typeIndex = array_rand($type);

    $status = [1, 0];
    $statusIndex = array_rand($status);

    return [
        'name' => $faker->firstName,
        'email' => $faker->unique()->safeEmail,
        'mobile' => 7665880638,
        'email_verified_at' => Carbon::now(),
        'password' => bcrypt('123456'),
        'status' => $status[$statusIndex],
        'created_at' => Carbon::now(),
    ];
});
