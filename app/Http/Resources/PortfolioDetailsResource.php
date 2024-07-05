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
        $imageFiles = File::files(public_path( $path));
        $images = [];
        foreach ($imageFiles as $file) {
            if($file->getFilename() !==basename($this->preview))
            $images[] = app('baseUrl') . $path . '/' . $file->getFilename();
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
                    'profile' => app('baseUrl') . $freelancer->profile,
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
