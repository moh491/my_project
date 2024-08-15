<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\File;

class RequestResource extends JsonResource
{
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
        $response = [
            'id' => $this['id'],
            'note' => $this['note'],
            'status' => $this['status'],
            'rating' => $this['rating'],
            'project_owner' => [
                'id' => $this['project_owner_id'],
                'name' => $this->project_owners->first_name . ' ' . $this->project_owners->last_name,
            ],
            'plan_id' => $this['plan_id'],
        ];
        if ($request->routeIs('request.show')) {
            $response['files'] = $this->getFiles($this['files']);
        }

        return $response;
    }
}
