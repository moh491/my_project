<?php

namespace App\Http\Resources;


use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class PortfolioDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    private function getImages($path)
    {
        $imageFiles = File::files(storage_path('app/public/' . $path));
        $images = [];
        foreach ($imageFiles as $file) {
            if ($file->getFilename() !== basename($this->preview))
                $images[] = app('baseUrl') . $path . '/' . $file->getFilename();
        }

        return $images;
    }

    public function toArray(Request $request): array
    {

        return [
            'id' => $this->id,
            'title' => $this->title,
            'date' => $this->date,
            'description' => $this->description,
            'skills' => SkillResource::collection($this['skills']),
            'contributors' => FreelancerResource::collection($this->freelancers
                ->when(
                    Auth::guard('Freelancer')->check(),
                    function ($collection) {
                        return $collection->reject(function ($freelancer) {
                            return $freelancer->id == Auth::guard('Freelancer')->user()->id;
                        });
                    }
                )),

            'demo' => $this->demo,
            'link' => $this->link,
            'preview' => app('baseUrl') . $this->preview,
            'images' => $this->getImages($this->images),
        ];
    }
}
