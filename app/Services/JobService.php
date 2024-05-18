<?php

namespace App\Services;

use App\Models\Job;

class JobService
{
    public function create(array $data): void
    {
        Job::create(
         $data
        );
    }

    public function update(string $id,array $data): void
    {
        $userId = auth()->user()->id;

        Job::where('id', $userId)->update($data);
    }

    public function delete(string $id): void
    {
        Job::where('id',$id)->delete();
    }
}
