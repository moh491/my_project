<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Plan::truncate();
        Plan::create([
            'type'=>'basic',
            'price'=>45,
            'description'=>'Our Basic Plan is ideal for startups and small businesses looking to develop a straightforward, functional mobile app. This plan includes initial concept consultation, basic UI/UX design, and development for a single platform (iOS or Android). We focus on delivering core functionalities that meet your primary needs. Additionally, we assist you with submitting your app to the app store, ensuring it meets all necessary guidelines.',
            'service_id'=>1
        ]);
        Plan::create([
            'type'=>'standard',
            'price'=>100,
            'description'=>'The Standard Plan is designed for businesses aiming for a more polished and feature-rich mobile app. This plan includes in-depth consultations to fine-tune your app concept and advanced UI/UX design for an enhanced user experience. We develop the app for both iOS and Android platforms, integrating advanced features to meet your needs. Comprehensive testing and app store optimization ensure your app is not only functional but also visible and attractive in the market. Basic analytics integration allows you to monitor your apps performance and user engagement.',
            'service_id'=>1
        ]);
        Plan::create([
            'type'=>'premium',
            'price'=>150,
            'description'=>'Our Premium Plan offers a complete, end-to-end solution for businesses looking to create a high-quality, feature-rich mobile app. This plan includes comprehensive consultations to cover every detail of your app, custom UI/UX design, and full-stack development for both iOS and Android platforms. We integrate the latest features and third-party services to enhance your apps capabilities. Rigorous testing and quality assurance ensure a flawless user experience. Along with extensive app store optimization and a tailored marketing strategy, we provide advanced analytics and ongoing post-launch support Regular updates keep your app competitive and up-to-date with the latest trends and technologies.',
            'service_id'=>1

        ]);
    }
}
