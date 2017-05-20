<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class BrowseThreadsTest extends TestCase
{
    use DatabaseMigrations;

    protected $thread;

    public function setUp()
    {
        parent::setUp();

        $this->thread = create('App\Thread');
    }

    /** @test */
    public function a_user_can_view_all_threads()
    {
        $thread = create('App\Thread');
        $this->get('/threads')
             ->assertSee($thread->title)
             ->assertSee($this->thread->title);
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
             ->assertSee($thread->title)
             ->assertDontSee($anotherThread->title);
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

    /** @test */
    public function a_user_can_filter_threads_by_popularity()
    {
        $threadWithOneReply = $this->thread;
        create('App\Reply', ['thread_id' => $threadWithOneReply->id]);
        $threadWithFiveReplies = create('App\Thread');
        create('App\Reply', ['thread_id' => $threadWithFiveReplies->id], 5);
        $threadWithThreeReplies = create('App\Thread');
        create('App\Reply', ['thread_id' => $threadWithThreeReplies->id], 3);

        $response = $this->getJson('/threads?sort=popular')->json();
        $this->assertEquals([5, 3, 1], array_column($response, 'replies_count'));
    }

    /** @test */
    public function a_user_can_filter_threads_by_new()
    {
        $firstThread = $this->thread;
        $anotherThread = create('App\Thread', ['created_at' => Carbon::now()->subHour()]);

        $response = $this->getJson('/threads?sort=new')->json();
        $this->assertEquals([1, 2], array_column($response, 'id'));
    }

    /** @test */
    public function a_user_can_browse_unanswered_threads()
    {
        create('App\Reply', ['thread_id' => $this->thread->id]);
        $threadWithoutReplies = create('App\Thread');

        $this->get('/threads?sort=unanswered')
            ->assertSee($threadWithoutReplies->body)
            ->assertDontSee($this->thread->body);
    }

    /** @test */
    public function a_user_can_browse_unanswered_threads_for_time_period()
    {
        create('App\Reply', ['thread_id' => $this->thread->id]);
        $threadWithoutReplies = create('App\Thread');
        $oldThreadWithoutReplies = create('App\Thread', ['created_at' => Carbon::now()->subDay()]);

        $this->get('/threads?sort=unanswered&t=hour')
            ->assertSee($threadWithoutReplies->body)
            ->assertDontSee($oldThreadWithoutReplies->body)
            ->assertDontSee($this->thread->body);
    }

    /** @test */
    public function a_user_can_filter_threads_by_popularity_and_author()
    {
        $this->signIn(create('App\User', ['name' => 'NameForTest']));
        $threadByUserWithThreeReplies = create('App\Thread', ['user_id' => auth()->id()]);
        $threadByUserWithOneReply = create('App\Thread', ['user_id' => auth()->id()]);
        $threadByAnotherUser = create('App\Thread');

        create('App\Reply', ['thread_id' => $threadByUserWithThreeReplies->id], 3);
        create('App\Reply', ['thread_id' => $threadByUserWithOneReply->id]);

        $response = $this->getJson("/threads?by=NameForTest&sort=popular")->json();
        $this->assertEquals([3, 1], array_column($response, 'replies_count'));
    }

    /** @test */
    public function a_user_can_fetch_replies_for_any_thread()
    {
        $thread = create('App\Thread');
        create('App\Reply', ['thread_id' => $thread->id], 10);
        $response = $this->getJson($thread->path() . '/replies')->json();
        $this->assertEquals(10, $response['total']);
        $this->assertCount(10, $response['data']);
    }
}
