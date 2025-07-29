<?php

namespace App\Http\Controllers;

use App\Models\Petugas;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Helpers\KodeGenerator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class PetugasController extends Controller
{
    /**
     * Generate unique KodePetugas.
     */
    protected function generateKodePetugas()
    {
        return KodeGenerator::generate(Petugas::class, 'KodePetugas', 'PTG', 2);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $petugas = Petugas::latest()->paginate(10);
        return view('petugas.index', compact('petugas'));
    }

    /**
     * Display the profile of the authenticated user.
     */
    public function profile()
    {
        $petugas = Petugas::findOrFail(Auth::id());
        return view('petugas.profile', compact('petugas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kodePetugas = $this->generateKodePetugas();
        return view('petugas.create', compact('kodePetugas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'Nama' => 'required|string|max:255',
            'Username' => 'required|string|max:255|unique:petugas,Username',
            'Password' => 'required|string|min:4',
            'Role' => 'required|in:admin,petugas',
        ], [
            'foto.image' => 'File harus berupa gambar.',
            'foto.mimes' => 'Format file harus JPEG, PNG, atau JPG.',
            'foto.max' => 'Ukuran file maksimal 2MB.',
            'Nama.required' => 'Nama wajib diisi.',
            'Username.required' => 'Username wajib diisi.',
            'Username.unique' => 'Username sudah digunakan.',
            'Password.required' => 'Password wajib diisi.',
            'Password.min' => 'Password minimal 4 karakter.',
            'Role.required' => 'Role wajib diisi.',
            'Role.in' => 'Role tidak valid.',
        ]);

        $data = $request->all();
        $data['KodePetugas'] = $this->generateKodePetugas();
        $data['Password'] = Hash::make($request->Password);
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('petugas', 'public');
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
     * Update the specified resource in storage (for Admin).
     */
    public function update(Request $request, $id)
    {
        $petugas = Petugas::findOrFail($id);

        $request->validate([
            'Nama' => 'required|string|max:255',
            'Username' => 'required|string|max:255|unique:petugas,Username,' . $id . ',KodePetugas',
            'Role' => 'required|in:admin,petugas',
            'password' => 'nullable|string|min:4|confirmed',
        ], [
            'Nama.required' => 'Nama wajib diisi.',
            'Username.required' => 'Username wajib diisi.',
            'Username.unique' => 'Username sudah digunakan.',
            'Role.required' => 'Role wajib diisi.',
            'Role.in' => 'Role tidak valid.',
            'password.min' => 'Password minimal 4 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak sesuai.',
        ]);

        $petugas->update([
            'Nama' => $request->Nama,
            'Username' => $request->Username,
            'Role' => $request->Role,
            'Password' => $request->filled('password') ? Hash::make($request->password) : $petugas->Password,
        ]);

        return redirect()->route('petugas.index')->with('success', 'Petugas berhasil diperbarui.');
    }

    /**
     * Update the authenticated user's profile.
     */
    public function updateProfile(Request $request)
    {
        try {
            // Debug log request
            Log::info('Update profile request:', [
                'has_file' => $request->hasFile('foto'),
                'file_valid' => $request->hasFile('foto') ? $request->file('foto')->isValid() : false,
                'all_params' => $request->except(['foto', 'password', 'password_confirmation', 'current_password'])
            ]);

            $petugas = Petugas::findOrFail(Auth::id());

            // Jika ada file foto yang diupload
            if ($request->hasFile('foto') && $request->file('foto')->isValid()) {
                // Validasi file
                $validated = $request->validate([
                    'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                ]);

                // Pastikan folder penyimpanan ada
                $storagePath = storage_path('app/public/petugas');
                if (!file_exists($storagePath)) {
                    mkdir($storagePath, 0755, true);
                }

                // Hapus foto lama jika ada
                if ($petugas->foto && Storage::disk('public')->exists($petugas->foto)) {
                    Storage::disk('public')->delete($petugas->foto);
                }

                try {
                    // Upload foto baru
                    $file = $request->file('foto');
                    $filename = 'profile_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs('petugas', $filename, 'public');

                    // Update path foto di database (hanya path relatif)
                    $relativePath = 'petugas/' . $filename;
                    $petugas->foto = $relativePath;
                    $petugas->save();

                    // Siapkan URL foto untuk respons
                    $fotoUrl = asset('storage/' . $relativePath);

                    Log::info('Foto profil berhasil diupload', [
                        'path' => $relativePath,
                        'url' => $fotoUrl,
                        'full_path' => storage_path('app/public/' . $relativePath)
                    ]);

                    if ($request->ajax() || $request->wantsJson()) {
                        return response()->json([
                            'success' => true,
                            'message' => 'Foto profil berhasil diupdate!',
                            'foto_url' => $fotoUrl
                        ]);
                    }

                    return redirect()->route('petugas.profil')->with([
                        'success' => 'Foto profil berhasil diupdate!',
                        'foto_url' => $fotoUrl
                    ]);
                } catch (\Exception $e) {
                    Log::error('Error uploading profile photo:', [
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);
                    
                    if ($request->ajax() || $request->wantsJson()) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Gagal mengupload foto: ' . $e->getMessage()
                        ], 500);
                    }
                    return back()->withErrors(['foto' => 'Gagal mengupload foto: ' . $e->getMessage()]);
                }
            }

            // Validasi untuk update data profil
            $request->validate([
                'Nama' => 'required|string|max:255',
                'username' => 'required|string|max:255|unique:petugas,Username,' . $petugas->KodePetugas . ',KodePetugas',
                'current_password' => 'required|string',
                'password' => 'nullable|string|min:4|confirmed',
            ]);

            try {
                // Verifikasi password lama
                if (!Hash::check($request->current_password, $petugas->Password)) {
                    if ($request->ajax() || $request->wantsJson()) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Password lama salah.'
                        ], 422);
                    }
                    return back()->withErrors(['current_password' => 'Password lama salah.']);
                }

                // Update data profil
                $petugas->Nama = $request->Nama;
                $petugas->Username = $request->username;

                // Update password jika diisi
                if ($request->filled('password')) {
                    $petugas->Password = Hash::make($request->password);
                }

                $petugas->save();

                Log::info('Profil berhasil diupdate', [
                    'user_id' => $petugas->KodePetugas,
                    'changes' => $petugas->getChanges()
                ]);

                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Profil berhasil diperbarui!',
                        'foto_url' => $petugas->foto ? asset('storage/' . $petugas->foto) : asset('image/profile.png')
                    ]);
                }

                return redirect()->route('petugas.profil')->with('success', 'Profil berhasil diperbarui!');

            } catch (\Exception $e) {
                Log::error('Error updating profile data:', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Gagal memperbarui profil: ' . $e->getMessage()
                    ], 500);
                }
                return back()->withErrors(['error' => 'Gagal memperbarui profil: ' . $e->getMessage()]);
            }

        } catch (\Exception $e) {
            // Log error
            Log::error('Error in updateProfile:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            $errorMessage = 'Terjadi kesalahan: ' . $e->getMessage();

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $errorMessage
                ], 500);
            }

            return back()->withErrors(['error' => $errorMessage]);
        }
    }

    /**
     * Remove the authenticated user's account or another account (for Admin).
     */
    public function deleteAccount(Request $request, string $id)
    {
        $petugas = Petugas::findOrFail($id);

        $request->validate([
            'confirm_delete' => 'required',
        ], [
            'confirm_delete.required' => 'Anda harus mencentang kotak konfirmasi untuk menghapus akun.',
        ]);

        // Hanya izinkan Admin menghapus akun lain, atau pengguna menghapus akun sendiri
        if (Auth::user()->Role !== 'admin' && Auth::id() !== $petugas->id) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki izin untuk menghapus akun ini.');
        }

        // Cegah penghapusan akun Admin terakhir
        if ($petugas->Role === 'admin') {
            $adminCount = Petugas::where('Role', 'admin')->count();
            if ($adminCount <= 1) {
                return back()->with('error', 'Tidak dapat menghapus akun Admin terakhir.');
            }
        }

        // Hapus foto jika ada
        if ($petugas->foto && Storage::disk('public')->exists($petugas->foto)) {
            Storage::disk('public')->delete($petugas->foto);
        }

        $petugas->delete();

        // Jika pengguna menghapus akun mereka sendiri, logout
        if (Auth::id() === $petugas->id) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login')->with('success', 'Akun Anda telah dihapus.');
        }

        return redirect()->route('petugas.index')->with('success', 'Akun berhasil dihapus.');
    }

    public function destroy(string $id){
        $petugas = Petugas::findOrFail($id);
        $petugas->delete();
        return redirect()->route('petugas.index')->with('Succes', 'Data Petugas Berhasil Dihapus');
    }

    /**
     * Find petugas by username (for reset password, etc.).
     */
    public function findByUsername(Request $request)
    {
        $request->validate([
            'username' => 'required',
        ]);
        $user = Petugas::where('Username', $request->username)->first();
        if ($user) {
            return response()->json($user);
        } else {
            return response()->json(['error' => 'Username tidak ditemukan'], 404);
        }
    }
}
