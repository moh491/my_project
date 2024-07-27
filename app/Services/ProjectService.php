<?php

namespace App\Services;

use App\Filtering\FilterJob;
use App\Filtering\FilterProjects;
use App\Http\Resources\BrowseJobs;
use App\Http\Resources\ProjectResource;
use App\Models\Field;
use App\Models\Job;
use App\Models\Offer;
use App\Models\Project;
use App\Http\Requests\StoreProjectRequest;
use App\Models\Project_Owners;
use App\Models\Skill;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\QueryBuilder;

class ProjectService
{
    public function createProject($data, $id)
    {

        $data['project_owner_id'] = $id;
        $skills = $data['skills'];
        unset($data['skills']);
        if (isset($data['ideal_skills'])) {
            $data['ideal_skills'] = json_encode($data['ideal_skills']);
        }
        $project = Project::create($data);
        if (!empty($skills)) {
            $project->skills()->attach($skills);
        }


    }

    public function AcceptOffer($id)
    {
        $offer = Offer::find($id);
        $project = Project::find($offer['project_id']);
        $project->update(['worker_type' => $offer['worker_type'], 'worker_id' => $offer['worker_id'], 'status' => 'Underway', 'start_date' => Carbon::now()]);
        $offer->update(['status' => 'Accept']);
        $project_owner = Project_Owners::find(Auth::guard('Project_Owner')->user()->id);
        $user = $offer['worker_type']::find($offer['worker_id']);
        $project_owner->update(['suspended_balance' => $project_owner['suspended_balance'] + $offer['budget'], 'withdrawal_balance' => $project_owner['withdrawal_balance'] - $offer['budget']]);
        $user->update(['suspended_balance' => $user['suspended_balance'] + ($offer['budget'] - $offer['budget'] * 0.15)]);
    }

    public function getProjectById($id): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Builder|array|null
    {
        return Project::with('project_owner')->findOrFail($id);
    }

    public function getProjcetOptions()
    {
        $classifications = Field::has('projects')
            ->select('id', 'name')
            ->get();

        $skills = Skill::select('id', 'name')
            ->distinct()
            ->get();


        $durations = [];
        $maxDuration = Project::max('duration');
        $minDuration = Project::min('duration');
        for ($i = $minDuration; $i <= $maxDuration; $i += 6) {
            $durations [] = $i . '-' . $i + 5;
        }


        $salaries = [];
        $maxSalary = ceil(Project::max('max_budget'));
        $minSalary = floor(Project::min('min_budget'));
        for ($i = $minSalary; $i <= $maxSalary; $i += 100) {
            $salaries [] = $i . '-' . $i + 99;
        }
//// Get the minimum salary
//        $minSalary = Project::min('salary');

//        foreach ($averageSalary as  $salary) {
//            $salary->average_salary = number_format($salary->average_salary, 0, '.', '');
//        }

        return [
            'classifications' => $classifications,
            'skills' => $skills,
            'deliveryDurations' => $durations,
            'salary_options' => $salaries,
        ];
    }

    public function getAllProjects()
    {
        return Project::paginate(10);

    }

    public function filterAll(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {

        $projects = QueryBuilder::for(Project::class)
            ->allowedFilters((new FilterProjects())->filterAll())
            ->with(['field:id,name'])
            ->get();

        return ProjectResource::collection($projects);

    }


}
