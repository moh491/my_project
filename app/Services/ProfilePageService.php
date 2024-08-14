<?php

namespace App\Services;

use App\Http\Resources\PortfolioResource;
use App\Http\Resources\ProfilePageResource;
use App\Models\Freelancer;
use Illuminate\Support\Facades\Storage;

class ProfilePageService
{
    public function ProfilePage(string $id){
        $freelancer=Freelancer::find($id);
        return new ProfilePageResource($freelancer);
    }

    public function updateProfile(string $id, $data)
    {
        $freelancer = Freelancer::find($id);
        if (isset($data['languages'])) {
            foreach ($data['languages'] as $language) {
                $freelancer->languages()->updateOrCreate(
                    ['language' => $language['language']],
                    ['level' => $language['level']]
                );
            }
        }
        if (isset($data['skills'])) {
            $freelancer->skills()->sync($data['skills']);
        }
        if (isset($data['profile'])) {
            Storage::disk('public')->delete($freelancer->profile);
            $imageName = $freelancer->id . '-' . $data['profile']->getClientOriginalName();
            $path = $data['profile']->storeAs('freelancer-profile', $imageName, 'public');
            $freelancer->update(['profile' => $path]);
        }
        unset($data['profile']);
        unset($data['skills']);
        unset($data['languages']);
        $freelancer->update($data);
    }
}
