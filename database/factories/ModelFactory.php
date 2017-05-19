<?php
/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {

    return [
        'name' => env('ADMIN_NAME'),
        'email' => env('ADMIN_EMAIL'),
        'password' => bcrypt(env('ADMIN_PASSWORD'))
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Post::class, function (Faker\Generator $faker) {
    $title = $faker->sentence;
    $slug = str_slug($title);
    return [
        'title' => $title,
        'body' => $faker->paragraph,
        'slug' => $slug,
        'uuid' => str_random(15)
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Category::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->sentence
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Tag::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->sentence
    ];
});