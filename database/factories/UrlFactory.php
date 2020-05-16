<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Url;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(Url::class, function (Faker $faker) {
    $appUrl = env('APP_URL');
    $randomKey = Str::lower(Str::random(3));
    return [
        'link' => $faker->url,
        'shortlink' => $appUrl . $faker->word . "-" . $randomKey
    ];
});
