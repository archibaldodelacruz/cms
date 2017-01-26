<?php

use App\Models\Forms\Form;
use App\Policies\FormPolicy;

class FormPolicyTest extends TestCase
{
    /**
     * @group policies
     */
    public function test_view()
    {
        (new FormPolicy)->view($this->authUser());
    }

    /**
     * @group policies
     */
    public function test_create()
    {
        (new FormPolicy)->create($this->authUser());
    }

    /**
     * @group policies
     */
    public function test_update()
    {
        $form = factory(Form::class)->create();

        (new FormPolicy)->update($this->authUser(), $form);
    }

    /**
     * @group policies
     */
    public function test_delete()
    {
        $form = factory(Form::class)->create();

        (new FormPolicy)->delete($this->authUser(), $form);
    }
}
