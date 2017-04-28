<?php

namespace App\Traits;

use App\Like;

trait Likeable
{
    /**
     * Object can have many likes.
     *
     * @return mixed
     */
    public function likes()
    {
        return $this->morphMany(Like::class, 'liked');
    }

    /**
     * Like an object by given user.
     *
     * @param $userId
     * @return mixed
     */
    public function like($userId)
    {
        return $this->likes()->create([
            'user_id' => $userId,
        ]);
    }

    /**
     * Check if an object was already liked by current user.
     *
     * @return bool
     */
    public function isLiked()
    {
        return !! $this->likes->where('user_id', auth()->id())->count();
    }

    public function getLikesCountAttribute()
    {
        return $this->likes->count();
    }
}