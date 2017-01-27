<?php

use App\Models\Animals\TemporaryHome;
use App\Policies\TemporaryHomePolicy;

class TemporaryHomePolicyTest extends BrowserKitTest
{
    /**
     * @group policies
     */
    public function test_view()
    {
        (new TemporaryHomePolicy)->view($this->authUser());
    }

    /**
     * @group policies
     */
    public function test_create()
    {
        (new TemporaryHomePolicy)->create($this->authUser());
    }

    /**
     * @group policies
     */
    public function test_update()
    {
        $temporary_home = factory(TemporaryHome::class)->create();

        (new TemporaryHomePolicy)->update($this->authUser(), $temporary_home);
    }

    /**
     * @group policies
     */
    public function test_delete()
    {
        $temporary_home = factory(TemporaryHome::class)->create();

        (new TemporaryHomePolicy)->delete($this->authUser(), $temporary_home);
    }
}
