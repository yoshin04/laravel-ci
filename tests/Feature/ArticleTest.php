<?php

namespace Tests\Feature;

use App\Article;
use App\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    use RefreshDatabase;

    public function testIsLikedByNull()
    {
        $article = factory(Article::class)->create();
        //ArticleモデルがDBに保存される

        $result = $article->isLikedBy(null);
        //ArtucleクラスのisLikeByメソッドを使用した戻り値が$resultに代入

        $this->assertFalse($result);
        //$this = TestCaseを継承したArticleTestクラス
        //assertFalse = 引数がfalseかどうかテストをする
    }

    public function testIsLikedByTheUser()
    {
        $article = factory(Article::class)->create();
        //Articleモデルをデータベースに保存
        $user = factory(User::class)->create();
        //Userモデルをデータベースに保存
        $article->likes()->attach($user);
        //いいねをする
        //likesテーブルのuser_id -> $userのid
        //likesテーブルのarticle_id -> $articleのid

        $result = $article->isLikedBy($user);
        //戻り値が変数$resultに代入される
        //$userは、$articleをいいねしたユーザー
        //$resultにはtrueが代入される

        $this->assertTrue($result);
        //assertTrueメソッドは、引数がtureであるか確認をする
    }

    public function testIsLikedByAnother()
    {
        $article = factory(Article::class)->create();
        $user = factory(User::class)->create();
        $another = factory(User::class)->create();
        $article->likes()->attach($another);
        //$anotherが代入されたUserモデルのインスタンスが、$articleをいいねしている->自分ではない他人がいいねをする

        $result = $article->isLikedBy($user);
        //$userは、この$articleをいいねしていないユーザーなため、falseが代入

        $this->assertFalse($result);
        //assertFalseメソッドは、引数がfalseかどうかをテスト
    }
}
