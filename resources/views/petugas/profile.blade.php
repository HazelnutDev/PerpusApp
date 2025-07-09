@extends('layouts.master')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header">Profile Details</h5>
                    <!-- Account -->
                    <div class="card-body">
                        <div class="d-flex align-items-start align-items-sm-center gap-4">
                            <img src="{{ $petugas->foto ? asset('storage/' . $petugas->foto) : asset('image/profile.png') }}"
                                alt="user-avatar" class="d-block rounded" height="100" width="100" id="uploadedAvatar" />
                            <div class="button-wrapper">
                                <form method="POST" action="{{ route('petugas.profil.update') }}"
                                    enctype="multipart/form-data" style="display:inline;">
                                    @csrf
                                    @method('PUT')
                                    <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                                        <span class="d-none d-sm-block">Upload new photo</span>
                                        <i class="bx bx-upload d-block d-sm-none"></i>
                                        <input type="file" id="upload" name="foto" class="account-file-input"
                                            hidden accept="image/png,image/jpeg" onchange="validateFile(this)" />
                                    </label>
                                    <button type="button" class="btn btn-outline-secondary account-image-reset mb-4"
                                        onclick="resetImage()">
                                        <i class="bx bx-reset d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">Reset</span>
                                    </button>
                                    <p class="text-muted mb-3">Hanya format JPG, JPEG, atau PNG. Maksimal 2MB.</p>
                                    @error('foto')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </form>
                            </div>
                        </div>
                        <hr class="mt-4" />
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif
                            @if (session('error'))
                                <div class="alert alert-danger alert-dismissible" role="alert">
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif
                            <form method="POST" action="{{ route('petugas.profil.update') }}">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="mb-3 col-md-4">
                                        <label for="Nama" class="form-label">Nama Lengkap</label>
                                        <input class="form-control @error('Nama') is-invalid @enderror" type="text"
                                            id="Nama" name="Nama" value="{{ old('Nama', $petugas->Nama) }}"
                                            required />
                                        @error('Nama')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3 col-md-4">
                                        <label for="username" class="form-label">Username</label>
                                        <input class="form-control @error('username') is-invalid @enderror" type="text"
                                            id="username" name="username" value="{{ old('username', $petugas->Username) }}"
                                            required />
                                        @error('username')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3 col-md-4">
                                        <label for="Role" class="form-label">Role</label>
                                        <input class="form-control" type="text" id="Role" value="{{ $petugas->Role }}"
                                            readonly />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-md-4">
                                        <label for="current_password" class="form-label">Password Lama</label>
                                        <input class="form-control @error('current_password') is-invalid @enderror"
                                            type="password" id="current_password" name="current_password" required />
                                        @error('current_password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3 col-md-4">
                                        <label for="password" class="form-label">Password Baru</label>
                                        <input class="form-control @error('password') is-invalid @enderror" type="password"
                                            id="password" name="password" />
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3 col-md-4">
                                        <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                                        <input class="form-control" type="password" id="password_confirmation"
                                            name="password_confirmation" />
                                        @error('password_confirmation')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <small class="text-muted">Isi Password Lama Untuk Verifikasi Perubahan</small>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary me-2"><i class="bx bx-save"></i> Simpan
                                        Perubahan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /Account -->

                    <!-- Delete Account -->
                    @if(Auth::user()->Role === 'admin' || Auth::id() === $petugas->id)
                        <div class="card">
                            <h5 class="card-header">Delete Account</h5>
                            <div class="card-body">
                                <div class="mb-3 col-12">
                                    <div class="alert alert-warning">
                                        <h6 class="alert-heading fw-bold mb-1">Apa Anda Yakin Ingin Menghapus Akun?</h6>
                                        <p class="mb-0">Setelah Anda menghapus akun, Anda tidak dapat kembali lagi. Pastikan
                                            Anda yakin.</p>
                                    </div>
                                </div>
                                <form id="deleteAccountForm" method="POST"
                                    action="{{ route('petugas.delete-account', $petugas->KodePetugas) }}">
                                    @csrf
                                    @method('DELETE')
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" name="confirm_delete"
                                            id="confirm_delete" required />
                                        <label class="form-check-label" for="confirm_delete">Saya Yakin Menghapus Akun
                                            Saya</label>
                                    </div>
                                    <button type="submit" class="btn btn-danger">Delete Account</button>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <script>
        function validateFile(input) {
            const file = input.files[0];
            const maxSize = 2 * 1024 * 1024; // 2MB
            const allowedTypes = ['image/png', 'image/jpeg'];
            if (file) {
                if (!allowedTypes.includes(file.type)) {
                    alert('Hanya format JPG, JPEG, atau PNG yang diperbolehkan.');
                    input.value = null;
                    document.getElementById('uploadedAvatar').src = '{{ $petugas->foto ? asset('storage/' . $petugas->foto) : asset('image/profile.png') }}';
                    return;
                }
                if (file.size > maxSize) {
                    alert('Ukuran file maksimal 2MB.');
                    input.value = null;
                    document.getElementById('uploadedAvatar').src = '{{ $petugas->foto ? asset('storage/' . $petugas->foto) : asset('image/profile.png') }}';
                    return;
                }
                document.getElementById('uploadedAvatar').src = URL.createObjectURL(file);
            }
        }

        function resetImage() {
            document.getElementById('uploadedAvatar').src = '{{ $petugas->foto ? asset('storage/' . $petugas->foto) : asset('image/profile.png') }}';
            document.getElementById('upload').value = null;
        }

        document.querySelector('#deleteAccountForm').addEventListener('submit', function(e) {
            if (!confirm('Apa Anda yakin ingin menghapus akun?\nAkun yang sudah dihapus tidak dapat dikembalikan lagi.')) {
                e.preventDefault();
            }
        });
    </script>
@endsection