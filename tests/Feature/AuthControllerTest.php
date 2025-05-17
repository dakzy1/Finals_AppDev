<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;


class AuthControllerTest extends TestCase
{
    use RefreshDatabase;


    /** @test */
    public function it_registers_a_user_and_redirects()
    {
        $this->withoutMiddleware();

        $response = $this->post(route('register.post'), [
            'first_name' => 'Test',
            'middle_name' => 'M',
            'last_name' => 'User',
            'gender' => 'male',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', ['email' => 'test@example.com']);
    }

    /** @test */
    public function it_fails_registration_with_invalid_data()
    {
        $this->withoutMiddleware(); 
        $response = $this->from(route('register'))->post(route('register.post'), [
            'first_name' => '',
            'email' => 'not-an-email',
            'password' => 'short',
        ]);

        $response->assertRedirect(route('register'));
        $response->assertSessionHasErrors(['first_name', 'email', 'password']);
        $this->assertGuest();
    }

    /** @test */
    public function it_shows_login_view()
    {
        $response = $this->get(route('login'));
        $response->assertStatus(200);
        $response->assertViewIs('auth.login');
    }

    /** @test */
    public function it_logs_in_with_valid_credentials()
    {
        
        $user = User::factory()->create([
            'email' => 'login@example.com',
            'password' => Hash::make('password123'),
            'status' => 'active',
        ]);

        $this->withSession([]); 

        $response = $this->post(route('login.post'), [
            'email' => 'login@example.com',
            'password' => 'password123',
        ]);
        
        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function it_fails_login_with_invalid_credentials()
    {
        $this->withoutMiddleware();
        User::factory()->create([
            'email' => 'wrong@example.com',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->from(route('login'))->post(route('login.post'), [
            'email' => 'wrong@example.com',
            'password' => 'wrongpass',
        ]);

        $response->assertRedirect(route('login'));
        $response->assertSessionHasErrors(['email']);
        $this->assertGuest();
    }

    /** @test */
    public function it_fails_login_if_user_is_deactivated()
    {
        $this->withoutMiddleware();
        $user = User::factory()->create([
            'email' => 'deactivated@example.com',
            'password' => Hash::make('password123'),
            'status' => 'deactivated',
        ]);

        $response = $this->from(route('login'))->post(route('login.post'), [
            'email' => 'deactivated@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('login'));
        $response->assertSessionHasErrors(['email']);
        $this->assertGuest();
    }

    /** @test */
    public function it_logs_out_the_user()
    {
        
        $user = User::factory()->create();

        $this->actingAs($user);
        $response = $this->post(route('logout'));

        $response->assertRedirect(route('login'));
        $this->assertGuest();
    }

     
}
