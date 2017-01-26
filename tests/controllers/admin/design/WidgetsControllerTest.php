<?php

use App\Models\Users\User;
use App\Models\Widgets\Widget;

class WidgetsControllerTest extends TestCase
{
    /**
     * @group admin/design/widgets
     */
    public function test_index_widgets()
    {
        $this->actingAs($this->authUser())
            ->visitRoute('admin::design::widgets::index');
    }

    /**
     * @group admin/design/widgets
     */
    public function test_index_widgets_without_permissions()
    {
        $this->actingAs(factory(User::class)->create())
            ->get(route('admin::design::widgets::index'))
            ->assertResponseStatus(401);
    }

    /**
     * @group admin/design/widgets
     */
    public function test_deleted_widgets()
    {
        $this->actingAs($this->authUser())
            ->visitRoute('admin::design::widgets::deleted');
    }

    /**
     * @group admin/design/widgets
     */
    public function test_deleted_widgets_without_permissions()
    {
        $this->actingAs(factory(User::class)->create())
            ->get(route('admin::design::widgets::deleted'))
            ->assertResponseStatus(401);
    }

    /**
     * @group admin/design/widgets
     */
    public function test_create_widgets()
    {
        $this->actingAs($this->authUser())
            ->visitRoute('admin::design::widgets::create')
            ->type('Title', 'es[title]')
            ->select('protecms', 'type')
            ->press('Crear bloque')
            ->seeInDatabase('widgets', [
                'id' => 1,
            ])
            ->seeInDatabase('widgets_translations', [
                'title' => 'Title',
            ]);
    }

    /**
     * @group admin/design/widgets
     */
    public function test_create_widgets_without_permissions()
    {
        $this->actingAs(factory(User::class)->create())
            ->get(route('admin::design::widgets::create'))
            ->assertResponseStatus(401);
    }

    /**
     * @group admin/design/widgets
     */
    public function test_edit_widgets()
    {
        $widget = factory(Widget::class)->create([
            'web_id' => 1,
            'type' => 'protecms',
            'file' => 'animals_search',
        ]);

        $this->actingAs($this->authUser())
            ->visitRoute('admin::design::widgets::edit', ['id' => $widget->id])
            ->type('New Title', 'es[title]')
            ->press('Actualizar')
            ->seeInDatabase('widgets', [
                'id' => 1,
            ])
            ->seeInDatabase('widgets_translations', [
                'title' => 'New Title',
            ]);
    }

    /**
     * @group admin/design/widgets
     */
    public function test_edit_widgets_without_permissions()
    {
        $widget = factory(Widget::class)->create([
            'web_id' => 1,
        ]);

        $this->actingAs(factory(User::class)->create())
            ->get(route('admin::design::widgets::edit', ['id' => $widget->id]))
            ->assertResponseStatus(401);
    }

    /**
     * @group admin/design/widgets
     */
    public function test_delete_widgets()
    {
        $widget = factory(Widget::class)->create([
            'web_id' => 1,
            'type' => 'protecms',
            'file' => 'animals_search',
        ]);

        $this->actingAs($this->authUser())
            ->visitRoute('admin::design::widgets::delete', ['id' => $widget->id])
            ->notSeeInDatabase('widgets', [
                'id' => $widget->id,
                'deleted_at' => null,
            ]);
    }

    /**
     * @group admin/design/widgets
     */
    public function test_delete_widgets_without_permissions()
    {
        $widget = factory(Widget::class)->create([
            'web_id' => 1,
        ]);

        $this->actingAs(factory(User::class)->create())
            ->get(route('admin::design::widgets::delete', ['id' => $widget->id]))
            ->assertResponseStatus(401);
    }

    /**
     * @group admin/design/widgets
     */
    public function test_delete_widgets_translation()
    {
        $widget = factory(Widget::class)->create([
            'web_id' => 1,
            'type' => 'protecms',
            'file' => 'animals_search',
            'es' => [
                'title' => 'Prueba',
            ],
            'en' => [
                'title' => 'Test',
            ],
        ]);

        $this->actingAs($this->authUser())
            ->seeInDatabase('widgets_translations', [
                'locale'  => 'es',
                'title'  => 'Prueba',
            ])
            ->seeInDatabase('widgets_translations', [
                'locale'  => 'en',
                'title'  => 'Test',
            ])
            ->visit(route('admin::design::widgets::delete_translation', ['id' => $widget->id]).'?langform=en')
            ->notSeeInDatabase('widgets_translations', [
                'locale'  => 'en',
                'title'  => 'Test',
            ]);
    }

    /**
     * @group admin/design/widgets
     */
    public function test_delete_widgets_translation_without_permissions()
    {
        $widget = factory(Widget::class)->create([
            'web_id' => 1,
        ]);

        $this->actingAs(factory(User::class)->create())
            ->get(route('admin::design::widgets::delete', ['id' => $widget->id]))
            ->assertResponseStatus(401);
    }

    /**
     * @group admin/design/widgets
     */
    public function test_restore_widgets()
    {
        $widget = factory(Widget::class)->create([
            'web_id' => 1,
        ]);

        $this->actingAs($this->authUser())
            ->visitRoute('admin::design::widgets::delete', ['id' => $widget->id])
            ->notSeeInDatabase('widgets', [
                'id' => $widget->id,
                'deleted_at' => null,
            ])
            ->visitRoute('admin::design::widgets::restore', ['id' => $widget->id])
            ->seeInDatabase('widgets', [
                'id' => $widget->id,
                'deleted_at' => null,
            ]);
    }

    /**
     * @group admin/design/widgets
     */
    public function test_restore_widgets_without_permissions()
    {
        $widget = factory(Widget::class)->create([
            'web_id' => 1,
        ]);

        $this->actingAs(factory(User::class)->create())
            ->get(route('admin::design::widgets::restore', ['id' => $widget->id]))
            ->assertResponseStatus(401);
    }
}
