<?php

namespace App\Filtering;

use App\Filtering\SearchFilter;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Database\Eloquent\Builder;


class FilterOffers {

    public function filterAll(): array
    {
        return [

            AllowedFilter::callback('date_created', function (Builder $query, $value) {
                return $query->whereDate('created_at', $value);
            }),

            AllowedFilter::callback('status', function ($query, $status) {
                $query->whereHas('project', function ($query) use ($status) {
                    $query->where('status', $status);
                });
            }),

            AllowedFilter::callback('owner', function ($query, $owner) {
                $query->whereHas('project', function ($query) use ($owner) {
                    $query->where('project_owner_id', $owner);
                });
            }),

            AllowedFilter::callback('search', function (Builder $query, $value) {
                $query->whereHas('project', function (Builder $projectQuery) use ($value) {
                    (new SearchFilter(['status', 'project_owner_id']))->__invoke($projectQuery, $value, 'projects');
                });

                $query->orWhere(function ($query) use ($value) {
                    $query->Where('duration', $value)
                        ->orWhere('description', 'like', "%$value%")
                        ->orWhereDate('created_at', $value);
                });
            }),

        ];
    }

}

