@extends('layouts.master')

@section('title', 'Profil')

@section('content')
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Profil /</span> Akun Saya
        </h4>

        <div class="row">
            <div class="col-md-12">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="card mb-4">
                    <h5 class="card-header">Detail Profil</h5>
                    <div class="card-body">
                        <form id="profileForm" action="{{ route('petugas.profil.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="d-flex align-items-start align-items-sm-center gap-4 mb-4">
                                <img src="{{ isset($petugas->foto) && $petugas->foto ? asset('storage/' . $petugas->foto) : asset('image/profile.png') }}"
                                    alt="{{ $petugas->Nama }}"
                                    class="d-block rounded"
                                    height="120"
                                    width="120"
                                    id="uploadedAvatar" />
                                <div class="button-wrapper">
                                    <label for="foto" class="btn btn-primary me-2 mb-3" tabindex="0">
                                        <span class="d-none d-sm-block">Unggah Foto Baru</span>
                                        <i class="bx bx-upload d-block d-sm-none"></i>
                                        <input
                                            type="file"
                                            id="foto"
                                            name="foto"
                                            class="account-file-input"
                                            hidden
                                            accept="image/png, image/jpeg"
                                            onchange="previewImage(this)" />
                                    </label>
                                    <p class="text-muted mb-0">Format: JPG, JPEG, atau PNG. Maksimal 2MB</p>
                                    @error('foto')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label for="KodePetugas" class="form-label">Kode Petugas</label>
                                    <input class="form-control" type="text" id="KodePetugas" name="KodePetugas"
                                        value="{{ $petugas->KodePetugas }}" readonly />
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="Nama" class="form-label">Nama Lengkap</label>
                                    <input class="form-control @error('Nama') is-invalid @enderror" type="text" id="Nama"
                                        name="Nama" value="{{ old('Nama', $petugas->Nama) }}" required />
                                    @error('Nama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="Username" class="form-label">Username</label>
                                    <input class="form-control @error('Username') is-invalid @enderror" type="text"
                                        id="Username" name="Username" value="{{ old('Username', $petugas->Username) }}" required />
                                    @error('Username')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="Role" class="form-label">Role</label>
                                    <input class="form-control" type="text" id="Role" name="Role"
                                        value="{{ $petugas->Role }}" readonly />
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="changePassword" />
                                    <label class="form-check-label" for="changePassword">
                                        Ubah Password
                                    </label>
                                </div>
                            </div>

                            <div id="passwordFields" style="display: none;">
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label for="current_password" class="form-label">Password Saat Ini</label>
                                        <input class="form-control @error('current_password') is-invalid @enderror"
                                            type="password" id="current_password" name="current_password" />
                                        @error('current_password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="password" class="form-label">Password Baru</label>
                                        <input class="form-control @error('password') is-invalid @enderror"
                                            type="password" id="password" name="password" />
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                                        <input class="form-control" type="password"
                                            id="password_confirmation" name="password_confirmation" />
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary me-2">
                                    <i class="bx bx-save"></i> Simpan Perubahan
                                </button>
                                <button type="reset" class="btn btn-outline-secondary">Batal</button>
                            </div>
                        </form>
                    </div>
                </div>

                @if(Auth::user()->Role === 'admin' || Auth::id() === $petugas->id)
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Hapus Akun</h5>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-warning">
                                <h6 class="alert-heading fw-bold mb-1">Hati-hati!</h6>
                                <p class="mb-0">
                                    Menghapus akun akan menghapus semua data terkait secara permanen.
                                    Tindakan ini tidak dapat dibatalkan.
                                </p>
                            </div>
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                                Hapus Akun Saya
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Delete Account Modal -->
    <div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Penghapusan Akun</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus akun ini? Tindakan ini tidak dapat dibatalkan.</p>
                    <p class="text-danger">Semua data yang terkait dengan akun ini akan dihapus secara permanen.</p>

                    <form id="deleteAccountForm" action="{{ route('petugas.delete-account', $petugas->KodePetugas) }}" method="POST" class="mt-3">
                        @csrf
                        @method('DELETE')
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="confirmDelete" name="confirm_delete" required>
                            <label class="form-check-label" for="confirmDelete">
                                Saya mengerti dan ingin melanjutkan penghapusan akun
                            </label>
                        </div>
                        <div class="d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-danger">Ya, Hapus Akun</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Toggle password fields
    document.getElementById('changePassword').addEventListener('change', function() {
        const passwordFields = document.getElementById('passwordFields');
        passwordFields.style.display = this.checked ? 'block' : 'none';
    });

    // Image preview
    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            const maxSize = 2 * 1024 * 1024; // 2MB
            const file = input.files[0];

            // Validasi ukuran file
            if (file.size > maxSize) {
                showAlert('danger', 'Ukuran file terlalu besar. Maksimal 2MB.');
                input.value = '';
                return false;
            }

            // Validasi tipe file
            const allowedTypes = ['image/jpeg', 'image/png'];
            if (!allowedTypes.includes(file.type)) {
                showAlert('danger', 'Format file tidak didukung. Gunakan format JPG atau PNG.');
                input.value = '';
                return false;
            }

            // Tampilkan preview
            reader.onload = function(e) {
                document.getElementById('uploadedAvatar').src = e.target.result;

                // Upload otomatis saat file dipilih
                const formData = new FormData(document.getElementById('profileForm'));
                uploadPhoto(formData);
            }

            reader.readAsDataURL(file);
        }
    }

    // Upload photo via AJAX
    async function uploadPhoto(formData) {
        try {
            // Dapatkan CSRF token dari meta tag
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Tambahkan CSRF token ke formData
            formData.append('_token', csrfToken);
            formData.append('_method', 'PUT');

            const response = await fetch("{{ route('petugas.profil.update') }}", {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: formData
            });

            const data = await response.json();

            if (response.ok && data.success) {
                // Update semua gambar profil di halaman
                const timestamp = new Date().getTime();
                const newImageUrl = data.foto_url + '?t=' + timestamp;
                const defaultImage = '{{ asset("image/profile.png") }}';

                // Update gambar di halaman profil
                document.getElementById('uploadedAvatar').src = newImageUrl;

                // Update gambar di navbar (jika ada di halaman yang sama)
                document.querySelectorAll('.profile-avatar').forEach(img => {
                    img.src = newImageUrl;
                    img.onerror = function() {
                        this.src = defaultImage;
                    };
                });

                // Perbarui juga di dropdown navbar
                document.querySelectorAll('.dropdown-menu .profile-avatar').forEach(img => {
                    img.src = newImageUrl;
                    img.onerror = function() {
                        this.src = defaultImage;
                    };
                });

                showAlert('success', 'Foto profil berhasil diupdate!');

                // Refresh halaman setelah 1 detik untuk memastikan semua komponen terupdate
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            } else {
                throw new Error(data.message || 'Gagal mengupload foto');
            }
        } catch (error) {
            console.error('Error:', error);
            showAlert('danger', error.message || 'Terjadi kesalahan saat mengupload foto');
            resetImage();
        }
    }

    // Reset image to default
    function resetImage() {
        const defaultImage = '{{ asset("image/profile.png") }}';
        document.getElementById('uploadedAvatar').src = defaultImage;
        document.getElementById('foto').value = '';
    }

    // Show alert message
    function showAlert(type, message) {
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
        alertDiv.role = 'alert';
        alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;

        // Temukan container alert atau buat baru
        let alertContainer = document.querySelector('.alert-container');
        if (!alertContainer) {
            alertContainer = document.createElement('div');
            alertContainer.className = 'alert-container position-fixed top-20 end-0 p-3';
            alertContainer.style.zIndex = '1100';
            document.body.appendChild(alertContainer);
        }

        // Tambahkan alert ke container
        alertContainer.appendChild(alertDiv);

        // Hapus alert setelah 5 detik
        setTimeout(() => {
            alertDiv.remove();
            if (alertContainer.children.length === 0) {
                alertContainer.remove();
            }
        }, 5000);
    }

    // Handle form submission
    document.getElementById('profileForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const form = this;
        const submitButton = form.querySelector('button[type="submit"]');
        const originalButtonText = submitButton.innerHTML;

        try {
            // Tampilkan loading state
            submitButton.disabled = true;
            submitButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menyimpan...';

            const formData = new FormData(form);

            // Hapus file input jika tidak ada file yang dipilih
            if (!document.getElementById('foto').files.length) {
                formData.delete('foto');
            }

            // Hapus field password jika tidak diubah
            if (!document.getElementById('changePassword').checked) {
                formData.delete('current_password');
                formData.delete('password');
                formData.delete('password_confirmation');
            }

            const response = await fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': formData.get('_token')
                },
                body: formData
            });

            const data = await response.json();

            if (response.ok && data.success) {
                showAlert('success', data.message || 'Profil berhasil diperbarui');

                // Reset form jika ada perubahan password
                if (document.getElementById('changePassword').checked) {
                    form.reset();
                    document.getElementById('passwordFields').style.display = 'none';
                    document.getElementById('changePassword').checked = false;
                }

                // Refresh halaman jika ada perubahan data penting
                if (data.refresh) {
                    setTimeout(() => window.location.reload(), 1500);
                }
            } else {
                throw new Error(data.message || 'Gagal memperbarui profil');
            }
        } catch (error) {
            console.error('Error:', error);
            showAlert('danger', error.message || 'Terjadi kesalahan saat memperbarui profil');
        } finally {
            // Reset button state
            submitButton.disabled = false;
            submitButton.innerHTML = originalButtonText;
        }
    });

    // Handle delete account form
    const deleteForm = document.getElementById('deleteAccountForm');
    if (deleteForm) {
        deleteForm.addEventListener('submit', function(e) {
            if (!confirm('Apakah Anda yakin ingin menghapus akun ini? Tindakan ini tidak dapat dibatalkan.')) {
                e.preventDefault();
            }
        });
    }
</script>
@endpush
