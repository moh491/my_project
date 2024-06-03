<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\File;

class ServiceDetailsResource extends JsonResource
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
            'description'=>$this->description,
            'images' => $this->getImages($this->image),
            'preview'=>$this->preview,
            'plans' => $this->plans->map(function ($plan) {
                return [
                    'id'=>$plan->id,
                    'type' => $plan->type,
                    'price' => $plan->price,
                    'description'=>$plan->description,
                    'features'=>$plan->features->map(function ($feature){
                    return [
                        'id'=>$feature->id,
                        'name'=>$feature->name,
                        'is_boolean'=>$feature->is_boolean,
                        'value'=>$feature->pivot['value'],
                    ];
                    }),
                    'delivery_options'=>$plan->delivery_options->map(function ($delivery){
                        return [
                            'id'=>$delivery->id,
                            'days'=>$delivery->days,
                            'increase'=>$delivery->increase,
                        ];
                    })
                ];
            }),
        ];
    }
}
