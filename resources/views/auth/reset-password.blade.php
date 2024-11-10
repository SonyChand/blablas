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
                <div class="text-center mb-6">
                    <h4 class="text-body-highlight">Reset new password</h4>
                    <p class="text-body-tertiary">Type your new password</p>
                    <form method="POST" action="{{ route('password.store') }}" class="needs-validation" novalidate=""
                        onsubmit="showLoader()">
                        @csrf
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">
                        <div class="position-relative mb-2">
                            <input class="form-control form-icon-input pe-6" id="email" type="email"
                                name="email" value="{{ old('email', $request->email) }}" required
                                autocomplete="username" />
                        </div>
                        <div class="position-relative mb-2">
                            <input class="form-control form-icon-input pe-6" id="password" type="password"
                                placeholder="Type new password" name="password" required autocomplete="new-password" />
                        </div>
                        <div class="position-relative mb-4">
                            <input class="form-control form-icon-input pe-6" id="confirmPassword" type="password"
                                placeholder="Confirm new password" name="password_confirmation" required
                                autocomplete="new-password" />
                        </div>
                        <button class="btn btn-primary w-100" type="submit">Set Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-auth.layout>
