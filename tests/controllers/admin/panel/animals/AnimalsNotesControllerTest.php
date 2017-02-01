<?php

use App\Models\Animals\Animal;

class AnimalsNotesControllerTest extends BrowserKitTest
{
    /**
     * @group admin/panel/animals
     */
    public function test_check_animals_notes_list()
    {
        $animal = factory(Animal::class)->create([
            'web_id' => 1,
        ]);

        factory(\App\Models\Animals\Note::class, 5)->create([
            'animal_id' => $animal->id,
        ]);

        $this->actingAs($this->authUser())
            ->visitRoute('admin::panel::animals::notes::index', ['id' => $animal->id])
            ->see('Notas')
            ->countElements('table.table-center tbody tr', 5);
    }

    /**
     * @group admin/panel/animals
     */
    public function test_create_notes_animal()
    {
        $animal = factory(Animal::class)->create([
            'web_id' => 1,
        ]);

        $this->actingAs($this->authUser())
            ->visitRoute('admin::panel::animals::notes::create', ['id' => $animal->id])
            ->see("Añadir nota a la ficha de {$animal->name}")
            ->type('Title', 'es[title]')
            ->type('Text', 'es[text]')
            ->type(date('d-m-Y H:i:s'), 'published_at')
            ->press('Añadir')
            ->seeInDatabase('animals_notes', [
                'animal_id' => $animal->id,
            ]);
    }

    /**
     * @group admin/panel/animals
     */
    public function test_edit_notes_animal()
    {
        $animal = factory(Animal::class)->create([
            'web_id' => 1,
        ]);

        $notes = factory(\App\Models\Animals\Note::class)->create([
            'animal_id' => $animal->id,
        ]);

        $this->actingAs($this->authUser())
            ->seeInDatabase('animals_notes', [
                'animal_id' => $animal->id,
            ])
            ->visitRoute('admin::panel::animals::notes::edit', ['id' => $notes->id, 'animal_id' => $animal->id])
            ->see('Jaime')
            ->type('Title', 'es[title]')
            ->type('Text', 'es[text]')
            ->type(date('d-m-Y H:i:s'), 'published_at')
            ->press('Actualizar')
            ->seeInDatabase('animals_notes', [
                'id'        => $notes->id,
                'animal_id' => $animal->id,
            ]);
    }

    /**
     * @group admin/panel/animals
     */
    public function test_delete_notes_animal()
    {
        $animal = factory(Animal::class)->create([
            'web_id' => 1,
        ]);

        $notes = factory(\App\Models\Animals\Note::class)->create([
            'animal_id' => $animal->id,
        ]);

        $this->actingAs($this->authUser())
            ->seeInDatabase('animals_notes', [
                'id' => $notes->id,
            ])
            ->visitRoute('admin::panel::animals::notes::delete', ['id' => $notes->id, 'animal_id' => $animal->id])
            ->notSeeInDatabase('animals_notes', [
                'id'         => $notes->id,
                'deleted_at' => null,
            ]);
    }
}
