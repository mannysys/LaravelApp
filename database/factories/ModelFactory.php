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
// 生成测试数据
$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'avatar' => $faker->imageUrl(256,256),
        'confirm_code' => str_random(48), //生成随机字符串
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Discussion::class, function (Faker\Generator $faker) {
    //获取出所有user表id
    $user_ids = \App\User::lists('id')->toArray();
    return [
        'title' => $faker->sentence,
        'body' => $faker->paragraph,
        'user_id' => $faker->randomElement($user_ids),  //将所有id随机分配
        'last_user_id' =>  $faker->randomElement($user_ids),
    ];
});


//生成评论测试数据
$factory->define(App\Comment::class, function (Faker\Generator $faker) {
    //获取出所有user表id
    $user_ids = \App\User::lists('id')->toArray();
    $discussion_ids = \App\Discussion::lists('id')->toArray();
    return [
        'body' => $faker->paragraph,
        'user_id' => $faker->randomElement($user_ids),
        'discussion_id' => $faker->randomElement($discussion_ids),

    ];
});