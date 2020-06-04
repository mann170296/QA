<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Question;
use Faker\Generator as Faker;

$factory->define(Question::class, function (Faker $faker) {
    return [
        'title' => rtrim($faker->sentence(rand(5, 10)), "."), // rtrim removes the . at the end of sentence
        'body' => $faker->paragraphs(rand(3, 7), true),
        'views' => rand(0, 10),
     //   'answers_count' => rand(0, 10),
        'votes' => rand(-3, 5),
        'user_id' => rand(1,3),
    ];
});
