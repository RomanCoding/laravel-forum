<?php

namespace App;

use App\Http\Filters\ThreadsFilter;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    protected $with = ['channel', 'creator'];

    protected $fillable = ['title', 'body', 'user_id', 'channel_id'];

    protected static function boot()
    {
        parent::boot();

        self::addGlobalScope('replyCount', function ($builder) {
            $builder->withCount('replies');
        });

        self::deleting(function($thread) {
            $thread->replies()->delete();
        });
    }

    /**
     * Fetch link to current thread.
     *
     * @return string
     */
    public function path()
    {
        return "/threads/{$this->channel->slug}/{$this->id}";
    }

    /**
     * Thread can have many replies.
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
     * Thread belongs to a channel.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function channel()
    {
        return $this->belongsTo('App\Channel');
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

    /**
     * Filter query.
     *
     * @param $query
     * @param ThreadsFilter $filter
     */
    public function scopeFilter($query, ThreadsFilter $filter)
    {
        return $filter->apply($query);
    }

    /**
     * Filter query, paginate and build proper GET params.
     *
     * @param $query
     * @param ThreadsFilter $filter
     * @param int $perPage
     * @return mixed
     */
    public function scopeFilterAndPaginate($query, ThreadsFilter $filter, $perPage)
    {
        return $filter->apply($query)->paginate($perPage)->appends($filter->getFilters());
    }
}
