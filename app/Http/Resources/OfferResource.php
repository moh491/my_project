<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\File;

class OfferResource extends JsonResource
{
    public static function collection($resource): LengthAwarePaginator|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        if ($resource instanceof LengthAwarePaginator) {
            return $resource->setCollection($resource->getCollection()->mapInto(static::class));
        }

        return parent::collection($resource);
    }
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    private function getFiles($path)
    {
        $pathFiles = File::files(storage_path('app/public/' . $path));
        $files = [];
        foreach ($pathFiles as $file) {
            $files[] = app('baseUrl') . $path . '/' . $file->getFilename();
        }

        return $files;
    }
    public function toArray(Request $request): array
    {
        $array =  [
            'id' => $this->id,
            'title' => $this['project']->title,
            'duration' => $this->duration,
            'budget' => $this->budget,
            'description' => $this->description,
            'worker_type' => $this['worker_type'],
            'status' => $this['status'],
            'created_at' =>  $this['created_at']->diffForHumans(),
        ];

        if ($this['worker_type'] === 'App\Models\Freelancer') {
            $array['worker'] = [
                'type' => 'freelancer',
                'details' => [
                    'id' => $this->worker->id,
                    'name' => $this->worker->first_name . ' ' . $this->worker->last_name,
                    'profile'=>app('baseUrl') .$this->profile,
                ],
            ];
        } else {
            $array['worker'] = [
                'type' => 'team',
                'details' => [
                    'id' => $this->worker->id,
                    'name' => $this->worker->name,
                    'profile'=>app('baseUrl') .$this->logo
                ],
            ];
        }
        if ($request->routeIs('details.show')) {
            $array['files'] = $this->getFiles($this['files']);
        }

        return  $array;
    }
}
