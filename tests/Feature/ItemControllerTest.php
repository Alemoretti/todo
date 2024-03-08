<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ItemControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_view_all_items()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/items');

        $response->assertStatus(200);
    }

    /** @test */
    public function a_user_can_store_an_item()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post('/items', [
            'name' => 'Test Item',
        ]);

        $this->assertDatabaseHas('items', [
            'user_id' => $user->id,
            'name' => 'Test Item',
        ]);

        $response->assertStatus(200);
    }

    /** @test */
    public function a_user_can_update_an_item()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $item = Item::factory()->create(['user_id' => $user->id]);

        $response = $this->put("/items/{$item->id}", [
            'name' => 'Updated Item',
        ]);

        $this->assertDatabaseHas('items', [
            'user_id' => $user->id,
            'name' => 'Updated Item',
        ]);

        $response->assertStatus(200);
    }

    /** @test */
    public function a_user_can_delete_an_item()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $item = Item::factory()->create(['user_id' => $user->id]);

        $response = $this->delete("/items/{$item->id}");

        $this->assertDatabaseMissing('items', [
            'id' => $item->id,
        ]);

        $response->assertStatus(200);
    }
}