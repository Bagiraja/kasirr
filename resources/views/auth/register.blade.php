<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <style>
         body {
            background-image: url('{{ asset('images/NexTrend.png') }}'); 
          
            background-size: cover; 
            /* Menutupi seluruh area */
            
            background-repeat: no-repeat; /* Jangan ulang gambar */
        }
        .form-container {
            max-width: 500px;
            margin: auto;
            display: flex;
            flex-direction: column;
            justify-content: center;
            height: 60vh;
            background-color: rgba(248, 249, 250, 0.5); /* Warna latar belakang semi-transparan */
            border: 1px solid #ced4da;
            border-radius: .25rem;
            padding: 2rem;
        }
    </style>
</head>
<body>
    <div class="container d-flex align-items-center justify-content-center min-vh-100">
        <div class="form-container">
        <h2 class="text-center">Register</h2>
        <form action="{{ route('register') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
                  <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
            </div>
            <div class="d-flex gap-2">
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
            </div>
        </div>
            <button type="submit" class="btn btn-primary w-100">Register</button>
        </form>
    </div>
    </div>
</body>
</html>
