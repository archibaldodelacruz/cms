<?php

use App\Policies\VeterinaryPolicy;
use App\Models\Veterinarians\Veterinary;

class VeterinaryPolicyTest extends BrowserKitTest
{
    /**
     * @group policies
     */
    public function test_view()
    {
        (new VeterinaryPolicy)->view($this->authUser());
    }

    /**
     * @group policies
     */
    public function test_create()
    {
        (new VeterinaryPolicy)->create($this->authUser());
    }

    /**
     * @group policies
     */
    public function test_update()
    {
        $veterinary = factory(Veterinary::class)->create();

        (new VeterinaryPolicy)->update($this->authUser(), $veterinary);
    }

    /**
     * @group policies
     */
    public function test_delete()
    {
        $veterinary = factory(Veterinary::class)->create();

        (new VeterinaryPolicy)->delete($this->authUser(), $veterinary);
    }
}
