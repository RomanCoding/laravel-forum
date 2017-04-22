<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class BrowseThreadsTest extends TestCase
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
    public function a_user_can_view_threads_from_channel()
    {
        $channel = create('App\Channel');
        $thread = create('App\Thread', ['channel_id' => $channel->id]);
        $anotherThread = create('App\Thread');
        $this->get($channel->path())
             ->assertSee($thread->title, $thread->body)
             ->assertDontSee($anotherThread->title, $anotherThread->body);
    }

    /** @test */
    public function a_user_can_view_threads_created_by_any_user()
    {
        $this->signIn(create('App\User', ['name' => 'NameForTest']));
        $threadByUser = create('App\Thread', ['user_id' => auth()->id()]);
        $threadByAnotherUser = create('App\Thread');

        $this->get("/threads?by=NameForTest")
             ->assertSee($threadByUser->title)
             ->assertDontSee($threadByAnotherUser->title);
    }
}
