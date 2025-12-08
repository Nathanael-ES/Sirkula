<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Distribution;
use App\Models\Donation;
use App\Models\Recipient;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $totalItems = Item::count();
        $pending = Item::where('status', 'pending')->count();
        $verified = Item::where('status', 'verified')->count();
        $ready = Item::where('status', 'ready')->count();
        $distributed = Item::where('status', 'distributed')->count();

        $totalRecipients = Recipient::count();
        $totalDistribution = Distribution::count();

        $myItems = 0;
        $myPending = 0;
        $myVerified = 0;
        $myReady = 0;

        if ($user->role === 'donatur') {
            $myItems = Item::where('donor_id', $user->id)->count();
            $myPending = Item::where('donor_id', $user->id)->where('status','pending')->count();
            $myVerified = Item::where('donor_id', $user->id)->where('status','verified')->count();
            $myReady = Item::where('donor_id', $user->id)->where('status','ready')->count();
        }

        return view('dashboard.index', compact(
            'user',
            'totalItems',
            'pending',
            'verified',
            'ready',
            'distributed',
            'totalRecipients',
            'totalDistribution',
            'myItems',
            'myPending',
            'myVerified',
            'myReady'
        ));
    }
}
