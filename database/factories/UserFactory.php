<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $name = $faker->name,
        'phone' => $faker->phoneNumber,
        'avatar' => 'https://ui-avatars.com/api/?name='.$name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
    ];
});

$factory->define(\App\Message::class, function (Faker $faker) {
    do{
       $to = rand(1,15);
       $from = rand(1,15);
    }while($to == $from);

    return [
        'to' => $to,
        'from' => $from,
        'text' => $faker->sentence
    ];
});