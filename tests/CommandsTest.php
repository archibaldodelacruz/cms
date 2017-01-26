<?php

use Illuminate\Support\Facades\Artisan;

class CommandsTest extends TestCase
{
    /**
     * @group commands
     */
    public function test_new_shelter()
    {
        Artisan::call('protecms:newshelter', [
            'subdomain' => 'demo',
            'domain' => 'demo.dev',
            'email' => 'testing@protecms.com'
        ]);
    }
}