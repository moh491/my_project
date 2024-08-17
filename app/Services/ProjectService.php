<?php

namespace App\Services;

use App\Filtering\FilterJob;
use App\Filtering\FilterProjects;
use App\Http\Resources\BrowseJobs;
use App\Http\Resources\ProjectResource;
use App\Jobs\CloseProjectJob;
use App\Mail\ConfirmAccepted;
use App\Mail\SentMail;
use App\Models\Field;
use App\Models\Job;
use App\Models\Offer;
use App\Models\Project;
use App\Http\Requests\StoreProjectRequest;
use App\Models\Project_Owners;
use App\Models\Review;
use App\Models\Skill;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
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


    //freelancer or team
    public function Projectdelivery($id)
    {

        $project = Project::find($id);
        $project->update(['status' => 'Completed']);
        $offer=Offer::where('project_id',$id)->where('worker_type',$project['worker_type'])->where('worker_id',$project['worker_id'])->first();
        $user = $project['worker_type']::find($project['worker_id']);
        $owner = Project_Owners::find($project['project_owner_id']);
        if ($project['worker_type'] == 'App\\Models\\Freelancer') {
            $description = $user->first_name . ' ' . $user->last_name . ' has delivery of the project ' . $project->title;
        } else {
            $description = $user->name . ' has delivery of the project ' . $project->title;
        }
        $title = 'ServiceMail Delivery';
        Mail::to($owner->email)->send(new ConfirmAccepted($title, $description,$offer['id']));
    }

    //project_owner
    public function AcceptProject($id)
    {
        $offer = Offer::find($id);
        $project = Project::find($offer['project_id']);
        $project->update(['status' => 'Under Review']);
        $project_owner = Project_Owners::find(Auth::guard('Project_Owner')->user()->id);
        $user = $project['worker_type']::find($project['worker_id']);
        $user->update(['suspended_balance' => $user['suspended_balance'] - ($offer['budget'] - $offer['budget'] * 0.15), 'available_balance' => $user['available_balance'] + ($offer['budget'] - $offer['budget'] * 0.15)]);
        //job
        $now = Carbon::now();
        $futureDate = $now->copy()->addDays(14);
        $secondsDifference = $futureDate->diffInSeconds($now);
        CloseProjectJob::dispatch($id)->delay($secondsDifference);
        $description = $project_owner->first_name . ' ' . $project_owner->last_name . ' has accepted the project ' . $project->title;
        $title = 'Accept ServiceMail';
        if ($offer['worker_type'] == 'App\\Models\\Freelancer') {
            Mail::to($user->email)->send(new SentMail($title, $description));
        } else {
            $owner_team = $user->freelancers()->where('is_owner', 1)->first();
            Mail::to($owner_team->email)->send(new SentMail($title, $description));
        }
    }

    public function rating($data, $id)
    {
        $data['project_id'] = $id;
        Review::create($data);
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
//        $minSalary = ServiceMail::min('salary');

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
        return Project::orderBy('created_at', 'desc')->paginate(10);

    }

    public function filterAll()
    {

        $projects = QueryBuilder::for(Project::class)
            ->allowedFilters((new FilterProjects())->filterAll())
            ->with(['field:id,name'])->orderBy('created_at','desc')
            ->get();

        return ProjectResource::collection($projects);

    }


}
