<?php

use App\Policies\PartnerPolicy;
use App\Models\Partners\Partner;

class PartnerPolicyTest extends BrowserKitTest
{
    /**
     * @group policies
     */
    public function test_view()
    {
        (new PartnerPolicy)->view($this->authUser());
    }

    /**
     * @group policies
     */
    public function test_create()
    {
        (new PartnerPolicy)->create($this->authUser());
    }

    /**
     * @group policies
     */
    public function test_update()
    {
        $partner = factory(Partner::class)->create();

        (new PartnerPolicy)->update($this->authUser(), $partner);
    }

    /**
     * @group policies
     */
    public function test_delete()
    {
        $partner = factory(Partner::class)->create();

        (new PartnerPolicy)->delete($this->authUser(), $partner);
    }
}
