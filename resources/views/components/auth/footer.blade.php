</main>
<!-- ===============================================-->
<!--    End of Main Content-->
<!-- ===============================================-->



<!-- ===============================================-->
<!--    JavaScripts-->
<!-- ===============================================-->
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

            @if ($errors->any())
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
