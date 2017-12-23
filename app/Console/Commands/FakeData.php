<?php

namespace App\Console\Commands;

use Faker\Factory;
use Image;
use App\ProteCMS\Core\{
    Models\Webs\Web,
    Models\Files\File,
    Models\Pages\Page,
    Models\Posts\Post,
    Models\Users\User,
    Models\Animals\Animal,
    Models\Posts\Category,
    Models\Partners\Partner,
    Models\Calendar\Calendar,
    Models\Animals\TemporaryHome,
    Models\Veterinarians\Veterinary
};
use Illuminate\Console\Command;

class FakeData extends Command
{
    protected $signature = 'protecms:fakedata';
    protected $description = 'Seed fake data to development';

    const USERS = 20;
    const POSTS_CATEGORIES = 4;
    const POSTS = 20;
    const POSTS_COMMENTS = 20;
    const FILES = 20;
    const ANIMALS = 20;
    const ANIMALS_PHOTOS = 6;
    const PAGES = 5;
    const VETERINARIANS = 5;
    const CALENDAR = 50;
    const TEMPORARY_HOMES = 20;
    const PARTNERS = 100;

    public function __construct(Web $web, User $user)
    {
        parent::__construct();

        $this->web = $web;
        $this->user = $user;
    }

    public function handle()
    {
        $this->call('migrate:refresh');
        $this->call('db:seed');

        $faker = Factory::create();

        // Generate web
        $this->info('Generating web');
        $web = new $this->web();
        $web->name = 'Protectora de Demostración';
        $web->domain = 'shelter.dev';
        $web->subdomain = 'shelter';
        $web->email = 'web@protecms.com';
        $web->country_id = 205;
        $web->state_id = 3288;
        $web->city_id = 38492;
        $web->installed = 1;
        $web->save();

        $web->setConfigs(config('protecms.webs.config.default'));
        $web->setConfig('animals.contact_email', $web->email);

        removeFolder($web->getStorageFolder());

        // Generate calendar
        $this->info('Generating calendar');
        factory(Calendar::class, self::CALENDAR)->create([
            'web_id' => $web->id,
        ]);

        // Generate users
        $this->info('Generating users');
        $user = factory(User::class)->create([
            'web_id'     => $web->id,
            'name'       => 'Admin',
            'email'      => 'admin@email.com',
            'password'   => 'admin',
            'type'       => 'admin',
            'status'     => 'active',
            'country_id' => 205,
            'state_id'   => 3288,
            'city_id'    => 38492,
        ]);

        factory(User::class, self::USERS)->create([
            'web_id' => $web->id,
        ]);

        // Generate posts
        $this->info('Generating posts categories');
        factory(Category::class, self::POSTS_CATEGORIES)->create([
            'web_id' => $web->id,
        ]);

        $this->info('Generating posts');
        for ($i = 0; $i < self::POSTS; $i++) {
            factory(Post::class)->create([
                'web_id'      => $web->id,
                'user_id'     => $user->id,
                'category_id' => mt_rand(1, self::POSTS_CATEGORIES),
            ]);
        }

        // Generate files
        $this->info('Generating files');
        factory(File::class, self::FILES)->create([
            'web_id' => $web->id,
        ]);

        // Generate animals
        $this->info('Generating animals');
        $animals = factory(Animal::class, self::ANIMALS)->create([
            'web_id' => $web->id,
        ]);

        foreach ($animals as $animal) {
            $path = storage_path('app/web/'.$web->id.'/animals/'.$animal->id.'/photos');

            foreach (range(0, rand(0, self::ANIMALS_PHOTOS)) as $i) {
                checkFolder($path);
                $image = $faker->image($path, 800, 800, 'animals', false);

                if ($image) {
                    if (is_file($path.'/'.$image)) {
                        Image::make($path.'/'.$image)->fit(600, 600, function ($constraint) {
                            $constraint->upsize();
                        })->save($path.'/thumbnail-m-'.$image);

                        Image::make($path.'/'.$image)->fit(200, 200, function ($constraint) {
                            $constraint->upsize();
                        })->save($path.'/thumbnail-m-'.$image);
                    }

                    $animal->media()->create([
                        'animal_id' => $animal->id,
                        'type'      => 'photo',
                        'file'      => $image,
                        'main'      => 0,
                    ]);
                }
            }
        }

        // Generate pages
        $this->info('Generating pages');
        $pages = factory(Page::class, self::PAGES)->create([
            'web_id'  => $web->id,
            'user_id' => $user->id,
        ]);

        // Generate temporary homes
        $this->info('Generating temporary homes');
        $temporary_homes = factory(TemporaryHome::class, self::TEMPORARY_HOMES)->create([
            'web_id' => $web->id,
        ]);

        // Generate partners
        $this->info('Generating partners');
        $partners = factory(Partner::class, self::PARTNERS)->create([
            'web_id' => $web->id,
        ]);

        // Generate veterinarians
        $this->info('Generating veterinarians');
        factory(Veterinary::class, self::VETERINARIANS)->create([
            'web_id' => $web->id,
        ]);

        // Generate forms
        $form = $web->forms()->create([
            'email'  => $web->email,
            'status' => 'published',
            'es'     => [
                'user_id' => $user->id,
                'title'   => 'Contacto',
                'slug'    => 'contacto',
                'subject' => 'Contacto',
                'text'    => '<p>Puedes contactar con nosotros mediante el siguiente formulario.</p>',
            ],
        ]);

        $fields = [
            'name'    => 'text',
            'subject' => 'text',
            'email'   => 'email',
            'message' => 'textarea',
        ];

        $order = 1;
        foreach ($fields as $key => $value) {
            $form->fields()->create([
                'order'    => $order,
                'name'     => $order,
                'type'     => $value,
                'required' => 1,
                'es'       => [
                    'title' => ucfirst(trans('validation.attributes.'.$key)),
                ],
            ]);

            $order++;
        }

        // Generate widgets
        $this->info('Generating widgets');
        $widget = $web->widgets()->create([
            'status' => 'active',
            'side'   => 'left',
            'order'  => 1,
            'type'   => 'menu',
            'es'     => [
                'title' => 'Menú principal',
            ],
        ]);

        $widget->links()->create([
            'type' => 'link',
            'es'   => [
                'title' => 'Inicio',
                'link'  => '/',
            ],
        ]);

        foreach ($pages as $page) {
            if ($page->status == 'published') {
                $widget->links()->create([
                    'type' => 'link',
                    'es'   => [
                        'title' => $page->title,
                        'link'  => '/pagina/'.$page->id.'-'.$page->slug,
                    ],
                ]);
            }
        }

        $widget->links()->create([
            'type' => 'link',
            'es'   => [
                'title' => $form->title,
                'link'  => '/formulario/'.$form->id.'-'.$form->slug,
            ],
        ]);

        $widget = $web->widgets()->create([
            'status' => 'active',
            'side'   => 'left',
            'order'  => 2,
            'type'   => 'menu',
            'es'     => [
                'title' => 'Animales',
            ],
        ]);

        $widget->links()->create([
            'type' => 'link',
            'es'   => [
                'title' => 'Todos los animales',
                'link'  => '/animales',
            ],
        ]);

        $widget->links()->create([
            'type' => 'link',
            'es'   => [
                'title' => 'Perros en adopción',
                'link'  => '/animales?especie=perros&estado=en-adopcion',
            ],
        ]);

        $widget->links()->create([
            'type' => 'link',
            'es'   => [
                'title' => 'Gatos en adopción',
                'link'  => '/animales?especie=gatos&estado=en-adopcion',
            ],
        ]);

        $web->widgets()->create([
            'status' => 'active',
            'side'   => 'right',
            'order'  => 1,
            'type'   => 'protecms',
            'file'   => 'animals_search',
            'es'     => [
                'title' => 'Buscador de animales',
            ],
        ]);

        $web->widgets()->create([
            'status' => 'active',
            'side'   => 'right',
            'order'  => 2,
            'type'   => 'protecms',
            'file'   => 'last_animals',
            'es'     => [
                'title' => 'Últimas fichas',
            ],
        ]);

        $this->info('Seed complete.');
        $this->line('---');
        $this->info('Now you can access to website using domain or subdomain:');
        $this->table(['Domain', 'Subdomain'], [[$web->domain, $web->subdomain]]);
        $this->line('---');
        $this->info('User to login:');
        $this->table(['Email', 'Password'], [['admin@email.com', 'admin']]);
    }
}
