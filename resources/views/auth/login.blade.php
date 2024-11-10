<x-auth.layout>
    @slot('title')
        {{ $title }}
    @endslot
    <div class="row vh-100 g-0">
        <div class="col-lg-6 position-relative d-none d-lg-block">
            <div class="bg-holder" style="background-image:url({{ asset('assets/') }}/assets/img/bg/dinkes2.jpg);"><img
                    src="{{ asset('assets') }}\assets\img\logos\logoDinkes.png" alt="phoenix" width="58"
                    style="position: absolute; top: 20px; left: 20px;" />
            </div>

            <!--/.bg-holder-->

        </div>
        <div class="col-lg-6">
            <div class="row flex-center h-100 g-0 px-4 px-sm-0">
                <div class="col-sm-10 col-md-8 col-lg-5 col-xl-5 col-xxl-3">
                    <a href="{{ route('home.index') }}" alt="phoenix" width="58"
                        style="position: absolute; top: 20px; right: 20px;"
                        class="btn btn-sm btn-outline-primary">Beranda</a>
                    <a class="d-flex flex-center text-decoration-none mb-4" href="{{ route('home.index') }}">
                        <div class="d-flex align-items-center fw-bolder fs-3 d-inline-block"><img
                                src="{{ asset('assets') }}\assets\img\logos\logoDinkes.png" alt="phoenix"
                                width="58" />
                        </div>
                    </a>
                    <div class="text-center mb-7">
                        <h3 class="text-body-highlight">Sign In</h3>
                        <p class="text-body-tertiary">masuk ke {{ config('app.name', 'Laravel') }}</p>
                    </div>
                    <form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate=""
                        onsubmit="showLoader()">
                        @csrf
                        <div class="mb-3 text-start">
                            <label class="form-label" for="email">Email address</label>
                            <div class="form-icon-container">
                                <input class="form-control form-icon-input" id="email" type="email"
                                    placeholder="name@example.com" name="email" value="{{ old('email') }}" required
                                    autofocus autocomplete="username" /><span
                                    class="fas fa-user text-body fs-9 form-icon"></span>
                            </div>
                            <div class="valid-feedback">Looks good!</div>
                        </div>
                        <div class="mb-3 text-start">
                            <label class="form-label" for="password">Password</label>
                            <div class="form-icon-container" data-password="data-password">
                                <input class="form-control form-icon-input pe-6" id="password" type="password"
                                    placeholder="Password" data-password-input="data-password-input" name="password"
                                    required autocomplete="current-password" /><span
                                    class="fas fa-key text-body fs-9 form-icon"></span>
                            </div>
                        </div>
                        <div class="row flex-between-center mb-7">
                            <div class="col-auto">
                                <div class="form-check mb-0">
                                    <input class="form-check-input" id="remember" type="checkbox" name="remember" />
                                    <label class="form-check-label mb-0" for="remember">Remember me</label>
                                </div>
                            </div>
                            <div class="col-auto"><a class="fs-9 fw-semibold"
                                    href="{{ route('password.request') }}">Forgot
                                    Password?</a>
                            </div>
                        </div>
                        <button class="btn btn-primary w-100 mb-3">Sign In</button>
                    </form>
                    <div class="text-center"><a class="fs-9 fw-bold" href="{{ route('register') }}">Create an
                            account</a>
                    </div>
                </div>
            </div>
        </div>
    </div>




</x-auth.layout>
