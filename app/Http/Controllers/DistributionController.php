<?php

namespace App\Http\Controllers;

use App\Models\Distribution;
use App\Models\Item;
use App\Models\Recipient;

class DistributionController extends Controller
{
    public function index()
    {
        $query = Distribution::with(['item','recipient']);

        if (request('search')) {
            $query->whereHas('item', function($q) {
                $q->where('name', 'like', '%' . request('search') . '%');
            })->orWhereHas('recipient', function($q) {
                $q->where('name', 'like', '%' . request('search') . '%');
            });
        }

        $distributions = $query->paginate(10)->withQueryString();

        return view('distributions.index', compact('distributions'));
    }


    public function create()
    {
        $items = Item::where('status', 'ready')->get();
        $recipients = Recipient::all();

        return view('distributions.create', compact('items','recipients'));
    }

    public function store()
    {
        request()->validate([
            'item_id' => 'required|exists:items,id',
            'recipient_id' => 'required|exists:recipients,id',
        ]);

        Distribution::create([
            'item_id' => request('item_id'),
            'recipient_id' => request('recipient_id'),
            'volunteer_id' => request()->user()->id,
            'distributed_at' => now(),
        ]);
        
        Item::find(request('item_id'))->update([
            'status' => 'distributed'
        ]);

        return redirect()->route('distributions.index')
            ->with('success','Distribusi berhasil dicatat');
    }

    public function destroy(Distribution $distribution)
    {
        $distribution->delete();
        return back()->with('success','Data distribusi dihapus');
    }
}
