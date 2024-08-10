<?php

namespace Database\Seeders;

use App\Models\Delivery_Option;
use App\Models\Project_Owners;
use App\Models\Request;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('requests')->truncate();

        $projectOwners = Project_Owners::all();

         $deliveryOptions = Delivery_Option::all();

         $statuses = [
            'Pending',
            'Underway',
            'Completed',
            'Under Review',
            'Closed',
            'Excluded'
        ];

         $notes = [
            'Please make sure the project is delivered on time.',
            'The client requested some changes, please review the requirements.',
            'This project requires urgent attention due to a tight deadline.',
            'All files have been uploaded. Please verify the contents.',
            'The design needs to be updated as per the latest feedback.',
            'Please proceed with the next phase of the project.',
            'The client has requested a meeting to discuss the project status.',
            'The initial draft has been approved. Please finalize the project.',
            'The payment has been processed. Please confirm the receipt.',
            'There are some unresolved issues that need immediate attention.'
        ];

        foreach ($projectOwners as $projectOwner) {
             $deliveryOption = $deliveryOptions->random();

             $note = $notes[array_rand($notes)];

             $rating = rand(0, 5) ? rand(1, 5) : null;

             $status = $statuses[array_rand($statuses)];

             Request::create([
                'note' => $note,
                'files' => null,
                'status' => $status,
                'rating' => $rating,
                'project_owner_id' => $projectOwner->id,
                'delivery_option_id' => $deliveryOption->id,
            ]);
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    }
}
