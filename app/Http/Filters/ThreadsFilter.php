<?php

namespace App\Http\Filters;

use App\User;
use Illuminate\Http\Request;

class ThreadsFilter extends Filter
{
    protected $filters = ['by'];

    /**
     * Filters the query by a given username.
     *
     * @param $userName
     */
    protected function by($userName)
    {
        $user = User::whereName($userName)->firstOrFail();
        return $this->query->where(['user_id' => $user->id]);
    }
}
