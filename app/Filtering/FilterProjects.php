<?php

namespace App\Filtering;

use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Database\Eloquent\Builder;

class FilterProjects {

    public function filterAll(): array
    {
        return [

            AllowedFilter::callback('classification', function (Builder $query, $value) {
                if (is_string($value) && is_array(json_decode($value, true))) {
                    $value = json_decode($value, true);
                }
                $value = (array) $value;
                $query->whereHas('field', function (Builder $query) use ($value) {
                    $query->whereIn('id', $value);
                });
            }),

            AllowedFilter::callback('skills', function (Builder $query, $value) {
                if (is_string($value) && is_array(json_decode($value, true))) {
                    $value = json_decode($value, true);
                }
                $value = (array) $value;

                $query->whereHas('skills', function (Builder $query) use ($value) {

                    if (is_string($value) && is_array(json_decode($value, true))) {
                        $value = json_decode($value, true);
                    }
                    $value = (array) $value;

                    $query->whereIn('skills.id', $value);
                });
            }),

            AllowedFilter::callback('deliveryDurations', function (Builder $query, $value) {
                $value =  explode('-',$value);
               $query->whereBetween('duration',$value);
            }),


            AllowedFilter::callback('salary_options', function (Builder $query, $value) {
                $value =  explode('-',$value);
                $query->where('min_budget', '>=' , $value[0])->
                where('max_budget','<=' ,$value[1]);
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

