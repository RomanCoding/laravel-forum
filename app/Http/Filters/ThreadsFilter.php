<?php

namespace App\Http\Filters;

use App\User;
use Carbon\Carbon;

class ThreadsFilter extends Filter
{
    protected $filters = ['by', 't', 'sort'];

    private $timePeriods = ['hour', 'day', 'week', 'month', 'year'];

    /**
     * Filters the query by a given username.
     *
     * @param string $userName
     * @return mixed
     */
    protected function by($userName)
    {
        $user = User::whereName($userName)->firstOrFail();
        return $this->query->where(['user_id' => $user->id]);
    }

    /**
     * Filters the query by a given time period.
     *
     * @param string $period
     * @return mixed
     */
    protected function t($period)
    {
        if (in_array($period, $this->timePeriods) && method_exists(Carbon::class, $method = 'sub' . $period))
            return $this->query->where('created_at', '>', Carbon::now()->$method());
        return $this->query;
    }


    /**
     * Filters the query in a requested order.
     *
     * @param $by
     * @return mixed
     */
    protected function sort($by)
    {
        if ($by == 'popular') {
            $this->query->getQuery()->orders = [];
            return $this->query->orderBy('replies_count', 'desc');
        }
        return $this->query->latest();
    }
}
