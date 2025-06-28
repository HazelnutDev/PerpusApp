<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Buku;
use Illuminate\Http\Request;

class AnggotaController extends Controller
{
    public function index()
    {
        $anggota = Anggota::latest()->paginate(10);
        return view('anggota.index', compact('anggota'));
    }

    public function create()
    {
        return view('anggota.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'NIS' => 'required|string|max:255|unique:anggota',
            'NamaAnggota' => 'required|string|max:255',
            'TanggalLahir' => 'required|date',
            'JenisKelamin' => 'required|in:L,P',
            'NoTelp' => 'nullable|string|max:15',
            'Alamat' => 'required|string',
            'Kelas' => 'required|string|max:10',
            'NamaOrtu' => 'required|string|max:10',
            'NoTelpOrtu' => 'required|string|max:10',

        ]);
        $lastAnggota = Anggota::orderBy('NoAnggotaM', 'desc')->first();

        if ($lastAnggota) {
            $lastAnggota = intval(substr($lastAnggota->NoAnggota, 1));
            $newAnggota = $lastAnggota + 1;
        } else {
            $newAnggota = 1;
        }
        

        $noAnggota = 'M' . str_pad($newAnggota, 1, '0', STR_PAD_LEFT);
        $request->merge(['NoAnggotaM' => $noAnggota]);

        Anggota::create($request->all());
        return redirect()->route('anggota.index')->with('success', 'Anggota berhasil ditambahkan');
    }

    public function show($id)
    {
    $anggota = Anggota::findOrFail($id);
    return view('anggota.show', compact('anggota'));
    }

    public function edit($id)
    {
        $anggota = Anggota::findOrFail($id);
        return view('anggota.edit', compact('anggota'));
    }

    public function update(Request $request, Anggota $anggota)
    {
        $request->validate([
            'NIS' => 'required|string|max:255|unique:anggota,NIS,' . $anggota->id,
            'Nama' => 'required|string|max:255',
            'JenisKelamin' => 'required|in:L,P',
            'NoTelp' => 'required|string|max:15',
            'Alamat' => 'required|string',
            'Kelas' => 'required|string|max:10',
        ]);

        $anggota->update($request->all());
        return redirect()->route('anggota.index')->with('success', 'Anggota berhasil diperbarui');
    }

    public function destroy($id)
    {
        $anggota = Anggota::findOrFail($id);
        $anggota->delete();
        return redirect()->route('anggota.index')->with('success', 'Anggota berhasil dihapus');
    }
}
