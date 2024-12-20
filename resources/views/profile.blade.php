<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Profil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    @include('componetskasir.profile')
    
    <div class="container" style="margin-top: 190px; margin-left: 200px;">


        <div class="row">

            <div class="card col-md-4" style="border: 1px solid;">
                <!-- Tampilkan Gambar Profil -->
                <img src="{{ asset('storage/' . Auth::user()->gambar) }}" alt="Profile Image" class="img-thumbnail mb-3 mt-2" style="width: 150px; height: 150px; object-fit: cover;">
                <form action="{{ route('profile.update', Auth::user()->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="gambar" class="form-label">Ubah Foto Profil</label>
                        <input class="form-control" type="file" id="gambar" name="gambar">
                    </div>

                    <button type="submit" class="btn btn-primary mb-2">Simpan Perubahan</button>
                </form>
            </div>
         <div class="card ms-5" style="width: 560px; background-color: #B0E0E6; border: 1px solid;">
            <div class="col mt-4">
                <form class="ms-3">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="name" value="{{ Auth::user()->name }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" value="{{ Auth::user()->email }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Peran</label>
                        <input type="text" class="form-control" id="role" value="{{ Auth::user()->role }}" disabled>
                    </div>
                </form>
            </div>
        </div>
        </div>

<button class="btn btn-primary mt-3"><a class="text-white" href="{{ route('admin.products') }}">back</a>
</button>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
