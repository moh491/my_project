<?php

namespace App\Filtering;

use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Database\Eloquent\Builder;

class FilterProjects {

    public function filterAll(): array
    {
        return [
             AllowedFilter::callback('skills', function (Builder $query, $value) {
                $values = is_string($value) ? explode(',', $value) : (array) $value;
                $values = array_map('intval', $values);

                $query->whereHas('skills', function (Builder $query) use ($values) {
                    $query->whereIn('skills.id', $values);
                });
            }),

             AllowedFilter::callback('classification', function (Builder $query, $value) {
                $values = is_string($value) ? explode(',', $value) : (array) $value;
                $values = array_map('intval', $values);

                $query->whereHas('field', function (Builder $query) use ($values) {
                    $query->whereIn('fields.id', $values);
                });
            }),

             AllowedFilter::callback('average_salary', function (Builder $query, $value) {
                $value = (array) $value;
                $query->whereRaw('min_budget <= ? AND max_budget >= ?', [$value, $value]);
            }),

             AllowedFilter::callback('search', function (Builder $query, $value) {
                $query->where(function ($query) use ($value) {
                    $query->whereHas('field', function (Builder $companyQuery) use ($value) {
                        (new SearchFilter(['name']))->__invoke($companyQuery, $value, 'fields');
                    });
                    $query->orWhereHas('skills', function (Builder $skillQuery) use ($value) {
                        (new SearchFilter(['name']))->__invoke($skillQuery, $value, 'skills');
                    });
                    $query->orWhere(function ($query) use ($value) {
                        $query->whereRaw('? BETWEEN min_budget AND max_budget', [$value])
                            ->orWhere('duration', $value)
                            ->orWhere('description', 'like', "%$value%")
                            ->orWhere('title', 'like', "%$value%")
                            ->orWhereDate('created_at', $value);
                    });
                });
            }),
        ];
    }


}

