<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <!-- CSS files -->
    <link href="{{ asset('dist/css/tabler.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('dist/css/tabler-flags.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('dist/css/tabler-payments.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('dist/css/tabler-vendors.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('dist/css/demo.min.css') }}" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JS Bundle (includes Popper.js) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>


    <style>
    @import url('https://rsms.me/inter/inter.css');

    :root {
        --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
    }

    body {
        font-feature-settings: "cv03", "cv04", "cv11";

    }

    html,
    body {
        height: 100%;
        margin: 0;
        overflow: hidden;
        /* Prevent body from scrolling */
    }

    .wrapper {
        display: flex;
        height: 100vh;
        /* Full viewport height */
    }

    .page-wrapper {
        flex-grow: 1;
        /* Allow it to take the remaining space */
        display: flex;
        flex-direction: column;
        overflow: hidden;
        /* Prevent overflow */
    }

    .main-content {
        flex-grow: 1;
        /* Allow content to grow */
        overflow-y: auto;
        /* Enable scrolling */
        padding: 20px;
        /* Adjust padding as needed */
    }




    .form-control:focus {
        box-shadow: none;
    }

    .wrapper {
        display: flex;
        height: 100vh;
        /* Full height of the viewport */
    }

    .sidebar {
        display: block;
        width: 250px;
        background-color: #e2e6e9;
        padding: 20px;
        height: 100%;
        transition: width 0.3s ease;
    }

    .hidden {
        width: 90px;
    }

    .page-wrapper {
        flex: 1;
        padding: 20px;
        overflow-y: auto;
    }

    .header {
        position: sticky !important;
        top: 0;
        z-index: 1000;
    }

    .sidebar {
        display: block;
    }

    .hidden .nav-link-title {
        display: none;
    }

    .nav-link-title {
        font-size: bold;
    }

    .nav-link {
        font-size: 1.2rem;
        color: #333;
        padding: 15px;
    }

    .nav-link-icon {
        width: 32px;
        height: 32px;
        color: #000;
        display: none;
    }

    .nav-link-icon svg {
        stroke: currentColor;
        font-weight: bold;
    }

    .nav-link:hover {
        color: #007bff;
    }




    /* Media query for mobile view */
    @media (max-width: 480px) {
        .sidebar {
            display: none;
            width: 130px;
            background-color: #e2e6e9;
        }

        .sidebar.visible {
            display: block;
        }

        .nav-link-title {
            font-size: 10px;
            color: black;
        }

        .navbar-brand {
            font-size: 10px;
        }

        .footer  {
            margin-left: -100px;
        }

        .footer-transparent {
            font-size: 70px;
            padding: 10px;
        }

        .toggleSidebar {
        margin-left: 0; /* Reset margin to make it visible */
        position: absolute; /* Position it where needed */
        right: 10px; /* Positioning from the right */
        top: 10px; /* Positioning from the top */
        display: block; /* Ensure it's visible */
    }

    }

    .marginleftcss {
        margin-left: 30px !important
    }

    .toggleSidebar {
        margin-left: -138px !important
    }

    .footer-transparent {
        background-color: #e2e6e9;
        border-top: 0;
        padding: 45px;
    }
   
    
    </style>

    {{-- - Page Styles - --}}
    @stack('page-styles')
    @livewireStyles

</head>

<body>
    <script src="{{ asset('dist/js/demo-theme.min.js') }}"></script>

    <header class="navbar navbar-expand-md d-print-none">
        <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal marginleftcss">
            <a href="{{ url('/') }}">
                <img src="{{ asset('assets/img/Walstar-logo.png') }}" width="110" height="32" alt="Tabler"
                    class="navbar-brand-image"> IMS
            </a>
        </h1>
        <div class="container-xl">
            <button class="navbar-toggler toggleSidebar" type="button" id="toggleSidebar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="navbar-nav flex-row order-md-last">
                <div class="d-none d-md-flex">

                    {{-- -
                            <a href="?theme=dark" class="nav-link px-0 hide-theme-dark" title="Enable dark mode" data-bs-toggle="tooltip"
                               data-bs-placement="bottom">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 3c.132 0 .263 0 .393 0a7.5 7.5 0 0 0 7.92 12.446a9 9 0 1 1 -8.313 -12.454z" /></svg>
                            </a>
                            <a href="?theme=light" class="nav-link px-0 hide-theme-light" title="Enable light mode" data-bs-toggle="tooltip"
                               data-bs-placement="bottom">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M3 12h1m8 -9v1m8 8h1m-9 8v1m-6.4 -15.4l.7 .7m12.1 -.7l-.7 .7m0 11.4l.7 .7m-12.1 -.7l-.7 .7" /></svg>
                            </a>
                            - --}}

                    <div class="nav-item dropdown d-none d-md-flex me-3">
                        <a href="#" class="nav-link px-0" data-bs-toggle="dropdown" tabindex="-1"
                            aria-label="Show notifications">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path
                                    d="M10 5a2 2 0 1 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6" />
                                <path d="M9 17v1a3 3 0 0 0 6 0v-1" />
                            </svg>

                            @if (auth()->user()->unreadNotifications->count() !== 0)
                            <span class="badge bg-red"></span>
                            @endif
                        </a>
                        <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-end dropdown-menu-card">

                            {{--                                    <div class="card"> --}}
                            {{--                                        <div class="card-header"> --}}
                            {{--                                            <h3 class="card-title">Last updates</h3> --}}
                            {{--                                        </div> --}}
                            {{--                                        <div class="list-group list-group-flush list-group-hoverable"> --}}

                            {{--                                            @foreach (auth()->user()->unreadNotifications as $notification) --}}
                            {{--                                                <a href="#" class="text-success"> --}}
                            {{--                                                    <li class="p-1 text-success"> {{$notification->data['data']}}
                            </li> --}}
                            {{--                                                </a> --}}
                            {{--                                                <div class="list-group-item"> --}}
                            {{--                                                    <div class="row align-items-center"> --}}
                            {{--                                                        <div class="col-auto"><span class="status-dot status-dot-animated bg-red d-block"></span></div> --}}
                            {{--                                                        <div class="col text-truncate"> --}}
                            {{--                                                            <a href="#" class="text-body d-block">Example 1</a> --}}
                            {{--                                                            <div class="d-block text-muted text-truncate mt-n1"> --}}
                            {{--                                                                Change deprecated html tags to text decoration classes (#29604) --}}
                            {{--                                                            </div> --}}
                            {{--                                                        </div> --}}
                            {{--                                                        <div class="col-auto"> --}}
                            {{--                                                            <a href="#" class="list-group-item-actions"> --}}
                            {{--                                                                <!-- Download SVG icon from http://tabler-icons.io/i/star --> --}}
                            {{--                                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon text-muted" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z" /></svg> --}}
                            {{--                                                            </a> --}}
                            {{--                                                        </div> --}}
                            {{--                                                    </div> --}}
                            {{--                                                </div> --}}
                            {{--                                            @endforeach --}}
                            {{--                                        </div> --}}
                            {{--                                    </div> --}}
                            <span class="dropdown-header">Dropdown header</span>
                            <a class="dropdown-item" href="#">
                                Action
                            </a>
                            <a class="dropdown-item" href="#">
                                Another action
                            </a>
                        </div>
                    </div>

                    {{-- -
                            <div class="dropdown">
                                <a href="#" class="btn dropdown-toggle" data-bs-toggle="dropdown">Open dropdown</a>
                                <div class="dropdown-menu">
                                    <span class="dropdown-header">Dropdown header</span>
                                    <a class="dropdown-item" href="#">
                                        Action
                                    </a>
                                    <a class="dropdown-item" href="#">
                                        Another action
                                    </a>
                                </div>
                            </div>
                            - --}}

                </div>

                <div class="nav-item dropdown">
                    <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown"
                        aria-label="Open user menu">
                        <span class="avatar avatar-sm shadow-none"
                            style="background-image: url({{ Auth::user()->photo ? asset('storage/profile/' . Auth::user()->photo) : asset('assets/img/illustrations/profiles/admin.jpg') }})">
                        </span>

                        <div class="d-none d-xl-block ps-2">
                            <div>{{ Auth::user()->name }}</div>
                            {{--                                    <div class="mt-1 small text-muted">UI Designer</div> --}}
                        </div>
                    </a>
                    <div class="dropdown-menu">
                        <a href="{{ route('profile.edit') }}" class="dropdown-item">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="icon dropdown-item-icon icon-tabler icon-tabler-settings" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path
                                    d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z">
                                </path>
                                <path d="M12 12m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"></path>
                            </svg>
                            Account
                        </a>
                        <form action="{{ route('logout') }}" method="post">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="icon dropdown-item-icon icon-tabler icon-tabler-logout" width="24"
                                    height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path
                                        d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2" />
                                    <path d="M9 12h12l-3 -3" />
                                    <path d="M18 15l3 -3" />
                                </svg>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>

                {{-- -
                        <div class="dropdown">
                            <a href="#" class="btn dropdown-toggle" data-bs-toggle="dropdown">Open dropdown</a>
                            <div class="dropdown-menu">

                                <a class="dropdown-item" href="#">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon dropdown-item-icon icon-tabler icon-tabler-settings" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z"></path>
                                        <path d="M12 12m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"></path>
                                    </svg>
                                    Action
                                </a>
                                <a class="dropdown-item" href="#">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon dropdown-item-icon icon-tabler icon-tabler-pencil" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M4 20h4l10.5 -10.5a1.5 1.5 0 0 0 -4 -4l-10.5 10.5v4"></path>
                                        <path d="M13.5 6.5l4 4"></path>
                                    </svg>
                                    Another action
                                </a>
                            </div>
                        </div>
                        - --}}


            </div>
        </div>
    </header>

    <div class="wrapper">

        @include('layouts.sidebar')
        <div class="page-wrapper">
            <div class="main-content">
                @yield('content')
            </div>
            @include('layouts.footer')

        </div>
    </div>









    <!-- Libs JS -->
    @stack('page-libraries')
    <!-- Tabler Core -->
    <script src="{{ asset('dist/js/tabler.min.js') }}" defer></script>
    <script src="{{ asset('dist/js/demo.min.js') }}" defer></script>
    {{-- - Page Scripts - --}}
    @stack('page-scripts')

    @livewireScripts

    <script>
    document.getElementById('toggleSidebar').addEventListener('click', function() {
        const sidebar = document.getElementById('sidebar');
        // sidebar.classList.toggle('hidden');

        if (window.innerWidth <= 480) {
            sidebar.classList.toggle('visible'); // Toggle visible for mobile view
        } else {
            sidebar.classList.toggle('hidden'); // Toggle hidden for larger screens
        }
    });
    </script>


</body>

</html>