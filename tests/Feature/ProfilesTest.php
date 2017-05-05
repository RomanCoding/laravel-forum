<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ProfilesTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_user_have_public_profile()
    {
        $user = create('App\User');
        $this->get("profiles/{$user->id}")
            ->assertSee($user->name);
    }

    /** @test */
    public function a_profile_shows_user_activity()
    {
        $this->signIn();
        $thread = create('App\Thread', ['user_id' => auth()->id()]);

        $this->get(auth()->user()->profile())
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }
}
