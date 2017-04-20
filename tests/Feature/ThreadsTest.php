<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ThreadsTest extends TestCase
{
    use DatabaseMigrations;

    protected $threads;
    protected $thread;

    public function setUp()
    {
        parent::setUp();

        $this->threads = factory('App\Thread', 50)->create();
        $this->thread = create('App\Thread');
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
        $response->assertSee($this->thread->title)
                 ->assertSee($this->thread->body);
    }

    /** @test */
    public function a_thread_can_have_reply()
    {
        $this->signIn();
        $reply = create('App\Reply');
        $this->post($this->thread->path(), $reply->toArray());
        $this->assertCount(1, $this->thread->replies);
    }

    /** @test */
    public function an_authenticated_user_can_create_thread()
    {
        $this->signIn();
        $this->post("/threads", $this->thread->toArray());
        $this->get($this->thread->path())
             ->assertSee($this->thread->title)
             ->assertSee($this->thread->body);
    }

    /** @test */
    public function guest_can_not_create_threads()
    {
        $this->withExceptionHandling()->get('/threads/create')->assertRedirect('/login');
        $this->disableExceptionHandling();
        $this->expectException('Illuminate\Auth\AuthenticationException');
        $this->post('/threads/channel', $this->thread->toArray());
    }

    /** @test */
    public function an_authenticated_user_can_see_form_of_new_thread()
    {
        $this->signIn();
        $this->get('/threads/create')->assertSee('Create new thread');
    }
}
