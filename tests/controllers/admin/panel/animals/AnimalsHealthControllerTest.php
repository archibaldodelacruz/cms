<?php

use App\Models\Animals\Animal;

class AnimalsHealthControllerTest extends BrowserKitTest
{
    /**
     * @group admin/panel/animals
     */
    public function test_check_animals_health_list()
    {
        $animal = factory(Animal::class)->create([
            'web_id' => 1,
        ]);

        factory(\App\Models\Animals\Health::class, 5)->create([
            'animal_id' => $animal->id,
        ]);

        $this->actingAs($this->authUser())
            ->visitRoute('admin::panel::animals::health::index', ['id' => $animal->id])
            ->see("Ficha de {$animal->name}")
            ->countElements('table.table-center tbody tr', 5);
    }

    /**
     * @group admin/panel/animals
     */
    public function test_create_health_animal()
    {
        $animal = factory(Animal::class)->create([
            'web_id' => 1,
        ]);

        $this->actingAs($this->authUser())
            ->visitRoute('admin::panel::animals::health::create', ['id' => $animal->id])
            ->see("Añadir salud a la ficha de {$animal->name}")
            ->type('Titulo', 'title')
            ->select('treatment', 'type')
            ->press('Añadir')
            ->seeInDatabase('animals_health', [
                'animal_id' => $animal->id,
                'title'     => 'Titulo',
            ]);
    }

    /**
     * @group admin/panel/animals
     */
    public function test_create_health_with_finances_animal()
    {
        $animal = factory(Animal::class)->create([
            'web_id' => 1,
        ]);

        $this->actingAs($this->authUser())
            ->visitRoute('admin::panel::animals::health::create', ['id' => $animal->id])
            ->see("Añadir salud a la ficha de {$animal->name}")
            ->type('Titulo', 'title')
            ->select('treatment', 'type')
            ->type(90, 'cost')
            ->select(1, 'finances')
            ->press('Añadir')
            ->seeInDatabase('animals_health', [
                'animal_id' => $animal->id,
                'title'     => 'Titulo',
            ]);
    }

    /**
     * @group admin/panel/animals
     */
    public function test_edit_health_animal()
    {
        $animal = factory(Animal::class)->create([
            'web_id' => 1,
        ]);

        $health = factory(\App\Models\Animals\Health::class)->create([
            'animal_id' => $animal->id,
            'title'     => 'Titulo salud',
        ]);

        $this->actingAs($this->authUser())
            ->seeInDatabase('animals_health', [
                'animal_id' => $animal->id,
                'title'     => 'Titulo salud',
            ])
            ->visitRoute('admin::panel::animals::health::edit', ['id' => $health->id, 'animal_id' => $animal->id])
            ->see('Titulo salud')
            ->type('Otro titulo', 'title')
            ->press('Actualizar')
            ->seeInDatabase('animals_health', [
                'id'        => $health->id,
                'animal_id' => $animal->id,
                'title'     => 'Otro titulo',
            ]);
    }

    /**
     * @group admin/panel/animals
     */
    public function test_delete_health_animal()
    {
        $animal = factory(Animal::class)->create([
            'web_id' => 1,
        ]);

        $health = factory(\App\Models\Animals\Health::class)->create([
            'animal_id' => $animal->id,
        ]);

        $this->actingAs($this->authUser())
            ->seeInDatabase('animals_health', [
                'id' => $health->id,
            ])
            ->visitRoute('admin::panel::animals::health::delete', ['id' => $health->id, 'animal_id' => $animal->id])
            ->notSeeInDatabase('animals_health', [
                'id'         => $health->id,
                'deleted_at' => null,
            ]);
    }
}
