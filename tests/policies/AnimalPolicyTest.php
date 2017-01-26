<?php

use App\Models\Animals\Animal;
use App\Policies\AnimalPolicy;

class AnimalPolicyTest extends TestCase
{
    /**
     * @group policies
     */
    public function test_view()
    {
        (new AnimalPolicy)->view($this->authUser());
    }

    /**
     * @group policies
     */
    public function test_create()
    {
        (new AnimalPolicy)->create($this->authUser());
    }

    /**
     * @group policies
     */
    public function test_update()
    {
        $animal = factory(Animal::class)->create();

        (new AnimalPolicy)->update($this->authUser(), $animal);
    }

    /**
     * @group policies
     */
    public function test_delete()
    {
        $animal = factory(Animal::class)->create();

        (new AnimalPolicy)->delete($this->authUser(), $animal);
    }
}
