<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ParticipateInThreadTest extends TestCase
{
    use DatabaseMigrations;

    protected $thread;
    protected $reply;

    public function setUp()
    {
        parent::setUp();

        $this->thread = create('App\Thread');
        $this->reply = make('App\Reply');
    }

    /** @test */
    public function a_thread_can_have_reply()
    {
        $this->signIn();
        $this->post($this->thread->path(), $this->reply->toArray());
        $this->assertCount(1, $this->thread->replies);
    }

    /** @test */
    public function a_user_can_view_all_replies_for_thread()
    {
        $response = $this->get($this->thread->path());
        foreach ($this->thread->replies as $reply) {
            $response->assertSee($reply->body);
        }
    }

    /** @test */
    public function a_reply_can_not_be_empty()
    {
        $this->withExceptionHandling()->signIn();
        $response = $this->post($this->thread->path(), make('App\Reply', ['body' => null])->toArray());
        $response->assertSessionHasErrors('body');
    }

    /** @test */
    public function guest_can_not_edit_any_reply()
    {
        $reply = create('App\Reply');
        $this->withExceptionHandling()
            ->patch("/replies/{$reply->id}", ['body' => 'new body'])
            ->assertRedirect('login');
    }

    /** @test */
    public function a_user_can_edit_only_his_replies()
    {
        $this->signIn();
        $reply = create('App\Reply');
        $this->withExceptionHandling()
            ->patch("/replies/{$reply->id}", ['body' => 'New body'])
            ->assertStatus(403);
        $replyByUser = create('App\Reply', ['user_id' => auth()->id()]);
        $this->patch("/replies/{$replyByUser->id}", ['body' => 'New body']);
        $this->assertDatabaseHas('replies', ['id' => $replyByUser->id, 'body' => 'New body']);
    }
}
