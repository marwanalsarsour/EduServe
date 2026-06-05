<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم - مسؤول النشاط</title>
    <link class="text-black" rel="icon" type="image/png" href="/public/images/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="/public/css/styles.css">
    <style>
        .nav-link.active {
            background-color: rgba(255, 255, 255, 0.2);
            color: white !important;
            font-weight: bold;
            border-radius: 6px;
        }
    </style>
</head>
<body class="bg-light text-end">

    <?php
    $navLinks = [
        ['url' => '/v_manager/dashboard', 'text' => 'الرئيسية', 'active' => true],
        ['url' => '/v_manager/volunteers', 'text' => 'قائمة المتطوعين', 'active' => false],
        ['url' => '/v_manager/attendance', 'text' => 'إدارة الحضور', 'active' => false],
        ['url' => '/v_manager/reports', 'text' => 'التقارير المرفوعة', 'active' => false]
    ];
    $notificationsUrl = '/v_manager/notifications';
    ?>

    <nav class="navbar navbar-expand-lg bg-primary" data-bs-theme="dark">
        <div class="container-fluid">
            <div class="p-1 me-3 m-1 ms-4">
                <img src="/images/LogoNav.png" alt="LogoNav">
            </div>
            <span class="navbar-brand text-white mb-0 h1">EduServe</span>
            <button class="navbar-toggler me-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
                aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title text-white" id="offcanvasNavbarLabel">EduServe</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body bg-primary">
                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3 fw-bold me-5 gap-3 align-items-center">

                        <?php if (!empty($navLinks)): ?>
                            <?php foreach ($navLinks as $link): ?>
                                <li class="nav-item">
                                    <a class="nav-link text-white <?= $link['active'] ? 'active' : '' ?>" href="<?= htmlspecialchars($link['url']) ?>">
                                        <?= htmlspecialchars($link['text']) ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        <?php endif; ?>

                        <li class="nav-item me-2">
                            <a class="nav-link position-relative text-white fs-5" href="<?= htmlspecialchars($notificationsUrl) ?>" title="الإشعارات">
                                <i class="bi bi-bell-fill"></i>
                                <?php if (($data['notifications_count'] ?? 0) > 0): ?>
                                    <span class="position-absolute top-1 start-100 translate-middle p-1 bg-warning border border-light rounded-circle">
                                        <span class="visually-hidden">إشعارات جديدة</span>
                                    </span>
                                <?php endif; ?>
                            </a>
                        </li>

                        <div class="dropdown">
                            <a class="btn btn-outline-light dropdown-toggle d-flex align-items-center gap-1" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle fs-5"></i> 
                            </a>

                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark">
                                <li>
                                    <a class="dropdown-item text-end" href="/external_dashboard">
                                        <i class="bi bi-speedometer2 ms-2"></i> لوحة تحكم الجهة
                                    </a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <a class="dropdown-item text-end text-danger" href="/logout">
                                        <i class="bi bi-box-arrow-right ms-2"></i> تسجيل الخروج
                                    </a>
                                </li>
                            </ul>
                        </div>

                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="container py-5">
        <div class="row mb-4">
            <div class="col-12">
                <h3 class="fw-bold text-black mb-1">مرحباً بك، مسؤول النشاط التطوعي</h3>
                <p class="text-secondary small">نظرة عامة على نشاط المتطوعين اليوم</p>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-primary text-white">
                    <div class="d-flex align-items-center">
                        <div>
                            <h2 class="fw-bold mb-0 text-white"><?= $data['active_volunteers'] ?? 0 ?></h2>
                            <p class="mb-0 small opacity-75">متطوع نشط</p>
                        </div>
                        <i class="bi bi-people fs-1 opacity-50 ms-auto"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white border-bottom border-4 border-primary">
                    <div class="d-flex align-items-center">
                        <div>
                            <h2 class="fw-bold mb-0 text-black"><?= $data['total_hours'] ?? 0 ?></h2>
                            <p class="mb-0 text-secondary small">ساعة منجزة كلياً</p>
                        </div>
                        <i class="bi bi-clock-history fs-1 text-primary opacity-25 ms-auto"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white border-bottom border-4 border-warning">
                    <div class="d-flex align-items-center">
                        <div>
                            <h2 class="fw-bold mb-0 text-black"><?= $data['notifications_count'] ?? 0 ?></h2>
                            <p class="mb-0 text-secondary small">الإشعارات</p>
                        </div>
                        <i class="bi bi-bell fs-1 text-warning opacity-25 ms-auto"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-5">
            <h5 class="fw-bold mb-3 text-black">الوصول السريع</h5>
            <div class="d-flex gap-2 flex-wrap">
                <a href="/v_manager/attendance" class="btn btn-primary rounded-pill px-4 shadow-sm fw-bold">
                    <i class="bi bi-calendar-check ms-2"></i>رصد الحضور اليومي
                </a>
                <a href="/v_manager/volunteers" class="btn btn-outline-dark rounded-pill px-4 shadow-sm fw-bold text-black">
                    <i class="bi bi-list-ul ms-2"></i>قائمة المتطوعين
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>