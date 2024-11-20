<nav class="navbar navbar-vertical navbar-expand-lg">
    <div class="collapse navbar-collapse" id="navbarVerticalCollapse">
        <!-- scrollbar removed-->
        <div class="navbar-vertical-content">
            <ul class="navbar-nav flex-column" id="navbarVerticalNav">

                <li class="nav-item">
                    <div class="nav-item-wrapper"><a
                            class="nav-link {{ request()->routeIs('dashboard.*') ? 'active' : '' }} label-1"
                            href="{{ route('dashboard.index') }}" role="button" data-bs-toggle="" aria-expanded="false">
                            <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                        data-feather="pie-chart"></span></span><span class="nav-link-text-wrapper"><span
                                        class="nav-link-text">Dashboard <span
                                            class="badge ms-2 badge badge-phoenix badge-phoenix-warning ">Demo</span></span></span>
                            </div>
                        </a>
                    </div>


                    @canany(['user-list', 'user-create', 'user-edit', 'user-delete'])
                        <div class="nav-item-wrapper">
                            <a class="nav-link dropdown-indicator label-1 {{ request()->routeIs('users.*') ? '' : 'collapsed' }}"
                                href="#nv-user" role="button" data-bs-toggle="collapse"
                                aria-expanded="{{ request()->is('panel/*') ? 'true' : 'false' }}" aria-controls="nv-user">
                                <div class="d-flex align-items-center">
                                    <div class="dropdown-indicator-icon-wrapper"><span
                                            class="fas fa-caret-right dropdown-indicator-icon"></span></div><span
                                        class="nav-link-icon"><span data-feather="users"></span></span><span
                                        class="nav-link-text">Pengguna</span>
                                </div>
                            </a>
                            <div class="parent-wrapper label-1">
                                <ul class="nav collapse parent {{ request()->routeIs('users.*') ? 'show' : '' }}"
                                    data-bs-parent="#navbarVerticalCollapse" id="nv-user">
                                    <li class="collapsed-nav-item-title d-none">Pengguna
                                    </li>
                                    <li class="nav-item"><a
                                            class="nav-link {{ request()->routeIs('users.index') ? 'active' : '' }}"
                                            href="{{ route('users.index') }}">
                                            <div class="d-flex align-items-center"><span class="nav-link-text">
                                                    Master Pengguna
                                                </span>
                                            </div>
                                        </a>
                                    </li>
                                    @can('user-create')
                                        <li class="nav-item">
                                            <a class="nav-link {{ request()->routeIs('users.create') ? 'active' : '' }}"
                                                href="{{ route('users.create') }}">
                                                <div class="d-flex align-items-center"><span class="nav-link-text">Tambah
                                                        Pengguna</span>
                                                </div>
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </div>
                        </div>
                    @endcan
                    @canany(['role-list', 'role-create', 'role-edit', 'role-delete'])
                        <div class="nav-item-wrapper">
                            <a class="nav-link dropdown-indicator label-1 {{ request()->routeIs('roles.*') ? '' : 'collapsed' }}"
                                href="#nv-role" role="button" data-bs-toggle="collapse"
                                aria-expanded="{{ request()->is('panel/*') ? 'true' : 'false' }}" aria-controls="nv-role">
                                <div class="d-flex align-items-center">
                                    <div class="dropdown-indicator-icon-wrapper"><span
                                            class="fas fa-caret-right dropdown-indicator-icon"></span></div>
                                    <span class="nav-link-icon"><span data-feather="lock"></span></span>
                                    <span class="nav-link-text">Role</span>
                                </div>
                            </a>
                            <div class="parent-wrapper label-1">
                                <ul class="nav collapse parent {{ request()->routeIs('roles.*') ? 'show' : '' }}"
                                    data-bs-parent="#navbarVerticalCollapse" id="nv-role">
                                    <li class="collapsed-nav-item-title d-none">Role</li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('roles.index') ? 'active' : '' }}"
                                            href="{{ route('roles.index') }}">
                                            <div class="d-flex align-items-center"><span class="nav-link-text">Master
                                                    Role</span></div>
                                        </a>
                                    </li>

                                    @can('role-create')
                                        <li class="nav-item">
                                            <a class="nav-link {{ request()->routeIs('roles.create') ? 'active' : '' }}"
                                                href="{{ route('roles.create') }}">
                                                <div class="d-flex align-items-center"><span class="nav-link-text">Tambah
                                                        Role</span></div>
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </div>
                        </div>
                    @endcanany


                    <div class="nav-item-wrapper"><a
                            class="nav-link dropdown-indicator {{ request()->is('management/*') ? '' : 'collapsed' }} label-1"
                            href="#nv-components" role="button" data-bs-toggle="collapse" aria-expanded="true"
                            aria-controls="nv-components">
                            <div class="d-flex align-items-center">
                                <div class="dropdown-indicator-icon-wrapper"><span
                                        class="fas fa-caret-right dropdown-indicator-icon"></span></div><span
                                    class="nav-link-icon"><span data-feather="package"></span></span><span
                                    class="nav-link-text">Manajemen <span
                                        class="badge ms-2 badge badge-phoenix badge-phoenix-warning ">Demo</span></span>
                            </div>
                        </a>
                        <div class="parent-wrapper label-1">
                            <ul class="nav collapse parent {{ request()->is('management/*') ? 'show' : '' }}"
                                data-bs-parent="#navbarVerticalCollapse" id="nv-components">
                                <li class="collapsed-nav-item-title d-none">Manajemen <span
                                        class="badge ms-2 badge badge-phoenix badge-phoenix-warning ">Demo</span>
                                </li>
                                <li class="nav-item"><a
                                        class="nav-link dropdown-indicator {{ request()->routeIs('*letters.*') || request()->routeIs('*official-task-files.*') ? '' : 'collapsed' }}"
                                        href="#nv-carousel" data-bs-toggle="collapse" aria-expanded="true"
                                        aria-controls="nv-carousel">
                                        <div class="d-flex align-items-center">
                                            <div class="dropdown-indicator-icon-wrapper"><span
                                                    class="fas fa-caret-right dropdown-indicator-icon"></span></div>
                                            <span class="nav-link-text">Surat <span
                                                    class="badge ms-2 badge badge-phoenix badge-phoenix-warning ">Demo</span></span>
                                        </div>
                                    </a>
                                    <!-- more inner pages-->
                                    <div class="parent-wrapper">
                                        <ul class="nav collapse parent {{ request()->routeIs('*letters.*') || request()->routeIs('*official-task-files.*') ? 'show' : '' }}"
                                            data-bs-parent="#components" id="nv-carousel">
                                            <li class="nav-item">
                                                <a class="nav-link {{ request()->routeIs('incoming-letters.*') ? 'active' : '' }}"
                                                    href="{{ route('incoming-letters.index') }}">
                                                    <div class="d-flex align-items-center"><span
                                                            class="nav-link-text">Surat Masuk</span>
                                                    </div>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link {{ request()->routeIs('outgoing-letters.*') ? 'active' : '' }}"
                                                    href="{{ route('outgoing-letters.index') }}">
                                                    <div class="d-flex align-items-center"><span
                                                            class="nav-link-text">Surat Keluar</span>
                                                    </div>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link {{ request()->routeIs('recommendation-letters.*') ? 'active' : '' }}"
                                                    href="{{ route('recommendation-letters.index') }}">
                                                    <div class="d-flex align-items-center"><span
                                                            class="nav-link-text">Rekomendasi</span>
                                                    </div>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link {{ request()->routeIs('official-task-files.*') ? 'active' : '' }}"
                                                    href="{{ route('official-task-files.index') }}">
                                                    <div class="d-flex align-items-center"><span
                                                            class="nav-link-text">Berkas Tugas Dinas</span></span>
                                                    </div>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>


                                {{-- Pegawai --}}
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('employees.*') ? 'active' : '' }}"
                                        href="{{ route('employees.index') }}">
                                        <div class="d-flex align-items-center"><span
                                                class="nav-link-text">Pegawai</span></div>
                                    </a>
                                </li>

                            </ul>
                        </div>
                    </div>


                    <div class="nav-item-wrapper"><a class="nav-link label-1"
                            onclick="return alert('belum tersedia :)')" href="#" role="button"
                            data-bs-toggle="" aria-expanded="false">
                            <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                        data-feather="file"></span></span><span class="nav-link-text-wrapper"><span
                                        class="nav-link-text">e-Pelaporan
                                        Bidang <span
                                            class="badge ms-2 badge-sm badge-phoenix badge-phoenix-danger ">!</span></span></span>
                            </div>
                        </a>
                    </div>
                    <div class="nav-item-wrapper"><a class="nav-link label-1"
                            onclick="return alert('belum tersedia :)')" href="#" role="button"
                            data-bs-toggle="" aria-expanded="false">
                            <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                        data-feather="database"></span></span><span
                                    class="nav-link-text-wrapper"><span class="nav-link-text">e-PKP <span
                                            class="badge ms-2 badge-sm badge-phoenix badge-phoenix-danger ">!</span></span></span>
                            </div>
                        </a>
                    </div>

                    <div class="nav-item-wrapper">
                        <a class="nav-link dropdown-indicator label-1 {{ request()->routeIs('profiles.*') ? '' : 'collapsed' }}"
                            href="#nv-profile" role="button" data-bs-toggle="collapse"
                            aria-expanded="{{ request()->is('panel/*') ? 'true' : 'false' }}"
                            aria-controls="nv-profile">
                            <div class="d-flex align-items-center">
                                <div class="dropdown-indicator-icon-wrapper"><span
                                        class="fas fa-caret-right dropdown-indicator-icon"></span></div><span
                                    class="nav-link-icon"><span data-feather="user"></span></span><span
                                    class="nav-link-text">Akun</span>
                            </div>
                        </a>
                        <div class="parent-wrapper label-1">
                            <ul class="nav collapse parent {{ request()->routeIs('profiles.*') ? 'show' : '' }}"
                                data-bs-parent="#navbarVerticalCollapse" id="nv-profile">
                                <li class="collapsed-nav-item-title d-none">Akun
                                </li>
                                <li class="nav-item"><a
                                        class="nav-link {{ request()->routeIs('profiles.index') ? 'active' : '' }}"
                                        href="{{ route('profiles.index') }}">
                                        <div class="d-flex align-items-center"><span
                                                class="nav-link-text">Profil</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="nav-item"><a
                                        class="nav-link {{ request()->routeIs('profiles.edit') ? 'active' : '' }}"
                                        href="{{ route('profiles.edit', Auth::user()->id) }}">
                                        <div class="d-flex align-items-center"><span class="nav-link-text">Ubah
                                                Profile</span>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <div class="navbar-vertical-footer">
        <button
            class="btn navbar-vertical-toggle border-0 fw-semibold w-100 white-space-nowrap d-flex align-items-center">
            <span class="uil uil-left-arrow-to-left fs-8"></span>
            <span class="uil uil-arrow-from-right fs-8"></span>
            <span class="navbar-vertical-footer-text ms-2">
                Collapsed
                View
            </span>
        </button>
    </div>
</nav>
