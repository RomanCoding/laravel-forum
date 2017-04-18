<?php

namespace Tests\Feature;

use App\Thread;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ThreadsTest extends TestCase
{
    use DatabaseMigrations;

    protected $threads;
    protected $thread;

    public function setUp()
    {
        parent::setUp();

        $this->threads = factory('App\Thread', 50)->create();
        $this->thread = factory('App\Thread')->create();
    }

    /** @test */
    public function a_user_can_view_all_threads()
    {
        $response = $this->get('/threads');
        $response->assertSee('All threads');
        foreach ($this->threads as $thread) {
            $response->assertSee($thread->title);
        }
    }

    /** @test */
    public function a_user_can_view_single_thread()
    {
        $response = $this->get($this->thread->path());
        $response->assertSee($this->thread->title);
        $response->assertSee($this->thread->body);
    }

    /** @test */
    public function a_thread_can_have_reply()
    {
        $this->be($user = factory('App\User')->create());
        $reply = factory('App\Reply')->create();
        $this->post($this->thread->path(), $reply->toArray());
        $this->assertCount(1, $this->thread->replies);
    }
}
