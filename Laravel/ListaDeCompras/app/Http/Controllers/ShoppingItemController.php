<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShoppingItem;

class ShoppingItemController extends Controller
{
    public function index()
    {
        $items = ShoppingItem::all();
        return view('shopping.index', compact('items'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        ShoppingItem::create([
            'name' => $request->name,
            'bought' => false,
        ]);

        return redirect()->route('shopping.index')->with('success', 'Item adicionado com sucesso!');
    }

    public function markAsBought($id)
    {
        $item = ShoppingItem::findOrFail($id);
        $item->bought = true;
        $item->save();

        return redirect()->route('shopping.index')->with('success', 'Item marcado como comprado!');
    }

    public function destroy($id)
    {
        $item = ShoppingItem::findOrFail($id);
        $item->delete();

        return redirect()->route('shopping.index')->with('success', 'Item removido com sucesso!');
    }
}
