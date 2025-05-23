<script>
    var navbarTopStyle = window.config.config.phoenixNavbarTopStyle;
    var navbarTop = document.querySelector('.navbar-top');
    if (navbarTopStyle === 'darker') {
        navbarTop.setAttribute('data-navbar-appearance', 'darker');
    }

    var navbarVerticalStyle = window.config.config.phoenixNavbarVerticalStyle;
    var navbarVertical = document.querySelector('.navbar-vertical');
    if (navbarVertical && navbarVerticalStyle === 'darker') {
        navbarVertical.setAttribute('data-navbar-appearance', 'darker');
    }
</script>
<footer class="footer position-absolute">
    <div class="row g-0 justify-content-between align-items-center h-100">
        <div class="col-12 col-sm-auto text-center">
            <p class="mb-0 mt-2 mt-sm-0 text-body">Sistem Informasi<span class="d-none d-sm-inline-block"></span><span
                    class="d-none d-sm-inline-block mx-1">|</span><br class="d-sm-none" />2024 &copy;<a class="mx-1"
                    href="#">Mitra</a>
            </p>
        </div>
        <div class="col-12 col-sm-auto text-center">
            <p class="mb-0 text-body-tertiary text-opacity-85">By Mahasiswa STMIK MI</p>
        </div>
    </div>
</footer>
</main>
<!-- ===============================================-->
<!--    End of Main Content-->
<!-- ===============================================-->


<div class="offcanvas offcanvas-end settings-panel border-0" id="settings-offcanvas" tabindex="-1"
    aria-labelledby="settings-offcanvas">
    <div class="offcanvas-header align-items-start border-bottom flex-column border-translucent">
        <div class="pt-1 w-100 mb-6 d-flex justify-content-between align-items-start">
            <div>
                <h5 class="mb-2 me-2 lh-sm"><span class="fas fa-palette me-2 fs-8"></span>Kustom Tema</h5>
                <p class="mb-0 fs-9">Kustomisasi tema sesuai preferensi anda</p>
            </div>
            <button class="btn p-1 fw-bolder" type="button" data-bs-dismiss="offcanvas" aria-label="Close"><span
                    class="fas fa-times fs-8"> </span></button>
        </div>
        <button class="btn btn-phoenix-secondary w-100" data-theme-control="reset"><span
                class="fas fa-arrows-rotate me-2 fs-10"></span>Reset</button>
    </div>
    @php
        $periodeTanggalSPMFooter = \App\Models\Backend\SPM\PeriodeSPM::where(
            'tahun_id',
            session('tahun_spm', 1),
        )->first();
        $tahunSPMFooter = \App\Models\Backend\SPM\Tahun::where('id', session('tahun_spm', 1))->first();
    @endphp
    <div class="offcanvas-body scrollbar px-card" id="themeController">
        @if (auth()->user()->roles->first()->id == 1)
            <div class="setting-panel-item mt-0">
                <h5 class="setting-panel-item-title">Periode Tanggal Input StaPMinKes Ciamis
                    {{ $tahunSPMFooter->tahun }}
                </h5>
                <form action="{{ route('spm.periodespm') }}" method="POST" class="needs-validation row gx-2"
                    novalidate>
                    @csrf
                    <div class="col-6">
                        <select name="periode_awal" id="periode_awal" class="form-control">
                            <option value="{{ $periodeTanggalSPMFooter->periode_awal ?? '' }}" hidden>
                                {{ $periodeTanggalSPMFooter->periode_awal ?? 'Pilih Tanggal Awal' }}
                            </option>
                            @for ($i = 1; $i <= 31; $i++)
                                <option value="{{ $i }}"
                                    {{ ($periodeTanggalSPMFooter->periode_awal ?? null) == $i ? 'selected' : '' }}>
                                    {{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-6">
                        <select name="periode_akhir" id="periode_akhir" class="form-control">
                            <option value="{{ $periodeTanggalSPMFooter->periode_akhir ?? '' }}" hidden>
                                {{ $periodeTanggalSPMFooter->periode_akhir ?? 'Pilih Tanggal Akhir' }}
                            </option>
                            @for ($i = 2; $i <= 31; $i++)
                                <option value="{{ $i }}"
                                    {{ ($periodeTanggalSPMFooter->periode_akhir ?? null) == $i ? 'selected' : '' }}>
                                    {{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-12 my-2">
                        <button type="submit" class="btn btn-primary w-100">Simpan</button>
                    </div>
                </form>
            </div>
        @endif
        <div class="setting-panel-item">
            <h5 class="setting-panel-item-title">Skema Warna</h5>
            <div class="row gx-2">
                <div class="col-4">
                    <input class="btn-check" id="themeSwitcherLight" name="theme-color" type="radio" value="light"
                        data-theme-control="phoenixTheme" />
                    <label class="btn d-inline-block btn-navbar-style fs-9" for="themeSwitcherLight"> <span
                            class="mb-2 rounded d-block"><img class="img-fluid img-prototype mb-0"
                                src="{{ asset('assets') }}/assets/img/generic/default-light.png"
                                alt="" /></span><span class="label-text">Terang</span></label>
                </div>
                <div class="col-4">
                    <input class="btn-check" id="themeSwitcherDark" name="theme-color" type="radio" value="dark"
                        data-theme-control="phoenixTheme" />
                    <label class="btn d-inline-block btn-navbar-style fs-9" for="themeSwitcherDark"> <span
                            class="mb-2 rounded d-block"><img class="img-fluid img-prototype mb-0"
                                src="{{ asset('assets') }}/assets/img/generic/default-dark.png"
                                alt="" /></span><span class="label-text"> Gelap</span></label>
                </div>
                <div class="col-4">
                    <input class="btn-check" id="themeSwitcherAuto" name="theme-color" type="radio" value="auto"
                        data-theme-control="phoenixTheme" />
                    <label class="btn d-inline-block btn-navbar-style fs-9" for="themeSwitcherAuto"> <span
                            class="mb-2 rounded d-block"><img class="img-fluid img-prototype mb-0"
                                src="{{ asset('assets') }}/assets/img/generic/auto.png" alt="" /></span><span
                            class="label-text"> Otomatis</span></label>
                </div>
            </div>
        </div>
        <div class="border border-translucent rounded-3 p-4 setting-panel-item bg-body-emphasis">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="setting-panel-item-title mb-1">RTL </h5>
                <div class="form-check form-switch mb-0">
                    <input class="form-check-input ms-auto" type="checkbox" data-theme-control="phoenixIsRTL" />
                </div>
            </div>
            <p class="mb-0 text-body-tertiary">Mengubah arah teks dan gambar</p>
        </div>
        <div class="setting-panel-item">
            <h5 class="setting-panel-item-title">Skema Navbar</h5>
            <div class="row gx-2">
                <div class="col-6">
                    <input class="btn-check" id="navbar-style-default" type="radio" name="config.name"
                        value="default" data-theme-control="phoenixNavbarVerticalStyle" />
                    <label class="btn d-block w-100 btn-navbar-style fs-9" for="navbar-style-default"> <img
                            class="img-fluid img-prototype d-dark-none"
                            src="{{ asset('assets') }}/assets/img/generic/default-light.png" alt="" /><img
                            class="img-fluid img-prototype d-light-none"
                            src="{{ asset('assets') }}/assets/img/generic/default-dark.png" alt="" /><span
                            class="label-text d-dark-none"> Bawaan</span><span
                            class="label-text d-light-none">Bawaan</span></label>
                </div>
                <div class="col-6">
                    <input class="btn-check" id="navbar-style-dark" type="radio" name="config.name"
                        value="darker" data-theme-control="phoenixNavbarVerticalStyle" />
                    <label class="btn d-block w-100 btn-navbar-style fs-9" for="navbar-style-dark"> <img
                            class="img-fluid img-prototype d-dark-none"
                            src="{{ asset('assets') }}/assets/img/generic/vertical-darker.png" alt="" /><img
                            class="img-fluid img-prototype d-light-none"
                            src="{{ asset('assets') }}/assets/img/generic/vertical-lighter.png"
                            alt="" /><span class="label-text d-dark-none"> Gelap</span><span
                            class="label-text d-light-none">Terang</span></label>
                </div>
            </div>
        </div>
        <div class="setting-panel-item">
            <h5 class="setting-panel-item-title">Skema Navbar Atas</h5>
            <div class="row gx-2">
                <div class="col-6">
                    <input class="btn-check" id="navbarTopDefault" name="navbar-top-style" type="radio"
                        value="default" data-theme-control="phoenixNavbarTopStyle" />
                    <label class="btn d-inline-block btn-navbar-style fs-9" for="navbarTopDefault"> <span
                            class="mb-2 rounded d-block"><img class="img-fluid img-prototype d-dark-none mb-0"
                                src="{{ asset('assets') }}/assets/img/generic/top-default.png" alt="" /><img
                                class="img-fluid img-prototype d-light-none mb-0"
                                src="{{ asset('assets') }}/assets/img/generic/top-style-darker.png"
                                alt="" /></span><span class="label-text">Bawaan</span></label>
                </div>
                <div class="col-6">
                    <input class="btn-check" id="navbarTopDarker" name="navbar-top-style" type="radio"
                        value="darker" data-theme-control="phoenixNavbarTopStyle" />
                    <label class="btn d-inline-block btn-navbar-style fs-9" for="navbarTopDarker"> <span
                            class="mb-2 rounded d-block"><img class="img-fluid img-prototype d-dark-none mb-0"
                                src="{{ asset('assets') }}/assets/img/generic/navbar-top-style-light.png"
                                alt="" /><img class="img-fluid img-prototype d-light-none mb-0"
                                src="{{ asset('assets') }}/assets/img/generic/top-style-lighter.png"
                                alt="" /></span><span class="label-text d-dark-none">Gelap</span><span
                            class="label-text d-light-none">Terang</span></label>
                </div>
            </div>
        </div>
    </div>
</div><a class="card setting-toggle" href="#settings-offcanvas" data-bs-toggle="offcanvas">
    <div class="card-body d-flex align-items-center px-2 py-1">
        <div class="position-relative rounded-start" style="height:34px;width:28px">
            <div class="settings-popover"><span class="ripple"><span
                        class="fa-spin position-absolute all-0 d-flex flex-center"><span
                            class="icon-spin position-absolute all-0 d-flex flex-center">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="#ffffff"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M19.7369 12.3941L19.1989 12.1065C18.4459 11.7041 18.0843 10.8487 18.0843 9.99495C18.0843 9.14118 18.4459 8.28582 19.1989 7.88336L19.7369 7.59581C19.9474 7.47484 20.0316 7.23291 19.9474 7.03131C19.4842 5.57973 18.6843 4.28943 17.6738 3.20075C17.5053 3.03946 17.2527 2.99914 17.0422 3.12011L16.393 3.46714C15.6883 3.84379 14.8377 3.74529 14.1476 3.3427C14.0988 3.31422 14.0496 3.28621 14.0002 3.25868C13.2568 2.84453 12.7055 2.10629 12.7055 1.25525V0.70081C12.7055 0.499202 12.5371 0.297594 12.2845 0.257272C10.7266 -0.105622 9.16879 -0.0653007 7.69516 0.257272C7.44254 0.297594 7.31623 0.499202 7.31623 0.70081V1.23474C7.31623 2.09575 6.74999 2.8362 5.99824 3.25599C5.95774 3.27861 5.91747 3.30159 5.87744 3.32493C5.15643 3.74527 4.26453 3.85902 3.53534 3.45302L2.93743 3.12011C2.72691 2.99914 2.47429 3.03946 2.30587 3.20075C1.29538 4.28943 0.495411 5.57973 0.0322686 7.03131C-0.051939 7.23291 0.0322686 7.47484 0.242788 7.59581L0.784376 7.8853C1.54166 8.29007 1.92694 9.13627 1.92694 9.99495C1.92694 10.8536 1.54166 11.6998 0.784375 12.1046L0.242788 12.3941C0.0322686 12.515 -0.051939 12.757 0.0322686 12.9586C0.495411 14.4102 1.29538 15.7005 2.30587 16.7891C2.47429 16.9504 2.72691 16.9907 2.93743 16.8698L3.58669 16.5227C4.29133 16.1461 5.14131 16.2457 5.8331 16.6455C5.88713 16.6767 5.94159 16.7074 5.99648 16.7375C6.75162 17.1511 7.31623 17.8941 7.31623 18.7552V19.2891C7.31623 19.4425 7.41373 19.5959 7.55309 19.696C7.64066 19.7589 7.74815 19.7843 7.85406 19.8046C9.35884 20.0925 10.8609 20.0456 12.2845 19.7729C12.5371 19.6923 12.7055 19.4907 12.7055 19.2891V18.7346C12.7055 17.8836 13.2568 17.1454 14.0002 16.7312C14.0496 16.7037 14.0988 16.6757 14.1476 16.6472C14.8377 16.2446 15.6883 16.1461 16.393 16.5227L17.0422 16.8698C17.2527 16.9907 17.5053 16.9504 17.6738 16.7891C18.7264 15.7005 19.4842 14.4102 19.9895 12.9586C20.0316 12.757 19.9474 12.515 19.7369 12.3941ZM10.0109 13.2005C8.1162 13.2005 6.64257 11.7893 6.64257 9.97478C6.64257 8.20063 8.1162 6.74905 10.0109 6.74905C11.8634 6.74905 13.3792 8.20063 13.3792 9.97478C13.3792 11.7893 11.8634 13.2005 10.0109 13.2005Z"
                                    fill="#2A7BE4"></path>
                            </svg></span></span></span></div>
        </div><small
            class="d-print-none text-uppercase text-body-tertiary fw-bold py-2 pe-2 ps-1 rounded-end">CUSTOM</small>
    </div>
</a>


<!-- ===============================================-->
<!--    JavaScripts-->
<!-- ===============================================-->

<script src="https://cdn.jsdelivr.net/npm/toastr@latest/build/toastr.min.js"></script>
<script src="{{ asset('assets') }}/vendors/popper/popper.min.js"></script>
<script src="{{ asset('assets') }}/vendors/bootstrap/bootstrap.min.js"></script>
<script src="{{ asset('assets') }}/vendors/anchorjs/anchor.min.js"></script>
<script src="{{ asset('assets') }}/vendors/is/is.min.js"></script>
<script src="{{ asset('assets') }}/vendors/fontawesome/all.min.js"></script>
<script src="{{ asset('assets') }}/vendors/lodash/lodash.min.js"></script>
<script src="{{ asset('assets') }}/vendors/list.js/list.min.js"></script>
<script src="{{ asset('assets') }}/vendors/feather-icons/feather.min.js"></script>
<script src="{{ asset('assets') }}/vendors/dayjs/dayjs.min.js"></script>
<script src="{{ asset('assets') }}/assets/js/phoenix.js"></script>
<script src="https://code.jquery.com/jquery-4.0.0-beta.2.js"></script>
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.js"></script>

<script type="text/javascript">
    const reloadTable = () => {
        $('#yajra, #yajra2').DataTable().draw(false);
    }
    const resetForm = (form) => {
        $(form)[0].reset();
    }
</script>
@stack('footer')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@stack('chart')

<div id="loader" data-wordLoad="{{ config('app.name', 'Sistem') . ' - ' . $subtitle }}">
    <div class="waviy">
        <span style="--i:1">L</span>
        <span style="--i:2">O</span>
        <span style="--i:3">A</span>
        <span style="--i:4">D</span>
        <span style="--i:5">I</span>
        <span style="--i:6">N</span>
        <span style="--i:7">G</span>

    </div>
    <img src="{{ asset('assets') }}\assets\img\logo\dinkes.png">
    <div class="waviy">
    </div>
</div>

<script>
    // Function to show the loader
    function showLoader() {
        event.preventDefault();
        event.stopPropagation();
        // Get the form element
        const form = document.querySelector('.needs-validation');
        const loader = document.getElementById('loader');

        // Check if the form is valid
        if (form.checkValidity() === false) {
            // If there are errors, prevent the default form submission
            event.preventDefault();
            event.stopPropagation();

            // Trigger the browser's default validation UI
            form.classList.add('was-validated');
        } else {
            // If the form is valid, show the loader
            loader.style.display = 'block';
            setTimeout(() => {
                loader.classList.add('fade-in');
            }, 50);

            // Submit the form
            form.submit();
        }
    }

    document.onreadystatechange = function() {
        if (document.readyState === "complete") {
            const loader = document.querySelector("#loader");
            loader.classList.add('fade-out');
            setTimeout(() => {
                loader.style.display = "none";
                document.querySelector("body").style.visibility = "visible";
            }, 500); // Match this duration with the CSS transition duration

            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "timeOut": 3000,
                "positionClass": "toast-top-right",
                "preventDuplicates": true
            }

            @if (isset($errors) && $errors->any())
                @foreach ($errors->all() as $error)
                    toastr.error("{{ $error }}");
                @endforeach
            @endif

            @if (session('success'))
                toastr.success("{{ session('success') }}");
            @endif

            @if (session('info'))
                toastr.info("{{ session('info') }}");
            @endif

            @if (session('warning'))
                toastr.warning("{{ session('warning') }}");
            @endif

            @if (session('error'))
                toastr.error("{{ session('error') }}");
            @endif
        }
    };

    function hideLoader() {
        const loader = document.getElementById('loader');
        loader.classList.add('fade-out');
        setTimeout(() => {
            loader.style.display = 'none';
        }, 500); // Match this duration with the CSS transition duration
    }
</script>

</body>

</html>
