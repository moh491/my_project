<?php

namespace App\Providers;

use App\Models\Certification;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Language;
use App\Models\Portfolio;
use App\Policies\CertificatePolicy;
use App\Policies\EducationPolicy;
use App\Policies\LanguagePolicy;
use App\Policies\PortfloioPolicy;
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
        Experience::class=>EducationPolicy::class,
        Portfolio::class=>PortfloioPolicy::class

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
