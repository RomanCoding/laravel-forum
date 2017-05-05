<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $guarded = [];

    public function subject()
    {
        return $this->morphTo();
    }

    /**
     * Get last activity of the user.
     *
     * @param User $user
     * @param int $entries
     * @return mixed
     */
    public static function feed(User $user, $entries = 30)
    {
        return static::where('user_id', $user->id)->latest()
            ->with('subject')->take($entries)->get()
            ->groupBy(function ($activity) {
                return $activity->created_at->format('Y-m-d');
            });
    }
}
