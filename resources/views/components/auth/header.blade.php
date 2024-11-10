<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="ltr" data-navigation-type="default" data-navbar-horizontal-shape="default">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <title>{{ config('app.name', 'Laravel') }} - {{ $title }}</title>


    <!-- ===============================================-->
    <!--    Favicons-->
    <!-- ===============================================-->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets') }}/assets/img/favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32"
        href="{{ asset('assets') }}/assets/img/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16"
        href="{{ asset('assets') }}/assets/img/favicons/favicon-16x16.png">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets') }}/assets/img/favicons/favicon.ico">
    <link rel="manifest" href="{{ asset('assets') }}/assets/img/favicons/manifest.json">
    <meta name="msapplication-TileImage" content="{{ asset('assets') }}/assets/img/favicons/mstile-150x150.png">
    <meta name="theme-color" content="#ffffff">
    <script src="{{ asset('assets') }}/vendors/simplebar/simplebar.min.js"></script>
    <script src="{{ asset('assets') }}/assets/js/config.js"></script>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>


    <!-- ===============================================-->
    <!--    Stylesheets-->
    <!-- ===============================================-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&amp;display=swap"
        rel="stylesheet">
    <link href="{{ asset('assets') }}/vendors/simplebar/simplebar.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <link href="{{ asset('assets') }}/assets/css/theme-rtl.css" type="text/css" rel="stylesheet" id="style-rtl">
    <link href="{{ asset('assets') }}/assets/css/theme.min.css" type="text/css" rel="stylesheet" id="style-default">
    <link href="{{ asset('assets') }}/assets/css/user-rtl.min.css" type="text/css" rel="stylesheet"
        id="user-style-rtl">
    <link href="{{ asset('assets') }}/assets/css/user.min.css" type="text/css" rel="stylesheet"
        id="user-style-default">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastr@latest/build/toastr.min.css">
    <script>
        var phoenixIsRTL = window.config.config.phoenixIsRTL;
        if (phoenixIsRTL) {
            var linkDefault = document.getElementById('style-default');
            var userLinkDefault = document.getElementById('user-style-default');
            linkDefault.setAttribute('disabled', true);
            userLinkDefault.setAttribute('disabled', true);
            document.querySelector('html').setAttribute('dir', 'rtl');
        } else {
            var linkRTL = document.getElementById('style-rtl');
            var userLinkRTL = document.getElementById('user-style-rtl');
            linkRTL.setAttribute('disabled', true);
            userLinkRTL.setAttribute('disabled', true);
        }
    </script>
    <style>
        #loader {
            position: fixed;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 9999;
            text-align: center;
            background-color: black;
            vertical-align: middle;
            color: #fff;
            transition: opacity 0.5s ease-in-out;
            opacity: 1;

        }

        #loader.fade-out {
            opacity: 0;
            pointer-events: none;
        }

        #loader img {
            position: absolute;
            top: 40%;
            right: 50%;
            transform: translate(50%, -50%);
            width: 8%;
            z-index: 9999;
            text-align: center;
            vertical-align: middle;
            color: #fff;

        }

        #loader:before {
            content: attr(data-wordLoad);
            color: #fff;
            position: absolute;
            top: calc(50% + 150px);
            left: calc(50% - 90px);
            width: 180px;
            display: table-cell;
            text-align: center;
            vertical-align: middle;
            font-size: 1.5rem;
        }

        .waviy {
            position: absolute;
            top: 60%;
            right: 50%;
            transform: translate(50%, -50%);
            -webkit-box-reflect: below -20px linear-gradient(transparent, rgba(0, 0, 0, .2));
            font-size: 30px;
        }

        .waviy span {
            font-family: 'Alfa Slab One', cursive;
            position: relative;
            display: inline-block;
            color: #fff;
            text-transform: uppercase;
            animation: waviy 1s infinite;
            animation-delay: calc(.1s * var(--i));

        }

        @keyframes waviy {

            0% {
                transform: translateY(0);
                color: cyan;
            }

            60%,
            100% {
                transform: translateY(0);
                color: lawngreen;
            }

            20% {
                transform: translateY(-20px)
            }
        }

        @media only screen and (max-width: 600px) {

            #loader img {
                position: absolute;
                top: 45%;
                right: 50%;
                transform: translate(50%, -50%);
                width: 20%;
                z-index: 9999;
                text-align: center;
                vertical-align: middle;
                color: #fff;

            }

            .waviy {
                position: absolute;
                top: 60%;
                right: 50%;
                transform: translate(50%, -50%);
                -webkit-box-reflect: below -20px linear-gradient(transparent, rgba(0, 0, 0, .2));
                font-size: 20px;
            }
        }
    </style>
</head>


<body>

    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->
    <main class="main" id="top">
