<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - KebunKita</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-4"></div>
            <div class="card col-md-4">
                <div class="card-body">
                    <h1 class="text-center">Register Kebun Kita</h1>

                    <!-- peringatan jika salah login -->
                    @if(session()->has('error_message'))
                    <div class="alert alert-danger">
                        {{ session()->get('error_message') }}
                    </div>
                    @endif

                    <form method="POST" action="{{ url ('register') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="name" name="name">
                            @if($errors->has('name'))
                            <span class="text-danger">{{$errors->first('name')}}</span>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email">
                            @if($errors->has('email'))
                            <span class="text-danger">{{$errors->first('email')}}</span>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password">
                            @if($errors->has('password'))
                            <span class="text-danger">{{$errors->first('password')}}</span>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                        </div>

                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Daftar</button>
                        </div>
                        <div class="small">
                            Sudah punya akun? <a href="{{ url('login') }}" class="text-decoration-none">Login sekarang!</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

