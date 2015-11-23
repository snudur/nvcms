<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/


$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Page::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->sentence(2),
        'content' => '<p>'.$faker->paragraph(1).'</p>'.'<p>'.$faker->paragraph(3).'</p>'.'<p>'.$faker->paragraph(3).'</p>'.'<p>'.$faker->paragraph(2).'</p>'.'<p>'.$faker->paragraph(1).'</p>',
        'parent_id' => 0,
        'topmenu' => 1,
        'slug' => $faker->slug,
        'status' => 1,
        'images' => [],
    ];
});



$factory->define(App\News::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->sentence(3),
        'content' => '<p>'.$faker->paragraph(1).'</p>'.'<p>'.$faker->paragraph(3).'</p>'.'<p>'.$faker->paragraph(3).'</p>'.'<p>'.$faker->paragraph(2).'</p>'.'<p>'.$faker->paragraph(1).'</p>',
        'parent_id' => 0,
        'published_at' => $faker->dateTimeBetween('-1 years', 'now'),
        'slug' => $faker->slug,
        'status' => 1,
        'images' => [],
    ];
});




$factory->define(App\Product::class, function (Faker\Generator $faker) {
    $prices = [
        '1990',
        '2250',
        '1890',
        '5590',
        '8890',
    ];

    return [
        'title' => $faker->sentence(3),
        'price' => $prices[mt_rand(0,4)],
        'featured' => 0,
        'content' => '<p>'.$faker->paragraph(2).'</p>',
        'slug' => $faker->slug,
        'category_id' => 0,
        'status' => 1,
        'images' => [],
    ];
});

function makeImages($num) {
    $arr = [];

    for($i = 0; $i <= $num; $i++) {
        $file = public_path().'/uploads/'.mt_rand(1,50).'.jpg';

        $size = getimagesize($file);

        $arr[] = [
            'width' => $size[0],
            'height' => $size[1],
            'name'  => mt_rand(1,50).'.jpg',
            'title' => 'mynd'
        ];
    }

    return $arr;
}

$factory->define(App\Category::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->sentence(3),
        'content' => '<p>'.$faker->paragraph(1).'</p>'.'<p>'.$faker->paragraph(3).'</p>'.'<p>'.$faker->paragraph(3).'</p>'.'<p>'.$faker->paragraph(2).'</p>'.'<p>'.$faker->paragraph(1).'</p>',
        'slug' => $faker->slug,
        'status' => 1,
        //'images' => makeImages(6)
    ];
});