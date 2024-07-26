<?php

namespace App\Filtering;

use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filtering\SearchFilter;

class FilterJob
{

    public function filterAll(): array
    {
        return [

            AllowedFilter::callback('company', function (Builder $query, $value) {
                $query->whereHas('company', function (Builder $query) use ($value) {
                    $query->where('id', $value);
                });
            }),

            AllowedFilter::callback('location', function (Builder $query, $value) {
                $query->whereHas('company', function (Builder $query) use ($value) {
                    $query->where('location', 'like', "%{$value}%");
                });
            }),

            AllowedFilter::callback('average_salary', function (Builder $query, $value) {
                $query->whereRaw('(? BETWEEN min_salary AND max_salary)', [$value]);
            }),


            AllowedFilter::callback('search', function (Builder $query, $value) {

                $query->where(function ($query) use ($value) {
                    $query->whereHas('company', function (Builder $companyQuery) use ($value) {
                        (new SearchFilter(['name', 'location']))->__invoke($companyQuery, $value, 'companies');
                    });
                });

                $query->orWhere(function ($query) use ($value) {
                    $query->whereRaw('? BETWEEN min_salary AND max_salary', [$value])
                        ->orwhere('description', 'like', "%$value%")
                        ->orWhere('title', 'like', "%$value%")
                        ->orWhereDate('created_at', $value);
                });
            }),

        ];
    }

}

