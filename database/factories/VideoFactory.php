<?php

use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(App\Models\VideoModel::class, function (Faker $faker) {
    $now = Carbon::now()->toDateTimeString();
    return [
        'title' => $faker->title,
        'thum' => $faker->imageUrl(200,200),
        'sum'=>random_int(1,1000),
        'number'=>random_int(1,1000),
        'playerUrl' => $faker->url,
        'type_id'=>random_int(1,6),
        'created_at' => $now,
        'updated_at' => $now,
    ];
});
