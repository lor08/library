<?php

namespace App\Traits;

use App\Filters\AbstractFilter;
use Illuminate\Database\Eloquent\Builder;

trait Filterable
{
    /**
     * @param Builder $builder
     * @param AbstractFilter $filter
     */
    public function scopeFilter(Builder $builder, AbstractFilter $filter)
    {
        $filter->apply($builder);
    }
}
