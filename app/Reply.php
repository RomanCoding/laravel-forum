<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Reply extends Model
{
    protected $guarded = [];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'liked');
    }

    public function like($userId)
    {
        return $this->likes()->create([
            'user_id' => $userId,
        ]);
    }
}
