<?php

namespace App\Services;

use App\Http\Resources\PortfolioDetailsResource;
use App\Http\Resources\PortfolioResource;
use App\Http\Resources\PortfolioTeamResource;
use App\Models\Freelancer;
use App\Models\Portfolio;
use App\Models\Team;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class PortfoliosService
{
    public function getPortfolios(string $id, $model)
    {

        $user = $model::find($id);
        $portfolios = $user->portfolios;
        if ($model == 'App\\Models\\Freelancer') {
            return PortfolioResource::collection($portfolios);
        }
        return PortfolioTeamResource::collection($portfolios);
    }

    public function getDetailsPortfolio(string $id): PortfolioDetailsResource
    {
        $portfolio = Portfolio::find($id);
        return new PortfolioDetailsResource($portfolio);
    }

    public function createPortfolio(string $id, $type, $data): void
    {
        $portfolio = Portfolio::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'date' => $data['date'],
            'preview' => $data['preview'],
            'demo' => $data['demo'],
            'link' => $data['link']
        ]);
        $portfolio->skills()->attach($data['skills']);
        if (isset($data['images'])) {
            $folderPath = 'portfolio/' . $portfolio->id;
            foreach ($data['images'] as $image) {
                $imageName = $image->getClientOriginalName();
                $image->storeAs('portfolio/' . $portfolio->id, $imageName, 'public');
            }
            $portfolio->update(['images' => $folderPath]);
        }
        if (isset($data['preview'])) {
            $imageName = $data['preview']->getClientOriginalName();
            $path = $data['preview']->storeAs('portfolio/' . $portfolio->id, $imageName, 'public');
            $portfolio->update(['preview' => $path]);
        }
        if ($type == "freelancer") {
            $portfolio->freelancers()->attach($id);

            if (isset($data['contributors']))
                $portfolio->freelancers()->attach($data['contributors']);
        } else {
            $portfolio->team()->attach($id);
        }

    }

    public function delete(string $id): void
    {
        Portfolio::where('id', $id)->delete();
        $folderPath = 'public/portfolio/' . $id;
        Storage::deleteDirectory($folderPath);
    }

    public function update(string $id, array $data): void
    {
        $freelancer = Auth::guard('Freelancer')->user();
        $portfolio = Portfolio::find($id);
        if (isset($data['preview'])) {
            Storage::disk('public')->delete($portfolio->preview);
            $imageName = $data['preview']->getClientOriginalName();
            $path = $data['preview']->storeAs('portfolio/' . $portfolio->id, $imageName, 'public');
            $portfolio->update(['preview' => $path]);
        }


        $existImages = $data['existImages'] ?? [];
        $files = Storage::files('public/' . $portfolio->image);
        foreach ($files as $file) {
            if ($file !== 'public/' . $portfolio->preview && !in_array($file, $existImages)) {
                Storage::delete($file);
            }
        }

        if (isset($data['images'])) {
            foreach ($data['images'] as $image) {
                $imageName = $image->getClientOriginalName();
                $image->storeAs('portfolio/' . $portfolio->id, $imageName, 'public');
            }
            $portfolio->update(['images' => 'portfolio/' . $portfolio->id]);
        }

        unset($data['preview']);
        unset($data['images']);
        $portfolio->update($data);
        if (isset($data['skills']))
            $portfolio->skills()->sync($data['skills']);
        if (isset($data['contributors'])) {
            $portfolio->freelancers()->sync($data['contributors']);
            $portfolio->freelancers()->attach($freelancer);
        }
    }

}
