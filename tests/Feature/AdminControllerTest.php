<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\FitnessClass;
use App\Models\Schedule;

class AdminControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_shows_admin_dashboard()
    {
        $response = $this->get(route('admin.dashboard'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.dashboard');
    }

    /** @test */
    public function it_updates_a_user()
    {
        $user = User::factory()->create();

        $response = $this->put(route('admin.update', $user->id), [
            'first_name' => 'Updated',
            'middle_name' => 'Middle',
            'last_name' => 'User',
            'gender' => 'male',
            'email' => 'updated@example.com',
            'password' => 'newpassword123',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'first_name' => 'Updated',
            'email' => 'updated@example.com',
        ]);
    }

    /** @test */
    public function it_deletes_a_user()
    {
        $user = User::factory()->create();

        $response = $this->delete(route('admin.destroy', $user->id));

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    /** @test */
    public function it_creates_a_fitness_class()
    {
        $response = $this->post(route('class.store'), [
            'name' => 'Zumba',
            'level' => 'Beginner',
            'duration' => '60 mins',
            'trainer' => 'Jane Doe',
            'description' => 'Fun class',
            'key_benefits' => 'Cardio',
            'user_limit' => 20,
            'time' => '08:00',
            'end_time' => '09:00',
        ]);

        $response->assertRedirect(route('admin.classmanage'));
        $this->assertDatabaseHas('fitness_classes', ['name' => 'Zumba']);
    }

    /** @test */
    public function it_updates_a_fitness_class()
    {
        $class = FitnessClass::factory()->create();

        $response = $this->put(route('class.update', $class->id), [
            'name' => 'Yoga',
            'level' => 'Intermediate',
            'duration' => '45 mins',
            'trainer' => 'John Smith',
            'description' => 'Stretching',
            'key_benefits' => 'Flexibility',
            'user_limit' => 15,
            'time' => '10:00',
            'end_time' => '11:00',
        ]);

        $response->assertRedirect(route('admin.classmanage'));
        $this->assertDatabaseHas('fitness_classes', ['name' => 'Yoga']);
    }

    /** @test */
    public function it_deletes_a_fitness_class()
    {
        $class = FitnessClass::factory()->create();

        $response = $this->delete(route('class.destroy', $class->id));

        $response->assertRedirect(route('admin.classmanage'));
        $this->assertDatabaseMissing('fitness_classes', ['id' => $class->id]);
    }

    /** @test */
    public function it_toggles_user_status()
    {
        $user = User::factory()->create(['status' => 'active']);

        $response = $this->put(route('admin.toggleStatus', $user->id));

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertEquals('deactivated', $user->fresh()->status);
    }
}
