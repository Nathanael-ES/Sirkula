<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class DonationController extends Controller
{
    public function index()
    {
        $query = Donation::with(['item.category', 'donor']);

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

    public function destroy(Donation $donation)
    {
        if (!in_array(Auth::user()->role, ['admin', 'relawan'])) {
            abort(403);
        }

        $donation->delete();

        return back()->with('success', 'Donasi berhasil dihapus');
    }
}
