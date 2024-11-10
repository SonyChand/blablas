<x-auth.layout>
    @slot('title')
        {{ $title }}
    @endslot
    <div class="container">
        <div class="row flex-center min-vh-100 py-5">
            <div class="col-sm-10 col-md-8 col-lg-5 col-xxl-4"><a class="d-flex flex-center text-decoration-none mb-4"
                    href="{{ asset('assets') }}/index.html">
                    <div class="d-flex align-items-center fw-bolder fs-3 d-inline-block"><img
                            src="{{ asset('assets') }}/assets/img/icons/logo.png" alt="phoenix" width="58" />
                    </div>
                </a>
                <div class="px-xxl-5">
                    <div class="text-center mb-6">
                        <h4 class="text-body-highlight">Verify Email</h4>
                        <p class="text-body-tertiary mb-0">A new verification link has been sent to the email address
                            you provided during registration. </p>

                    </div>
                    <div class="d-flex justify-content-between text-center">
                        <form class="needs-validation" novalidate="" method="POST"
                            action="{{ route('verification.send') }}" onsubmit="showLoader()">
                            @csrf

                            <div>
                                <button type="submit" class="btn btn-sm btn-primary my-2">
                                    {{ __('Resend Verification Email') }}
                                </button>
                            </div>
                        </form>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <button type="submit" class="btn btn-sm btn-secondary my-2">
                                {{ __('Log Out') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-auth.layout>
