<?php

namespace Database\Seeders;

use App\Models\Feature;
use App\Models\Plan;
use App\Models\Plan_Feature;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlanFeaturesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Plan_Feature::truncate();

         $plans = Plan::all();

         $featuresByPlanType = [
            'basic' => [
                'Responsive Design',
                'Customizable',

            ],
            'standard' => [
                'API Access',
                'E-commerce Ready',

            ],
            'premium' => [
                'Advanced Security',
                'Scalability',

            ]
        ];

         foreach ($plans as $plan) {
            $planType = strtolower($plan->type);
            if (!array_key_exists($planType, $featuresByPlanType)) {
                continue;
            }

            $features = Feature::whereIn('name', $featuresByPlanType[$planType])->get();

             $numFeaturesToAssign = min(rand(3, count($features)), $features->count());

            if ($features->count() > 0) {
                $assignedFeatures = $features->random($numFeaturesToAssign);

                foreach ($assignedFeatures as $feature) {
                    Plan_Feature::create([
                        'value' => rand(0, 1) ? 'true' : 'false',
                        'plan_id' => $plan->id,
                        'feature_id' => $feature->id,
                    ]);
                }
            }
        }

         DB::statement('SET FOREIGN_KEY_CHECKS=1;');
//        Plan_Feature::create([
//            'value'=>'4',
//            'plan_id'=>1,
//            'feature_id'=>1
//        ]);
//        Plan_Feature::create([
//            'value'=>'false',
//            'plan_id'=>1,
//            'feature_id'=>2
//        ]);
//
//
//        Plan_Feature::create([
//            'value'=>'6',
//            'plan_id'=>2,
//            'feature_id'=>1
//        ]);
//        Plan_Feature::create([
//            'value'=>'true',
//            'plan_id'=>2,
//            'feature_id'=>2
//        ]);
//
//
//
//        Plan_Feature::create([
//            'value'=>'unlimited',
//            'plan_id'=>3,
//            'feature_id'=>1
//        ]);
//        Plan_Feature::create([
//            'value'=>'true',
//            'plan_id'=>3,
//            'feature_id'=>2
//        ]);
 //****************************************
        /*
         *
         *
          DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // تفريغ جدول plan_features
        Plan_Feature::truncate();

        // الحصول على جميع الخطط
        $plans = Plan::with('service.features')->get();

        // توزيع الخصائص على الخطط
        foreach ($plans as $plan) {
            // الحصول على ميزات الخدمة المرتبطة بالخطة
            $serviceFeatures = $plan->service->features;

            // التأكد من عدم محاولة اختيار أكثر من العدد المتاح من الميزات
            $numFeaturesToAssign = min(rand(3, 7), $serviceFeatures->count());

            $assignedFeatures = $serviceFeatures->random($numFeaturesToAssign);

            foreach ($assignedFeatures as $feature) {
                Plan_Feature::create([
                    'value' => $feature->is_boolean ? 'Enabled' : 'Configured',
                    'plan_id' => $plan->id,
                    'feature_id' => $feature->id,
                ]);
            }
        }

        // إعادة تمكين التحقق من المفاتيح الخارجية
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
         * */

    }
}
