<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RepliesTest extends TestCase
{
    use DatabaseMigrations;

    protected $thread;

    public function setUp()
    {
        parent::setUp();
        $this->thread = create('App\Thread');
    }

    /** @test */
    public function a_user_can_view_all_replies_for_thread()
    {
        $response = $this->get($this->thread->path());
        foreach ($this->thread->replies as $reply)
        {
            $response->assertSee($reply->body);
        }
    }

    /** @test */
    public function an_authenticated_user_can_reply_to_a_thread()
    {
        $this->signIn();
        $reply = make('App\Reply');
        $this->post($this->thread->path(), $reply->toArray());
        $this->get($this->thread->path())->assertSee($reply->body);
    }

    /** @test */
    public function guest_can_not_reply_to_a_thread()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');
        $reply = make('App\Reply');
        $this->post($this->thread->path(), $reply->toArray());
    }

}
