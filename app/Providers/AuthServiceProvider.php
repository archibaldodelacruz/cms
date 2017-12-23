<?php

namespace App\Providers;

use App\ProteCMS\Core\Models\Files\File;
use App\ProteCMS\Core\Models\Forms\Form;
use App\ProteCMS\Core\Models\Pages\Page;
use App\ProteCMS\Core\Models\Posts\Post;
use App\ProteCMS\Core\Models\Users\User;
use App\Policies\FilePolicy;
use App\Policies\FormPolicy;
use App\Policies\PagePolicy;
use App\Policies\PostPolicy;
use App\Policies\UserPolicy;
use App\ProteCMS\Core\Models\Animals\Animal;
use App\Policies\AnimalPolicy;
use App\Policies\FinancePolicy;
use App\Policies\PartnerPolicy;
use App\ProteCMS\Core\Models\Finances\Finance;
use App\ProteCMS\Core\Models\Partners\Partner;
use App\Policies\CalendarPolicy;
use App\ProteCMS\Core\Models\Calendar\Calendar;
use App\Policies\VeterinaryPolicy;
use App\ProteCMS\Core\Models\Animals\TemporaryHome;
use App\Policies\TemporaryHomePolicy;
use App\ProteCMS\Core\Models\Veterinarians\Veterinary;
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
