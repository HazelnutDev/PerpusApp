<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use Illuminate\Http\Request;
use App\Helpers\KodeGenerator;

class AnggotaController extends Controller
{
    protected function generateNoAnggota (){
        return KodeGenerator::generate(Anggota::class, 'NoAnggotaM', 'M', 3);
    }
    public function index()
    {
        $anggota = Anggota::latest()->paginate(10);
        return view('anggota.index', compact('anggota'));
    }

    public function create()
    {
        $noAnggota = $this->generateNoAnggota();
        return view('anggota.create', compact("noAnggota"));
    }

    public function store(Request $request)
    {   
        // dd($request->all());
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
        $NoAnggota = $this->generateNoAnggota();
        $request->merge(['NoAnggotaM' => $NoAnggota]);

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

    public function update(Request $request, $id)
    {
        $anggota = Anggota::findOrFail($id);
        $request->validate([
            'NIS' => 'required|string|max:255|unique:anggota,NIS,' . $anggota->NoAnggotaM . ',NoAnggotaM',
            'NamaAnggota' => 'required|string|max:255',
            'TanggalLahir' => 'required|date',
            'JenisKelamin' => 'required|in:L,P',
            'NoTelp' => 'required|string|max:15',
            'Alamat' => 'required|string',
            'Kelas' => 'required|string|max:10',
            'NamaOrtu' => 'required|string|max:10',
            'NoTelpOrtu' => 'required|string|max:10',
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
