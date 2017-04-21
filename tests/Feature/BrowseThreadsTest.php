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
}
