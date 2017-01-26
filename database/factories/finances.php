<?php

$factory->define(App\Models\Finances\Finance::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->sentence,
        'description' => $faker->optional->paragraph,
        'amount' => $faker->randomFloat,
        'type' => $faker->randomElement(config('protecms.finances.type')),
        'reason' => $faker->randomElement(config('protecms.finances.reason')),
        'executed_at' => $faker->dateTime->format('Y-m-d H:i:s'),
    ];
});
