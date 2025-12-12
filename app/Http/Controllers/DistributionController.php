<?php

namespace App\Http\Controllers;

use App\Models\Distribution;
use App\Models\Item;
use App\Models\Recipient;
use Illuminate\Http\Request;

class DistributionController extends Controller
{
    public function index()
    {
        // 1. Logic Pencarian (Search)
        $query = Distribution::with(['item', 'recipient', 'volunteer']);

        if (request('search')) {
            $query->whereHas('item', function($q) {
                $q->where('name', 'like', '%' . request('search') . '%');
            })->orWhereHas('recipient', function($q) {
                $q->where('name', 'like', '%' . request('search') . '%');
            });
        }

        $distributions = $query->latest()->paginate(10)->withQueryString();

        // 2. DATA UNTUK MODAL CREATE
        // Mengambil item yang statusnya 'ready' saja
        $items = Item::where('status', 'ready')->get(); 
        $recipients = Recipient::all();

        // 3. Debugging (Opsional: Hapus tanda // di bawah untuk cek apakah data ada)
        // dd($items); 

        return view('distributions.index', compact('distributions', 'items', 'recipients'));
    }

    public function create()
    {
        abort(404);
    }

    public function store(Request $request)
    {
        // Validasi
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'recipient_id' => 'required|exists:recipients,id',
        ]);

        // Simpan Data
        Distribution::create([
            'item_id' => $request->item_id,
            'recipient_id' => $request->recipient_id,
            'volunteer_id' => auth()->id(),
            'distributed_at' => now(),
        ]);
        
        // Update Status Barang jadi 'distributed'
        $item = Item::findOrFail($request->item_id);
        $item->update(['status' => 'distributed']);

        return redirect()->route('distributions.index')
            ->with('success', 'Distribusi berhasil dicatat.');
    }

    public function destroy(Distribution $distribution)
    {
        // LOGIC PENGEMBALIAN STATUS BARANG (RESTORE STOCK)
        // Sebelum menghapus data distribusi, kita kembalikan status barangnya
        
        $item = Item::find($distribution->item_id);
        
        if ($item) {
            $item->update(['status' => 'ready']);
        }
        
        // Baru hapus data distribusinya
        $distribution->delete();

        return back()->with('success', 'Data distribusi dihapus dan stok barang dikembalikan ke Ready.');
    }
}