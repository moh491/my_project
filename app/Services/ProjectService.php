<?php

namespace App\Services;

use App\Filtering\FilterJob;
use App\Filtering\FilterProjects;
use App\Http\Resources\BrowseJobs;
use App\Http\Resources\ProjectResource;
use App\Models\Field;
use App\Models\Job;
use App\Models\Project;
use App\Http\Requests\StoreProjectRequest;
use App\Models\Skill;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\QueryBuilder;

class ProjectService
{
    public function createProject(StoreProjectRequest $request)
    {
        $data = $request->validated();

        $data['project_owner_id'] = auth()->id();

        return Project::create($data);
    }

    public function getProjectById($id): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Builder|array|null
    {
        return Project::with('project_owner')->findOrFail($id);
    }

    public function getProjcetOptions()
    {
        $classifications = Field::has('projects')
            ->select('id', 'name')
            ->paginate(10);

        $skills = Skill::select(DB::raw('name as skill_name'))
            ->distinct()
            ->paginate(10);

        $deliveryDurations = Project::select('duration as delivery_duration')
            ->distinct()
            ->paginate(10);

        $dates = Project::select(DB::raw('DATE(created_at) as publish_date'))
            ->distinct()
            ->paginate(10);

        $averageSalary = DB::table('projects')
            ->select(DB::raw('((min_budget + max_budget) / 2) as average_salary'))
            ->distinct()
            ->paginate(10);

        foreach ($averageSalary as  $salary) {
            $salary->average_salary = number_format($salary->average_salary, 0, '.', '');
        }

        return [
            'classifications' => $classifications,
            'skills' => $skills,
            'deliveryDurations'=> $deliveryDurations,
            'salary_options' => $averageSalary,
            'date_posted' => $dates,
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
