<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    protected $fillable = ['name', 'slug'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Fetch link to current channel.
     *
     * @return string
     */
    public function path()
    {
        return "/threads/{$this->slug}";
    }

    /**
     * A channel has many threads.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function threads()
    {
        return $this->hasMany(Thread::class);
    }
}
