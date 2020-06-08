<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Image;
use Faker\Generator as Faker;

$factory->define(Image::class, function (Faker $faker) {
    return [
        'title' => $faker->word,
        'path' => $faker->imageUrl($width = 640, $height = 480),
        'description' => $faker->sentence,
        'alter' => $faker->sentence,
    ];
});
