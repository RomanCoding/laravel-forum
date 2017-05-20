<?php

namespace App\Http\Controllers;


use App\Thread;

class ThreadSubscriptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store($channel, Thread $thread)
    {
        auth()->user()->subscribeToThread($thread);
    }

    public function destroy($channel, Thread $thread)
    {
        auth()->user()->unsubscribeFromThread($thread);
    }
}
