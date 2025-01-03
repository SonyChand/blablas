<x-auth.layout>
    @slot('title')
        Halaman Tidak Ditemukan
    @endslot
    <main class="main" id="top">
        <div class="px-3">
            <div class="row min-vh-100 flex-center p-5">
                <div class="col-12 col-xl-10 col-xxl-8">
                    <div class="row justify-content-center align-items-center g-5 text-center">
                        <div class="col-12" style="font-family: “Brush Script MT”, cursive;">
                            <h1 class="display-1 fw-bold text-primary"
                                style="font-size: 10rem !important; text-shadow: 1px 1px 10px rgb(117, 216, 225);
                                   background: linear-gradient(90deg, rgb(140, 0, 255), rgb(6, 255, 2));
                                   -webkit-background-clip: text;
                                   -webkit-text-fill-color: transparent;
                                   font-weight: bolder;font-family: mistral;letter-spacing: 10px;">
                                504</h1>
                            <h2 class="text-body-secondary fw-bolder mb-3">Gateway Timeout!</h2>
                            <p class="text-body mb-5">Server tidak menerima respons tepat waktu dari server upstream.
                            </p>
                            @php
                                $previousUrl = url()->previous();
                                $currentUrl = url()->current();
                            @endphp

                            @if ($previousUrl === $currentUrl)
                                <a class="btn btn-sm btn-primary" href="{{ route('login') }}">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </a>
                            @else
                                <a class="btn btn-sm btn-primary" href="{{ $previousUrl }}">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
    </main>
</x-auth.layout>
