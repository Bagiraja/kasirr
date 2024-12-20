<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Navbar</title>
   
    <style>
        .navbar {
            width: calc(100% - 335px);
            position: fixed;
            top: 0;
            left: 335px;
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
            cursor: pointer;
        }
        .profile-container {
            position: relative;
            display: flex;
            align-items: center;
            margin-left: auto;
        }
        .profile-menu {
            display: none;
            position: absolute;
            top: 50px;
            right: 10;
            background-color: white;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 4px;
            padding: 10px;
            z-index: 1001;
        }
        .profile-menu a, .profile-menu form {
            display: block;
            margin-bottom: 10px;
            text-decoration: none;
            color: black;
            font-size: 14px;
        }
        .profile-menu form {
            margin: 0;
        }
        .profile-menu form button {
            background: none;
            border: none;
            padding: 0;
            color: black;
            cursor: pointer;
            font-size: 14px;
        }
        .profile-menu a:hover, .profile-menu button:hover {
    
        }

        #log{
            background-color: red;
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
        <a class="navbar-brand fw-bold ms-2" href="#" style="font-size: 18px; color: white;">Tambah Product</a>
        <div class="profile-container">
            <img src="{{ asset('storage/' . Auth::user()->gambar) }}" alt="Profile Image" class="profile-image" id="profileImage">
            <span class="profile-name ms-2 me-2 text-white">{{ Auth::user()->name }}</span>
            <div class="profile-menu" id="profileMenu">
                <a href="{{ route('main.profile') }}">Profil</a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger text-white" id="log">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <script>
        // Toggle the profile menu when the profile image is clicked
        document.getElementById('profileImage').addEventListener('click', function() {
            var profileMenu = document.getElementById('profileMenu');
            profileMenu.style.display = profileMenu.style.display === 'block' ? 'none' : 'block';
        });

        // Close the profile menu if clicked outside
        document.addEventListener('click', function(event) {
            var profileImage = document.getElementById('profileImage');
            var profileMenu = document.getElementById('profileMenu');
            if (!profileImage.contains(event.target) && !profileMenu.contains(event.target)) {
                profileMenu.style.display = 'none';
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
