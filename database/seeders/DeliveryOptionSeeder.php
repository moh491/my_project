<?php

namespace Database\Seeders;

use App\Models\Delivery_Option;
use App\Models\Plan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeliveryOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('delivery__options')->truncate();
        // احصل على جميع الخطط الموجودة
        $plans = Plan::all();

        // إنشاء خيارات التوصيل لكل خطة
        foreach ($plans as $plan) {
            // توليد عدد عشوائي من الأيام بين 1 و 7
            $days = rand(1, 7);

            // تحديد قيمة الزيادة بناءً على عدد الأيام
            if ($days == 7) {
                $increase = 0.00;
            } elseif ($days >= 3 && $days <= 6) {
                $increase = 12.00;
            } else { // اليوم أو اليومين
                $increase = 30.00;
            }

            // إنشاء خيار التوصيل للخطة
            Delivery_Option::create([
                'days' => $days,
                'increase' => $increase,
                'plan_id' => $plan->id,
            ]);
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

//        Delivery_Option::create([
//            'days'=>4,
//            'increase'=>20,
//            'plan_id'=>1
//
//        ]);
//        Delivery_Option::create([
//            'days'=>5,
//            'increase'=>40,
//            'plan_id'=>1
//
//        ]);
//
//        Delivery_Option::create([
//            'days'=>4,
//            'increase'=>20,
//            'plan_id'=>2
//
//        ]);
//        Delivery_Option::create([
//            'days'=>5,
//            'increase'=>40,
//            'plan_id'=>2
//
//        ]);
//        Delivery_Option::create([
//            'days'=>4,
//            'increase'=>20,
//            'plan_id'=>3
//
//        ]);
//        Delivery_Option::create([
//            'days'=>5,
//            'increase'=>40,
//            'plan_id'=>3
//
//        ]);
    }
}
