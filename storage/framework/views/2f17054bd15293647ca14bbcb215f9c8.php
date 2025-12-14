
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($settings->store_name); ?> - Fashion Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --success-gradient: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            --dark-gradient: linear-gradient(135deg, #232526 0%, #414345 100%);
        }
        
        * {
            font-family: 'Poppins', sans-serif;
        }
        
        body {
            overflow-x: hidden;
        }
        
        /* Navbar */
        .navbar-landing {
            background: transparent;
            position: absolute;
            width: 100%;
            z-index: 1000;
            padding: 1.5rem 0;
            transition: all 0.3s ease;
        }
        
        .navbar-landing.scrolled {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            position: fixed;
        }
        
        .navbar-landing .navbar-brand {
            font-weight: 800;
            font-size: 1.8rem;
            color: white;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .navbar-landing.scrolled .navbar-brand {
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .navbar-landing .nav-link {
            color: rgba(255, 255, 255, 0.9) !important;
            font-weight: 500;
            padding: 0.5rem 1rem !important;
            transition: all 0.3s ease;
        }
        
        .navbar-landing.scrolled .nav-link {
            color: #333 !important;
        }
        
        .navbar-landing .nav-link:hover {
            transform: translateY(-2px);
        }
        
        .btn-landing {
            background: white;
            color: #667eea;
            padding: 0.75rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
        }
        
        .btn-landing:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            background: white;
            color: #764ba2;
        }
        
        .navbar-landing.scrolled .btn-landing {
            background: var(--primary-gradient);
            color: white;
        }
        
        /* Hero Section */
        .hero-section {
            background: var(--primary-gradient);
            min-height: 100vh;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 80%;
            height: 200%;
            background: rgba(255, 255, 255, 0.05);
            transform: rotate(-25deg);
            border-radius: 50%;
        }
        
        .hero-section::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -10%;
            width: 50%;
            height: 100%;
            background: rgba(255, 255, 255, 0.03);
            transform: rotate(15deg);
            border-radius: 50%;
        }
        
        .hero-content {
            position: relative;
            z-index: 1;
        }
        
        .hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            color: white;
            line-height: 1.2;
            margin-bottom: 1.5rem;
        }
        
        .hero-subtitle {
            font-size: 1.25rem;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 2rem;
            line-height: 1.8;
        }
        
        .promo-badge {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            display: inline-block;
            color: white;
            font-weight: 500;
            margin-bottom: 2rem;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.02); }
        }
        
        .btn-hero {
            padding: 1rem 2.5rem;
            font-size: 1.1rem;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
        }
        
        .btn-hero-primary {
            background: white;
            color: #667eea;
        }
        
        .btn-hero-primary:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
            background: white;
            color: #764ba2;
        }
        
        .btn-hero-outline {
            background: transparent;
            border: 2px solid rgba(255, 255, 255, 0.5);
            color: white;
        }
        
        .btn-hero-outline:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: white;
            color: white;
        }
        
        .hero-image {
            position: relative;
            z-index: 1;
        }
        
        .hero-image img {
            max-width: 100%;
            filter: drop-shadow(0 30px 60px rgba(0, 0, 0, 0.3));
            animation: float 3s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }
        
        /* Stats Section */
        .stats-section {
            background: white;
            padding: 3rem 0;
            margin-top: -80px;
            position: relative;
            z-index: 10;
            border-radius: 30px 30px 0 0;
        }
        
        .stat-item {
            text-align: center;
            padding: 1.5rem;
        }
        
        .stat-number {
            font-size: 2.5rem;
            font-weight: 800;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .stat-label {
            color: #666;
            font-weight: 500;
        }
        
        /* Categories Section */
        .categories-section {
            padding: 5rem 0;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        }
        
        .section-title {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 1rem;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .section-subtitle {
            color: #666;
            font-size: 1.1rem;
            margin-bottom: 3rem;
        }
        
        .category-card {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            text-align: center;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.05);
            text-decoration: none;
            display: block;
        }
        
        .category-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 50px rgba(102, 126, 234, 0.2);
        }
        
        .category-icon {
            width: 80px;
            height: 80px;
            background: var(--primary-gradient);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2rem;
            color: white;
        }
        
        .category-name {
            font-weight: 700;
            font-size: 1.25rem;
            color: #333;
            margin-bottom: 0.5rem;
        }
        
        .category-count {
            color: #666;
            font-size: 0.9rem;
        }
        
        /* Products Section */
        .products-section {
            padding: 5rem 0;
            background: white;
        }
        
        .product-card {
            background: white;
            border: none;
            border-radius: 20px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            overflow: hidden;
            height: 100%;
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
        
        .badge-modern {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 500;
            font-size: 0.75rem;
        }
        
        .btn-modern-primary {
            background: var(--primary-gradient);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            font-weight: 600;
            border: none;
            transition: all 0.3s ease;
        }
        
        .btn-modern-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
            color: white;
        }
        
        /* CTA Section */
        .cta-section {
            background: var(--primary-gradient);
            padding: 5rem 0;
            text-align: center;
        }
        
        .cta-title {
            font-size: 2.5rem;
            font-weight: 800;
            color: white;
            margin-bottom: 1rem;
        }
        
        .cta-subtitle {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1.1rem;
            margin-bottom: 2rem;
        }
        
        /* Footer */
        .footer-landing {
            background: var(--dark-gradient);
            color: rgba(255, 255, 255, 0.8);
            padding: 4rem 0 2rem;
        }
        
        .footer-landing h5 {
            color: white;
            font-weight: 700;
            margin-bottom: 1.5rem;
        }
        
        .footer-links {
            list-style: none;
            padding: 0;
        }
        
        .footer-links li {
            margin-bottom: 0.75rem;
        }
        
        .footer-links a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .footer-links a:hover {
            color: white;
            padding-left: 5px;
        }
        
        .social-icons a {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: white;
            margin-right: 0.5rem;
            transition: all 0.3s ease;
        }
        
        .social-icons a:hover {
            background: var(--primary-gradient);
            transform: translateY(-3px);
        }
        
        /* Animations */
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
        
        /* Responsive */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            
            .section-title {
                font-size: 2rem;
            }
            
            .stat-number {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-landing">
        <div class="container">
            <a class="navbar-brand" href="<?php echo e(url('/')); ?>">
                <i class="bi bi-bag-heart-fill"></i> <?php echo e($settings->store_name); ?>

            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" href="#categories">Kategori</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#products">Produk</a>
                    </li>
                    <?php if(auth()->guard()->check()): ?>
                        <li class="nav-item ms-2">
                            <a class="btn btn-landing" href="<?php echo e(route('home')); ?>">
                                <i class="bi bi-house"></i> Dashboard
                            </a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(route('login')); ?>">Masuk</a>
                        </li>
                        <li class="nav-item ms-2">
                            <a class="btn btn-landing" href="<?php echo e(route('register')); ?>">
                                <i class="bi bi-person-plus"></i> Daftar
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 hero-content">
                    <?php if($settings->promo_text): ?>
                        <div class="promo-badge">
                            <i class="bi bi-megaphone-fill me-2"></i><?php echo e($settings->promo_text); ?>

                        </div>
                    <?php endif; ?>
                    <h1 class="hero-title">
                        Temukan Gaya<br>Fashion Terbaikmu
                    </h1>
                    <p class="hero-subtitle">
                        Koleksi fashion terlengkap dengan kualitas premium dan harga terjangkau. 
                        Tampil stylish setiap hari bersama <?php echo e($settings->store_name); ?>.
                    </p>
                    <div class="d-flex gap-3 flex-wrap">
                        <a href="<?php echo e(route('products.index')); ?>" class="btn btn-hero btn-hero-primary">
                            <i class="bi bi-grid me-2"></i>Lihat Koleksi
                        </a>
                        <?php if(auth()->guard()->guest()): ?>
                            <a href="<?php echo e(route('register')); ?>" class="btn btn-hero btn-hero-outline">
                                <i class="bi bi-person-plus me-2"></i>Daftar Sekarang
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-lg-6 hero-image d-none d-lg-block">
                    <svg viewBox="0 0 400 400" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <linearGradient id="grad1" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" style="stop-color:rgba(255,255,255,0.3);stop-opacity:1" />
                                <stop offset="100%" style="stop-color:rgba(255,255,255,0.1);stop-opacity:1" />
                            </linearGradient>
                        </defs>
                        <circle cx="200" cy="200" r="180" fill="url(#grad1)"/>
                        <circle cx="200" cy="200" r="140" fill="rgba(255,255,255,0.1)"/>
                        <circle cx="200" cy="200" r="100" fill="rgba(255,255,255,0.05)"/>
                        <text x="200" y="180" text-anchor="middle" fill="white" font-size="60" font-weight="bold">
                            <tspan>🛍️</tspan>
                        </text>
                        <text x="200" y="240" text-anchor="middle" fill="white" font-size="24" font-weight="600">
                            Fashion Store
                        </text>
                    </svg>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-6">
                    <div class="stat-item">
                        <div class="stat-number"><?php echo e($featuredProducts->count()); ?>+</div>
                        <div class="stat-label">Produk Tersedia</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-item">
                        <div class="stat-number"><?php echo e($categories->count()); ?></div>
                        <div class="stat-label">Kategori</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-item">
                        <div class="stat-number">100%</div>
                        <div class="stat-label">Kualitas Premium</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-item">
                        <div class="stat-number">24/7</div>
                        <div class="stat-label">Layanan</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="categories-section" id="categories">
        <div class="container">
            <div class="text-center">
                <h2 class="section-title">Kategori Produk</h2>
                <p class="section-subtitle">Temukan produk berdasarkan kategori favorit Anda</p>
            </div>
            <div class="row g-4">
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-lg-3 col-md-4 col-6">
                        <a href="<?php echo e(route('products.index', ['category' => $category->id])); ?>" class="category-card animate-fadeInUp" style="animation-delay: <?php echo e($index * 0.1); ?>s">
                            <div class="category-icon">
                                <i class="bi bi-tag-fill"></i>
                            </div>
                            <h5 class="category-name"><?php echo e($category->name); ?></h5>
                            <p class="category-count"><?php echo e($category->products_count); ?> Produk</p>
                        </a>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>
    <!-- Products Section -->
    <section class="products-section" id="products">
        <div class="container">
            <div class="text-center">
                <h2 class="section-title">Produk Unggulan</h2>
                <p class="section-subtitle">Koleksi terbaru dan terlaris dari kami</p>
            </div>
            <div class="row g-4">
                <?php $__currentLoopData = $featuredProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="product-card h-100 animate-fadeInUp" style="animation-delay: <?php echo e($index * 0.05); ?>s">
                            <div class="overflow-hidden">
                                <img src="<?php echo e($product->image_url); ?>" class="card-img-top product-img" alt="<?php echo e($product->name); ?>">
                            </div>
                            <div class="card-body d-flex flex-column">
                                <div class="mb-2">
                                    <?php if($product->category): ?>
                                        <span class="badge bg-primary badge-modern"><?php echo e($product->category->name); ?></span>
                                    <?php endif; ?>
                                    <span class="badge bg-secondary badge-modern"><?php echo e($product->size); ?></span>
                                </div>
                                <h5 class="fw-bold mb-2"><?php echo e($product->name); ?></h5>
                                <p class="text-muted small mb-3"><?php echo e(Str::limit($product->description, 60)); ?></p>
                                
                                <div class="mt-auto">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <span class="price-tag">Rp <?php echo e(number_format($product->price, 0, ',', '.')); ?></span>
                                        <small class="text-<?php echo e($product->stock > 0 ? 'success' : 'danger'); ?> fw-bold">
                                            <i class="bi bi-box"></i> <?php echo e($product->stock); ?>

                                        </small>
                                    </div>
                                    
                                    <a href="<?php echo e(route('products.show', $product)); ?>" class="btn btn-modern-primary w-100">
                                        <i class="bi bi-eye"></i> Lihat Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <div class="text-center mt-5">
                <a href="<?php echo e(route('products.index')); ?>" class="btn btn-modern-primary btn-lg">
                    <i class="bi bi-grid me-2"></i>Lihat Semua Produk
                </a>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <h2 class="cta-title">Siap untuk Berbelanja?</h2>
            <p class="cta-subtitle">Daftar sekarang dan nikmati penawaran eksklusif dari kami!</p>
            <?php if(auth()->guard()->guest()): ?>
                <a href="<?php echo e(route('register')); ?>" class="btn btn-hero btn-hero-primary btn-lg">
                    <i class="bi bi-person-plus me-2"></i>Daftar Gratis
                </a>
            <?php else: ?>
                <a href="<?php echo e(route('products.index')); ?>" class="btn btn-hero btn-hero-primary btn-lg">
                    <i class="bi bi-cart me-2"></i>Mulai Belanja
                </a>
            <?php endif; ?>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer-landing">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <h5><i class="bi bi-bag-heart-fill me-2"></i><?php echo e($settings->store_name); ?></h5>
                    <p><?php echo e($settings->store_description ?? 'Toko fashion online terpercaya dengan koleksi terlengkap dan harga terbaik.'); ?></p>
                    <div class="social-icons">
                        <a href="#"><i class="bi bi-facebook"></i></a>
                        <a href="#"><i class="bi bi-instagram"></i></a>
                        <a href="#"><i class="bi bi-twitter"></i></a>
                        <a href="#"><i class="bi bi-whatsapp"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4">
                    <h5>Menu</h5>
                    <ul class="footer-links">
                        <li><a href="<?php echo e(url('/')); ?>">Beranda</a></li>
                        <li><a href="<?php echo e(route('products.index')); ?>">Produk</a></li>
                        <li><a href="<?php echo e(route('login')); ?>">Masuk</a></li>
                        <li><a href="<?php echo e(route('register')); ?>">Daftar</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-4">
                    <h5>Kategori</h5>
                    <ul class="footer-links">
                        <?php $__currentLoopData = $categories->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><a href="<?php echo e(route('products.index', ['category' => $category->id])); ?>"><?php echo e($category->name); ?></a></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-4">
                    <h5>Kontak</h5>
                    <ul class="footer-links">
                        <li><i class="bi bi-geo-alt me-2"></i><?php echo e($settings->store_address); ?></li>
                        <li><i class="bi bi-telephone me-2"></i><?php echo e($settings->store_phone); ?></li>
                        <li><i class="bi bi-envelope me-2"></i><?php echo e($settings->store_email); ?></li>
                    </ul>
                </div>
            </div>
            <hr class="my-4" style="border-color: rgba(255,255,255,0.1);">
            <div class="text-center">
                <p class="mb-0">&copy; <?php echo e(date('Y')); ?> <?php echo e($settings->store_name); ?>. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar-landing');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
        
        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\akari-store\resources\views/welcome.blade.php ENDPATH**/ ?>