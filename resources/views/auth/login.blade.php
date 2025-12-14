{{-- resources/views/auth/login.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - {{ config('app.name', 'Akari Store') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --success-gradient: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        }
        
        * {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            min-height: 100vh;
            display: flex;
            overflow: hidden;
        }
        
        /* Left Side - Illustration */
        .auth-illustration {
            flex: 1;
            background: var(--primary-gradient);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 3rem;
            position: relative;
            overflow: hidden;
        }
        
        .auth-illustration::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 100%;
            height: 200%;
            background: rgba(255, 255, 255, 0.03);
            transform: rotate(-30deg);
            border-radius: 50%;
        }
        
        .auth-illustration::after {
            content: '';
            position: absolute;
            bottom: -30%;
            right: -20%;
            width: 80%;
            height: 100%;
            background: rgba(255, 255, 255, 0.05);
            transform: rotate(15deg);
            border-radius: 50%;
        }
        
        .illustration-content {
            position: relative;
            z-index: 1;
            text-align: center;
            color: white;
        }
        
        .illustration-icon {
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            animation: float 3s ease-in-out infinite;
        }
        
        .illustration-icon i {
            font-size: 5rem;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }
        
        .illustration-content h2 {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 1rem;
        }
        
        .illustration-content p {
            font-size: 1.1rem;
            opacity: 0.9;
            max-width: 400px;
            line-height: 1.8;
        }
        
        /* Floating shapes */
        .floating-shape {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: floatRandom 6s ease-in-out infinite;
        }
        
        .shape-1 { width: 80px; height: 80px; top: 10%; left: 15%; animation-delay: 0s; }
        .shape-2 { width: 60px; height: 60px; top: 70%; left: 10%; animation-delay: 1s; }
        .shape-3 { width: 40px; height: 40px; top: 30%; right: 15%; animation-delay: 2s; }
        .shape-4 { width: 50px; height: 50px; bottom: 15%; right: 25%; animation-delay: 1.5s; }
        
        @keyframes floatRandom {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            25% { transform: translate(10px, -10px) rotate(5deg); }
            50% { transform: translate(-5px, -20px) rotate(-5deg); }
            75% { transform: translate(-10px, -5px) rotate(3deg); }
        }
        
        /* Right Side - Form */
        .auth-form-container {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 3rem;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            position: relative;
        }
        
        .auth-form-wrapper {
            width: 100%;
            max-width: 420px;
            animation: slideInRight 0.6s ease;
        }
        
        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        .brand-mobile {
            display: none;
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .brand-mobile a {
            font-size: 1.8rem;
            font-weight: 800;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .auth-card {
            background: white;
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        
        .auth-card-header {
            background: var(--primary-gradient);
            color: white;
            padding: 2rem;
            text-align: center;
        }
        
        .auth-card-header h3 {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .auth-card-header p {
            opacity: 0.9;
            margin: 0;
        }
        
        .auth-card-body {
            padding: 2rem;
        }
        
        .form-floating {
            margin-bottom: 1.25rem;
        }
        
        .form-floating .form-control {
            border: 2px solid #e9ecef;
            border-radius: 12px;
            padding: 1rem 1rem 1rem 3rem;
            height: calc(3.5rem + 2px);
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        
        .form-floating .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }
        
        .form-floating label {
            padding-left: 3rem;
            color: #6c757d;
        }
        
        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #667eea;
            font-size: 1.25rem;
            z-index: 4;
        }
        
        .form-check {
            margin-bottom: 1.5rem;
        }
        
        .form-check-input:checked {
            background-color: #667eea;
            border-color: #667eea;
        }
        
        .btn-auth {
            width: 100%;
            padding: 1rem;
            background: var(--primary-gradient);
            border: none;
            border-radius: 12px;
            color: white;
            font-size: 1.1rem;
            font-weight: 600;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .btn-auth:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
            color: white;
        }
        
        .btn-auth::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: 0.5s;
        }
        
        .btn-auth:hover::before {
            left: 100%;
        }
        
        .auth-card-footer {
            background: #f8f9fa;
            padding: 1.5rem 2rem;
            text-align: center;
            border-top: 1px solid #e9ecef;
        }
        
        .auth-card-footer p {
            margin: 0;
            color: #6c757d;
        }
        
        .auth-card-footer a {
            color: #667eea;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .auth-card-footer a:hover {
            color: #764ba2;
        }
        
        .back-to-home {
            margin-top: 1.5rem;
            text-align: center;
        }
        
        .back-to-home a {
            color: #6c757d;
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }
        
        .back-to-home a:hover {
            color: #667eea;
        }
        
        .invalid-feedback {
            font-size: 0.85rem;
            margin-top: 0.5rem;
        }
        
        /* Divider */
        .divider {
            display: flex;
            align-items: center;
            margin: 1.5rem 0;
            color: #adb5bd;
        }
        
        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #dee2e6;
        }
        
        .divider span {
            padding: 0 1rem;
            font-size: 0.85rem;
        }
        
        /* Responsive */
        @media (max-width: 992px) {
            body {
                flex-direction: column;
            }
            
            .auth-illustration {
                display: none;
            }
            
            .auth-form-container {
                flex: 1;
                min-height: 100vh;
            }
            
            .brand-mobile {
                display: block;
            }
        }
        
        @media (max-width: 576px) {
            .auth-form-container {
                padding: 1.5rem;
            }
            
            .auth-card-header,
            .auth-card-body,
            .auth-card-footer {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Left Side - Illustration -->
    <div class="auth-illustration d-none d-lg-flex">
        <div class="floating-shape shape-1"></div>
        <div class="floating-shape shape-2"></div>
        <div class="floating-shape shape-3"></div>
        <div class="floating-shape shape-4"></div>
        
        <div class="illustration-content">
            <div class="illustration-icon">
                <i class="bi bi-bag-heart-fill"></i>
            </div>
            <h2>Selamat Datang!</h2>
            <p>Masuk ke akun Anda dan nikmati pengalaman berbelanja fashion terbaik bersama kami.</p>
        </div>
    </div>
    
    <!-- Right Side - Form -->
    <div class="auth-form-container">
        <div class="auth-form-wrapper">
            <!-- Mobile Brand -->
            <div class="brand-mobile">
                <a href="{{ url('/') }}">
                    <i class="bi bi-bag-heart-fill"></i>
                    {{ config('app.name', 'Akari Store') }}
                </a>
            </div>
            
            <div class="auth-card">
                <div class="auth-card-header">
                    <h3><i class="bi bi-box-arrow-in-right me-2"></i>Masuk</h3>
                    <p>Masuk ke akun Anda untuk melanjutkan</p>
                </div>
                
                <div class="auth-card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        
                        <!-- Email -->
                        <div class="form-floating position-relative">
                            <i class="bi bi-envelope input-icon"></i>
                            <input type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   placeholder="Email" 
                                   required 
                                   autofocus>
                            <label for="email">Email</label>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Password -->
                        <div class="form-floating position-relative">
                            <i class="bi bi-lock input-icon"></i>
                            <input type="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   id="password" 
                                   name="password" 
                                   placeholder="Password" 
                                   required>
                            <label for="password">Password</label>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Remember Me -->
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">Ingat Saya</label>
                        </div>
                        
                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-auth">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
                        </button>
                    </form>
                </div>
                
                <div class="auth-card-footer">
                    <p>Belum punya akun? <a href="{{ route('register') }}">Daftar Sekarang</a></p>
                </div>
            </div>
            
            <div class="back-to-home">
                <a href="{{ url('/') }}">
                    <i class="bi bi-arrow-left me-1"></i>Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
