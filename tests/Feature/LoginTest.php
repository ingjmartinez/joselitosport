<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_assets_use_https_behind_a_tls_proxy(): void
    {
        $this->withHeaders([
            'X-Forwarded-Proto' => 'https',
            'X-Forwarded-Port' => '443',
        ])->get('http://sport.joselitogroup.com/login')
            ->assertOk()
            ->assertSee('https://sport.joselitogroup.com/velzon/assets/css/app.min.css', false)
            ->assertSee('https://sport.joselitogroup.com/velzon/assets/libs/particles.js/particles.js', false)
            ->assertDontSee('http://sport.joselitogroup.com/', false);
    }

    public function test_login_assets_keep_http_for_local_requests(): void
    {
        $this->get('http://localhost/login')
            ->assertOk()
            ->assertSee('http://localhost/velzon/assets/css/app.min.css', false)
            ->assertSee('http://localhost/velzon/assets/libs/particles.js/particles.js', false)
            ->assertDontSee('https://localhost/', false);
    }

    public function test_guest_can_view_login_and_is_redirected_from_dashboard(): void
    {
        $this->get('/login')->assertOk()->assertSee('Iniciar sesión');
        $this->get('/dashboard')->assertRedirect('/login');
    }

    public function test_user_can_login_and_logout(): void
    {
        $user = User::factory()->create(['password' => 'secret-password']);

        $this->post('/login', ['email' => $user->email, 'password' => 'secret-password'])
            ->assertRedirect(route('dashboard'));
        $this->assertAuthenticatedAs($user);
        $this->get('/dashboard')->assertOk()->assertSee($user->name);

        $this->post('/logout')->assertRedirect(route('login'));
        $this->assertGuest();
    }

    public function test_wrong_password_is_rejected(): void
    {
        $user = User::factory()->create();

        $this->post('/login', ['email' => $user->email, 'password' => 'incorrect'])
            ->assertSessionHasErrors('email');
        $this->assertGuest();
    }
}
