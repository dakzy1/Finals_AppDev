<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\FitnessClass;
use App\Models\Schedule;


class ClassPageControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_shows_dashboard_with_classes_and_schedules()
    {
        $user = User::factory()->create();
        $class = FitnessClass::factory()->create();
        $schedule = Schedule::factory()->create([
            'user_id' => $user->id,
            'class_id' => $class->id,
        ]);

        $this->actingAs($user)
            ->get(route('dashboard'))
            ->assertStatus(200)
            ->assertViewHasAll(['schedules', 'classes']);
    }

    /** @test */
    public function it_shows_upcoming_schedule()
    {
        $user = User::factory()->create();
        $class = FitnessClass::factory()->create();

        Schedule::factory()->create([
            'user_id' => $user->id,
            'class_id' => $class->id,
            'date' => now()->addDay(),
            'time' => '10:00',
        ]);

        $this->actingAs($user)
            ->get('/dashboard')
            ->assertStatus(200)
            ->assertViewHas('upcomingSchedule');
    }

    /** @test */
    public function it_books_a_class_successfully()
    {
        $user = User::factory()->create();
        $class = FitnessClass::factory()->create();

        $this->actingAs($user)
            ->post("/class/{$class->id}/book", [
                'trainer' => 'Coach X',
                'date' => now()->addDays(2)->format('Y-m-d'),
                'time' => '10:00',
            ])
            ->assertRedirect(route('dashboard'));

        $this->assertDatabaseHas('schedules', [
            'user_id' => $user->id,
            'class_id' => $class->id,
            'trainer' => 'Coach X',
        ]);
    }

    /** @test */
    public function it_fails_booking_for_past_dates()
    {
        $user = User::factory()->create();
        $class = FitnessClass::factory()->create();

        $this->actingAs($user)
            ->post("/class/{$class->id}/book", [
                'trainer' => 'Coach X',
                'date' => now()->subDays(1)->format('Y-m-d'), 
                'time' => '10:00',
            ])
            ->assertSessionHasErrors('date'); 
    }


    /** @test */
    public function it_prevents_booking_time_conflict()
    {
        $user = User::factory()->create();
        $class = FitnessClass::factory()->create();

        Schedule::factory()->create([
            'user_id' => $user->id,
            'class_id' => $class->id,
            'date' => now()->addDays(1)->format('Y-m-d'),
            'time' => '10:00',
        ]);

        $this->actingAs($user)
            ->post("/class/{$class->id}/book", [
                'trainer' => 'Coach Z',
                'date' => now()->addDays(1)->format('Y-m-d'),
                'time' => '10:00',
            ])
            ->assertViewIs('bookclass')
            ->assertViewHas('warningMessage');
    }

    /** @test */
    public function it_updates_a_schedule()
    {
        $user = User::factory()->create();
        $schedule = Schedule::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user)
            ->put("/class/{$schedule->id}/book", [
                'date' => now()->addDays(3)->format('Y-m-d'),
                'time' => '12:00',
                'trainer' => 'Updated Coach',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('schedules', [
            'id' => $schedule->id,
            'trainer' => 'Updated Coach',
        ]);
    }

    /** @test */
    public function it_deletes_a_schedule()
    {
        $user = User::factory()->create();
        $schedule = Schedule::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user)
            ->delete("/class/{$schedule->id}/book")
            ->assertRedirect();

        $this->assertDatabaseMissing('schedules', ['id' => $schedule->id]);
    }
}
