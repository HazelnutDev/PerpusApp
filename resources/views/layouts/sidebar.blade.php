<!-- Layout wrapper -->
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        <!-- Menu -->
        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
            <div class="app-brand demo">
                <a href="{{ route('dashboard') }}" class="app-brand-link">
                    <span class="app-brand-logo demo">
                        <i class="menu-icon tf-icons bx bx-book-reader text-primary" style="font-size: 2rem;"></i>
                    </span>
                    <span class="fw-bolder ms-2" style="font-size: 1.2rem">Perpustakaan <br> SMP Tepal</span>
                </a>

                <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                    <i class="bx bx-chevron-left bx-sm align-middle"></i>
                </a>
            </div>

            <div class="menu-inner-shadow"></div>

            <ul class="menu-inner py-1">
                <!-- Dashboard -->
                <li class="menu-item {{ Request::is('dashboard') ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-dashboard"></i>
                        <div data-i18n="Analytics">Dashboard</div>
                    </a>
                </li>

                <!-- Library Management -->
                <li class="menu-header small text-uppercase"><span class="menu-header-text">Manajemen
                        Perpustakaan</span></li>

                <!-- Books -->
                <li class="menu-item {{ Request::is('buku*') ? 'active' : '' }}">
                    <a href="{{ route('buku.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-book"></i>
                        <div data-i18n="Books">Buku</div>
                    </a>
                </li>

                <!-- Officers -->
                <li class="menu-item {{ Request::is('petugas*') ? 'active' : '' }}">
                    <a href="{{ route('petugas.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-id-card"></i>
                        <div data-i18n="Officers">Petugas</div>
                    </a>
                </li>

                <!-- Members -->
                <li
                    class="menu-item {{ Request::is('anggota*') && !Request::is('anggota-non-siswa*') ? 'active' : '' }}">
                    <a href="{{ route('anggota.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-user"></i>
                        <div data-i18n="Members">Anggota Siswa</div>
                    </a>
                </li>

                <!-- Non-Student Members -->
                <li class="menu-item {{ Request::is('anggota-non-siswa*') ? 'active' : '' }}">
                    <a href="{{ route('anggota-non-siswa.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-user-pin"></i>
                        <div data-i18n="Non-Student Members">Anggota Non Siswa</div>
                    </a>
                </li>

                <!-- Transactions -->
                <li class="menu-header small text-uppercase"><span class="menu-header-text">Transaksi</span></li>

                <!-- Borrowing -->
                <li class="menu-item {{ Request::is('peminjaman*') ? 'active' : '' }}">
                    <a href="{{ route('peminjaman.index') }}" class="menu-link">
                        <i class='menu-icon tf-icons bx bx-cart-plus'></i>
                        <div data-i18n="Borrowing">Peminjaman</div>
                    </a>
                </li>

                <!-- Returns -->
                <li class="menu-item {{ Request::is('pengembalian*') ? 'active' : '' }}">
                    <a href="{{ route('pengembalian.index') }}" class="menu-link">
                        <i class='menu-icon tf-icons bx bx-calendar-detail'></i>
                        <div data-i18n="Returns">Pengembalian</div>
                    </a>
                </li>

                <!-- Reports -->
                <li class="menu-header small text-uppercase"><span class="menu-header-text">Laporan</span></li>

                <!-- All Reports -->
                <li class="menu-item {{ Request::is('laporan*') ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons bx bx-file-report"></i>
                        <div data-i18n="Reports">Laporan</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item {{ Request::is('laporan/anggota*') ? 'active' : '' }}">
                            <a href="{{ route('laporan.anggota.index') }}" class="menu-link">
                                <div data-i18n="Members Report">Anggota</div>
                            </a>
                        </li>
                        <li class="menu-item {{ Request::is('laporan/buku*') ? 'active' : '' }}">
                            <a href="{{ route('laporan.buku.index') }}" class="menu-link">
                                <div data-i18n="Books Report">Buku</div>
                            </a>
                        </li>
                        <li class="menu-item {{ Request::is('laporan/peminjaman*') ? 'active' : '' }}">
                            <a href="{{ route('laporan.peminjaman.index') }}" class="menu-link">
                                <div data-i18n="Borrowing Report">Peminjaman</div>
                            </a>
                        </li>
                        <li class="menu-item {{ Request::is('laporan/keterlambatan*') ? 'active' : '' }}">
                            <a href="{{ route('laporan.keterlambatan.index') }}" class="menu-link">
                                <div data-i18n="Late Returns Report">Keterlambatan</div>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </aside>
        <!-- / Menu -->
