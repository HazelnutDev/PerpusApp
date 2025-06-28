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
                            <img src="{{ isset($petugas->foto) && $petugas->foto ? asset('storage/' . $petugas->foto) : asset('image/user.jpg') }}"
                                alt="user-avatar" class="d-block rounded" height="100" width="100" id="uploadedAvatar" />
                            <div class="button-wrapper">
                                <form method="post" action="{{ route('petugas.profil') }}" enctype="multipart/form-data"
                                    style="display:inline;">
                                    @csrf
                                    @method('PUT')
                                    <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                                        <span class="d-none d-sm-block">Upload new photo</span>
                                        <i class="bx bx-upload d-block d-sm-none"></i>
                                        <input type="file" id="upload" name="foto" class="account-file-input"
                                            hidden accept="image/png, image/jpeg" />
                                    </label>
                                    <button type="button" class="btn btn-outline-secondary account-image-reset mb-4"
                                        onclick="document.getElementById('uploadedAvatar').src='{{ isset($petugas->foto) && $petugas->foto ? asset('storage/' . $petugas->foto) : asset('image/user.jpg') }}'; document.getElementById('upload').value=null;">
                                        <i class="bx bx-reset d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">Reset</span>
                                    </button>
                                    <p class="text-muted mb-3">Hanya Format jpg, jpeg or png. Max size of 2MB</p>
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
                            <div class="row">
                                <div class="mb-3 col-md-4">
                                    <label for="Nama" class="form-label">Nama Lengkap</label>
                                    <input class="form-control @error('Nama') is-invalid @enderror" type="text"
                                        id="Nama" name="Nama" value="{{ $petugas->Nama }}" required />
                                    @error('Nama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label for="username" class="form-label">Username</label>
                                    <input class="form-control @error('username') is-invalid @enderror" type="text"
                                        id="username" name="username" value="{{ $petugas->Username }}" required />
                                    @error('username')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label for="Role" class="form-label">Role</label>
                                    <input class="form-control @error('Role') is-invalid @enderror" type="text"
                                        id="Role" name="Role" value="{{ $petugas->Role }}" required readonly />
                                    @error('Role')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-md-4">
                                    <label for="Password" class="form-label">Password</label>
                                    <input class="form-control @error('Password') is-invalid @enderror" type="Password"
                                        id="Password" name="Password" required />
                                    @error('Password')
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
                                <small class="text-muted">Kosongkan jika tidak ingin mengubah password</small>
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary me-2"><i class="bx bx-save"></i> Simpan
                                        Perubahan</button>
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                    <!-- /Account -->

                    <!-- Delete Account -->
                </div>
                <div class="card">
                    <h5 class="card-header">Delete Account</h5>
                    <div class="card-body">
                        <div class="mb-3 col-12">
                            <div class="alert alert-warning">
                                <h6 class="alert-heading fw-bold mb-1">Apa Anda Yakin Ingin Menghapus Akun?</h6>
                                <p class="mb-0">Setelah Anda menghapus akun, Anda tidak dapat kembali lagi. Pastikan Anda
                                    yakin.
                                </p>
                            </div>
                        </div>
                        {{-- <form id="DeleteAkun" method="POST" action="{{ route('petugas.destroy/{{$KodePetugas}}') }}"> --}}
                            <form id="DeleteAkun" method="POST" action="{{ route('petugas.destroy', $petugas->KodePetugas) }}">
                            @csrf
                            @method('DELETE')
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="deactivate-account" id="deactivate-account" />
                                <label class="form-check-label" for="deactivate-account">Saya Yakin Delete akun saya</label>
                            </div>
                            <button type="submit" class="btn btn-danger deactivate-account">Delete Account</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('upload').addEventListener('change', function(e) {
            const [file] = this.files;
            if (file) {
                document.getElementById('uploadedAvatar').src = URL.createObjectURL(file);
            }
        });
    </script>
    <script>
        document.querySelector('.deactivate-account').addEventListener('click', function() {
            if (confirm('Apa Anda Yakin Ingin Menghapus Akun?\nAkun yang sudah dihapus tidak dapat dikembalikan lagi.')) {
                // If the user confirms, submit the form
                document.getElementById('DeleteAkun').submit();
            } else {
                // If the user cancels, prevent form submission
                event.preventDefault();
            }
        });
    </script>
@endsection
