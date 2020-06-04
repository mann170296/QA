<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Answer;
use App\User;

use Faker\Generator as Faker;

$factory->define(Answer::class, function (Faker $faker) {
    return [
        'body' => $faker->paragraph(rand(3, 7), true),
        'votes_count' => rand(0, 10),
        'user_id' => User::where('id', '>', '0')->pluck('id')->random(),
    ];
});
