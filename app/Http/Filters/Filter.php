<?php

namespace App\Http\Filters;

use Illuminate\Http\Request;

abstract class Filter
{
    protected $request;
    protected $query;

    /**
     * Filter constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Apply filters to a query.
     *
     * @param $query
     */
    public function apply($query)
    {
        $this->query = $query;
        foreach ($this->getFilters() as $filter => $value) {
            if (!method_exists($this, $filter)) return;
            $this->$filter($value);
        }
        return $this->query;
    }

    /**
     * Return allowed filters from the request.
     *
     * @return array
     */
    public function getFilters()
    {
        return $this->request->intersect($this->filters);
    }
}