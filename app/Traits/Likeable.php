<?php

namespace App\Traits;

use App\Activity;
use App\Like;

trait Likeable
{
    protected static function bootLikeable()
    {
        self::deleting(function ($subject) {
            $subject->likes->each->delete();
        });
    }

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
     * Remove like from an object by given user.
     *
     * @param $userId
     * @return mixed
     */
    public function unlike($userId)
    {
        $this->likes()
            ->whereUserId($userId)
            ->firstOrFail()
            ->activity()
            ->delete();
        return $this->likes()
            ->whereUserId($userId)
            ->delete();
    }

    /**
     * Check if an object was already liked by current user.
     *
     * @return bool
     */
    public function isLiked()
    {
        return !!$this->likes->where('user_id', auth()->id())->count();
    }

    public function getIsLikedAttribute()
    {
        return $this->isLiked();
    }

    public function getLikesCountAttribute()
    {
        return $this->likes->count();
    }
}