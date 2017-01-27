<?php

use App\Models\Animals\Animal;

class AnimalsSponsorshipsControllerTest extends BrowserKitTest
{
    /**
     * @group admin/panel/animals
     */
    public function test_check_animals_sponsorships_list()
    {
        $animal = factory(Animal::class)->create([
            'web_id' => 1,
        ]);

        factory(\App\Models\Animals\Sponsorship::class, 5)->create([
            'animal_id' => $animal->id,
        ]);

        $this->actingAs($this->authUser())
            ->visitRoute('admin::panel::animals::sponsorships::index', ['id' => $animal->id])
            ->see("Apadrinamientos de {$animal->name}")
            ->countElements('table.table-center tbody tr', 5);
    }

    /**
     * @group admin/panel/animals
     */
    public function test_create_sponsorships_animal()
    {
        $animal = factory(Animal::class)->create([
            'web_id' => 1,
        ]);

        $this->actingAs($this->authUser())
            ->visitRoute('admin::panel::animals::sponsorships::create', ['id' => $animal->id])
            ->see("Añadir apadrinamiento a la ficha de {$animal->name}")
            ->type('Alicia', 'name')
            ->select('visible', 'visible')
            ->select('active', 'status')
            ->select('day', 'donation_time')
            ->press('Añadir')
            ->seeInDatabase('animals_sponsorships', [
                'animal_id' => $animal->id,
                'name'      => 'Alicia',
            ]);
    }

    /**
     * @group admin/panel/animals
     */
    public function test_edit_sponsorships_animal()
    {
        $animal = factory(Animal::class)->create([
            'web_id' => 1,
        ]);

        $sponsorships = factory(\App\Models\Animals\Sponsorship::class)->create([
            'animal_id' => $animal->id,
            'name'      => 'Jaime',
        ]);

        $this->actingAs($this->authUser())
            ->seeInDatabase('animals_sponsorships', [
                'animal_id' => $animal->id,
                'name'      => 'Jaime',
            ])
            ->visitRoute('admin::panel::animals::sponsorships::edit', ['id' => $sponsorships->id, 'animal_id' => $animal->id])
            ->see('Jaime')
            ->type('Otro nombre', 'name')
            ->press('Actualizar')
            ->seeInDatabase('animals_sponsorships', [
                'id'        => $sponsorships->id,
                'animal_id' => $animal->id,
                'name'      => 'Otro nombre',
            ]);
    }

    /**
     * @group admin/panel/animals
     */
    public function test_delete_sponsorships_animal()
    {
        $animal = factory(Animal::class)->create([
            'web_id' => 1,
        ]);

        $sponsorships = factory(\App\Models\Animals\Sponsorship::class)->create([
            'animal_id' => $animal->id,
        ]);

        $this->actingAs($this->authUser())
            ->seeInDatabase('animals_sponsorships', [
                'id' => $sponsorships->id,
            ])
            ->visitRoute('admin::panel::animals::sponsorships::delete', ['id' => $sponsorships->id, 'animal_id' => $animal->id])
            ->notSeeInDatabase('animals_sponsorships', [
                'id'         => $sponsorships->id,
                'deleted_at' => null,
            ]);
    }
}
