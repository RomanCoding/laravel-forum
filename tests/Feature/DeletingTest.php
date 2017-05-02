<?php

namespace Tests\Feature;

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
}
