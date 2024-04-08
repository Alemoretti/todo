<?php

use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can delete an item', function () {
    $user = User::factory()->create();
    $item = Item::factory()->create(['user_id' => $user->id]);

    $response = $this->actingAs($user)->delete(route('items.destroy', $item));

    $response->assertRedirect(route('items'));
    $this->assertDatabaseMissing('items', ['id' => $item->id]);
});

it('can complete a task', function () {
    $user = User::factory()->create();
    $item = Item::factory()->create(['user_id' => $user->id, 'completed' => false]);

    $response = $this->actingAs($user)->put(route('items.update', $item));

    $response->assertRedirect();
    $this->assertDatabaseHas('items', ['id' => $item->id, 'completed' => 0]);
});

it('can add an item', function () {
    $user = User::factory()->create();
    $itemData = ['user_id' => $user->id, 'name' => 'Test Item'];

    $response = $this->actingAs($user)->post(route('items.store'), $itemData);

    $response->assertRedirect(route('items'));
    $this->assertDatabaseHas('items', $itemData);
});