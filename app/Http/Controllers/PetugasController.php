<?php

namespace App\Http\Controllers;

use App\Models\Petugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class PetugasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $petugas = Petugas::latest()->paginate(10);
        return view('petugas.index', compact('petugas'));
    }

     public function index1()
    {
        $petugas = Petugas::find(Auth::id());
        return view('petugas.profile', compact('petugas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('petugas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            // Validasi untuk menyimpan petugas
            'Nama' => 'required',
            'Username' => 'required',
            'Password' => 'required',
            'Role' => 'required',
        ]);
        $data = $request->all();
        $data['Password'] = Hash::make($request->Password);
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('petugas', 'public');
            $data['foto'] = $fotoPath;
        }
        Petugas::create($data);
        return redirect()->route('petugas.index')->with('success', 'Data berhasil ditambahkan');    
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $petugas = Petugas::findOrFail($id);
        return view('petugas.show', compact('petugas'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $petugas = Petugas::findOrFail($id);
        return view('petugas.edit', compact('petugas'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $petugas = Petugas::find(Auth::id());
        $request->validate([
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'Nama' => 'required|string|max:255',
            'username' => "required|string|max:255|unique:petugas,Username,{$petugas->KodePetugas},KodePetugas",
            'Role' => 'required|string',
            'Password' => 'required', // password lama untuk konfirmasi
            'password' => 'nullable|string|min:4|confirmed', // password baru opsional
        ], [
            'Nama.required' => 'Nama wajib diisi',
            'username.required' => 'Username wajib diisi',
            'username.unique' => 'Username sudah digunakan',
            'Role.required' => 'Role wajib diisi',
            'Password.required' => 'Password lama wajib diisi',
            'password.min' => 'Password minimal 4 karakter',
            'password.confirmed' => 'Konfirmasi password tidak sesuai',
        ]);

        // Cek password lama
        if (!Hash::check($request->Password, $petugas->Password)) {
            return back()->withErrors(['Password' => 'Password lama salah']);
        }

        $petugas->Nama = $request->Nama;
        $petugas->Username = $request->username;
        $petugas->Role = $request->Role;
        if ($request->filled('password')) {
            $petugas->Password = Hash::make($request->password);
        }
        if ($request->hasFile('foto')) {
            if ($petugas->foto && Storage::disk('public')->exists($petugas->foto)) {
                Storage::disk('public')->delete($petugas->foto);
            }
            $fotoPath = $request->file('foto')->store('petugas', 'public');
            $petugas->foto = $fotoPath;
        }
        $petugas->save();

        return redirect()->route('petugas.profil')->with('success', 'Profile berhasil diperbarui!');
    }

    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $petugas = Petugas::findOrFail($id);
        $petugas->delete();
        return redirect()->route('petugas.index')->with('success', 'Data berhasil dihapus');
    }

    /**
     * Cari petugas berdasarkan username (untuk reset password, dsb)
     */
    public function findByUsername(Request $request)
    {
        $request->validate([
            'username' => 'required',
        ]);
        $user = Petugas::where('Username', $request->username)->first();
        if ($user) {
            // Contoh: return data user, atau redirect/kirim link reset password
            return response()->json($user);
        } else {
            return response()->json(['error' => 'Username tidak ditemukan'], 404);
        }
    }
    
}
