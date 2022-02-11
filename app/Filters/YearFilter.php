<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class YearFilter extends AbstractFilter
{
    /**
     * @param int $year
     */
    public function startYear(int $year)
    {
        $this->builder->where('year', '>=', $year);
    }

    /**
     * @param int $year
     */
    public function stopYear(int $year)
    {
        $this->builder->where('year', '<=', $year);
    }
}
