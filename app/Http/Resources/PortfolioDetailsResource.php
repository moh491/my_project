<?php

namespace App\Http\Resources;



use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
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
            if($file->getFilename() !==basename($this->preview))
            $images[] = $path . '/' . $file->getFilename();
        }

        return $images;
    }
    public function toArray(Request $request): array
    {

        return [
            'id'=>$this->id,
            'title'=>$this->title,
            'date'=>$this->date,
            'description'=>$this->description,
            'skills'=>$this->skills()->pluck('name'),
            'contributors' => $this->freelancers->map(function ($freelancer) {
                return [
                    'profile' => $freelancer->profile,
                    'id' => $freelancer->id,
                ];
            }),
            'demo'=>$this->demo,
            'link'=>$this->link,
            'preview'=>$this->preview,
            'images' => $this->getImages($this->images),
        ];
    }
}
