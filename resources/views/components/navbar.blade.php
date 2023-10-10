<!--sidebar-wrapper-->
<div class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div class="">
            <img src="{{ url('assets/images/logo-icon.png') }}" class="logo-icon-2" alt="" />
        </div>
        <div>
            <h4 class="logo-text">Digitren</h4>
        </div>
        <a href="javascript:;" class="toggle-btn ms-auto"> <i class="bx bx-menu"></i>
        </a>
    </div>
    <!--navigation-->
    <ul class="metismenu" id="menu">
        <li class="{{ request()->routeIs('dashboard.*') ? 'mm-active' : '' }}">
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon icon-color-1"><i class="bx bx-home-alt"></i>
                </div>
                <div class="menu-title">Dashboard</div>
            </a>
            <ul>
                <li> <a href="{{ route('dashboard') }}"><i class="bx bx-right-arrow-alt"></i>Analytics</a>
                </li>
                <li> <a href="#"><i class="bx bx-right-arrow-alt"></i>Sales</a>
                </li>
            </ul>
        </li>
        @role('Administrator|Pengurus')
            <!-- master data -->
            <li class="menu-label">Master Data</li>
            <li class="{{ request()->routeIs('kamar.*') ? 'mm-active' : '' }}">
                <a href="{{ route('kamar.index') }}">
                    <div class="parent-icon icon-color-10"> <i class="bx bx-home-alt"></i>
                    </div>
                    <div class="menu-title">Kamar</div>
                </a>
            </li>
            <li class="{{ request()->routeIs('kelas.*') ? 'mm-active' : '' }}">
                <a href="{{ route('kelas.index') }}">
                    <div class="parent-icon icon-color-3"> <i class="bx bx-devices"></i>
                    </div>
                    <div class="menu-title">Kelas</div>
                </a>
            </li>
            <li class="{{ request()->routeIs('santri.*') ? 'mm-active' : '' }}">
                <a href="{{ route('santri.index') }}">
                    <div class="parent-icon icon-color-4"><i class="bx bx-user"></i>
                    </div>
                    <div class="menu-title">Santri</div>
                </a>
            </li>
            <li class="{{ request()->routeIs('mapel.*') ? 'mm-active' : '' }}">
                <a href="{{ route('mapel.index') }}">
                    <div class="parent-icon icon-color-11"><i class="bx bx-book"></i>
                    </div>
                    <div class="menu-title">Mata Pelajaran</div>
                </a>
            </li>
            <li class="{{ request()->routeIs('rapor.*') ? 'mm-active' : '' }}">
                <a href="{{ route('rapor.index') }}">
                    <div class="parent-icon icon-color-6"><i class="bx bx-task"></i>
                    </div>
                    <div class="menu-title">Rapor Santri</div>
                </a>
            </li>
            <!-- master data -->

            <!-- surat menyurat -->
            <li class="menu-label">Surat Menyurat</li>
            <li class="{{ request()->routeIs('jenis_surat.*') ? 'mm-active' : '' }}">
                <a href="#">
                {{-- <a href="{{ route('jenis_surat.index') }}"> --}}
                    <div class="parent-icon icon-color-7"><i class="bx bx-abacus"></i>
                    </div>
                    <div class="menu-title">Data Surat</div>
                </a>
            </li>
            <li class="{{ request()->routeIs('surat.*') ? 'mm-active' : '' }}">
                <a href="#">
                {{-- <a href="{{route('surat.index')}}"> --}}
                    <div class="parent-icon icon-color-4"><i class="bx bx-file"></i>
                    </div>
                    <div class="menu-title">Surat Izin Santri</div>
                </a>
            </li>
            <!-- surat menyurat -->
        @endrole

        @hasanyrole('Administrator|Keuangan')
            <!-- tabungan -->
            <li class="menu-label">Tabungan</li>
            <li class="{{ request()->routeIs('saldo_debit.*') ? 'mm-active' : '' }}">
                <a href="{{ route('saldo_debit.index') }}">
                    <div class="parent-icon icon-color-5"><i class="bx bx-dollar"></i>
                    </div>
                    <div class="menu-title">Tabungan</div>
                </a>
            </li>
            <li class="{{ request()->routeIs('transaksi.*') ? 'mm-active' : '' }}">
                <a href="{{ route('transaksi.index') }}">
                    <div class="parent-icon icon-color-7"><i class="bx bx-transfer-alt"></i>
                    </div>
                    <div class="menu-title">Transaksi</div>
                </a>
            </li>
            <!-- tabungan -->
        @endrole

        <!-- utilities -->
        <li class="menu-label">Utilitis</li>
        @role('Administrator')
            {{-- <li class="{{ request()->routeIs('roles.*') ? 'mm-active' : '' }}">
                <a href="{{ route('roles.index') }}">
                    <div class="parent-icon text-warning"><i class="bx bx-shield"></i>
                    </div>
                    <div class="menu-title">Jabatan</div>
                </a>
            </li> --}}
            <li class="{{ request()->routeIs('users.*') ? 'mm-active' : '' }}">
                <a href="{{ route('users.index') }}">
                    <div class="parent-icon text-info"><i class="bx bx-user-circle"></i>
                    </div>
                    <div class="menu-title">Pengguna</div>
                </a>
            </li>
            <li class="{{ request()->routeIs('riwayat.*') ? 'mm-active' : '' }}">
                <a href="{{ route('riwayat.index') }}">
                    <div class="parent-icon icon-color-8"><i class="bx bx-history"></i>
                    </div>
                    <div class="menu-title">Riwayat</div>
                </a>
            </li>
            <li class="{{ request()->routeIs('sinkronisasi.*') ? 'mm-active' : '' }}">
                <a href="#">
                {{-- <a href="{{ route('sinkronisasi.index') }}"> --}}
                    <div class="parent-icon icon-color-9"><i class="bx bx-sync"></i>
                    </div>
                    <div class="menu-title">Sinkronisasi</div>
                </a>
            </li>
        @endrole
        @role('Pengurus')
            <li class="{{ request()->routeIs('sinkronisasi.*') ? 'mm-active' : '' }}">
                <a href="{{ route('sinkronisasi.index') }}">
                    <div class="parent-icon icon-color-9"><i class="bx bx-sync"></i>
                    </div>
                    <div class="menu-title">Sinkronisasi</div>
                </a>
            </li>
        @endrole
        <!-- utilities -->
        <!--end navigation-->
</div>
<!--end sidebar-wrapper-->
