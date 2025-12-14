<?php

namespace App\Http\Controllers;

use App\Models\Distribution;
use App\Models\Item;
use App\Models\Recipient;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DistributionController extends Controller
{
    public function index()
    {
        $query = Distribution::with(['item', 'recipient', 'volunteer']);

        if (request('search')) {
            $query->whereHas('item', function($q) {
                $q->where('name', 'like', '%' . request('search') . '%');
            })->orWhereHas('recipient', function($q) {
                $q->where('name', 'like', '%' . request('search') . '%');
            });
        }

        $distributions = $query->latest()->paginate(10)->withQueryString();
        $items = Item::where('status', 'ready')->get(); 
        $recipients = Recipient::all();
        // dd($items); 

        return view('distributions.index', compact('distributions', 'items', 'recipients'));
    }

    public function create()
    {
        abort(404);
    }

    public function store(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'recipient_id' => 'required|exists:recipients,id',
        ]);
        
        Distribution::create([
            'item_id' => $request->item_id,
            'recipient_id' => $request->recipient_id,
            'volunteer_id' => Auth::id(),
            'distributed_at' => now(),
        ]);
        
        $item = Item::findOrFail($request->item_id);
        $item->update(['status' => 'distributed']);

        return redirect()->route('distributions.index')
            ->with('success', 'Distribusi berhasil dicatat.');
    }

    public function destroy(Distribution $distribution)
    {
        $item = Item::find($distribution->item_id);
        
        if ($item) {
            $item->update(['status' => 'ready']);
        }
        $distribution->delete();

        return back()->with('success', 'Data distribusi dihapus dan stok barang dikembalikan ke Ready.');
    }
}