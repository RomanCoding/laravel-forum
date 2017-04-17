<?php

namespace Tests\Feature;

use App\Thread;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RepliesTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function a_user_can_view_all_replies_for_thread()
    {
        $thread = factory('App\Thread')->create();
        factory('App\Reply', 10)->create(['thread_id' => $thread->id]);
        $response = $this->get('/threads/' . $thread->id);

        foreach ($thread->replies as $reply)
        {
            $response->assertSee($reply->body);
        }
    }
}
