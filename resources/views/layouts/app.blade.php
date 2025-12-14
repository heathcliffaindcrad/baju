{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - {{ config('app.name', 'Akari Store') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --success-gradient: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            --dark-gradient: linear-gradient(135deg, #232526 0%, #414345 100%);
            --glass-bg: rgba(255, 255, 255, 0.1);
            --glass-border: rgba(255, 255, 255, 0.2);
        }
        
        * {
            font-family: 'Poppins', sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }
        
        /* Modern Navbar */
        .navbar-modern {
            background: var(--primary-gradient);
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            padding: 1rem 0;
            position: relative;
            z-index: 1100;
        }
        
        .navbar-modern .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: white !important;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .navbar-modern .nav-link {
            color: rgba(255, 255, 255, 0.9) !important;
            font-weight: 500;
            padding: 0.5rem 1rem !important;
            border-radius: 8px;
            transition: all 0.3s ease;
            margin: 0 0.25rem;
        }
        
        .navbar-modern .nav-link:hover {
            background: var(--glass-bg);
            color: white !important;
            transform: translateY(-2px);
        }
        
        .navbar-modern .dropdown-menu {
            background: white;
            border: none;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            padding: 0.5rem;
            margin-top: 0.5rem;
            z-index: 1050;
        }
        
        .navbar-modern .dropdown-item {
            border-radius: 8px;
            padding: 0.75rem 1rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }
        
        .navbar-modern .dropdown-item:hover {
            background: var(--primary-gradient);
            color: white;
        }
        
        /* Modern Cards */
        .card-modern {
            background: white;
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            overflow: hidden;
        }
        
        .card-modern:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 40px rgba(0, 0, 0, 0.12);
        }
        
        .card-modern .card-header {
            background: transparent;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            padding: 1.25rem 1.5rem;
            font-weight: 600;
        }
        
        .card-modern .card-body {
            padding: 1.5rem;
        }
        
        /* Product Cards */
        .product-card {
            background: white;
            border: none;
            border-radius: 20px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            overflow: hidden;
        }
        
        .product-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 20px 40px rgba(102, 126, 234, 0.2);
        }
        
        .product-card .product-img {
            height: 220px;
            object-fit: cover;
            transition: transform 0.4s ease;
        }
        
        .product-card:hover .product-img {
            transform: scale(1.1);
        }
        
        .product-card .card-body {
            padding: 1.5rem;
        }
        
        .product-card .price-tag {
            background: var(--success-gradient);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 700;
            display: inline-block;
        }
        
        /* Modern Buttons */
        .btn-modern {
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            font-weight: 600;
            border: none;
            transition: all 0.3s ease;
        }
        
        .btn-modern-primary {
            background: var(--primary-gradient);
            color: white;
        }
        
        .btn-modern-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
            color: white;
        }
        
        .btn-modern-success {
            background: var(--success-gradient);
            color: white;
        }
        
        .btn-modern-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(17, 153, 142, 0.4);
            color: white;
        }
        
        /* Stat Cards */
        .stat-card-modern {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }
        
        .stat-card-modern:hover {
            transform: translateY(-5px);
        }
        
        .stat-card-modern.gradient-1 {
            background: var(--primary-gradient);
            color: white;
        }
        
        .stat-card-modern.gradient-2 {
            background: var(--success-gradient);
            color: white;
        }
        
        .stat-card-modern.gradient-3 {
            background: var(--secondary-gradient);
            color: white;
        }
        
        .stat-card-modern.gradient-4 {
            background: var(--dark-gradient);
            color: white;
        }
        
        /* Badge Modern */
        .badge-modern {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 500;
            font-size: 0.75rem;
        }
        
        /* Footer Modern */
        .footer-modern {
            background: var(--dark-gradient);
            color: rgba(255, 255, 255, 0.8);
            padding: 3rem 0 2rem;
        }
        
        .footer-modern h5 {
            color: white;
            font-weight: 600;
            margin-bottom: 1rem;
        }
        
        /* Alerts Modern */
        .alert-modern {
            border: none;
            border-radius: 12px;
            padding: 1rem 1.5rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        
        /* Table Modern */
        .table-modern {
            border-collapse: separate;
            border-spacing: 0;
        }
        
        .table-modern thead th {
            background: var(--primary-gradient);
            color: white;
            padding: 1rem;
            font-weight: 600;
            border: none;
        }
        
        .table-modern thead th:first-child {
            border-radius: 12px 0 0 0;
        }
        
        .table-modern thead th:last-child {
            border-radius: 0 12px 0 0;
        }
        
        .table-modern tbody td {
            padding: 1rem;
            vertical-align: middle;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }
        
        .table-modern tbody tr:hover {
            background: rgba(102, 126, 234, 0.05);
        }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 10px;
        }
        
        /* Animation */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .animate-fadeInUp {
            animation: fadeInUp 0.6s ease forwards;
        }
        
        .notification-badge { 
            position: absolute; 
            top: 5px; 
            right: 5px; 
        }
    </style>
    @stack('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-modern">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="bi bi-bag-heart-fill"></i> {{ \App\Models\Setting::getSettings()->store_name }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    @auth
                        @if(auth()->user()->isAdmin())
                            {{-- Admin Navigation --}}
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                                    <i class="bi bi-speedometer2"></i> Dashboard
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown">
                                    <i class="bi bi-gear-fill"></i> Kelola
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('admin.products.index') }}"><i class="bi bi-box"></i> Produk</a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.categories.index') }}"><i class="bi bi-tags"></i> Kategori</a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.users.index') }}"><i class="bi bi-people"></i> Pengguna</a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.transactions.index') }}"><i class="bi bi-receipt"></i> Transaksi</a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.reports.index') }}"><i class="bi bi-file-earmark-bar-graph"></i> Laporan</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.settings.edit') }}"><i class="bi bi-sliders"></i> Pengaturan</a></li>
                                </ul>
                            </li>
                        @else
                            {{-- Customer Navigation --}}
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('home') }}"><i class="bi bi-bag-heart"></i> Katalog</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('user.dashboard') }}"><i class="bi bi-speedometer2"></i> Dashboard</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('cart.index') }}">
                                    <i class="bi bi-cart3"></i> Keranjang
                                    @if(count(session('cart', [])) > 0)
                                        <span class="badge bg-danger rounded-pill">{{ count(session('cart', [])) }}</span>
                                    @endif
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('transactions.index') }}">
                                    <i class="bi bi-receipt"></i> Pesanan
                                </a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('products.index') }}"><i class="bi bi-grid"></i> Produk</a>
                        </li>
                    @endauth
                </ul>
                <ul class="navbar-nav">
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle"></i> {{ auth()->user()->username }}
                                @php $unread = auth()->user()->notifications()->unread()->count(); @endphp
                                @if($unread > 0)
                                    <span class="badge bg-danger rounded-pill">{{ $unread }}</span>
                                @endif
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('notifications.index') }}">
                                    <i class="bi bi-bell"></i> Notifikasi
                                    @if($unread > 0)
                                        <span class="badge bg-danger float-end rounded-pill">{{ $unread }}</span>
                                    @endif
                                </a></li>
                                <li><a class="dropdown-item" href="{{ route('profile') }}"><i class="bi bi-person"></i> Profil</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger"><i class="bi bi-box-arrow-right"></i> Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}"><i class="bi bi-box-arrow-in-right"></i> Masuk</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link btn btn-light text-primary ms-2 px-3" href="{{ route('register') }}">
                                <i class="bi bi-person-plus"></i> Daftar
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        <div class="container">
            @if(session('success'))
                <div class="alert alert-success alert-modern alert-dismissible fade show animate-fadeInUp">
                    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger alert-modern alert-dismissible fade show animate-fadeInUp">
                    <i class="bi bi-exclamation-circle-fill me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @yield('content')
        </div>
    </main>

    <footer class="footer-modern mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5><i class="bi bi-bag-heart-fill me-2"></i>{{ \App\Models\Setting::getSettings()->store_name }}</h5>
                    <p class="mb-1"><i class="bi bi-geo-alt me-2"></i>{{ \App\Models\Setting::getSettings()->store_address }}</p>
                    <p class="mb-1"><i class="bi bi-telephone me-2"></i>{{ \App\Models\Setting::getSettings()->store_phone }}</p>
                    <p class="mb-1"><i class="bi bi-envelope me-2"></i>{{ \App\Models\Setting::getSettings()->store_email }}</p>
                </div>
                <div class="col-md-6 text-end">
                    <div class="badge bg-warning text-dark px-3 py-2 mb-3">
                        <i class="bi bi-megaphone me-1"></i>{{ \App\Models\Setting::getSettings()->promo_text }}
                    </div>
                    <p class="mb-0">&copy; {{ date('Y') }} {{ \App\Models\Setting::getSettings()->store_name }}. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto-dismiss alerts after 5 seconds
        setTimeout(() => {
            document.querySelectorAll('.alert').forEach(alert => {
                alert.classList.remove('show');
                alert.classList.add('fade');
            });
        }, 5000);
    </script>
    @stack('scripts')
</body>
</html>