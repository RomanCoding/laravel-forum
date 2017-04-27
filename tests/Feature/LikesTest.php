<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LikesTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_guests_can_not_like_any_reply()
    {
        $this->withExceptionHandling()
            ->post("/likes/reply/1")
            ->assertRedirect('login');
    }
    
    /** @test */
    public function an_authenticated_user_can_like_reply()
    {
        $this->signIn();
        $reply = create('App\Reply');
        $this->post("/likes/reply/{$reply->id}");

        $this->assertCount(1, $reply->likes);
    }

    /** @test */
    public function an_authenticated_user_can_like_reply_only_once()
    {
        $this->signIn();
        $reply = create('App\Reply');
        $this->post("/likes/reply/{$reply->id}");
        $this->post("/likes/reply/{$reply->id}");

        $this->assertCount(1, $reply->likes);
    }
}
