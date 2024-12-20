<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Navbar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar {
            width: calc(100% - 320px);
            position: fixed;
            top: 0;
            left: 320px;
            z-index: 1000;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #B0E0E6;
            border-radius: 4px;
            padding: 10px;
        }
        .profile-image {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }
        .profile-name {
            color: white;
            margin-left: 10px;
        }
        .profile-container {
            display: flex;
            align-items: center;
            margin-left: auto; /* Make sure profile-container is pushed to the right */
        }
     

        /* Media query for screens smaller than 768px */
        @media (max-width: 768px) {
            .navbar {
                width: 100%;
                left: 0;
                padding: 10px;
                justify-content: space-between;
            }
            .navbar-brand {
                display: none; /* Hide brand name on small screens */
            }
            .profile-container {
                margin-left: auto; /* Ensure profile container is on the right */
            }
        }

        /* Media query for screens smaller than 576px */
        @media (max-width: 576px) {
            .navbar-brand {
                font-size: 16px; /* Reduce font size for smaller screens */
            }
            .profile-image {
                width: 30px;
                height: 30px; /* Reduce profile image size */
            }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <a class="navbar-brand fw-bold ms-2" href="#" style="font-size: 18px; color: white;">Laporan Stock</a>
        <div class="profile-container">
            <img src="{{ asset('storage/' . Auth::user()->gambar) }}" alt="Profile Image" class="profile-image">
            <span class="profile-name">{{ Auth::user()->name }}</span>
            <div class="dropdown ms-3">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    ▼
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                    <li><a class="dropdown-item" href="{{ route('main.profile') }}">Profil</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-logout">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
