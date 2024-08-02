<?php

namespace App\Jobs;

use App\Enums\Status;
use App\Models\Delivery_Option;
use App\Models\Plan;
use App\Models\Project_Owners;
use App\Models\Request;
use App\Models\Service;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CloseServiceJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public $requestId;

    public function __construct($requestId)
    {
        $this->requestId = $requestId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $request = Request::find($this->requestId);

        $request->update(['status' => Status::CLOSED]);

        $owner = Project_Owners::find($request['project_owner_id']);
        $delivery_option = Delivery_Option::find($request['delivery_option_id']);
        $plan = Plan::find($delivery_option['plan_id']);
        $service = Service::find($plan['service_id']);
        $user = $service['owner_type']::find($service['owner_id']);

        $owner->update(['suspended_balance' => $owner['suspended_balance'] - $plan['price']]);
        $user->update(['available_balance' => $user['available_balance'] - ($plan['price'] - $plan['price'] * 0.15), 'withdrawal_balance' => $user['withdrawal_balance'] + ($plan['price'] - $plan['price'] * 0.15)]);
    }
}
