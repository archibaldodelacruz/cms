<?php

$factory->define(App\Models\Widgets\Widget::class, function (Faker\Generator $faker) {
    return [
        'web_id' => function () {
            return factory(App\Models\Webs\Web::class)->create()->id;
        },
        'file'    => $faker->randomElement(config('protecms.widgets.files')),
        'status'  => $faker->randomElement(config('protecms.widgets.status')),
        'side'    => $faker->randomElement(config('protecms.widgets.side')),
        'order'   => $faker->randomNumber,
        'type'    => $faker->randomElement(config('protecms.widgets.type')),
        'es'      => [
            'title' => $faker->sentence,
            'content' => $faker->paragraph,
        ],
    ];
});
