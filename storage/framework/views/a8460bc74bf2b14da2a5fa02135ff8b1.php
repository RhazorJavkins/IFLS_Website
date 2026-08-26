<!DOCTYPE html>
<html lang="<?php echo e(app()->getLocale()); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'IF Language School'); ?></title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

    <!-- ======= NAVBAR ======= -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="<?php echo e(url('/' . app()->getLocale())); ?>">
                <img src="<?php echo e(asset('logo.png')); ?>" alt="IF Language School" height="40" style="display:inline-block;">
                <span class="fw-bold ms-2">IF Language School</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="<?php echo e(url('/' . app()->getLocale() . '/')); ?>"><?php echo e(__('messages.home')); ?></a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo e(url('/' . app()->getLocale() . '/about')); ?>"><?php echo e(__('messages.about')); ?></a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo e(url('/' . app()->getLocale() . '/courses')); ?>"><?php echo e(__('messages.courses')); ?></a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo e(url('/' . app()->getLocale() . '/services')); ?>"><?php echo e(__('messages.services')); ?></a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo e(url('/' . app()->getLocale() . '/blog')); ?>"><?php echo e(__('messages.blog')); ?></a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo e(url('/' . app()->getLocale() . '/gallery')); ?>"><?php echo e(__('messages.gallery')); ?></a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo e(url('/' . app()->getLocale() . '/contact')); ?>"><?php echo e(__('messages.contact')); ?></a></li>

                    <!-- DROPDOWN SWITCH BAHASA -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="langDropdown" role="button" data-bs-toggle="dropdown">
                            🌐 <?php echo e(strtoupper(app()->getLocale())); ?>

                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <?php
                                // Ambil semua segmen URL (misal: ['id', 'about'] atau ['id'])
                                $segments = request()->segments();
                                // Hapus segmen pertama (bahasa saat ini), sisanya adalah path asli
                                $pathWithoutLocale = implode('/', array_slice($segments, 1));
                                // Pertahankan query string (misal filter ?level=...) saat ganti bahasa
                                $queryString = request()->query() ? '?' . http_build_query(request()->query()) : '';
                            ?>
                            <li>
                                <a class="dropdown-item" href="<?php echo e(url('id/' . $pathWithoutLocale . $queryString)); ?>">
                                    🇮🇩 Indonesia
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="<?php echo e(url('en/' . $pathWithoutLocale . $queryString)); ?>">
                                    🇬🇧 English
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="<?php echo e(url('zh/' . $pathWithoutLocale . $queryString)); ?>">
                                    🇨🇳 中文
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- ======= CONTENT ======= -->
    <main>
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <!-- ======= FOOTER ======= -->
    <footer class="bg-dark text-white text-center py-4 mt-5">
        <div class="container">
            <p class="mb-0">&copy; <?php echo e(date('Y')); ?> IF Language School. <?php echo e(__('messages.language')); ?></p>
        </div>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html><?php /**PATH C:\laragon\www\if-language-school\resources\views/layouts/app.blade.php ENDPATH**/ ?>