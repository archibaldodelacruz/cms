<?php

use App\Models\Webs\Web;

class WebsControllerTest extends BrowserKitTest
{
    public function prepareForTests()
    {
        Artisan::call('migrate:refresh');

        $web = new Web();
        $web->subdomain = 'admin';
        $web->installed = 1;
        $web->save();

        $this->user = $web->users()->create([
            'name'     => 'Testing',
            'email'    => 'admin@protecms.com',
            'password' => 'admin',
            'type'     => 'admin',
            'status'   => 'active',
        ]);

        $web->setConfigs(config('protecms.webs.config.default'));

        $this->app->bind('App\Models\Webs\Web', function () use ($web) {
            return $web;
        });
    }

    /**
     * @group superadmin/webs
     */
    public function test_webs_list()
    {
        $this->actingAs($this->user)
            ->visitRoute('superadmin::webs::index');
    }

    /**
     * @group superadmin/webs
     */
    public function test_create_web()
    {
        $this->actingAs($this->user)
            ->visitRoute('superadmin::webs::create')
            ->type('new', 'subdomain')
            ->type('new@protecms.com', 'email')
            ->press('Crear')
            ->seeInDatabase('webs', [
                'email' => 'new@protecms.com',
            ]);
    }

    /**
     * @group superadmin/webs
     */
    public function test_edit_web()
    {
        $web = factory(Web::class)->create();

        $this->actingAs($this->user)
            ->visitRoute('superadmin::webs::edit', ['id' => $web->id])
            ->type('New name', 'name')
            ->press('Actualizar')
            ->seeInDatabase('webs', [
                'name' => 'New name',
            ]);
    }
}
