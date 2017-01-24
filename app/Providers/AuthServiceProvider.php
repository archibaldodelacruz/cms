<?php

namespace App\Providers;

use App\Models\Files\File;
use App\Models\Forms\Form;
use App\Models\Pages\Page;
use App\Models\Posts\Post;
use App\Models\Users\User;
use App\Policies\FilePolicy;
use App\Policies\FormPolicy;
use App\Policies\PagePolicy;
use App\Policies\PostPolicy;
use App\Policies\UserPolicy;
use App\Models\Animals\Animal;
use App\Policies\AnimalPolicy;
use App\Policies\FinancePolicy;
use App\Policies\PartnerPolicy;
use App\Models\Finances\Finance;
use App\Models\Partners\Partner;
use App\Policies\CalendarPolicy;
use App\Models\Calendar\Calendar;
use App\Policies\VeterinaryPolicy;
use App\Models\Animals\TemporaryHome;
use App\Policies\TemporaryHomePolicy;
use App\Models\Veterinarians\Veterinary;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Post::class          => PostPolicy::class,
        Page::class          => PagePolicy::class,
        User::class          => UserPolicy::class,
        Form::class          => FormPolicy::class,
        File::class          => FilePolicy::class,
        Animal::class        => AnimalPolicy::class,
        Partner::class       => PartnerPolicy::class,
        Finance::class       => FinancePolicy::class,
        Calendar::class      => CalendarPolicy::class,
        Veterinary::class    => VeterinaryPolicy::class,
        TemporaryHome::class => TemporaryHomePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
