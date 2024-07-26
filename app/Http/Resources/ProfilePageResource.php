<?php

namespace App\Http\Resources;

use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class ProfilePageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function projectCompletedCount()
    {
        return $this->projects()
            ->where('status', 'Closed')
            ->count();
    }

    public function calculateReemploymentRate()
    {
        $freelancerId = Auth::guard('Freelancer')->user()->id;
        $projects = Project::where('worker_id', $freelancerId)
            ->where('worker_type', 'App\Models\Freelancer')
            ->where('status', 'Closed')
            ->get()
            ->groupBy('project_owner_id');
        $totalProjects = 0;
        $totalReemployments = 0;
        foreach ($projects as $projectsByOwner) {
            $projectCount = $projectsByOwner->count();
            $totalProjects += $projectCount;
            $totalReemployments += $projectCount > 1 ? $projectCount - 1 : 0;
        }
        $overallReEmploymentRate = $totalProjects > 0 ? ($totalReemployments / $totalProjects) * 100 : 0;
        return $overallReEmploymentRate;
    }

    public function calculateOnTimeDeliveryRate()
    {
        $freelancerId = Auth::guard('Freelancer')->user()->id;
        $projects = Project::where('worker_id', $freelancerId)
            ->where('worker_type', 'App\Models\Freelancer')
            ->where('status', 'Closed')
            ->get();
        $totalProjects = $projects->count();
        $onTimeProjects = 0;
        foreach ($projects as $project) {
            $startDate = Carbon::parse($project->start_date);
            $endDate = Carbon::parse($project->end_date);
            $expectedEndDate = $startDate->addDays($project->duration);
            if ($endDate <= $expectedEndDate) {
                $onTimeProjects++;
            }
        }
        $onTimeDeliveryRate = $totalProjects > 0 ? ($onTimeProjects / $totalProjects) * 100 : 0;
        return $onTimeDeliveryRate;
    }

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'profile' => app('baseUrl') . $this->profile,
            'full_name' => $this->first_name . ' ' . $this->last_name,
            'position' => $this->position->name,
            'rating' => 5,
            'location' => $this->location,
            'time_zone' => $this->time_zone,
            'completion_rate' => $this->projectCompletedCount() / $this->projects()->count() * 100,
            'completed_projects' => $this->projectCompletedCount(),
            're_employment_rate' => $this->calculateReemploymentRate(),
            'on_time_delivery_rate' => $this->calculateOnTimeDeliveryRate(),
            'total_balance' => $this->suspended_balance + $this->available_balance + $this->withdrawal_balance,
            'suspended_balance' => $this->suspended_balance,
            'available_balance' => $this->available_balance,
            'withdrawal_balance' => $this->withdrawal_balance,
            'bending_offers' => $this->offers()->where('status', 'Pending')->count() / $this->offers()->count() * 100,
            'accept_offers' => $this->offers()->where('status', 'Accept')->count() / $this->offers()->count() * 100,
            'rejected_offers' => $this->offers()->where('status', 'Reject')->count() / $this->offers()->count() * 100,
            'about' => $this->about,
            'languages' => $this->languages()->select('language as name', 'level')->get()->map(function ($language) {
                return [
                    'name' => $language->name,
                    'level' => $language->level,
                ];
            }),
            'skills' => $this->skills()->select('skills.id as skill_id', 'skills.name')->get()->map(function ($skill) {
                return [
                    'id' => $skill->skill_id,
                    'name' => $skill->name,
                ];
            }),
        ];
    }
}
