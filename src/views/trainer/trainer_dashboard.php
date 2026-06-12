<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة تحكم المدرب - EduServe</title>
    <link rel="icon" type="image/png" href="/public/images/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .nav-link.active {
            background-color: lightgray;
            color: blue !important;
            font-weight: bold;
            border-radius: 6px;
        }
        .stat-card {
            transition: transform 0.2s;
            background-color: white;
        }
        .stat-card:hover {
            transform: translateY(-5px);
            border-color: blue !important;
        }
        .custom-text-dark {
            color: black;
        }
        .custom-text-blue {
            color: blue;
        }
    </style>
</head>
<body class="bg-light">

    <?php
    $navLinks = [
        ['url' => '/trainer/dashboard', 'text' => 'الرئيسية', 'active' => true],
        ['url' => '/trainer/attendance', 'text' => 'إدارة الحضور', 'active' => false],
        ['url' => '/trainer/reports', 'text' => 'التقارير المرفوعة', 'active' => false]
    ];
    $notificationsUrl = '/trainer/notifications';
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
                    <h5 class="offcanvas-title" id="offcanvasNavbarLabel">EduServe</h5>
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
                                <span class="position-absolute top-1 start-100 translate-middle p-1 bg-danger border border-light rounded-circle">
                                    <span class="visually-hidden">إشعارات جديدة</span>
                                </span>
                            </a>
                        </li>

                        <div class="dropdown">
                            <a class="btn btn-outline-light dropdown-toggle d-flex align-items-center gap-1" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle fs-5"></i> 
                            </a>

                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark">
                                <li>
                                    <a class="dropdown-item text-end" href="/external_dashboard">
                                        <i class="bi bi-speedometer ms-2"></i> اللوحة الخارجية
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
        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="card shadow-sm p-4 text-center stat-card border-0 rounded-3">
                    <i class="bi bi-people custom-text-blue fs-1 mb-2"></i>
                    <h6 class="text-muted small">الطلاب المعينين</h6>
                    <h3 class="fw-bold custom-text-dark"><?= $stats['total_students'] ?? 0 ?></h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm p-4 text-center border-start border-4 border-warning stat-card border-top-0 border-end-0 border-bottom-0 rounded-3">
                    <i class="bi bi-clock-history text-warning fs-1 mb-2"></i>
                    <h6 class="text-muted small">بانتظار تأكيد الحضور</h6>
                    <h3 class="fw-bold custom-text-dark"><?= $stats['pending_attendance'] ?? 0 ?></h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm p-4 text-center border-start border-4 border-success stat-card border-top-0 border-end-0 border-bottom-0 rounded-3">
                    <i class="bi bi-file-earmark-check text-success fs-1 mb-2"></i>
                    <h6 class="text-muted small">تقارير مكتملة</h6>
                    <h3 class="fw-bold custom-text-dark"><?= $stats['completed_reports'] ?? 0 ?></h3>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm p-4 rounded-4 bg-white">
            <h5 class="fw-bold mb-4 custom-text-dark"><i class="bi bi-list-stars ms-2 custom-text-blue"></i>قائمة الطلاب الحالية</h5>
            <div class="table-responsive">
                <table class="table align-middle table-hover">
                    <thead>
                        <tr class="text-muted small uppercase border-bottom">
                            <th class="py-3">اسم الطالب</th>
                            <th class="py-3">التخصص</th>
                            <th class="py-3">ساعات الإنجاز</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($students)): ?>
                            <?php foreach ($students as $student): ?>
                            <tr>
                                <td class="py-3">
                                    <div class="fw-bold custom-text-dark"><?= htmlspecialchars($student['name'] ?? '') ?></div>
                                </td>
                                <td class="py-3">
                                    <span class="badge bg-light text-secondary border px-2 py-1.5"><?= htmlspecialchars($student['major'] ?? '') ?></span>
                                </td>
                                <td class="py-3">
                                    <div class="d-flex align-items-center" style="min-width: 150px;">
                                        <small class="me-2 fw-bold text-secondary"><?= $student['total_hours'] ?? 0 ?>/120</small>
                                        <div class="progress flex-grow-1" style="height: 6px;">
                                            <div class="progress-bar bg-primary" style="width: <?= (($student['total_hours'] ?? 0) / 120) * 100 ?>%"></div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox fs-2 d-block mb-2 text-secondary"></i>
                                    لا يوجد طلاب معينين حالياً.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>