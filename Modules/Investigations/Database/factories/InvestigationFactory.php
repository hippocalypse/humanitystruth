<?php

use Faker\Generator as Faker;
use Modules\Investigations\Entities\Investigation;

$factory->define(Investigation::class, function (Faker $faker) {
    return [
        'account_id' => 0,
        'title' => $faker->sentence,
        'objective' => $faker->sentence,
    ];
});
