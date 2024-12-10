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
<div class="container">
    <div class="row justify-content-center align-items-center min-vh-100">
        <div class="col-md-6">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header bg-primary text-white text-center py-4">
                    <h2 class="font-weight-light">Selamat Datang di KebunKita</h2>
                </div>
                <div class="card-body p-5">
                    <form action="#" method="POST">
                        @csrf
                        <div class="form-floating mb-3">
                            <label for="email"><i class="fas fa-envelope me-2"></i>Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="petani@gmail.com" required>
                        </div>
                        <div class="form-floating mb-3">
                            <label for="password"><i class="fas fa-lock me-2"></i>Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="remember" name="remember">
                            <label class="form-check-label" for="remember">
                                Ingat Device Ini
                            </label>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-sign-in-alt me-2"></i> Login
                            </button>
                        </div>
                    </form>
                    
                    <div class="text-center my-4">
                        <p class="text-muted">Atau masuk menggunakan</p>
                        <div class="d-flex justify-content-center gap-3">
                            <a href="#" class="btn btn-outline-danger">
                                <i class="fab fa-google me-2"></i> Google
                            </a>
                            <a href="#" class="btn btn-outline-primary">
                                <i class="fab fa-facebook-f me-2"></i> Facebook
                            </a>
                            <a href="#" class="btn btn-outline-success">
                                <i class="fab fa-whatsapp me-2"></i> Whatsapp
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-center py-3">
                    <div class="small mb-2">
                        <a href="#" class="text-decoration-none">
                            <i class="fas fa-key me-2"></i>Lupa Password?
                        </a>
                    </div>
                    <div class="small">
                        Belum punya akun? <a href="#" class="text-decoration-none">Daftar sekarang!</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

@push('styles')
<style>
    body {
        background: linear-gradient(120deg, #84fab0 0%, #8fd3f4 100%);
    }
    .card {
        transition: all 0.3s ease-in-out;
        backdrop-filter: blur(10px);
        background-color: rgba(255, 255, 255, 0.8);
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 1rem 3rem rgba(0,0,0,.175)!important;
    }
    .form-floating input:focus {
        border-color: #8fd3f4;
        box-shadow: 0 0 0 0.25rem rgba(132, 250, 176, 0.25);
    }
    .btn-outline-danger:hover, .btn-outline-primary:hover, .btn-outline-info:hover {
        color: #fff;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const button = this.querySelector('button[type="submit"]');
            button.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Mohon ditunggu...';
            button.disabled = true;
            setTimeout(() => this.submit(), 1000);
        });
    });
</script>
@endpush
