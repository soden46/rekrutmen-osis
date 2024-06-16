@can('admin')
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <div class="sidebar-brand-icon d-flex align-items-center justify-content-center">
            <img src="{{ asset('assets/img/Logobgiputih.png') }}" alt="Logo" width="" height="80"></img>
        </div>
        <a class="sidebar-brand d-flex align-items-center justify-content-center">
            <div class="sidebar-brand-text mx-3">
                <p>{{ Auth::user()->nama }}</p>
            </div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.index') }}">
                <i class="fa fa-light fa-user-pen"></i>
                <span>Dashborad</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                aria-expanded="true" aria-controls="collapseUtilities">
                <i class="fa fa-building-o"></i>
                <span>Data Pengguna</span>
            </a>
            <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="{{ route('admin.admin') }}">Data Admin</a>
                    <a class="collapse-item" href="{{ route('admin.pembina') }}">Data Pembina</a>
                    <a class="collapse-item" href="{{ route('admin.siswa') }}">Data Siswa</a>
                </div>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.ekskul') }}">
                <i class="fa fa-light fa-newspaper"></i>
                <span>Data Ekstrakulikuler</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.rekrutmen') }}">
                <i class="fa fa-info-circle"></i>
                <span>Data Rekrutmen</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.pendaftaran') }}">
                <i class="fa fa-info-circle"></i>
                <span>Data Pendaftaran</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.jadwal') }}">
                <i class="fa fa-info-circle"></i>
                <span>Data Jadwal Tes</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.hasil') }}">
                <i class="fa fa-info-circle"></i>
                <span>Data Hasil Tes</span>
            </a>
        </li>
        <hr class="sidebar-divider">
        <li class="nav-item">
            <a class="nav-link" href="/logout">
                <i class="fa fa-sign-out"></i>
                <span>Logout</span>
            </a>
        </li>
    </ul>
@endcan
@can('pembina')
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
        <div class="sidebar-brand-icon d-flex align-items-center justify-content-center">
            <img src="{{ asset('assets/img/Logobgiputih.png') }}" alt="Logo" width="" height="80"></img>
        </div>
        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="">
            <div class="sidebar-brand-text mx-3">{{ Auth::user()->nama }}</div>
        </a>
        <hr class="sidebar-divider my-0">
        <!-- Nav Item -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('pembina.index') }}">
                <i class="fa fa-light fa-user-pen"></i>
                <span>Dashborad</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('pembina.rekrutmen') }}">
                <i class="fa fa-info-circle"></i>
                <span>Data Rekrutmen</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('pembina.siswa') }}">
                <i class="fa fa-info-circle"></i>
                <span>Data Siswa</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('pembina.pendaftaran') }}">
                <i class="fa fa-info-circle"></i>
                <span>Data Pendaftaran</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('pembina.jadwal') }}">
                <i class="fa fa-info-circle"></i>
                <span>Data Jadwal Tes</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('pembina.hasil') }}">
                <i class="fa fa-info-circle"></i>
                <span>Data Hasil Tes</span>
            </a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">
        <!-- Sidebar Toggler (Sidebar) -->
        <li class="nav-item">
            <a class="nav-link" href="/logout">
                <i class="fa fa-sign-out"></i>
                <span>Logout</span></a>
        </li>
    </ul>
    </ul>
@endcan
@can('siswa')
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
        <div class="sidebar-brand-icon d-flex align-items-center justify-content-center">
            <img src="{{ asset('assets/img/Logobgiputih.png') }}" alt="Logo" width="" height="80"></img>
        </div>
        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="">
            <div class="sidebar-brand-text mx-3">{{ Auth::user()->nama }}</div>
        </a>
        <hr class="sidebar-divider my-0">
        <!-- Nav Item -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('siswa.biodata') }}">
                <i class="fa fa-light fa-user-pen"></i>
                <span>Biodata</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('siswa.rekrutmen') }}">
                <i class="fa fa-light fa-newspaper"></i>
                <span>Rekrtutmen</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('siswa.pendafataran') }}">
                <i class="fa fa-info-circle"></i>
                <span>Pendafatran</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('siswa.jadwal') }}">
                <i class="fa fa-info-circle"></i>
                <span>Jadwal Tes</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('siswa.hasil') }}">
                <i class="fa fa-info-circle"></i>
                <span>Hasil Tes</span>
            </a>
        </li>
        <!-- Divider -->
        <hr class="sidebar-divider">
        <!-- Sidebar Toggler (Sidebar) -->
        <li class="nav-item">
            <a class="nav-link" href="/logout">
                <i class="fa fa-sign-out"></i>
                <span>Logout</span></a>
        </li>
    </ul>
    </ul>
@endcan
