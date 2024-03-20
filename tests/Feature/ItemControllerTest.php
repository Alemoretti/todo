<?php

use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can delete an item', function () {
    $user = User::factory()->create();
    $item = Item::factory()->create(['user_id' => $user->id]);

    $response = $this->actingAs($user)->delete(route('items.destroy', $item));

    $response->assertRedirect(route('items.index'));
    $this->assertDatabaseMissing('items', ['id' => $item->id]);
});

it('can complete a task', function () {
    $user = User::factory()->create();
    $item = Item::factory()->create(['user_id' => $user->id, 'completed' => false]);

    $response = $this->actingAs($user)->patch(route('items.completeTask', $item));

    $response->assertRedirect(route('items.index'));
    $this->assertDatabaseHas('items', ['id' => $item->id, 'completed' => true]);
});