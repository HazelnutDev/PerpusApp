<?php

namespace App\Http\Controllers\Auth;

use App\Models\Petugas;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if ($request->isMethod('get')) {
            if (Auth::guard('petugas')->check()) {
                return redirect()->route('dashboard');
            }
            return view('Auth.login');
        }

        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string'
        ], [
            'username.required' => 'Username wajib diisi',
            'password.required' => 'Password wajib diisi'
        ]);

        // Cari user berdasarkan username
        $user = Petugas::where('Username', $credentials['username'])->first();

        if (!$user) {
            return back()->withErrors([
                'login_error' => 'Username atau password salah',
            ])->withInput($request->only('username'));
        }

        // Verifikasi password
        if (!Hash::check($credentials['password'], $user->Password)) {
            return back()->withErrors([
                'login_error' => 'Username atau password salah',
            ])->withInput($request->only('username'));
        }

        // Login dengan guard petugas
        $remember = $request->has('remember-me');

        if (Auth::guard('petugas')->attempt(
            ['Username' => $credentials['username'], 'password' => $credentials['password']],
            $remember
        )) {
            $request->session()->regenerate();

            // Tambahkan log untuk debugging
            Log::info('Login berhasil', [
                'user_id' => $user->KodePetugas,
                'username' => $user->Username,
                'role' => $user->Role
            ]);

            return redirect()->intended(route('dashboard'));
        }

        // Jika sampai di sini berarti ada kesalahan
        return back()->withErrors([
            'login_error' => 'Terjadi kesalahan saat login. Silakan coba lagi.',
        ])->withInput($request->only('username'));
    }

    public function logout(Request $request)
    {
        Auth::guard('petugas')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    public function register(Request $request)
    {
        if ($request->isMethod('get')) {
            return view('Auth.register');
        }

        $validator = Validator::make($request->all(), [
            'KodePetugas' => 'required|unique:petugas,KodePetugas',
            'Nama' => 'required',
            'Username' => 'required|unique:petugas,Username',
            'Password' => 'required|min:6',
            'Role' => 'required|in:Admin,Petugas',
        ],[
            'KodePetugas.required' => 'Kode Petugas wajib diisi',
            'KodePetugas.unique' => 'Kode Petugas sudah digunakan',
            'Nama.required' => 'Nama wajib diisi',
            'Username.required' => 'Username wajib diisi',
            'Username.unique' => 'Username sudah digunakan',
            'Password.required' => 'Password wajib diisi',
            'Password.min' => 'Password minimal 6 karakter',
            'Role.required' => 'Role wajib diisi',
            'Role.in' => 'Role tidak valid',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $petugas = Petugas::create([
            'KodePetugas' => $request->KodePetugas,
            'Nama' => $request->Nama,
            'Username' => $request->Username,
            'Password' => Hash::make($request->Password),
            'Role' => $request->Role,
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silahkan login.');
    }

    public function changePassword(Request $request)
    {
        if ($request->isMethod('get')) {
            return view('Auth.change-password');
        }

        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'password' => 'required|min:6|confirmed',
        ], [
            'current_password.required' => 'Password saat ini wajib diisi',
            'password.required' => 'Password baru wajib diisi',
            'password.min' => 'Password minimal 6 karakter',
            'password.confirmed' => 'Konfirmasi password tidak sesuai',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        if (!Hash::check($request->current_password, Auth::user()->Password)) {
            return back()->withErrors(['current_password' => 'Password saat ini salah']);
        }

        $user = Auth::user();
        DB::table('petugas')
            ->where('KodePetugas', $user->KodePetugas)
            ->update(['Password' => Hash::make($request->password)]);

        return redirect()->route('dashboard')->with('success', 'Password berhasil diubah!');
    }

    public function forgotPassword(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'username' => 'required',
            ]);
            $user = Petugas::where('Username', $request->username)->first();
            if ($user && $user->Username) {
                $resetLink = route('resetPassword', ['username' => $user->Username]);
                // Cek apakah user punya email
                if ($user->Email) {
                    Mail::to($user->Email)->send(new ResetPasswordMail($resetLink));
                    return back()->with('success', 'Link reset password sudah dikirim ke email Anda.');
                } else {
                    // Jika tidak ada email, tampilkan link di halaman
                    return back()->with('success', 'Email tidak ditemukan. Link reset password: <a href="' . $resetLink . '">' . $resetLink . '</a>');
                }
            } else {
                return back()->withErrors(['username' => 'Username tidak ditemukan']);
            }
        }
        return view('auth.forgot-password');
    }

    public function resetPassword(Request $request, $username)
    {
        $petugas = Petugas::where('Username', $username)->firstOrFail();
        if ($request->isMethod('get')) {
            return view('Auth.reset-password', compact('petugas'));
        }
        $validator = Validator::make($request->all(), [
            'password' => 'required|min:6|confirmed',
        ], [
            'password.required' => 'Password baru wajib diisi',
            'password.min' => 'Password minimal 6 karakter',
            'password.confirmed' => 'Konfirmasi password tidak sesuai',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        DB::table('petugas')
            ->where('Username', $username)
            ->update(['Password' => Hash::make($request->password)]);
        return redirect()->route('login')->with('success', 'Password berhasil direset!');
    }
}
