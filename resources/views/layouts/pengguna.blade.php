<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
     
        body {
            font-family: Arial, sans-serif;
            display: flex;
            margin: 0;
            padding: 0;
            height: 100vh;
        }
        .sidebar {
            width: 300px;
            background-color: #B0E0E6;
            border-top-right-radius: 20px;
            border-bottom-right-radius: 20px;
            color: black;
            min-height: 100vh;
            padding-top: 20px;
        }
        .sidebar h2 {
            font-size: 20px;
            text-align: center;
            margin-bottom: 30px;
        }
        .sidebar a {
            color: black;
            border-radius: 5px;
            display: block;
            background-color: white;
            padding: 10px 20px;
            text-decoration: none;
            width: 98%;
            margin: 5px 0;
            transition: background-color 0.3s ease;
        }
        .sidebar a:hover {
            background-color: black;
            color: white;
        }
        .content {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
        }

        .sidebarrr{
            margin-left: 8px;
        }
        .btn-logout {
            display: block;
            width: 80%;
            margin: 20px auto;
            height: 5vh;
            text-align: center;
            font-size: 17px;
            background-color: #dc3545;
            border-radius: 5px;
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .btn-logout:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2 class="fw-bold">Admin</h2>
        <div class="sidebarrr">
        <a href="{{ route('barang.products') }}">Manajemen Produk</a>
    </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn-logout">Logout</button>
        </form>
    </div>
    <div class="content">
        @yield('content')
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-pzjw8f+ua7Kw1TIq3A4uRz5XzO1X8a3xURgSroP6Xn1ptFvLwF7M9E2/J4LgO0C0" crossorigin="anonymous"></script>
</body>
</html>
