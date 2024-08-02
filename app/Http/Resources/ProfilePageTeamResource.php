<?php

namespace App\Http\Resources;

use App\Models\Freelancer;
use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class ProfilePageTeamResource extends JsonResource
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
        ;
        $projects =$this->projects()
            ->where('worker_type', 'App\Models\Team')
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
        return (int)$overallReEmploymentRate;
    }

    public function calculateOnTimeDeliveryRate()
    {

        $projects =$this->projects()
            ->where('worker_type', 'App\Models\Team')
            ->where('status', 'Closed')->get();
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
        return (int)$onTimeDeliveryRate;
    }

    public function Offer($status)
    {

        if (!$this->offers()->count() == 0) {
            $number = $this->offers()->where('status', $status)->count() / $this->offers()->count() * 100;
            return (int)$number;
        }

    }

    public function comletionrate()
    {

        if ($this->projects()->count() > 0) {
            $num = $this->projectCompletedCount() / $this->projects()->count() * 100;
            return (int)$num;
        }
    }



    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'logo' => $this->logo,
            'name' => $this->name,
            'link'=>$this->link,
            'completion_rate' => $this->comletionrate(),
            'completed_projects' => $this->projectCompletedCount(),
            're_employment_rate' => $this->calculateReemploymentRate(),
            'on_time_delivery_rate' => $this->calculateOnTimeDeliveryRate(),
            'total_balance' => $this->suspended_balance + $this->available_balance + $this->withdrawal_balance,
            'suspended_balance' => $this->suspended_balance,
            'available_balance' => $this->available_balance,
            'withdrawal_balance' => $this->withdrawal_balance,
            'bending_offers' => $this->Offer('Pending'),
            'accept_offers' => $this->Offer('Accept'),
            'rejected_offers' => $this->offer('Reject'),
            'about' => $this->about,
            'skills' => SkillResource::collection($this->skills),
            'members' => FreelancerResource::collection($this->freelancers),


        ];
    }
}
