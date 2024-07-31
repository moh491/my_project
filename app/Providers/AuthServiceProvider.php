<?php

namespace App\Providers;

use App\Http\Controllers\FreelancerControllers\PlanServiceController;
use App\Models\Certification;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Feature;
use App\Models\Language;
use App\Models\Plan;
use App\Models\Portfolio;
use App\Models\Request;
use App\Models\Service;
use App\Models\Skill;
use App\Models\Team;
use App\Policies\CertificatePolicy;
use App\Policies\EducationPolicy;
use App\Policies\ExperiencePolicy;
use App\Policies\FeaturePolicy;
use App\Policies\LanguagePolicy;
use App\Policies\PortfloioPolicy;
use App\Policies\RequestPolicy;
use App\Policies\ServicePolicy;
use App\Policies\SkillPolicy;
use App\Policies\TeamPolicy;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        Certification::class=>CertificatePolicy::class,
        Education::class=>EducationPolicy::class,
        Language::class=>LanguagePolicy::class,
        Experience::class=>ExperiencePolicy::class,
        Portfolio::class=>PortfloioPolicy::class,
        Service::class=>ServicePolicy::class,
        Feature::class=>ServicePolicy::class,
        Plan::class=>ServicePolicy::class,
        Skill::class=>SkillPolicy::class,
        Request::class=>RequestPolicy::class,
        Team::class => TeamPolicy::class,

    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        ResetPassword::createUrlUsing(function (object $notifiable, string $token) {
            return config('app.frontend_url')."/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}";
        });

        //
    }
}
