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

    public function setUp()
    {
        parent::setUp();

        $this->threads = factory('App\Thread', 50)->create();
    }

    /**
     * @test
     */
    public function a_user_can_view_all_threads()
    {
        $response = $this->get('/threads');
        $response->assertSee('All threads');
        foreach ($this->threads as $thread) {
            $response->assertSee($thread->title);
        }
    }

    /**
     * @test
     */
    public function a_user_can_view_single_thread()
    {
        $thread = $this->threads->first();
        $response = $this->get('/threads/' . $thread->id);

        $response->assertSee($thread->title);
        $response->assertSee($thread->body);
    }
}
