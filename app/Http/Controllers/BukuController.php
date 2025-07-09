<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function index()
    {
        $buku = Buku::latest()->paginate(10);
        return view('buku.index', compact('buku'));
    }

    public function create()
    {
        $lastBook = Buku::orderBy('KodeBuku', 'desc')->first();
        $newNumber = $lastBook ? intval(substr($lastBook->KodeBuku, 1)) + 1 : 1;
        $kodeBuku = 'B' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);

        return view('buku.create', compact('kodeBuku'));
        // return view('buku.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'Judul' => 'required|string|max:255',
            'NoUDC' => 'required|string|max:10',
            'Penerbit' => 'required|string|max:255',
            'Pengarang' => 'required|string|max:255',
            'TahunTerbit' => 'required|digits:4|integer',
            'Deskripsi' => 'required|string|max:300',
            'ISBN' => 'required|string|unique:buku,ISBN',
            'Stok' => 'required|integer|min:0',
        ]);

        $lastBook = Buku::orderBy('KodeBuku', 'desc') ->first();

        if ($lastBook) {
        $lastNumber = intval(substr($lastBook->KodeBuku, 1));
        $newNumber = $lastNumber + 1;
        } else {
        $newNumber = 1; 
        }

        $kodeBuku = 'B' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
        $request->merge(['KodeBuku' => $kodeBuku]);

        Buku::create($request->all());
        return redirect()->route('buku.index')->with('success', 'Buku berhasil ditambahkan');
    }

    public function show(Buku $buku)
    {
        return view('buku.show', compact('buku'));
    }

    public function edit(Buku $buku)
    {
        return view('buku.edit', compact('buku'));
    }

    public function update(Request $request, Buku $buku)
    {
        $request->validate([
            'Judul' => 'required|string|max:255',
            'NoUDC' => 'required|string|max:10',
            'Penerbit' => 'required|string|max:255',
            'Pengarang' => 'required|string|max:255',
            'TahunTerbit' => 'required|digits:4|integer',
            'Deskripsi' => 'nullable|string',
            'ISBN' => 'nullable|string|unique:buku,ISBN,' . $buku->KodeBuku . ',KodeBuku',
            'Stok' => 'required|integer|min:0',
        ]);
        
        $buku->update($request->all());
        return redirect()->route('buku.index')->with('success', 'Buku berhasil diperbarui');
    }

    public function destroy(Buku $buku)
    {
        $buku->delete();
        return redirect()->route('buku.index')->with('success', 'Buku berhasil dihapus');
    }
}
