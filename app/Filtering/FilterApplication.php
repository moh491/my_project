<?php

namespace App\Filtering;

use App\Filtering\SearchFilter;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Database\Eloquent\Builder;

class FilterApplication {

    public function filterAll(): array
    {
        return [
             AllowedFilter::callback('experience_year', function (Builder $query, $values) {
                 $values = is_array($values) ? $values : explode(',', $values);

                 $values = array_map('intval', $values);

                 $values = array_filter($values, function($value) {
                    return $value > 0 && $value <= 50;
                });

                if (!empty($values)) {
                    $query->whereIn('experience_year', $values);
                }
            }),


             AllowedFilter::callback('budget', function (Builder $query, $values) {
                $values = is_array($values) ? $values : explode(',', $values);

                 $values = array_map('floatval', $values);

                if (!empty($values)) {
                    $query->whereIn('budget', $values);
                }
            }),
        ];
    }

}

