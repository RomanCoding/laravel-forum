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
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function a_user_can_view_all_threads()
    {
        $threads = factory('App\Thread', 50)->create();
        $response = $this->get('/threads');

        $response->assertSee('All threads');
        foreach ($threads as $thread) {
            $response->assertSee($thread->title);
        }
    }

    /**
     * @test
     */
    public function a_user_can_view_single_thread()
    {
        $thread = factory('App\Thread')->create();
        $response = $this->get('/threads/' . $thread->id);

        $response->assertSee($thread->title);
        $response->assertSee($thread->body);
    }
}
