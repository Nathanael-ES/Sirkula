<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Category;
use App\Models\Recipient;
use App\Models\Distribution;
use Carbon\Carbon; // <--- 1. PENTING: Import Carbon untuk urusan tanggal

class DashboardController extends Controller
{
    public function index()
    {
        // --- A. Setup Tanggal Hari Ini ---
        $today = Carbon::today();

        // --- B. Statistik Utama (Angka Besar) ---
        $totalItems = Item::count();
        $pending    = Item::where('status', 'pending')->count();
        $verified   = Item::where('status', 'verified')->count();
        $ready      = Item::where('status', 'ready')->count();

        $totalDistribution = Distribution::count();
        $totalRecipients   = Recipient::count();

        // --- C. Statistik Harian (Untuk Fitur Titik Ijo) ---
        
        // 1. Barang yang berubah status menjadi 'ready' HARI INI
        // Kita pakai updated_at karena asumsinya barang masuk dulu, baru diubah statusnya
        $recentReady = Item::where('status', 'ready')
                            ->whereDate('updated_at', $today)
                            ->count();

        // 2. Distribusi yang dibuat HARI INI
        $recentDist = Distribution::whereDate('created_at', $today)->count();

        // 3. Penerima baru yang didaftarkan HARI INI
        $recentRecipients = Recipient::whereDate('created_at', $today)->count();


        // --- D. Data untuk tabel ---
        $categories = Category::orderBy('name')->get();
        $recipients = Recipient::orderBy('name')->get();

        // --- E. Kirim ke View ---
        return view('dashboard.index', compact(
            'totalItems',
            'pending',
            'verified',
            'ready',
            'totalDistribution',
            'totalRecipients',
            'categories',
            'recipients',
            // Variabel baru untuk titik ijo:
            'recentReady',
            'recentDist',
            'recentRecipients'
        ));
    }
}