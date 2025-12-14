<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Category;
use App\Models\Recipient;
use App\Models\Distribution;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $totalItems = Item::count();
        $pending    = Item::where('status', 'pending')->count();
        $verified   = Item::where('status', 'verified')->count();
        $ready      = Item::where('status', 'ready')->count();

        $totalDistribution = Distribution::count();
        $totalRecipients   = Recipient::count();

        $recentReady = Item::where('status', 'ready')
                            ->whereDate('updated_at', $today)
                            ->count();

        $recentDist = Distribution::whereDate('created_at', $today)->count();

        $recentRecipients = Recipient::whereDate('created_at', $today)->count();

        $categories = Category::orderBy('name')->get();
        $recipients = Recipient::orderBy('name')->get();

        return view('dashboard.index', compact(
            'totalItems',
            'pending',
            'verified',
            'ready',
            'totalDistribution',
            'totalRecipients',
            'categories',
            'recipients',
            'recentReady',
            'recentDist',
            'recentRecipients'
        ));
    }
}