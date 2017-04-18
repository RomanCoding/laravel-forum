<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{

    /**
     * Fetch link to current thread.
     *
     * @return string
     */
    public function path()
    {
        return '/threads/' . $this->id;
    }

    /**
     * Thread can has many replies.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    /**
     * Thread is created by a user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    /**
     * Add a reply for current thread.
     *
     * @param $reply
     */
    public function addReply($reply)
    {
        $this->replies()->create($reply);
    }
}
