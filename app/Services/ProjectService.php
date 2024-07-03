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
        $skills = $data['skills'];
        unset($data['skills']);

        if (isset($data['ideal_skills'])) {
            $data['ideal_skills'] = json_encode($data['ideal_skills']);
        }

        return DB::transaction(function () use ($data, $skills) {

            $project = Project::create($data);
            if (!empty($skills)) {
                $project->skills()->attach($skills);
            }
            return $project;
        });

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
