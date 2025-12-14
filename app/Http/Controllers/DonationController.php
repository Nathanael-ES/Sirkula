<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use Illuminate\Http\Request;
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

        $donations = $query->latest()->paginate(10)->withQueryString();

        return view('donations.index', compact('donations'));
    }

    public function destroy(Donation $donation)
    {
        if (Auth::user()->role === 'donatur' && Auth::id() !== $donation->donor_id) {
            abort(403);
        }

        if (!in_array(Auth::user()->role, ['admin', 'relawan', 'donatur'])) {
            abort(403);
        }

        if ($donation->item) {
            $donation->item->delete();
        }
        
        $donation->delete();

        return back()->with('success', __('messages.donation_deleted'));
    }
}