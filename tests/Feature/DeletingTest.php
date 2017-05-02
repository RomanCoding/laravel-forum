<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class DeletingTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function guests_can_not_delete_any_thread()
    {
        $this->withExceptionHandling();
        $thread = create('App\Thread');
        $this->delete($thread->path())->assertRedirect('/login');
    }

    /** @test */
    public function an_authenticated_user_can_delete_thread()
    {
        $this->signIn();
        $thread = create('App\Thread', [
            'user_id' => auth()->id()
        ]);
        $reply = create('App\Reply', ['thread_id' => $thread->id]);
        $this->json('DELETE', $thread->path());
        $this->assertDatabaseMissing('threads', ['id' => 1]);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
    }
}
