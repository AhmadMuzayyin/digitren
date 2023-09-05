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
        <li class="{{ request()->routeIs('santri.*') == 'dashboard' ? 'mm-active' : '' }}">
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
        <!-- master data -->
        <li class="menu-label">Master Data</li>
        <li class="{{ request()->routeIs('kamar.*') ? 'mm-active' : '' }}">
            <a href="#">
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
        <li class="{{ request()->routeIs('rapor.*') ? 'mm-active' : '' }}">
            <a href="#">
                <div class="parent-icon icon-color-6"><i class="bx bx-task"></i>
                </div>
                <div class="menu-title">Rapor Santri(on going)</div>
            </a>
        </li>
        <!-- master data -->

        <!-- transaksi data -->
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
        <li class="menu-label">Utilitis</li>
        <li class="{{ request()->routeIs('riwayat.*') ? 'mm-active' : '' }}">
            <a href="#">
                <div class="parent-icon icon-color-8"><i class="bx bx-history"></i>
                </div>
                <div class="menu-title">Riwayat</div>
            </a>
        </li>
        <li class="{{ request()->routeIs('sinkronisasi.*') ? 'mm-active' : '' }}">
            <a href="{{ route('sinkronisasi.index') }}">
                <div class="parent-icon icon-color-9"><i class="bx bx-sync"></i>
                </div>
                <div class="menu-title">Sinkronisasi</div>
            </a>
        </li>
    </ul>
    <!--end navigation-->
</div>
<!--end sidebar-wrapper-->