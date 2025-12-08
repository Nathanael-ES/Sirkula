<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class DonationController extends Controller
{
    public function index()
    {
        $query = Donation::with(['item','donor']);

        if (Auth::user()->role === 'donatur') {
            $query->where('donor_id', Auth::id());
        }

        if (request('search')) {
            $query->whereHas('item', function ($q) {
                $q->where('name', 'like', '%' . request('search') . '%');
            });
        }

        $donations = $query->paginate(10)->withQueryString();

        return view('donations.index', compact('donations'));
    }


    public function create()
    {
        $items = Item::where('donor_id', Auth::id())
                     ->where('status', 'pending')
                     ->get();

        return view('donations.create', compact('items'));
    }

    public function store()
    {
        request()->validate([
            'item_id' => 'required|exists:items,id'
        ]);

        Donation::create([
            'item_id' => request('item_id'),
            'donor_id' => Auth::id(),
            'submitted_at' => now(),
        ]);

        return redirect()->route('donations.index')
            ->with('success','Donasi berhasil diajukan');
    }

    public function destroy(Donation $donation)
    {
        $donation->delete();
        return back()->with('success','Donasi dihapus');
    }
}
