<?php

use App\Models\Users\User;
use App\Policies\UserPolicy;

class UserPolicyTest extends TestCase
{
    /**
     * @group policies
     */
    public function test_view()
    {
        (new UserPolicy)->view($this->authUser());
    }

    /**
     * @group policies
     */
    public function test_create()
    {
        (new UserPolicy)->create($this->authUser());
    }

    /**
     * @group policies
     */
    public function test_update()
    {
        $user = factory(User::class)->create();

        (new UserPolicy)->update($this->authUser(), $user);
    }

    /**
     * @group policies
     */
    public function test_delete()
    {
        $user = factory(User::class)->create();

        (new UserPolicy)->delete($this->authUser(), $user);
    }
}
