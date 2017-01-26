<?php

use App\Models\Users\User;
use App\Models\Animals\Animal;

class AnimalsControllerTest extends TestCase
{
    /**
     * @group admin/panel/animals
     */
    public function test_check_animals_list()
    {
        $animals = factory(Animal::class, 10)->create([
            'web_id' => 1,
        ]);

        $this->actingAs($this->authUser())
            ->visitRoute('admin::panel::animals::index')
            ->see('Listado de Animales')
            ->seeInDatabase('animals', [
                'id'   => $animals[0]->id,
                'name' => $animals[0]->name,
            ]);
    }

    /**
     * @group admin/panel/animals
     */
    public function test_check_animals_list_without_permissions()
    {
        $this->actingAs(factory(User::class)->create())
            ->get(route('admin::panel::animals::index'))
            ->assertResponseStatus(401);
    }

    /**
     * @group admin/panel/animals
     */
    public function test_check_animals_deleted_list()
    {
        $animals = factory(Animal::class, 10)->create([
            'web_id' => 1,
        ]);

        $this->actingAs($this->authUser())
            ->visitRoute('admin::panel::animals::deleted')
            ->see('Listado de Animales eliminados')
            ->seeInDatabase('animals', [
                'id'   => $animals[0]->id,
                'name' => $animals[0]->name,
            ]);
    }

    /**
     * @group admin/panel/animals
     */
    public function test_check_animals_deleted_list_without_permissions()
    {
        $this->actingAs(factory(User::class)->create())
            ->get(route('admin::panel::animals::deleted'))
            ->assertResponseStatus(401);
    }

    /**
     * @group admin/panel/animals
     */
    public function test_create_animal()
    {
        $this->actingAs($this->authUser())
            ->visitRoute('admin::panel::animals::create')
            ->see('Nueva ficha')
            ->type('Suky', 'name')
            ->press('Crear ficha')
            ->seeInDatabase('animals', [
                'id'   => 1,
                'name' => 'Suky',
            ]);
    }

    /**
     * @group admin/panel/animals
     */
    public function test_create_animal_without_permissions()
    {
        $this->actingAs(factory(User::class)->create())
            ->get(route('admin::panel::animals::create'))
            ->assertResponseStatus(401);
    }

    /**
     * @group admin/panel/animals
     */
    public function test_edit_animal()
    {
        $animal = factory(Animal::class)->create([
            'web_id'    => 1,
            'name'      => 'Ahri',
            'microchip' => 'Old',
        ]);

        $this->actingAs($this->authUser())
            ->seeInDatabase('animals', [
                'id'        => $animal->id,
                'name'      => 'Ahri',
                'microchip' => 'Old',
            ])
            ->visitRoute('admin::panel::animals::edit', ['id' => $animal->id])
            ->see('Ficha de Ahri')
            ->type('Awesome', 'microchip')
            ->press('Actualizar')
            ->seeInDatabase('animals', [
                'id'        => $animal->id,
                'name'      => 'Ahri',
                'microchip' => 'Awesome',
            ]);
    }

    /**
     * @group admin/panel/animals
     */
    public function test_edit_animal_without_permissions()
    {
        $animal = factory(Animal::class)->create();

        $this->actingAs(factory(User::class)->create())
            ->get(route('admin::panel::animals::edit', ['id' => $animal->id]))
            ->assertResponseStatus(401);
    }

    /**
     * @group admin/panel/animals
     */
    public function test_delete_animal()
    {
        $animal = factory(Animal::class)->create([
            'web_id' => 1,
            'name'   => 'Turko',
        ]);

        $this->actingAs($this->authUser())
            ->seeInDatabase('animals', [
                'id'   => $animal->id,
                'name' => 'Turko',
            ])
            ->visitRoute('admin::panel::animals::delete', ['id' => $animal->id])
            ->notSeeInDatabase('animals', [
                'id'         => $animal->id,
                'name'       => 'Turko',
                'deleted_at' => null,
            ]);
    }

    /**
     * @group admin/panel/animals
     */
    public function test_delete_animal_without_permissions()
    {
        $animal = factory(Animal::class)->create([
            'web_id' => 1,
            'name'   => 'Turko',
        ]);
        
        $this->actingAs(factory(User::class)->create())
            ->get(route('admin::panel::animals::delete', ['id' => $animal->id]))
            ->assertResponseStatus(401);
    }

    /**
     * @group admin/panel/animals
     */
    public function test_delete_animal_translation()
    {
        $animal = factory(Animal::class)->create([
            'web_id' => 1,
            'name'   => 'Suky',
            'es'     => [
                'text' => '¡Soy la mejor!',
            ],
            'en' => [
                'text' => 'I\'m the best!',
            ],
        ]);

        $this->actingAs($this->authUser())
            ->seeInDatabase('animals_translations', [
                'locale' => 'es',
                'text'   => '¡Soy la mejor!',
            ])
            ->seeInDatabase('animals_translations', [
                'locale' => 'en',
                'text'   => 'I\'m the best!',
            ])
            ->visitRoute('admin::panel::animals::delete_translation', ['id' => $animal->id])
            ->notSeeInDatabase('animals_translations', [
                'locale' => 'es',
                'text'   => '¡Soy la mejor!',
            ]);
    }

    /**
     * @group admin/panel/animals
     */
    public function test_delete_animal_translation_without_permissions()
    {
        $animal = factory(Animal::class)->create([
            'web_id' => 1,
            'name'   => 'Suky',
            'es'     => [
                'text' => '¡Soy la mejor!',
            ],
            'en' => [
                'text' => 'I\'m the best!',
            ],
        ]);

        $this->actingAs(factory(User::class)->create())
            ->get(route('admin::panel::animals::delete_translation', ['id' => $animal->id]))
            ->assertResponseStatus(401);
    }

    /**
     * @group admin/panel/animals
     */
    public function test_restore_animal()
    {
        $animal = factory(Animal::class)->create([
            'web_id' => 1,
            'name'   => 'Turko',
        ]);

        $this->actingAs($this->authUser())
            ->seeInDatabase('animals', [
                'id'   => $animal->id,
                'name' => 'Turko',
            ])
            ->visitRoute('admin::panel::animals::delete', ['id' => $animal->id])
            ->notSeeInDatabase('animals', [
                'id'         => $animal->id,
                'name'       => 'Turko',
                'deleted_at' => null,
            ])
            ->visitRoute('admin::panel::animals::restore', ['id' => $animal->id])
            ->seeInDatabase('animals', [
                'id'         => $animal->id,
                'name'       => 'Turko',
                'deleted_at' => null,
            ]);
    }

    /**
     * @group admin/panel/animals
     */
    public function test_restore_animal_without_permissions()
    {
        $animal = factory(Animal::class)->create([
            'web_id' => 1,
            'name'   => 'Turko',
        ]);

        $this->actingAs(factory(User::class)->create())
            ->get(route('admin::panel::animals::restore', ['id' => $animal->id]))
            ->assertResponseStatus(401);
    }
}
