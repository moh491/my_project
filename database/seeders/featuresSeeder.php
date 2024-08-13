<?php

namespace Database\Seeders;

use App\Models\Feature;
use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class featuresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // تفريغ جدول features
        Feature::truncate();

        // الحصول على جميع الخدمات
        $services = Service::all();

        // قائمة بأسماء الخصائص مع قيم منطقية
        $featuresData = [
            ['name' => 'Responsive Design', 'is_boolean' => true],
            ['name' => 'Customizable', 'is_boolean' => true],
            ['name' => 'Analytics Support', 'is_boolean' => true],
            ['name' => 'SEO Optimized', 'is_boolean' => true],
            ['name' => 'Multilingual', 'is_boolean' => false],
            ['name' => 'E-commerce Ready', 'is_boolean' => true],
            ['name' => 'Cross-platform', 'is_boolean' => true],
            ['name' => '24/7 Support', 'is_boolean' => true],
            ['name' => 'Cloud Integration', 'is_boolean' => true],
            ['name' => 'API Access', 'is_boolean' => true],
            ['name' => 'Offline Mode', 'is_boolean' => false],
            ['name' => 'User Authentication', 'is_boolean' => true],
            ['name' => 'Social Media Integration', 'is_boolean' => true],
            ['name' => 'Payment Gateway', 'is_boolean' => true],
            ['name' => 'Live Chat', 'is_boolean' => true],
            ['name' => 'Data Backup', 'is_boolean' => true],
            ['name' => 'Real-time Notifications', 'is_boolean' => true],
            ['name' => 'Custom Domain', 'is_boolean' => false],
            ['name' => 'Subscription Management', 'is_boolean' => true],
            ['name' => 'Advanced Security', 'is_boolean' => true],
            ['name' => 'Role-based Access Control', 'is_boolean' => true],
            ['name' => 'Reporting & Analytics', 'is_boolean' => true],
            ['name' => 'Scalability', 'is_boolean' => true],
            ['name' => 'Version Control', 'is_boolean' => true],
            ['name' => 'Multi-Tenancy', 'is_boolean' => false],
            ['name' => 'High Availability', 'is_boolean' => true],
            ['name' => 'Automated Deployment', 'is_boolean' => true],
            ['name' => 'Continuous Integration', 'is_boolean' => true],
            ['name' => 'Test Automation', 'is_boolean' => true],
            ['name' => 'User Activity Tracking', 'is_boolean' => true],
            ['name' => 'Interactive UI', 'is_boolean' => true],
            ['name' => 'Easy Migration', 'is_boolean' => false],
            ['name' => 'Localization', 'is_boolean' => false],
            ['name' => 'High Performance', 'is_boolean' => true],
        ];

        // توزيع الخصائص على الخدمات
        foreach ($services as $service) {
            // اختيار عشوائي لعدد من الخصائص لكل خدمة
            $assignedFeatures = collect($featuresData)->random(rand(5, 10));

            foreach ($assignedFeatures as $feature) {
                Feature::create([
                    'name' => $feature['name'],
                    'is_boolean' => $feature['is_boolean'],
                    'service_id' => $service->id,
                ]);
            }
        }

        // إعادة تمكين التحقق من المفاتيح الخارجية
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
//        Feature::create([
//            'name'=>'Core Functionality',
//            'is_boolean'=>false,
//            'service_id'=>1,
//        ]);
//        Feature::create([
//            'name'=>'App Concept Consultation',
//            'is_boolean'=>true,
//            'service_id'=>1,
//        ]);

    }
}
