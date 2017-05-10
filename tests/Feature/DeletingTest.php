<?php

namespace Tests\Feature;

use App\Activity;
use Illuminate\Auth\Access\AuthorizationException;
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
    public function a_user_can_delete_only_his_threads()
    {
        $this->signIn();
        $thread = create('App\Thread', [
            'user_id' => auth()->id()
        ]);
        $threadByAnotherUser = create('App\Thread');
        $this->expectException(AuthorizationException::class);
        $this->delete($threadByAnotherUser->path());

        $this->delete($thread->path())
            ->assertStatus(204);
    }

    /** @test */
    public function it_delete_replies_and_activity_with_thread_deleting()
    {
        $this->signIn();
        $thread = create('App\Thread', [
            'user_id' => auth()->id()
        ]);
        $reply = create('App\Reply', [
            'thread_id' => $thread->id,
            'user_id' => auth()->id()
        ]);
        $this->delete($thread->path());
        $this->assertDatabaseMissing('replies', [
            'thread_id' => $thread->id,
        ]);
        $this->assertCount(0, Activity::all());
    }

    /** @test */
    public function guest_can_not_delete_any_reply()
    {
        $reply = create('App\Reply');
        $this->withExceptionHandling()
            ->delete("/replies/{$reply->id}")
            ->assertRedirect('login');
    }

    /** @test */
    public function a_user_can_delete_only_his_replies()
    {
        $this->signIn();
        $reply = create('App\Reply');
        $this->withExceptionHandling()
            ->delete("/replies/{$reply->id}")
            ->assertStatus(403);
        $replyByUser = create('App\Reply', ['user_id' => auth()->id()]);
        $this->delete("/replies/{$replyByUser->id}");
        $this->assertDatabaseMissing('replies', ['id' => $replyByUser->id]);
    }
}
