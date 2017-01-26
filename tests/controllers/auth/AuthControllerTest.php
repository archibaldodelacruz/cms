<?php


class AuthControllerTest extends TestCase
{
    /**
     * @group auth
     */
    public function test_check_login_form()
    {
        $this->visitRoute('auth::login')
            ->see('Acceder al panel')
            ->type('testing@protecms.com', 'email')
            ->type('testing', 'password')
            ->press('Acceder')
            ->see('Panel de Administración | ProteCMS');
    }

    /**
     * @group auth
     */
    public function test_fail_login_form()
    {
        $this->visitRoute('auth::login')
            ->see('Acceder al panel')
            ->type('testing@protecms.com', 'email')
            ->type('wrong', 'password')
            ->press('Acceder')
            ->see('El correo electrónico o la contraseña no son válidos');
    }

    /**
     * @group auth
     */
    public function test_fail_login_temporary_ban_form()
    {
        for ($i = 5; $i > 1; $i--) {
            $this->visitRoute('auth::login')
                ->see('Acceder al panel')
                ->type('testing@protecms.com', 'email')
                ->type('wrong', 'password')
                ->press('Acceder')
                ->see('El correo electrónico o la contraseña no son válidos');

            if ($i < 2) {
                $this->visitRoute('auth::login')
                    ->see('Acceder al panel')
                    ->type('testing@protecms.com', 'email')
                    ->type('wrong', 'password')
                    ->press('Acceder')
                    ->see('El correo electrónico o la contraseña no son válidos. Le quedan '.$i.' intentos, luego se bloqueará al usuario durante 1 minuto.');
            }
        }

        $this->visitRoute('auth::login')
                ->see('Acceder al panel')
                ->type('testing@protecms.com', 'email')
                ->type('wrong', 'password')
                ->press('Acceder')
                ->see('Su cuenta ha sido temporalmente bloqueada. Prueba de nuevo en 1 minuto.');
    }

    /**
     * @group auth
     */
    public function test_check_logout()
    {
        $this->actingAs($this->authUser())
            ->visitRoute('admin::panel::index')
            ->see('Panel de Administración | ProteCMS')
            ->visitRoute('auth::logout')
            ->see('Acceder al panel');
    }
}
