<?php

namespace Tests\Feature;

use App\Activity;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ActivityTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function activity_tracks_threads_creating()
    {
        $this->signIn();
        $thread = create('App\Thread');
        $this->assertCount(1, Activity::all());
        $this->assertDatabaseHas('activities', [
            'subject_id' => $thread->id,
            'subject_type' => 'App\Thread',
            'user_id' => auth()->id(),
            'activity' => 'created_thread',
        ]);
    }

    /** @test */
    public function activity_tracks_replying_to_threads()
    {
        $this->signIn();
        $reply = create('App\Reply');
        $this->assertCount(2, Activity::all());
        $this->assertDatabaseHas('activities', [
            'subject_id' => $reply->id,
            'subject_type' => 'App\Reply',
            'user_id' => auth()->id(),
            'activity' => 'created_reply',
        ]);
    }

    /** @test */
    public function activity_subject_is_correctly_related()
    {
        $this->signIn();
        $thread = create('App\Thread');
        $reply = create('App\Reply', [
            'thread_id' => $thread->id
        ]);
        $this->assertEquals(Activity::first()->subject->title, $thread->title);
        $this->assertEquals(Activity::orderBy('id', 'desc')->first()->subject->body, $reply->body);
    }
}
