<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use Carbon\Carbon;


class ProjectDetialsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    public function toArray(Request $request): array
    {

        $createdAt = Carbon::parse($this->created_at);
        $now = Carbon::now();
        $diffInDays = $createdAt->diffInDays($now);
        $diffInHours = $createdAt->diffInHours($now);
        $diffInMinutes = $createdAt->diffInMinutes($now);

        $timeSincePosted = '';

        if ($diffInDays > 0) {
            $timeSincePosted = $diffInDays . ' days ago';
        } elseif ($diffInHours > 0) {
            $timeSincePosted = $diffInHours . ' hours ago';
        } else {
            $timeSincePosted = $diffInMinutes . ' minutes ago';
        }
        $projectData = [
            'title' => $this->title,
            'status' => $this->status,
            'min_budget' => $this->min_budget,
            'max_budget' => $this->max_budget,
            'duration' => $this->duration,
            'date_posted' => $this->created_at->format('Y,m,d'),
            'time_since_posted' => $timeSincePosted,
            'description' => $this->description,
            'project_owner' => [
                'id' => $this->project_owner->id,
                'name' => $this->project_owner->first_name . ' ' . $this->project_owner->last_name,
                'profile'=>$this->project_owner->profile,
                'about' => $this->project_owner->about,
            ],
            'offers_average' => $this->offers()->avg('budget'),
            'offers_number' => $this->offers()->count(),
            'required_skills' => $this->skills->pluck('name'),
        ];

        if ($this->worker_type === 'App\Models\Freelancer') {
            $projectData['worker'] = [
                'type' => 'freelancer',
                'details' => [
                    'id' => $this->worker->id,
                    'name' => $this->worker->first_name . ' ' . $this->worker->last_name,
                    'email' => $this->worker->email,
                    'profile'=>$this->worker->profile,
                    'about' => $this->worker->about,
                    'skills' => $this->worker->skills->pluck('name'),
                ],
            ];
        } elseif ($this->worker_type === 'App\Models\Team') {
            $projectData['worker'] = [
                'type' => 'team',
                'details' => [
                    'id' => $this->worker->id,
                    'name' => $this->worker->name,
                    'logo' => $this->worker->logo,
                    'link' => $this->worker->link,
                    'about' => $this->worker->about,
                ],
            ];
        }

        return $projectData;
    }

}
