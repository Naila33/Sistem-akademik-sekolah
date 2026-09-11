<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        @yield('title', 'Sistem Akademik Sekolah')
    </title>


    {{-- ========================================================= --}}
    {{-- BOOTSTRAP --}}
    {{-- ========================================================= --}}

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    {{-- BOOTSTRAP ICONS --}}
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
        rel="stylesheet"
    >


    {{-- SIDEBAR --}}
    <link
        rel="stylesheet"
        href="{{ asset('css/sidebar.css') }}"
    >


    {{-- ========================================================= --}}
    {{-- GLOBAL STYLE --}}
    {{-- ========================================================= --}}

    <style>

        * {
            box-sizing: border-box;
        }


        html,
        body {
            margin: 0;
            padding: 0;
        }


        body {

            font-family:
                Arial,
                sans-serif;

            background: #f5f6fa;

            color: #333;

        }


        /* ====================================================== */
        /* WRAPPER */
        /* ====================================================== */

        .wrapper {

            display: flex;

            min-height: 100vh;

        }


        /* ====================================================== */
        /* MAIN CONTENT */
        /* ====================================================== */

        .main {

            margin-left: 250px;

            width: calc(100% - 250px);

            min-height: 100vh;

        }


        /* ====================================================== */
        /* NAVBAR */
        /* ====================================================== */

        .navbar {

            height: 65px;

            background: white;

            border-bottom: 1px solid #e5e7eb;

            display: flex;

            align-items: center;

            justify-content: space-between;

            padding: 0 30px;

        }


        .navbar h3 {

            font-size: 18px;

            margin: 0;

            font-weight: 600;

        }


        .admin-info {

            font-size: 14px;

            color: #64748b;

        }


        /* ====================================================== */
        /* CONTENT */
        /* ====================================================== */

        .content {

            padding: 30px;

        }


        /* ====================================================== */
        /* PAGE HEADER */
        /* ====================================================== */

        .page-header {

            margin-bottom: 25px;

        }


        .page-header h1 {

            font-size: 24px;

            margin-bottom: 5px;

        }


        .page-header p {

            color: #64748b;

            font-size: 14px;

        }


        /* ====================================================== */
        /* GLOBAL CARD */
        /* ====================================================== */

        .card {

            border-radius: 10px;

        }


        /* ====================================================== */
        /* TABLE */
        /* ====================================================== */

        .table-wrapper {

            overflow-x: auto;

        }


        table {

            width: 100%;

            border-collapse: collapse;

        }


        th,
        td {

            padding: 12px 15px;

            border-bottom: 1px solid #e5e7eb;

            text-align: left;

            font-size: 14px;

        }


        th {

            background: #f8fafc;

            font-weight: 600;

        }


        /* ====================================================== */
        /* BUTTON */
        /* ====================================================== */

        .btn {

            border-radius: 6px;

        }


        /* ====================================================== */
        /* ALERT */
        /* ====================================================== */

        .alert {

            border-radius: 6px;

        }


        /* ====================================================== */
        /* PENILAIAN MATA PELAJARAN */
        /* ====================================================== */

        /*
        |--------------------------------------------------------------------------
        | SEARCH KELAS
        |--------------------------------------------------------------------------
        */

        .kelas-search-card {

            margin-bottom: 40px;

        }


        .kelas-search {

            max-width: 650px;

        }


        .kelas-search .input-group-text {

            background: #fff;

        }


        .kelas-search .form-control {

            height: 44px;

        }


        .kelas-search .form-control:focus {

            border-color: #198754;

            box-shadow:
                0 0 0 .2rem
                rgba(25, 135, 84, .15);

        }


        /*
        |--------------------------------------------------------------------------
        | GRID KELAS
        |--------------------------------------------------------------------------
        */

        .kelas-grid {

            display: grid;

            grid-template-columns:
                repeat(3, minmax(0, 1fr));

            gap: 24px;

        }


        /*
        |--------------------------------------------------------------------------
        | CARD KELAS
        |--------------------------------------------------------------------------
        */

        .kelas-item {

            min-width: 0;

        }


        .kelas-link {

            display: block;

            height: 100%;

            text-decoration: none;

        }


        .kelas-card {

            height: 100%;

            border-radius: 12px;

            transition:
                transform .2s ease,
                box-shadow .2s ease;

        }


        .kelas-card:hover {

            transform:
                translateY(-5px);

            box-shadow:
                0 10px 25px
                rgba(0, 0, 0, .10)
                !important;

        }


        .kelas-icon {

            transition:
                transform .2s ease;

        }


        .kelas-card:hover
        .kelas-icon {

            transform:
                scale(1.05);

        }


        /*
        |--------------------------------------------------------------------------
        | EMPTY SEARCH
        |--------------------------------------------------------------------------
        */

        .kelas-empty {

            grid-column:
                1 / -1;

        }


        /*
        |--------------------------------------------------------------------------
        | RESPONSIVE KELAS
        |--------------------------------------------------------------------------
        */

        @media (max-width: 991px) {

            .kelas-grid {

                grid-template-columns:
                    repeat(2, minmax(0, 1fr));

            }

        }


        @media (max-width: 575px) {

            .kelas-grid {

                grid-template-columns:
                    1fr;

            }

        }


        /* ====================================================== */
        /* RESPONSIVE MAIN */
        /* ====================================================== */

        @media (max-width: 768px) {

            .main {

                margin-left: 210px;

                width:
                    calc(100% - 210px);

            }


            .content {

                padding: 20px;

            }


            .navbar {

                padding:
                    0 20px;

            }

        }

    </style>


    {{-- STYLE TAMBAHAN JIKA SUATU HALAMAN MEMBUTUHKAN --}}
    @stack('styles')

</head>


<body>


    <div class="wrapper">


        {{-- SIDEBAR --}}
        @include('layouts.sidebar')
    @endif


        {{-- ===================================================== --}}
        {{-- MAIN --}}
        {{-- ===================================================== --}}

        <main class="main">


            {{-- NAVBAR --}}
            <nav class="navbar">

                <h3>

                    @yield(
                        'title',
                        'Dashboard'
                    )

                </h3>


                <div class="admin-info">

                    Administrator

                </div>

            </nav>


            {{-- ================================================= --}}
            {{-- CONTENT --}}
            {{-- ================================================= --}}

            <section class="content">


                {{-- SUCCESS --}}
                @if(session('success'))

                    <div class="alert alert-success">

                        {{ session('success') }}

                    </div>

                @endif


                {{-- ERROR --}}
                @if(session('error'))

                    <div class="alert alert-danger">

                        {{ session('error') }}


                @endif
            </section>


        </main>


    </div>


    {{-- ========================================================= --}}
    {{-- BOOTSTRAP JS --}}
    {{-- ========================================================= --}}

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    ></script>


    {{-- ========================================================= --}}
    {{-- PAGE SCRIPTS --}}
    {{-- ========================================================= --}}

    @stack('scripts')


    {{-- ========================================================= --}}
    {{-- SIDEBAR SCROLL --}}
    {{-- ========================================================= --}}

    <script>

        document.addEventListener(
            'DOMContentLoaded',
            function () {

                const sidebar =
                    document.querySelector(
                        '.sidebar'
                    );

                if (!sidebar) {
                    return;
                }


                const savedScroll =
                    sessionStorage.getItem(
                        'sidebarScroll'
                    );


                if (
                    savedScroll !== null
                ) {

                    sidebar.scrollTop =
                        parseInt(
                            savedScroll
                        );

                }


                sidebar.addEventListener(
                    'scroll',
                    function () {

                        sessionStorage.setItem(
                            'sidebarScroll',
                            sidebar.scrollTop
                        );

                    }
                );

            }
        );

    </script>


</body>

</html>