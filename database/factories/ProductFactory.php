<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\{Type,Product};
use Faker\Generator as Faker;

$type_ids = Type::all()->pluck('id');
$factory->define(Product::class, function (Faker $faker) use ($type_ids){
    return [
        'title' => $faker->word,
        'description' => $faker->paragraph($nbSentences = 3, $variableNbSentences = true),
        'type_id' => $type_ids->random(),
        'status' => Product::STATUS_ACTIVE,
        'created_at' => $faker->dateTimeBetween($startDate = '-30 days', $endDate = 'now')
    ];
});
