<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * A user can have threads created by him.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function threads()
    {
        return $this->hasMany(Thread::class);
    }

    /**
     * Get given amount of latest user's threads.
     *
     * @param int $count
     * @return mixed
     */
    public function latestThreads(int $count)
    {
        return $this->threads()->latest()->limit($count)->get();
    }

    /**
     * A user can have replies written by him.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function getLikesCountAttribute()
    {
        return $this->replies()->has('likes')->count();
    }

    /**
     * Fetch link to user's profile.
     *
     * @return string
     */
    public function profile()
    {
        return "/profiles/{$this->id}";
    }

    public function activity()
    {
        return $this->hasMany(Activity::class);
    }

    /**
     * Get last activity of the user.
     *
     * @param $entries
     * @return mixed
     */
    public function getLastActivity($entries)
    {
        return $this->activity()->latest()->with('subject')->take($entries)->get()->groupBy(function ($activity) {
            return $activity->created_at->format('Y-m-d');
        });
    }
}
