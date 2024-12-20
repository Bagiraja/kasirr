<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        body {
            background-image: url('{{ asset('images/NexTrend.png') }}'); 
          
            background-size: cover; 
         
            background-repeat: no-repeat; 
        }
        .form-container {
            max-width: 500px;
            margin: auto;
            display: flex;
            flex-direction: column;
            justify-content: center;
            height: 60vh;
            background-color: rgba(248, 249, 250, 0.5); 
            border: 1px solid #ced4da;
            border-radius: .25rem;
            padding: 2rem;
        }
    </style>
</head>
<body>
    <div class="container d-flex align-items-center justify-content-center min-vh-100">
        <div class="form-container">
            <h2 class="text-center mb-4">Login</h2>
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email">
                    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" name="password">
                </div>
                <button type="submit" class="btn w-100" style="background-color: white;">Submit</button>
            </form>
           <span>Don't have account?<a href="{{ route("register") }}" class="mt-4 ms-2" style="color: black; text-decoration: none;">Register</a></span> 
        </div>
    </div>
</body>
</html>
