<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Perpustakaan LP3I')</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            font-family: 'Averia Serif Libre';
            margin: 0;
            padding: 0;
            height: 100vh   ;
            display: flex;
            overflow: hidden;
            background-color:white;
        }

        .sidebar {
            width: 280px;
            background-color: #00328E;
            color: white;
            height: 100vh;
            padding-top: 20px;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1000;
            transition: transform 0.3s ease;
        }

        .sidebar-header {
            display: flex;
            align-items: center;
            padding: 0 20px;
            margin-bottom: 20px;
        }

        
        

        .sidebar-header h6 {
            margin: 0;
            font-size: 14px;
            line-height: 1.2;
        }

        .sidebar a {
            color: white;
            display: flex;
            align-items: center;
            padding: 8px 20px;
            text-decoration: none;
            margin-top: 8px;
            transition: all 0.3s ease;
            border-radius: 8px;
            margin-right: 20px;
        }

        .sidebar a.active {
            background-color: white;
            color: #00328E;
        }

        .sidebar a.active img {
            filter: brightness(0) invert(1);
        }

        .sidebar.show {
            transform: translateX(0);
          
        }

        /* Gaya untuk ikon dalam elemen aktif */
.sidebar a.active img {
    filter: brightness(0) saturate(100%) hue-rotate(200deg); /* Ubah warna menjadi biru */
    transition: filter 0.3s ease; /* Tambahkan transisi untuk efek halus */
}

/* Hover untuk elemen aktif */
.sidebar a.active:hover img {
    filter: brightness(0) saturate(200%) hue-rotate(210deg); /* Biru lebih terang pada hover */
}

/* Hover untuk elemen lainnya */
.sidebar a:hover img {
    filter: brightness(0) invert(1) sepia(1) saturate(500%) hue-rotate(200deg); /* Biru standar */
}

/* Reset ke warna asli ketika tidak aktif atau di-hover */
.sidebar a img {
    filter: none;
    transition: filter 0.3s ease;
}


        .sidebarrr a img {
            width: 22px;
            height: 22px;
            margin-right: 15px;
        }
        .sidebar a:hover {
            background-color: #e6eeff;
        }

        .sidebar a.active:hover {
            background-color: white;
        }

        .sidebarrr a img {
            width: 22px;
            height: 22px;
            margin-right: 15px;
            transition: filter 0.3s ease;
        }

        .content {
            padding-top: 60px; /* Adjust this value based on your navbar height */
            margin-left: 280px;
            flex: 1;
            transition: margin-left 0.3s ease;
            position: relative;
            height: 100vh;
        }

        .content.expanded {
            margin-left: 0;
        }

     #logout{
          background-color: #00328E;
          background-color: white; 
          border: 1px solid #00328E;
           color: #00328E; 
           width: 150px;
         border-radius: 8px;
            height: 40px; 
        }

        #logout:hover{
            transform: scale(1.1);
        }


        .navbar {
            background-color: #00328E;
            padding: 10px 20px;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            position: fixed;
            top: 0;
            right: 0;
            left: 280px;
            z-index: 1000;
            height: 60px; /* Adjust this value if needed */
            transition: left 0.3s ease;
        }

        .navbar-right {
            display: flex;
            align-items: center;
        }

        .notification-icon {
            font-size: 20px;
            color: white;
            margin-right: 20px;
        }

        .profile {
            display: flex;
            align-items: center;
        }

        .profile-image {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .profile-name {
            color: white;
        }

        .sidebar-toggler {
            display: none;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: 100vh;
                transform: translateX(-100%);
            }
            
            .sidebar-header img {
               margin-top: 60px;
               max-width: 150px;
            }
            
            .content {
                margin-left: 0;
            }
            .navbar {
                left: 0;
            }
            .sidebar-toggler {
                display: block;
                position: fixed;
                top: 10px;
                left: 10px;
                z-index: 1001;
                cursor: pointer;
                font-size: 24px;
                color: #333;
                background: #fff;
                border: 1px solid #ddd;
                border-radius: 5px;
                padding: 5px 10px;
            }
            .content.expanded {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <div class="sidebar" id="sidebar">
<h4 class="text-center">Petugas Kasir</h4>
        <div class="sidebarrr ms-5 mt-4">
            <a href="{{ route('kasir.dashboard') }}" class="{{ request()->routeIs('kasir.dashboard') ? 'active' : '' }}">
                <img src="{{ asset('images/dashboard (2).png') }}" alt="">Dashboard
            </a>
            <a href="{{ route('kasir.transactions.index') }}" class="{{ request()->routeIs('kasir.transactions.index') ? 'active' : '' }}">
                <img src="{{ asset('images/file.png') }}" alt="">Riwayat Transaksi
            </a>
            <a href="{{ route('kasir.transactions.create') }}" class="{{ request()->routeIs('kasir.transactions.create') ? 'active' : '' }}">
                <img src="{{  asset('images/transaction.png') }}" alt="">Transaksi
            </a>
            <a href="{{ route('kasir.reports.stocks') }}" class="{{ request()->routeIs('kasir.reports.stocks') ? 'active' : '' }}">
                <img src="{{  asset('images/scroll.png') }}" alt="">Laporan Stock
            </a>
            <a href="{{ route('kasir.products') }}" class="{{ request()->routeIs('kasir.products') ? 'active' : '' }}">
                <img src="{{ asset('images/commerce.png') }}" alt="">Manajemen Product
            </a>
           
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" id="logout" class="btn-logout mt-4 ms-3" ><img src="{{ asset('images/logout (2).png') }}" style="width: 22px; height: 22px; margin-right: 13px; " alt="">Logout</button>
            </form>
        </div>
    </div>

    <div class="navbar" id="navbar">
        <div class="navbar-right">
            <div class="profile">
                <a href="{{ route('profile.show') }}" class="text-decoration-none">
                    <img src="{{ Auth::user()->profile_picture_url }}"
                         alt="Profile" class="profile-image">
                    <span class="profile-name">{{ Auth::user()->name }}</span>
                </a>
            </div>
        </div>
    </div>

    <div class="content" id="content">
        @yield('content')
    </div>

    <div class="sidebar-toggler" id="sidebar-toggler">
        ☰
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script>
        document.getElementById('sidebar-toggler').addEventListener('click', function(){
            var sidebar = document.getElementById('sidebar');
            var content = document.getElementById('content');
            var navbar = document.getElementById('navbar');
            sidebar.classList.toggle('show');
            content.classList.toggle('expanded');
        });
    </script>
</body>
</html>