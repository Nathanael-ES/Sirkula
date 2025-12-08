<?php

namespace App\Http\Controllers;

use App\Http\Requests\RecipientRequest;
use App\Models\Recipient;

class RecipientController extends Controller
{
    public function index()
    {
        $query = Recipient::query();

        if (request('search')) {
            $query->where('name', 'like', '%' . request('search') . '%')
                ->orWhere('phone', 'like', '%' . request('search') . '%');
        }

        $recipients = $query->paginate(10)->withQueryString();

        return view('recipients.index', compact('recipients'));
    }


    public function create()
    {
        return view('recipients.create');
    }

    public function store(RecipientRequest $request)
    {
        Recipient::create($request->validated());
        return redirect()->route('recipients.index')
            ->with('success', 'Penerima berhasil ditambahkan');
    }

    public function edit(Recipient $recipient)
    {
        return view('recipients.edit', compact('recipient'));
    }

    public function update(RecipientRequest $request, Recipient $recipient)
    {
        $recipient->update($request->validated());
        return redirect()->route('recipients.index')
            ->with('success', 'Penerima berhasil diperbarui');
    }

    public function destroy(Recipient $recipient)
    {
        $recipient->delete();
        return redirect()->route('recipients.index')
            ->with('success', 'Penerima berhasil dihapus');
    }
}
