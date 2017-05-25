<?php

namespace Tests\Feature;

use Illuminate\Auth\AuthenticationException;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ThreadSubscribingTest extends TestCase
{
    use DatabaseMigrations;

    protected $thread;

    public function setUp()
    {
        parent::setUp();

        $this->thread = create('App\Thread');
    }

    /** @test */
    public function authenticated_user_can_subscribe_to_a_thread()
    {
        $this->signIn();
        $this->post($this->thread->path() . '/subscribe');
        $this->assertCount(1, $this->thread->subscribers);
        $this->assertCount(1, auth()->user()->subscriptions);
    }

    /** @test */
    public function guests_can_not_subscribe_to_any_thread()
    {
        $this->expectException(AuthenticationException::class);
        $this->post($this->thread->path() . '/subscribe');
    }

    /** @test */
    public function user_can_unsubscribe_from_a_thread()
    {
        $this->signIn($user = create('App\User'));
        $this->post($this->thread->path() . '/subscribe');
        $this->assertCount(1, $this->thread->subscribers);
        $this->assertCount(1, $user->subscriptions);
        $this->delete($this->thread->path() . '/subscribe');
        $this->assertCount(0, $this->thread->fresh()->subscribers);
        $this->assertCount(0, $user->fresh()->subscriptions);
    }
}
