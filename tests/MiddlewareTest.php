<?php

use App\Models\Webs\Web;
use App\Models\Users\User;

class MiddlewareTest extends TestCase
{
    /**
     * @group middlewares
     */
    public function test_check_superadmin()
    {
        $web = factory(Web::class)->create([
            'subdomain' => 'admin',
            'installed' => 1
        ]);

        $user = factory(User::class)->create([
            'web_id' => $web->id,
            'type' => 'admin'
        ]);

        $web->setConfigs(config('protecms.webs.config.default'));

        $this->app->bind('App\Models\Webs\Web', function () use ($web) {
            return $web;
        });

        $this->actingAs($user)
            ->visitRoute('superadmin::index');
    }

    /**
     * @group middlewares
     */
    public function test_wrong_check_superadmin()
    {
        $web = factory(Web::class)->create([
            'subdomain' => 'other',
            'installed' => 1
        ]);

        $web->setConfigs(config('protecms.webs.config.default'));

        $this->app->bind('App\Models\Webs\Web', function () use ($web) {
            return $web;
        });

        $this->actingAs($this->authUser())
            ->get(route('superadmin::index'))
            ->seeStatusCode(401);
    }

    /**
     * @group middlewares
     */
    public function test_redirect_if_authenticated()
    {
        $this->actingAs($this->authUser())
            ->visitRoute('auth::login')
            ->seeRouteIs('admin::panel::index');
    }

    /**
     * @group middlewares
     */
    public function test_redirect_if_installed()
    {
        $web = factory(Web::class)->create([
            'installed' => 1
        ]);

        $web->setConfigs(config('protecms.webs.config.default'));

        $this->app->bind('App\Models\Webs\Web', function () use ($web) {
            return $web;
        });

        $this->visit('install')
            ->seeRouteIs('web::index');
    }

    /**
     * @group middlewares
     */
    public function test_verify_install()
    {
        $web = factory(Web::class)->create([
            'installed' => 0
        ]);

        $this->app->bind('App\Models\Webs\Web', function () use ($web) {
            return $web;
        });

        $this->visit('/')
            ->seeRouteIs('install::index');
    }

    /**
     * @group middlewares
     */
    public function test_verify_install_with_step()
    {
        $web = factory(Web::class)->create([
            'installed' => 0
        ]);

        $web->setConfig('install_step', 'data');

        $this->app->bind('App\Models\Webs\Web', function () use ($web) {
            return $web;
        });

        $this->visit('/')
            ->seeRouteIs('install::index');
    }
}