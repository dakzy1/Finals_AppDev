<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class ProfileControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_updates_the_user_profile()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->put(route('profile.update'), [
            'first_name' => 'UpdatedName',
            'email' => 'updated@example.com',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Profile updated successfully!');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'first_name' => 'UpdatedName',
            'email' => 'updated@example.com',
        ]);
    }

    /** @test */
    public function it_does_not_allow_duplicate_email_on_profile_update()
    {
        $user1 = User::factory()->create(['email' => 'existing@example.com']);
        $user2 = User::factory()->create();

        $this->actingAs($user2);

        $response = $this->from('/profile')->put(route('profile.update'), [
            'first_name' => 'AnyName',
            'email' => 'existing@example.com',
        ]);

        $response->assertRedirect('/profile');
        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function it_deletes_the_user_account()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->delete(route('profile.destroy'));

        $response->assertRedirect('/');
        $response->assertSessionHas('success', 'Your account has been deleted.');

        $this->assertGuest();
        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
        ]);
    }
}
