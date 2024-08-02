<?php

namespace App\Jobs;

use App\Models\Offer;
use App\Models\Project;
use App\Models\Project_Owners;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CloseProjectJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $offerId;
    /**
     * Create a new job instance.
     */
    public function __construct($offerId)
    {
        $this->offerId = $offerId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        info('test');
        $offer=Offer::find($this->offerId);
        $project=Project::find($offer['project_id']);
        $project->update(['status'=>'Closed']);
        $owner=Project_Owners::find($project['project_owner_id']);
        $owner->update(['suspended_balance'=>$owner['suspended_balance'] - $offer['budget']]);
        $user = $offer['worker_type']::find($offer['worker_id']);
        $user->update(['available_balance' => $user['available_balance'] - ($offer['budget'] - $offer['budget'] * 0.15),'withdrawal_balance'=>$user['withdrawal_balance'] + ($offer['budget'] - $offer['budget'] * 0.15)]);

    }
}
