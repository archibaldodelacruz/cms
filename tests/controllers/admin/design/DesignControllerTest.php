<?php

use App\Models\Users\User;

class DesignControllerTest extends TestCase
{
    /**
     * @group admin/design
     */
    public function test_index_design()
    {
        $this->actingAs($this->authUser())
            ->visitRoute('admin::design::index');
    }

    /**
     * @group admin/design
     */
    public function test_index_design_without_permissions()
    {
        $this->actingAs(factory(User::class)->create())
            ->get(route('admin::design::index'))
            ->assertResponseStatus(401);
    }

    /**
     * @group admin/design
     */
    public function test_config_design()
    {
        $this->actingAs($this->authUser())
            ->visitRoute('admin::design::config');
    }

    /**
     * @group admin/design
     */
    public function test_config_design_without_permissions()
    {
        $this->actingAs(factory(User::class)->create())
            ->get(route('admin::design::config'))
            ->assertResponseStatus(401);
    }

    /**
     * @group admin/design
     */
    public function test_css_design()
    {
        $this->actingAs($this->authUser())
            ->visitRoute('admin::design::css');
    }

    /**
     * @group admin/design
     */
    public function test_css_design_without_permissions()
    {
        $this->actingAs(factory(User::class)->create())
            ->get(route('admin::design::css'))
            ->assertResponseStatus(401);
    }
}
