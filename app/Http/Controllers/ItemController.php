<?php

namespace App\Http\Controllers;

use App\Http\Requests\ItemRequest;
use App\Models\Category;
use App\Models\Item;
use App\Models\Donation;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    public function index()
    {
        $query = Item::with('category');

        if (Auth::user()->role === 'donatur') {
            $query->where('donor_id', Auth::id());
        }

        if (request('search')) {
            $query->where('name', 'like', '%' . request('search') . '%');
        }

        if (request('category')) {
            $query->where('category_id', request('category'));
        }

        if (request('status')) {
            $query->where('status', request('status'));
        }

        $items = $query->paginate(10)->withQueryString();
        $categories = Category::all();

        return view('items.index', compact('items', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('items.create', compact('categories'));
    }

    public function store(ItemRequest $request)
    {
        $data = $request->validated();
        $data['donor_id'] = Auth::id();

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('items', 'public');
        }

        $item = Item::create($data);

        Donation::create([
            'item_id' => $item->id,
            'donor_id' => Auth::id(),
            'submitted_at' => now(),
        ]);

        return redirect()->route('items.index')
            ->with('success', __('messages.item_created'));
    }


    public function edit(Item $item)
    {
        if (Auth::user()->role !== 'admin' && $item->donor_id !== Auth::id()) {
            abort(403);
        }

        $categories = Category::all();
        return view('items.edit', compact('item', 'categories'));
    }

    public function update(ItemRequest $request, Item $item)
    {
        $data = $request->validated();

        if ($request->has('status')) {
            $data['status'] = $request->status;
        }

        if ($request->hasFile('photo')) {
            if ($item->photo)
                Storage::disk('public')->delete($item->photo);
            $data['photo'] = $request->file('photo')->store('items', 'public');
        }

        $item->update($data);

        return redirect()->route('items.index')
            ->with('success', __('messages.item_updated'));
    }

    public function destroy(Item $item)
    {
        if ($item->photo)
            Storage::disk('public')->delete($item->photo);
        $item->delete();

        return redirect()->route('items.index')
            ->with('success', 'Barang berhasil dihapus');
    }

    public function updateStatus(Item $item, $status)
    {
        if (!in_array($status, ['pending', 'verified', 'ready'])) {
            abort(400);
        }

        $item->update(['status' => $status]);

        return back()->with('success', 'Status barang diperbarui');
    }


}
