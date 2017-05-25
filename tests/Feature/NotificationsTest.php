<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class NotificationsTest extends TestCase
{
    use DatabaseMigrations;

    protected $thread;

    public function setUp()
    {
        parent::setUp();

        $this->thread = create('App\Thread');
    }

    /** @test */
    public function notification_for_user_is_prepared_when_subscribed_thread_reveives_a_reply()
    {
        $this->signIn($user = create('App\User'));
        $this->post($this->thread->path() . '/subscribe');
        $this->thread->addReply([
            'user_id' => create('App\User')->id,
            'body' => 'placeholder'
        ]);
        $this->assertCount(1, $user->notifications);
    }

    /** @test */
    public function notification_for_user_is_not_prepared_when_subscribed_thread_reveives_a_reply_from_this_user()
    {
        $this->signIn($user = create('App\User'));
        $this->post($this->thread->path() . '/subscribe');
        $reply = make('App\Reply', [
            'thread_id' => $this->thread->id,
            'user_id' => $user->id
        ]);
        $this->post($this->thread->path(), $reply->toArray());
        $this->assertCount(0, $user->notifications);
    }

    /** @test */
    public function users_can_mark_their_notifications_as_read()
    {
        $this->signIn($user = create('App\User'));
        $this->post($this->thread->path() . '/subscribe');
        $this->thread->addReply([
            'user_id' => create('App\User')->id,
            'body' => 'placeholder'
        ]);
        $this->assertCount(1, $user->unreadNotifications);
        $notificationId = $user->notifications->first()->id;
        $this->delete('/profiles/' . $user->id . '/notifications/' . $notificationId);
        $this->assertCount(0, $user->fresh()->unreadNotifications);
    }

    /** @test */
    public function a_user_can_fetch_his_notifications()
    {
        $this->signIn($user = create('App\User'));
        $this->post($this->thread->path() . '/subscribe');
        $this->thread->addReply([
            'user_id' => create('App\User')->id,
            'body' => 'placeholder'
        ]);
        $response = $this->getJson('/profiles/' . $user->id . '/notifications')->json();
        $this->assertCount(1, $response);
    }
}
