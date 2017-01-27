<?php

use App\Models\Pages\Page;
use App\Models\Posts\Post;
use App\Models\Users\User;

class UsersControllerTest extends BrowserKitTest
{
    /**
     * @group admin/panel/users
     */
    public function test_check_users_list()
    {
        factory(User::class, 9)->create([
            'web_id' => 1,
        ]);

        $this->actingAs($this->authUser())
            ->visitRoute('admin::panel::users::index')
            ->see('Listado de usuarios')
            ->countElements('table.table-center tbody tr', 10);
    }

    /**
     * @group admin/panel/users
     */
    public function test_check_users_list_without_permissions()
    {
        $user = factory(User::class)->create([
            'web_id' => 1,
            'type' => 'user',
        ]);

        $this->actingAs($user)
            ->get(route('admin::panel::users::index'))
            ->seeStatusCode(401);
    }

    /**
     * @group admin/panel/users
     */
    public function test_create_user()
    {
        $this->actingAs($this->authUser())
            ->visitRoute('admin::panel::users::create')
            ->see('Registrar usuario')
            ->type('Jaime', 'name')
            ->type('web@protecms.com', 'email')
            ->type('password', 'password')
            ->type('password', 'password_confirmation')
            ->select('active', 'status')
            ->select('admin', 'type')
            ->select('yes', 'notification')
            ->press('Registrar')
            ->seeInDatabase('users', [
                'id' => 2,
            ])
            ->seeRouteIs('admin::panel::users::edit', ['id' => 2]);
    }

    /**
     * @group admin/panel/users
     */
    public function test_create_user_without_permissions()
    {
        $user = factory(User::class)->create([
            'web_id' => 1,
            'type' => 'user',
        ]);

        $this->actingAs($user)
            ->get(route('admin::panel::users::create'))
            ->seeStatusCode(401);
    }

    /**
     * @group admin/panel/users
     */
    public function test_show_user()
    {
        $user = factory(User::class)->create([
            'web_id' => 1,
        ]);

        $this->actingAs($this->authUser())
            ->visitRoute('admin::panel::users::show', ['id' => 2])
            ->see($user->name);
    }

    /**
     * @group admin/panel/users
     */
    public function test_show_user_without_permissions()
    {
        $user = factory(User::class)->create([
            'web_id' => 1,
            'type' => 'user',
        ]);

        $this->actingAs($user)
            ->get(route('admin::panel::users::show', ['id' => 2]))
            ->seeStatusCode(401);
    }

    /**
     * @group admin/panel/users
     */
    public function test_edit_user()
    {
        factory(User::class)->create([
            'web_id' => 1,
        ]);

        $this->actingAs($this->authUser())
            ->seeInDatabase('users', [
                'id' => 2,
            ])
            ->visitRoute('admin::panel::users::edit', ['id' => 2])
            ->type('Cambio de nombre', 'name')
            ->press('Actualizar')
            ->seeInDatabase('users', [
                'name' => 'Cambio de nombre',
            ]);
    }

    /**
     * @group admin/panel/users
     */
    public function test_edit_user_without_permissions()
    {
        $user = factory(User::class)->create([
            'web_id' => 1,
            'type' => 'user',
        ]);

        $this->actingAs($user)
            ->get(route('admin::panel::users::edit', ['id' => $user->id]))
            ->seeStatusCode(401);
    }

    /**
     * @group admin/panel/users
     */
    public function test_delete_user()
    {
        $from = factory(User::class)->create([
            'web_id' => 1,
            'status' => 'active',
            'type'   => 'volunteer',
        ]);

        factory(Post::class, 2)->create([
            'web_id' => 1,
            'es'     => [
                'title'   => 'Titulo',
                'slug'    => 'titulo',
                'text'    => 'Texto',
                'user_id' => $from->id,
            ],
        ]);

        factory(Page::class, 2)->create([
            'web_id' => 1,
            'es'     => [
                'title'   => 'Titulo',
                'slug'    => 'titulo',
                'text'    => 'Texto',
                'user_id' => $from->id,
            ],
        ]);

        $this->actingAs($this->authUser())
            ->seeInDatabase('users', [
                'id' => $from->id,
            ])
            ->seeInDatabase('users', [
                'id' => 1,
            ])
            ->seeInDatabase('posts_translations', [
                'user_id' => $from->id,
            ])
            ->notSeeInDatabase('posts_translations', [
                'user_id' => 1,
            ])
            ->seeInDatabase('pages_translations', [
                'user_id' => $from->id,
            ])
            ->notSeeInDatabase('pages_translations', [
                'user_id' => 1,
            ])
            ->visitRoute('admin::panel::users::delete', ['id' => $from->id])
            ->seeInDatabase('posts_translations', [
                'user_id' => 1,
            ])
            ->notSeeInDatabase('posts_translations', [
                'user_id' => $from->id,
            ])
            ->seeInDatabase('pages_translations', [
                'user_id' => 1,
            ])
            ->notSeeInDatabase('pages_translations', [
                'user_id' => $from->id,
            ])
            ->notSeeInDatabase('users', [
                'id'         => $from->id,
                'deleted_at' => null,
            ]);
    }

    /**
     * @group admin/panel/users
     */
    public function test_delete_user_without_permissions()
    {
        $user = factory(User::class)->create([
            'web_id' => 1,
            'type' => 'user',
        ]);

        $this->actingAs($user)
            ->get(route('admin::panel::users::delete', ['id' => $user->id]))
            ->seeStatusCode(401);
    }

    /**
     * @group admin/panel/users
     */
    public function test_read_notifications()
    {
        \Notification::send($this->authUser(), new \App\Notifications\NewUpdate([
            'text' => 'New update',
            'link' => 'new-update',
        ]));

        $this->assertEquals($this->authUser()->unreadNotifications()->count(), 1);

        $this->actingAs($this->authUser())
            ->post(route('admin::panel::users::read_notifications'));

        $this->assertEquals($this->authUser()->unreadNotifications()->count(), 0);
    }
}
