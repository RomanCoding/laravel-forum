<?php

namespace App\Http\Controllers;

use App\Thread;
use Illuminate\Http\Request;

class ReplyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param $channel
     * @param Thread $thread
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request, $channel, Thread $thread)
    {
        $this->validate($request, [
            'body' => 'required',
        ]);
        $thread->addReply([
            'user_id' => $request->user()->id,
            'body' => $request->body,
        ]);
        return redirect($thread->path());
    }
}
