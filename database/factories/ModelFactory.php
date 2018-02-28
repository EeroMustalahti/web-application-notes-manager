<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;
    $name = $faker->unique()->name;

    return [
        'name' => $name,
        'slug' => str_slug($name),
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Note::class, function (Faker\Generator $faker) {
    $startDate = \Carbon\Carbon::now();
    $endDate = \Carbon\Carbon::now()->subYear();

    return [
        'title' => $faker->sentence,
        'body' => $faker->paragraph(2),
        'created_at' => \Carbon\Carbon::createFromTimestamp(rand($endDate->timestamp, $startDate->timestamp))->format('Y-m-d H:i:s'),
        'user_id' => random_int(1, 4),
    ];
});