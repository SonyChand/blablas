<x-auth.layout>
    @slot('title')
        {{ $title }}
    @endslot
    <div class="container">
        <div class="row flex-center min-vh-100 py-5">
            <div class="col-sm-10 col-md-8 col-lg-5 col-xl-5 col-xxl-3"><a
                    class="d-flex flex-center text-decoration-none mb-4" href="{{ asset('assets') }}/index.html">
                    <div class="d-flex align-items-center fw-bolder fs-3 d-inline-block"><img
                            src="{{ asset('assets') }}/assets/img/icons/logo.png" alt="phoenix" width="58" />
                    </div>
                </a>
                <div class="text-center mb-7">
                    <h3 class="text-body-highlight">Sign Up</h3>
                    <p class="text-body-tertiary">Create your account today</p>
                </div>
                <button class="btn btn-phoenix-secondary w-100 mb-3"><span
                        class="fab fa-google text-danger me-2 fs-9"></span>Sign up with google</button>
                <button class="btn btn-phoenix-secondary w-100"><span
                        class="fab fa-facebook text-primary me-2 fs-9"></span>Sign up with facebook</button>
                <div class="position-relative mt-4">
                    <hr class="bg-body-secondary" />
                    <div class="divider-content-center">or use email</div>
                </div>
                <form method="POST" action="{{ route('register') }}" class="needs-validation" novalidate=""
                    onsubmit="showLoader()">
                    @csrf
                    <div class="mb-3 text-start">
                        <label class="form-label" for="name">Name</label>
                        <input class="form-control" id="name" type="text" placeholder="Name" name="name"
                            value="{{ old('name') }}" required autofocus autocomplete="name" />
                    </div>
                    <div class="mb-3 text-start">
                        <label class="form-label" for="email">Email address</label>
                        <input class="form-control" id="email" type="email" placeholder="name@example.com"
                            name="email" value="{{ old('email') }}" required autocomplete="username" />
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-sm-6">
                            <label class="form-label" for="password">Password</label>
                            <div class="position-relative" data-password="data-password">
                                <input class="form-control form-icon-input pe-6" id="password" type="password"
                                    placeholder="Password" data-password-input="data-password-input" type="password"
                                    name="password" required autocomplete="new-password" />

                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label" for="confirmPassword">Confirm Password</label>
                            <div class="position-relative" data-password="data-password">
                                <input class="form-control form-icon-input pe-6" id="confirmPassword" type="password"
                                    placeholder="Confirm Password" data-password-input="data-password-input"
                                    type="password" name="password_confirmation" required autocomplete="new-password" />
                            </div>
                        </div>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" id="termsService" type="checkbox" />
                        <label class="form-label fs-9 text-transform-none" for="termsService">I accept the <a
                                href="#!">terms </a>and <a href="#!">privacy policy</a></label>
                    </div>
                    <button class="btn btn-primary w-100 mb-3">Sign up</button>
                    <div class="text-center"><a class="fs-9 fw-bold" href="{{ route('login') }}">Sign in to an
                            existing
                            account</a></div>
                </form>
            </div>
        </div>
    </div>



</x-auth.layout>
