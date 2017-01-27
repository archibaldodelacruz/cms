<?php

use App\Models\Pages\Page;
use App\Policies\PagePolicy;

class PagePolicyTest extends BrowserKitTest
{
    /**
     * @group policies
     */
    public function test_view()
    {
        (new PagePolicy)->view($this->authUser());
    }

    /**
     * @group policies
     */
    public function test_create()
    {
        (new PagePolicy)->create($this->authUser());
    }

    /**
     * @group policies
     */
    public function test_update()
    {
        $page = factory(Page::class)->create();

        (new PagePolicy)->update($this->authUser(), $page);
    }

    /**
     * @group policies
     */
    public function test_delete()
    {
        $page = factory(Page::class)->create();

        (new PagePolicy)->delete($this->authUser(), $page);
    }
}
