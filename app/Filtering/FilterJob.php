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
                $query->where('company_id', $value);
            }),

            AllowedFilter::callback('location', function (Builder $query, $value) {
                $query->whereHas('company', function (Builder $query) use ($value) {
                    $query->where('location', 'like', "%{$value}%");
                });
            }),

            AllowedFilter::callback('average_salary', function (Builder $query, $value) {

                $value = (float) $value;
                $query->whereRaw('min_salary <= ? AND max_salary >= ?', [$value, $value]);
            }),


            AllowedFilter::callback('search', function (Builder $query, $value) {
                $query->where(function ($query) use ($value) {
                    $query->whereHas('company', function (Builder $companyQuery) use ($value) {
                         $companyQuery->where(function (Builder $query) use ($value) {
                            $query->where('name', 'like', "%$value%")
                                ->orWhere('location', 'like', "%$value%");
                        });
                    });

                     $query->orWhere(function (Builder $query) use ($value) {
                        $query->whereRaw('? BETWEEN min_salary AND max_salary', [$value])
                            ->orWhere('description', 'like', "%$value%")
                            ->orWhere('title', 'like', "%$value%");
                    });
                });
            }),
        ];
    }

}
