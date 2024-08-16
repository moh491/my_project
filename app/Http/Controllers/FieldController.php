<?php

namespace App\Http\Controllers;

use App\Http\Resources\fieldResource;
use App\Models\Field;

class FieldController extends Controller
{
    public function endPoint()
    {
        return FieldResource::collection(Field::all());
    }
}
