@extends('layouts.master')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Edit Petugas</h5>
                    <a href="{{ route('petugas.index') }}" class="btn btn-outline-secondary btn-sm d-flex align-items-center">
                        <i class="bx bx-arrow-back me-1"></i> Kembali
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('petugas.update', ['petuga' => $petugas->KodePetugas]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="KodePetugas">Kode Petugas</label>
                                    <input type="text" class="form-control" id="KodePetugas" name="KodePetugas" value="{{ $petugas->KodePetugas }}" readonly />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="Nama">Nama</label>
                                    <input type="text" class="form-control @error('Nama') is-invalid @enderror" id="Nama" name="Nama" value="{{ old('Nama', $petugas->Nama) }}" required />
                                    @error('Nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="Username">Username</label>
                                    <input type="text" class="form-control @error('Username') is-invalid @enderror" id="Username" name="Username" value="{{ old('Username', $petugas->Username) }}" required />
                                    @error('Username')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="Role">Role</label>
                                    <select class="form-control @error('Role') is-invalid @enderror" id="Role" name="Role" required>
                                        <option value="petugas" {{ old('Role', $petugas->Role) == 'petugas' ? 'selected' : '' }}>Petugas</option>
                                        <option value="admin" {{ old('Role', $petugas->Role) == 'admin' ? 'selected' : '' }}>Admin</option>
                                    </select>
                                    @error('Role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="Password">Password Baru</label>
                                    <input type="password" class="form-control @error('Password') is-invalid @enderror" id="Password" name="Password" />
                                    <small class="text-muted">Kosongkan jika tidak ingin mengubah password</small>
                                    @error('Password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary"><i class="bx bx-save"></i> Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
