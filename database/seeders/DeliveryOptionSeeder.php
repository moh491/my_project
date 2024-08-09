<?php

namespace Database\Seeders;

use App\Models\Delivery_Option;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeliveryOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Delivery_Option::create([
            'days'=>4,
            'increase'=>20,
            'plan_id'=>1

        ]);
        Delivery_Option::create([
            'days'=>5,
            'increase'=>40,
            'plan_id'=>1

        ]);

        Delivery_Option::create([
            'days'=>4,
            'increase'=>20,
            'plan_id'=>2

        ]);
        Delivery_Option::create([
            'days'=>5,
            'increase'=>40,
            'plan_id'=>2

        ]);
        Delivery_Option::create([
            'days'=>4,
            'increase'=>20,
            'plan_id'=>3

        ]);
        Delivery_Option::create([
            'days'=>5,
            'increase'=>40,
            'plan_id'=>3

        ]);
    }
}
