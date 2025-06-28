<!DOCTYPE html>
<html
  lang="id"
  class="light-style customizer-hide"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="{{asset('sneat')}}/assets"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>Daftar</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{asset('sneat')}}/assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="{{asset('sneat')}}/assets/vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{asset('sneat')}}/assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{asset('sneat')}}/assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{asset('sneat')}}/assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{asset('sneat')}}/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="{{asset('sneat')}}/assets/vendor/css/pages/page-auth.css" />
    <!-- Helpers -->
    <script src="{{asset('sneat')}}/assets/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{asset('sneat')}}/assets/js/config.js"></script>
  </head>

  <body>
    <!-- Content -->

    <div class="container-xxl">
      <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
          <!-- Register Card -->
          <div class="card">
            <div class="card-body">
              <!-- Logo -->
              <div class="app-brand justify-content-center">
                <a href="index.html" class="app-brand-link gap-2">
                  <span class="app-brand-logo demo">
                    <i class="menu-icon tf-icons bx bx-book-reader text-primary" style="font-size: 2rem;"></i>
                  </span>
                  <span class="app-brand-text demo text-body fw-bolder">PerpusApp</span>
                </a>
              </div>
              <!-- /Logo -->
              <h4 class="mb-2">Hayuk Daftar Sekarang 🙌</h4>
              <p class="mb-2">Buat akun baru untuk Kelola Perpustakaan</p>

              <form id="registerForm" class="mb-3" action="{{route('register')}}" method="POST">
                @csrf
                <div class="mb-3">
                  <label for="KodePetugas" class="form-label">Kode Petugas</label>
                  <input
                    type="text"
                    class="form-control @error('KodePetugas') is-invalid @enderror"
                    id="KodePetugas"
                    name="KodePetugas"
                    placeholder="Masukkan kode petugas"
                    value="{{old('KodePetugas')}}"
                  />
                  @error('KodePetugas')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                  @enderror
                </div>
                <div class="mb-3">
                  <label for="Nama" class="form-label">Nama</label>
                  <input
                    type="text"
                    class="form-control @error('Nama') is-invalid @enderror"
                    id="Nama"
                    name="Nama"
                    placeholder="Masukkan nama"
                    value="{{old('Nama')}}"
                  />
                  @error('Nama')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                  @enderror
                </div>
                <div class="mb-3">
                  <label for="Username" class="form-label">Username</label>
                  <input
                    type="text"
                    class="form-control @error('Username') is-invalid @enderror"
                    id="Username"
                    name="Username"
                    placeholder="Masukkan username"
                    value="{{old('Username')}}"
                  />
                  @error('Username')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                  @enderror
                </div>
                <div class="mb-3 form-password-toggle">
                  <label class="form-label" for="Password">Password</label>
                  <div class="input-group input-group-merge">
                    <input
                      type="password"
                      id="Password"
                      class="form-control @error('Password') is-invalid @enderror"
                      name="Password"
                      placeholder="Masukkan password"
                      aria-describedby="Password"
                    />
                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                    @error('Password')
                      <div class="invalid-feedback">
                          {{ $message }}
                      </div>
                    @enderror
                  </div>
                </div>
                <div class="mb-3">
                  <label for="Role" class="form-label">Role</label>
                  <select class="form-select @error('Role') is-invalid @enderror" id="Role" name="Role">
                    <option value="">Select Role</option>
                    <option value="Admin" {{old('Role') == 'Admin' ? 'selected' : ''}}>Admin</option>
                    <option value="Petugas" {{old('Role') == 'Petugas' ? 'selected' : ''}}>Petugas</option>
                  </select>
                  @error('Role')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                  @enderror
                </div>

                <button class="btn btn-primary d-grid w-100">Daftar</button>
              </form>

              <p class="text-center">
                <span>Sudah punya akun?</span>
                <a href="{{route('login')}}">
                  <span>Login</span>
                </a>
              </p>
            </div>
          </div>
          <!-- Register Card -->
        </div>
      </div>
    </div>

    <!-- / Content -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{asset('sneat')}}/assets/vendor/libs/jquery/jquery.js"></script>
    <script src="{{asset('sneat')}}/assets/vendor/libs/popper/popper.js"></script>
    <script src="{{asset('sneat')}}/assets/vendor/js/bootstrap.js"></script>
    <script src="{{asset('sneat')}}/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="{{asset('sneat')}}/assets/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->
    <script src="{{asset('sneat')}}/assets/js/main.js"></script>

    <!-- Page JS -->

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
  </body>
</html>