<?php

namespace App\Filtering;

use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Database\Eloquent\Builder;

class FilterProjects {

    public function filterAll(): array
    {
        return [
            AllowedFilter::callback('classification', function (Builder $query, $value) {
                $query->whereHas('field', function (Builder $query) use ($value) {
                    $query->whereIn('id', $value);
                });
            }),

            AllowedFilter::callback('skills', function (Builder $query, $value) {
                $query->whereHas('skills', function (Builder $query) use ($value) {
                    $query->whereIn('skills.id', $value);
                });
            }),

            AllowedFilter::callback('deliveryDurations', function (Builder $query, $value) {
                $query->where('duration', $value);
            }),

            AllowedFilter::callback('date_posted', function (Builder $query, $value) {
                $query->whereDate('created_at', $value);
            }),

            AllowedFilter::callback('salary_options', function (Builder $query, $value) {
                $query->whereRaw('((min_budget + max_budget) / 2) >= ?', [$value]);
            }),

            AllowedFilter::callback('search', function (Builder $query, $value) {

                $query->whereHas('field', function (Builder $fieldQuery) use ($value) {
                    (new SearchFilter(['name']))->__invoke($fieldQuery, $value, 'fields');
                });

                $query->orWhereHas('skills', function (Builder $skillQuery) use ($value) {
                    (new SearchFilter(['name']))->__invoke($skillQuery, $value, 'skills');
                });

                $query->orWhere(function ($query) use ($value) {
                    $query->whereRaw('? BETWEEN min_budget AND max_budget', [$value])
                        ->orWhere('duration',$value)
                        ->orwhere('description','like',"%$value%")
                        ->orwhere('title','like',"%$value%")
                        ->orWhereDate('created_at', $value);
                });
            }),
        ];
    }


}

