<?php

use Faker\Generator as Faker;
use App\Excerpt;

$factory->define(Excerpt::class, function (Faker $faker) {
    return [
        Excerpt::create(['content' => 'When the people fear the government, there is tyranny. When government fears the people, there is liberty.', 'author' => 'Thomas Jefferson']),
        //Excerpt::create(['content' => '...', 'author' => '...'])
    ];
});
