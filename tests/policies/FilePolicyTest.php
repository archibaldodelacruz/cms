<?php

use App\Models\Files\File;
use App\Policies\FilePolicy;

class FilePolicyTest extends TestCase
{
    /**
     * @group policies
     */
    public function test_view()
    {
        (new FilePolicy)->view($this->authUser());
    }

    /**
     * @group policies
     */
    public function test_create()
    {
        (new FilePolicy)->create($this->authUser());
    }

    /**
     * @group policies
     */
    public function test_update()
    {
        $file = factory(File::class)->create();

        (new FilePolicy)->update($this->authUser(), $file);
    }

    /**
     * @group policies
     */
    public function test_delete()
    {
        $file = factory(File::class)->create();

        (new FilePolicy)->delete($this->authUser(), $file);
    }
}
