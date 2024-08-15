<?php

namespace App\Http\Resources;

use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;
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
        return (int)$overallReEmploymentRate;
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

        $num=0;
        if ($this->projects()->count() > 0) {
            $num = $this->projectCompletedCount() / $this->projects()->count() * 100;
        }
        return (int)$num;
    }

    public function avarageReviewProject()
    {

        $projects = $this->projects()->where('status', 'Closed')->has('review')->get();
        $totalScore = 0;
        $totalReviews = 0;
        foreach ($projects as $project) {
            $review = $project->review;
            $overallScore = ($review->professionalism +
                    $review->communication +
                    $review->quality +
                    $review->commit_to_deadlines +
                    $review->re_employee +
                    $review->experience) / 6;
            $totalScore += $overallScore;
            $totalReviews++;
        }
        return $totalReviews > 0 ? round($totalScore / $totalReviews) : 0;

    }

    public function avarageRatingRequests()
    {
        $services = $this->services()->get();
        $allRatings = new Collection();
        foreach ($services as $service) {
            $requests = $service->allRequests()->where('status', 'Closed')->whereNotNull('rating');
            $ratings = $requests->pluck('rating');
            $allRatings = $allRatings->concat($ratings);
        }
        return $allRatings->count() > 0 ? round($allRatings->avg()) : 0;
    }


    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'profile' => app('baseUrl') . $this['profile'],
            'first_name' => $this['first_name'],
            'last_name' => $this['last_name'],
            'position' => new PositionResource($this['position']),
            'field' => new FieldResource($this['position']['field']),
            'rating' => round(($this->avarageReviewProject() + $this->avarageRatingRequests()) / 2),
            'location' => $this['location'],
            'time_zone' => $this['time_zone'],
            'completion_rate' => $this->comletionrate(),
            'completed_projects' => $this->projectCompletedCount(),
            're_employment_rate' => $this->calculateReemploymentRate(),
            'on_time_delivery_rate' => $this->calculateOnTimeDeliveryRate(),
            'total_balance' => $this['suspended_balance'] + $this['available_balance'] + $this['withdrawal_balance'],
            'suspended_balance' => $this['suspended_balance'],
            'available_balance' => $this['available_balance'],
            'withdrawal_balance' => $this['withdrawal_balance'],
            'bending_offers' => $this->Offer('Pending'),
            'accept_offers' => $this->Offer('Accept'),
            'rejected_offers' => $this->offer('Reject'),
            'about' => $this['about'],
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
