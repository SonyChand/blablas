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

                    <div class="text-center mb-5">
                        <h4 class="text-body-highlight">Forgot your password?</h4>
                        <p class="text-body-tertiary mb-2">Enter your email below and we will send <br
                                class="d-sm-none" />you a reset link</p>
                        <form class="d-flex align-items-center mb-5 needs-validation" method="POST"
                            action="{{ route('password.email') }}" novalidate="" onsubmit="showLoader()">
                            @csrf
                            <input class="form-control flex-1" type="email" name="email" value="{{ old('email') }}"
                                required autofocus />


                            <button class="btn btn-primary ms-2" type="submit">Send<span
                                    class="fas fa-chevron-right ms-2"></span></button>
                        </form>

                        <a class="fs-9 fw-bold" href="{{ route('login') }}">to Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-auth.layout>
