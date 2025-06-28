<?php

namespace App\Http\Controllers;

use App\Models\Rak;
use Illuminate\Http\Request;

class RakController extends Controller
{
    public function index()
    {
        $rak = Rak::latest()->paginate(10);
        return view('rak.index', compact('rak'));
    }

    public function create()
    {
        return view('rak.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor' => 'required|string|max:50|unique:raks',
            'lokasi' => 'required|string|max:255',
            'kapasitas' => 'required|integer|min:1',
            'keterangan' => 'nullable|string'
        ]);

        Rak::create($request->all());

        return redirect()->route('rak.index')
            ->with('success', 'Rak berhasil ditambahkan');
    }

    public function show(Rak $rak)
    {
        return view('rak.show', compact('rak'));
    }

    public function edit(Rak $rak)
    {
        return view('rak.edit', compact('rak'));
    }

    public function update(Request $request, Rak $rak)
    {
        $request->validate([
            'nomor' => 'required|string|max:50|unique:raks,nomor,' . $rak->id,
            'lokasi' => 'required|string|max:255',
            'kapasitas' => 'required|integer|min:1',
            'keterangan' => 'nullable|string'
        ]);

        $rak->update($request->all());

        return redirect()->route('rak.index')
            ->with('success', 'Rak berhasil diperbarui');
    }

    public function destroy(Rak $rak)
    {
        // Check if rak has books
        if ($rak->bukus()->count() > 0) {
            return redirect()->route('rak.index')
                ->with('error', 'Rak tidak dapat dihapus karena masih memiliki buku');
        }

        $rak->delete();

        return redirect()->route('rak.index')
            ->with('success', 'Rak berhasil dihapus');
    }
}
