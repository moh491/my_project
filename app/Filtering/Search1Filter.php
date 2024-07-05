<?php

namespace App\Filtering;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class Search1Filter implements Filter
{
    protected $fields;

    public function __construct($fields)
    {
        $this->fields = $fields;
    }

    public function __invoke(Builder $query, $value, string $property)
    {
        $query->where(function ($query) use ($value, $property) {
            foreach ($this->fields as $field) {
                $query->orWhere($field, 'LIKE', '%' . $value . '%');
            }
        });
    }

}
