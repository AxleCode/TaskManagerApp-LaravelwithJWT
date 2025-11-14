<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Task Manager App - TES WIT</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    body { background-color:#f8f9fa; }
    .card { border-radius: 1rem; }
</style>
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    @php
                        // pengecekan error register
                        $registerActive = $errors->has('name') || $errors->has('password') || $errors->has('password_confirmation');
                    @endphp
                    
                    <ul class="nav nav-tabs mb-4" id="authTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ !$registerActive ? 'active' : '' }}" id="login-tab" data-bs-toggle="tab" data-bs-target="#login" type="button">Login</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ $registerActive ? 'active' : '' }}" id="register-tab" data-bs-toggle="tab" data-bs-target="#register" type="button">Register</button>
                        </li>
                    </ul>
                    
                    <div class="tab-content" id="authTabContent">
                        <!-- Login -->
                        <div class="tab-pane fade {{ !$registerActive ? 'show active' : '' }}" id="login">
                            @if($errors->any() && !$registerActive)
                                <div class="alert alert-danger">{{ $errors->first() }}</div>
                            @endif
                            <form action="{{ route('login.submit') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <input type="email" name="email" placeholder="Email" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <input type="password" name="password" placeholder="Password" class="form-control" required>
                                </div>
                                <button class="btn btn-primary w-100">Login</button>
                            </form>
                        </div>
                    
                        <!-- Register -->
                        <div class="tab-pane fade {{ $registerActive ? 'show active' : '' }}" id="register">
                            @if($errors->any() && $registerActive)
                                <div class="alert alert-danger">{{ $errors->first() }}</div>
                            @endif
                            <form action="{{ route('register.submit') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <input type="text" name="name" placeholder="Full Name" class="form-control" value="{{ old('name') }}" required>
                                </div>
                                <div class="mb-3">
                                    <input type="email" name="email" placeholder="Email" class="form-control" value="{{ old('email') }}" required>
                                </div>
                                <div class="mb-3">
                                    <input type="password" name="password" placeholder="Password" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <input type="password" name="password_confirmation" placeholder="Confirm Password" class="form-control" required>
                                </div>
                                <button class="btn btn-success w-100">Register</button>
                            </form>
                        </div>
                    </div>
                
                </div>
            </div>
        </div>
    </div>  
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
