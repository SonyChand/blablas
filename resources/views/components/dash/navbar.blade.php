<nav class="navbar navbar-top fixed-top navbar-expand d-print-none mt-4" id="navbarDefault">
    <div class="collapse navbar-collapse justify-content-between">
        <div class="navbar-logo">

            <button class="btn navbar-toggler navbar-toggler-humburger-icon hover-bg-transparent" type="button"
                data-bs-toggle="collapse" data-bs-target="#navbarVerticalCollapse" aria-controls="navbarVerticalCollapse"
                aria-expanded="false" aria-label="Toggle Navigation"><span class="navbar-toggle-icon"><span
                        class="toggle-line"></span></span></button>
            <a class="navbar-brand me-1 me-sm-3" href="{{ route('home.index') }}">
                <div class="d-flex align-items-center">
                    <div class="d-flex align-items-center"><img src="{{ asset('assets') }}\assets\img\logo\dinkes.png"
                            alt="Logo SiDANIS" width="37" />
                        <h5 class="logo-text ms-2 d-none d-sm-block text-lower"
                            style="text-shadow: 1px 1px 10px rgb(203, 195, 195);
                                   background: linear-gradient(90deg, rgb(114, 0, 208), rgb(2, 255, 44));
                                   -webkit-background-clip: text;
                                   -webkit-text-fill-color: transparent;
                                   font-weight: bolder;font-family: mistral;letter-spacing: 5px;">
                            {{ config('app.name', 'Laravel') }}
                        </h5>
                    </div>
                </div>
            </a>
        </div>

        <span class="badge bg-primary">{{ auth::user()->puskesmas->nama ?? 'Anda belum memilih Puskesmas' }}</span>

        <ul class="navbar-nav navbar-nav-icons flex-row">
            <li class="nav-item d-print-none">
                <div class="theme-control-toggle fa-icon-wait px-2">
                    <input class="form-check-input ms-0 theme-control-toggle-input" type="checkbox"
                        data-theme-control="phoenixTheme" value="dark" id="themeControlToggle" />
                    <label class="mb-0 theme-control-toggle-label theme-control-toggle-light" for="themeControlToggle"
                        data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Switch theme"
                        style="height:32px;width:32px;"><span class="icon" data-feather="moon"></span></label>
                    <label class="mb-0 theme-control-toggle-label theme-control-toggle-dark" for="themeControlToggle"
                        data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Switch theme"
                        style="height:32px;width:32px;"><span class="icon" data-feather="sun"></span></label>
                </div>
            </li>
            <li class="nav-item dropdown"><a class="nav-link lh-1 pe-0" id="navbarDropdownUser" href="#!"
                    role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true"
                    aria-expanded="false">
                    <div class="avatar avatar-l ">
                        <img class="rounded-circle "
                            src="{{ Auth::user()->picture ? Storage::url(Auth::user()->picture) : asset('assets/assets/img/team/1.webp') }}"
                            alt="" />

                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end navbar-dropdown-caret py-0 dropdown-profile shadow border"
                    aria-labelledby="navbarDropdownUser">
                    <div class="card position-relative border-0">
                        <div class="card-body p-0">
                            <div class="text-center pt-4 pb-3">
                                <div class="avatar avatar-xl ">
                                    <img class="rounded-circle "
                                        src="{{ Auth::user()->picture ? Storage::url(Auth::user()->picture) : asset('assets/assets/img/team/1.webp') }}"
                                        alt="" />

                                </div>
                                <h6 class="mt-2 text-body-emphasis">
                                    {{ Auth::user()->name }}
                                </h6>
                            </div>
                            <div class="mb-3 mx-3">
                                <input class="form-control form-control-sm" id="statusUpdateInput" type="text"
                                    placeholder="Update your status" />
                            </div>
                        </div>
                        <div class="overflow-auto scrollbar" style="height: 10rem;">
                            <ul class="nav d-flex flex-column mb-2 pb-1">
                                <li class="nav-item"><a
                                        class="nav-link {{ request()->routeIs('profiles.*') ? 'text-primary' : '' }} px-3 d-block"
                                        href="{{ route('profiles.index') }}">
                                        <span class="me-2 text-body align-bottom"
                                            data-feather="user"></span><span>Profil</span></a></li>
                                <li class="nav-item"><a
                                        class="nav-link {{ request()->routeIs('dashboard.*') ? 'text-primary' : '' }} px-3 d-block"
                                        href="{{ route('dashboard.index') }}"><span class="me-2 text-body align-bottom"
                                            data-feather="pie-chart"></span>Dashboard</a></li>
                            </ul>
                        </div>
                        <div class="card-footer p-0 border-top border-translucent">
                            <div class="px-3 my-3">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf

                                    <button class="btn btn-phoenix-secondary d-flex flex-center w-100"
                                        onclick="event.preventDefault();
                                                        this.closest('form').submit();">
                                        {{ __('Sign Out') }}
                                    </button>
                                </form>
                            </div>
                            <div class="my-2 text-center fw-bold fs-10 text-body-quaternary"><a
                                    class="text-body-quaternary me-1" href="#!">Privacy policy</a>&bull;<a
                                    class="text-body-quaternary mx-1" href="#!">Terms</a>&bull;<a
                                    class="text-body-quaternary ms-1" href="#!">Cookies</a></div>
                        </div>
                    </div>
                </div>
            </li>
        </ul>

    </div>
    <style>
        .marquee {
            background-color: black;
            height: 20pt;
            line-height: 20pt;
            overflow: hidden;
            filter: brightness(200%);
        }

        .marquee span {
            display: inline-block;
            vertical-align: middle;
            white-space: nowrap;
            font-weight: 900;
            font-size: 15pt;
            text-shadow: 2px 0px 5px red;
            filter: drop-shadow(0px 0px 5px red);
        }
    </style>
    <marquee class="marquee fixed-top">
        <span class="text-primary text-uppercase align-middle" id="marqueeText">

        </span>
    </marquee>
    @php
        $periodeTanggalSPMMarquee = \App\Models\Backend\SPM\PeriodeSPM::where(
            'tahun_id',
            session('tahun_spm', 1),
        )->first();
        $tahunSPMMarquee = \App\Models\Backend\SPM\Tahun::where('id', session('tahun_spm', 1))->first();
    @endphp
    <script>
        let messages = [];
        @if (!auth()->user()->puskesmas_id)
            messages.push("Anda belum memilih puskesmas");
        @else
            messages.push("{{ auth()->user()->puskesmas->nama }}");
        @endif
        @if (!$periodeTanggalSPMMarquee)
            messages.push("Periode Input SPM Tahun {{ $tahunSPMMarquee->tahun }} pada bulan ini belum diatur");
        @else
            messages.push(
                "Periode Input SPM Tahun {{ $tahunSPMMarquee->tahun }} bulan ini yaitu tanggal {{ $periodeTanggalSPMMarquee->periode_awal }} hingga {{ $periodeTanggalSPMMarquee->periode_akhir }}"
            );
        @endif
        let currentIndex = 0;

        function displayMessage() {
            document.getElementById("marqueeText").textContent = messages[currentIndex];
            const displayDuration = 5000;
            currentIndex = (currentIndex + 1) % messages.length;
            setTimeout(displayMessage, displayDuration);
        }

        displayMessage();
    </script>

</nav>


<div class="content">
    <nav class="mb-3" aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            @if (Breadcrumbs::exists($slot))
                {!! Breadcrumbs::render($slot) !!}
            @endif
        </ol>
    </nav>
