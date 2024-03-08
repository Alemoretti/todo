<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class ItemControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_store_an_item()
    {
        $this->withoutExceptionHandling();

        // Create a user
        $user = User::factory()->create();

        // Authenticate as the user
        $this->actingAs($user);

        // Make a POST request to the store route
        $response = $this->post('/items', [
            'item' => [
                'name' => 'Test Item',
            ],
        ]);

        // Assert that the item was stored in the database
        $this->assertDatabaseHas('items', [
            'user_id' => $user->id,
            'name' => 'Test Item',
        ]);

        // Assert that the response was successful
        $response->assertStatus(200);
    }
}