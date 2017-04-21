<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateThreadTest extends TestCase
{
    use DatabaseMigrations;

    protected $thread;

    public function setUp()
    {
        parent::setUp();

        $this->thread = make('App\Thread');
    }

    /** @test */
    public function an_authenticated_user_can_create_thread()
    {
        $this->signIn();
        $this->get("/threads/create");
        $response = $this->post("/threads", $this->thread->toArray());
        $this->get($response->headers->get('Location'))
            ->assertSee($this->thread->title)
            ->assertSee($this->thread->body);
    }

    /** @test */
    public function guest_can_not_create_threads()
    {
        $this->withExceptionHandling()->get('/threads/create')->assertRedirect('/login');
        $this->disableExceptionHandling();
        $this->expectException('Illuminate\Auth\AuthenticationException');
        $this->publishThread();
    }

    /** @test */
    public function a_title_is_required()
    {
        $this->withExceptionHandling()->signIn();
        $response = $this->publishThread(['title' => null]);
        $response->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_body_is_required()
    {
        $this->withExceptionHandling()->signIn();
        $response = $this->publishThread(['body' => null]);
        $response->assertSessionHasErrors('body');
    }

    /** @test */
    public function a_channel_should_be_valid()
    {
        $this->withExceptionHandling()->signIn();
        $response = $this->publishThread(['channel_id' => 99999]);
        $response->assertSessionHasErrors('channel_id');
    }

    /**
     * Make a thread object, send POST request to create a thread.
     *
     * @param array $overrides
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    private function publishThread($overrides = [])
    {
        return $this->post("/threads", make('App\Thread', $overrides)->toArray());
    }
}
