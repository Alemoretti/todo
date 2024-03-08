<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Item;

class ItemController extends Controller
{
    /**
     * Display the item's list.
     */
    public function index()
    {
        return Inertia::render('Items/Index', [
            'items' => Item::where('user_id', auth()->id())->get(),
        ]);
    }

    /**
     * Store a newly created item.
     */
    public function store(Request $request)
    {
        $newItem = new Item;
        $newItem->user_id = auth()->id();
        $newItem->name = $request->item["name"];
        $newItem->save();

        return redirect()->back();
    }

    /**
     * Update the specified item.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|max:255',
        ]);

        $item = Item::findOrFail($id);
        $item->name = $request->input('name');
        $item->save();

        return redirect()->route('items.index')->with('success', 'Item updated successfully');
    }

    /**
     * Remove the specified item.
     */
    public function destroy(string $id)
    {
        $item = Item::findOrFail($id);
        $item->delete();
        return redirect()->route('items.index')->with('success', 'Item deleted successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function completeTask(string $id)
    {
        $item = Item::findOrFail($id);
        $item->completed = true;

        return redirect()->route('items.index')->with('success', 'Item deleted successfully');
    }    
}
