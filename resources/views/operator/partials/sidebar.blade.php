<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header">
            <div class="d-flex justify-content-between">
                <div class="logo">
                    <a href="javascript:void(0)">
                        <img src="{!! asset('public/img/ambilin2.png') !!}" alt="Logo" srcset="" style="height: 2.15rem; padding-bottom: 0.45rem;">
                        {{-- <span>Ambilin</span> --}}
                    </a>
                </div>
                <div class="toggler">
                    <a href="#" class="sidebar-hide d-xl-none d-block" style="color: #ccc"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu" style="margin-top: 0">
                <li class="sidebar-item @if($active == 'dashboard') active @endif">
                    <a href="{{ route('index-operator') }}" class='sidebar-link'>
                        <i class="bi bi-grid-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="sidebar-title"><span class="divider" style="margin-bottom: 0"><span class="divider-text">User</span></span></li>
                <li class="sidebar-item @if($active == 'tambah user') active @endif">
                    <a href="{{route('tambah_user-operator')}}" class='sidebar-link'>
                        <i class="bi bi-person-plus-fill"></i>
                        <span>Tambah User</span>
                    </a>
                </li>
                <li class="sidebar-item has-sub @if(($active == 'mitra new') || ($active == 'mitra verifying') || ($active == 'mitra verified') || ($active == 'mitra unverified')) active @endif">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-person-fill"></i>
                        <span>Rumah Tangga</span>
                    </a>
                    <ul class="submenu" @if(($active == 'mitra new') || ($active == 'mitra verifying') || ($active == 'mitra verified') || ($active == 'mitra unverified')) style="display: block" @endif>
                        <li class="submenu-item @if($active == 'mitra new') active @endif">
                            <a href="{{ route('mitra_new-operator',['jenis'=>'rumah_tangga']) }}">Pengguna Baru</a>
                        </li>
                        <li class="submenu-item @if($active == 'mitra verifying') active @endif">
                            <a href="{{ route('mitra_verifying-operator',['jenis'=>'rumah_tangga']) }}">Menunggu Verifikasi</a>
                        </li>
                        <li class="submenu-item @if($active == 'mitra verified') active @endif">
                            <a href="{{ route('mitra_verified-operator',['jenis'=>'rumah_tangga']) }}">Terverifikasi</a>
                        </li>
                        <li class="submenu-item @if($active == 'mitra unverified') active @endif">
                            <a href="{{ route('mitra_unverified-operator',['jenis'=>'rumah_tangga']) }}">Ditolak</a>
                        </li>
                        {{-- <li><hr style="margin: 0 1.5rem;"></li> --}}
                    </ul>
                </li>

                <li class="sidebar-item has-sub @if(($active == 'bank sampah new') || ($active == 'bank sampah verifying') || ($active == 'bank sampah verified') || ($active == 'bank sampah unverified')) active @endif">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-people-fill"></i>
                        <span>Bank Sampah</span>
                    </a>
                    <ul class="submenu" @if(($active == 'bank sampah new') || ($active == 'bank sampah verifying') || ($active == 'bank sampah verified') || ($active == 'bank sampah unverified')) style="display: block" @endif>
                        <li class="submenu-item @if($active == 'bank sampah new') active @endif">
                            <a href="{{ route('mitra_new-operator',['jenis'=>'bank_sampah']) }}">Pengguna Baru</a>
                        </li>
                        <li class="submenu-item @if($active == 'bank sampah verifying') active @endif">
                            <a href="{{ route('mitra_verifying-operator',['jenis'=>'bank_sampah']) }}">Menunggu Verifikasi</a>
                        </li>
                        <li class="submenu-item @if($active == 'bank sampah verified') active @endif">
                            <a href="{{ route('mitra_verified-operator',['jenis'=>'bank_sampah']) }}">Terverifikasi</a>
                        </li>
                        <li class="submenu-item @if($active == 'bank sampah unverified') active @endif">
                            <a href="{{ route('mitra_unverified-operator',['jenis'=>'bank_sampah']) }}">Ditolak</a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-item has-sub @if(($active == 'kolektor new') || ($active == 'kolektor verifying') || ($active == 'kolektor verified') || ($active == 'kolektor unverified')) active @endif">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-person-lines-fill"></i>
                        <span>Kolektor</span>
                    </a>
                    <ul class="submenu" @if(($active == 'kolektor new') || ($active == 'kolektor verifying') || ($active == 'kolektor verified') || ($active == 'kolektor unverified')) style="display: block" @endif>
                        <li class="submenu-item @if($active == 'kolektor new') active @endif">
                            <a href="{{ route('mitra_new-operator',['jenis'=>'kolektor']) }}">Pengguna Baru</a>
                        </li>
                        {{-- <li class="submenu-item @if($active == 'kolektor verifying') active @endif">
                            <a href="{{ route('kolektor_verifying-operator') }}">Menunggu Verifikasi</a>
                        </li> --}}
                        <li class="submenu-item @if($active == 'kolektor verified') active @endif">
                            <a href="{{ route('mitra_verified-operator',['jenis'=>'kolektor']) }}">Terverifikasi</a>
                        </li>
                        <li class="submenu-item @if($active == 'kolektor unverified') active @endif">
                            <a href="{{ route('mitra_unverified-operator',['jenis'=>'kolektor']) }}">Ditolak</a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-item @if($active == 'kategori user') active @endif">
                    <a href="{{ route('kategori_user-operator') }}" class='sidebar-link'>
                        <i class="bi bi-list-nested"></i>
                        <span>Kategori User</span>
                    </a>
                </li>

                <li class="sidebar-item @if($active == 'lupa password') active @endif">
                    <a href="{{ route('lupa_password-operator') }}" class='sidebar-link'>
                        <i class="bi bi-lock-fill"></i>
                        <span>Lupa Password</span>
                    </a>
                </li>

                <li class="sidebar-item has-sub @if(($active == 'request hapus') || ($active == 'akun terhapus')) active @endif">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-person-x-fill"></i>
                        <span>Hapus Akun</span>
                    </a>
                    <ul class="submenu" @if(($active == 'request hapus') || ($active == 'akun terhapus')) style="display: block" @endif>
                        <li class="submenu-item @if($active == 'request hapus') active @endif">
                            <a href="#">Request Hapus</a>
                        </li>
                        <li class="submenu-item @if($active == 'akun terhapus') active @endif">
                            <a href="#">Akun Terhapus</a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-item @if($active == 'gamifikasi') active @endif">
                    <a href="{{route('gamifikasi-operator')}}" class='sidebar-link'>
                        <i class="bi bi-bar-chart-steps"></i>
                        <span>Gamifikasi</span>
                    </a>
                </li>

                <li class="sidebar-title"><span class="divider" style="margin-bottom: 0"><span class="divider-text">Fitur</span></span></li>
                <li class="sidebar-item has-sub @if(($active == 'ambilin request') || ($active == 'ambilin tersedia') || ($active == 'ambilin proses') || ($active == 'ambilin terambil') || ($active == 'ambilin ditolak') || ($active == 'ambilin dibatalkan') || ($active == 'ambilin dihapus') || ($active == 'tanggal layanan') || ($active == 'waktu layanan')) active @endif">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-trash-fill"></i>
                        <span>Ambilin</span>
                    </a>
                    <ul class="submenu" @if(($active == 'ambilin request') || ($active == 'ambilin tersedia') || ($active == 'ambilin proses') || ($active == 'ambilin terambil') || ($active == 'ambilin ditolak') || ($active == 'ambilin dibatalkan') || ($active == 'ambilin dihapus') || ($active == 'tanggal layanan') || ($active == 'waktu layanan')) style="display: block" @endif>
                        <li class="submenu-item @if($active == 'ambilin request') active @endif">
                            <a href="{{ route('ambilin-operator', ['jenis' => 'request']) }}">Ambilin Request</a>
                        </li>
                        <li><hr style="margin: 0 1.5rem;"></li>
                        <li class="submenu-item @if($active == 'ambilin tersedia') active @endif">
                            <a href="{{ route('ambilin-operator', ['jenis' => 'tersedia']) }}">Ambilin Tersedia</a>
                        </li>
                        <li class="submenu-item @if($active == 'ambilin proses') active @endif">
                            <a href="{{ route('ambilin-operator', ['jenis' => 'proses']) }}">Ambilin Proses</a>
                        </li>
                        <li class="submenu-item @if($active == 'ambilin terambil') active @endif">
                            <a href="{{ route('ambilin-operator', ['jenis' => 'terambil']) }}">Ambilin Terambil</a>
                        </li>
                        <li><hr style="margin: 0 1.5rem;"></li>
                        <li class="submenu-item @if($active == 'ambilin ditolak') active @endif">
                            <a href="{{ route('ambilin-operator', ['jenis' => 'ditolak']) }}">Ambilin Ditolak</a>
                        </li>
                        <li class="submenu-item @if($active == 'ambilin dibatalkan') active @endif">
                            <a href="{{ route('ambilin-operator', ['jenis' => 'dibatalkan']) }}">Ambilin Dibatalkan</a>
                        </li>
                        <li class="submenu-item @if($active == 'ambilin dihapus') active @endif">
                            <a href="{{ route('ambilin-operator', ['jenis' => 'dihapus']) }}">Ambilin Dihapus</a>
                        </li>
                        <li><hr style="margin: 0 1.5rem;"></li>
                        <li class="submenu-item @if($active == 'tanggal layanan') active @endif">
                            <a href="{{ route('tanggal_layanan-operator') }}">Tanggal Layanan</a>
                        </li>
                        <li class="submenu-item @if($active == 'waktu layanan') active @endif">
                            <a href="{{ route('waktu_layanan-operator') }}">Waktu Layanan</a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-item has-sub @if(($active == 'paskas proses') || ($active == 'paskas pengajuan ulang') || ($active == 'paskas lolos') || ($active == 'paskas tidak lolos') || ($active == 'paskas hapus')) active @endif">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-inboxes-fill"></i>
                        <span>Paskas</span>
                    </a>
                    <ul class="submenu" @if(($active == 'paskas proses') || ($active == 'paskas pengajuan ulang') || ($active == 'paskas lolos') || ($active == 'paskas tidak lolos') || ($active == 'paskas hapus')) style="display: block" @endif>
                        <li class="submenu-item @if($active == 'paskas proses') active @endif">
                            <a href="{{ route('barkas-operator', ['jenis' => 'paskas', 'status' => 'proses']) }}">Paskas Proses</a>
                        </li>
                        <li class="submenu-item @if($active == 'paskas pengajuan ulang') active @endif">
                            <a href="{{ route('barkas-operator', ['jenis' => 'paskas', 'status' => 'pengajuan ulang']) }}">Paskas Pengajuan Ulang</a>
                        </li>
                        <li class="submenu-item @if($active == 'paskas lolos') active @endif">
                            <a href="{{ route('barkas-operator', ['jenis' => 'paskas', 'status' => 'lolos']) }}">Paskas Lolos</a>
                        </li>
                        <li class="submenu-item @if($active == 'paskas tidak lolos') active @endif">
                            <a href="{{ route('barkas-operator', ['jenis' => 'paskas', 'status' => 'tidak lolos']) }}">Paskas Tidak Lolos</a>
                        </li>
                        <li class="submenu-item @if($active == 'paskas hapus') active @endif">
                            <a href="{{ route('barkas-operator', ['jenis' => 'paskas', 'status' => 'hapus']) }}">Paskas Dihapus</a>
                        </li>
                    </ul>
                </li>
                {{-- <li class="sidebar-item @if($active == 'paskas') active @endif">
                    <a href="{{ route('paskas-operator') }}" class='sidebar-link'>
                        <i class="bi bi-grid-fill"></i>
                        <span>paskas</span>
                    </a>
                </li> --}}

                <li class="sidebar-item has-sub @if(($active == 'sebar proses') || ($active == 'sebar pengajuan ulang') || ($active == 'sebar lolos') || ($active == 'sebar tidak lolos') || ($active == 'sebar hapus')) active @endif">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-inboxes-fill"></i>
                        <span>Sebar</span>
                    </a>
                    <ul class="submenu" @if(($active == 'sebar proses') || ($active == 'sebar pengajuan ulang') || ($active == 'sebar lolos') || ($active == 'sebar tidak lolos') || ($active == 'sebar hapus')) style="display: block" @endif>
                        <li class="submenu-item @if($active == 'sebar proses') active @endif">
                            <a href="{{ route('barkas-operator', ['jenis' => 'sebar', 'status' => 'proses']) }}">Sebar Proses</a>
                        </li>
                        <li class="submenu-item @if($active == 'sebar pengajuan ulang') active @endif">
                            <a href="{{ route('barkas-operator', ['jenis' => 'sebar', 'status' => 'pengajuan ulang']) }}">Sebar Pengajuan Ulang</a>
                        </li>
                        <li class="submenu-item @if($active == 'sebar lolos') active @endif">
                            <a href="{{ route('barkas-operator', ['jenis' => 'sebar', 'status' => 'lolos']) }}">Sebar Lolos</a>
                        </li>
                        <li class="submenu-item @if($active == 'sebar tidak lolos') active @endif">
                            <a href="{{ route('barkas-operator', ['jenis' => 'sebar', 'status' => 'tidak lolos']) }}">Sebar Tidak Lolos</a>
                        </li>
                        <li class="submenu-item @if($active == 'sebar hapus') active @endif">
                            <a href="{{ route('barkas-operator', ['jenis' => 'sebar', 'status' => 'hapus']) }}">Sebar Dihapus</a>
                        </li>
                    </ul>
                </li>
                {{-- <li class="sidebar-item @if($active == 'sebar') active @endif">
                    <a href="{{ route('sebar-operator') }}" class='sidebar-link'>
                        <i class="bi bi-grid-fill"></i>
                        <span>sebar</span>
                    </a>
                </li> --}}

                <li class="sidebar-item has-sub @if(($active == 'harga sampah tambah') || ($active == 'harga sampah mitra') || ($active == 'harga sampah bank sampah') || ($active == 'harga sampah kolektor') || ($active == 'harga sampah pelapak')) active @endif">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-cash"></i>
                        <span>Harga Sampah</span>
                    </a>
                    <ul class="submenu" @if(($active == 'harga sampah tambah') || ($active == 'harga sampah mitra') || ($active == 'harga sampah bank sampah') || ($active == 'harga sampah kolektor') || ($active == 'harga sampah pelapak')) style="display: block" @endif>
                        <li class="submenu-item @if($active == 'harga sampah tambah') active @endif">
                            <a href="{{ route('harga_sampah_tambah-operator') }}">Tambah Harga Sampah</a>
                        </li>
                        <li class="submenu-item @if($active == 'harga sampah mitra') active @endif">
                            <a href="{{ route('harga_sampah_mitra-operator', ['mitra' => 'mitra']) }}">Rumah Tangga</a>
                        </li>
                        <li class="submenu-item @if($active == 'harga sampah bank sampah') active @endif">
                            <a href="{{ route('harga_sampah_mitra-operator', ['mitra' => 'bank sampah']) }}">Bank Sampah</a>
                        </li>
                        <li class="submenu-item @if($active == 'harga sampah kolektor') active @endif">
                            <a href="{{ route('harga_sampah_mitra-operator', ['mitra' => 'kolektor']) }}">Kolektor</a>
                        </li>
                        <li class="submenu-item @if($active == 'harga sampah pelapak') active @endif">
                            <a href="{{ route('harga_sampah_mitra-operator', ['mitra' => 'pelapak']) }}">Pelapak</a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-item has-sub @if(($active == 'wp lokasi') || ($active == 'wp lokasi jenis') || ($active == 'wp lokasi hapus')) active @endif">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-geo-alt-fill"></i>
                        <span>Lokasi User</span>
                    </a>
                    <ul class="submenu" @if(($active == 'wp lokasi jenis') || ($active == 'wp lokasi') || ($active == 'wp lokasi hapus')) style="display: block" @endif>
                        <li class="submenu-item @if($active == 'wp lokasi jenis') active @endif">
                            <a href="{{ route('wp_lokasijenis-operator') }}">Jenis Lokasi</a>
                        </li>
                        <li class="submenu-item @if($active == 'wp lokasi') active @endif">
                            <a href="{{ route('wp_lokasi-operator', ['jenis' => 'wp lokasi']) }}">Lokasi</a>
                        </li>
                        <li class="submenu-item @if($active == 'wp lokasi hapus') active @endif">
                            <a href="{{ route('wp_lokasi-operator', ['jenis' => 'wp lokasi hapus']) }}">Lokasi Dihapus</a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-item @if($active == 'notifikasi') active @endif">
                    <a href="{{route('notifikasi-operator')}}" class='sidebar-link'>
                        <i class="bi bi-bell-fill"></i>
                        <span>Notifikasi</span>
                    </a>
                </li>
                
            </ul>
        </div>
        <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
    </div>
</div>