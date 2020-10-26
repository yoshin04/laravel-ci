<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Article;
use App\User;
use Faker\Generator as Faker;

$factory->define(Article::class, function (Faker $faker) {
    return [
        'title' => $faker->text(50),
        'body' => $faker->text(5000),
        'user_id' => function() {
            return factory(User::class);
        }
        //外部キー制約を使用しているカラムをファクトリで取り扱うときは、「参照先のモデルを生成するfactory関数」を返すクロージャー（無名関数）をセットする
    ];
});
