<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] !== true) {
    header('Location: /login');
    exit();
}

$user_role = $_SESSION['user_role'] ?? '';
$user_name = $_SESSION['user_name'] ?? ($_SESSION['full_name'] ?? 'المستخدم'); 

$navLinks = [];
$profileUrl = '/student_profile';
$notificationsUrl = '#'; 

switch (trim($user_role)) {
    case 'طالب':
    case 'student':
        $navLinks = [
            ['text' => 'لوحة التحكم', 'url' => '/student_dashboard'],
            ['text' => 'الفرص', 'url' => '/student_opportunities'],
            ['text' => 'طلباتي', 'url' => '/student_my-application'],
            ['text' => 'الحضور', 'url' => '/student_attendance'],
            ['text' => 'التقارير', 'url' => '/student_reports']
        ];
        $profileUrl = '/student_profile';
        $notificationsUrl = '/student_notifications';
        break;

    case 'مشرف تدريب':
    case 'supervisor':
    case 'academic_supervisor':
        $navLinks = [
            ['text' => 'لوحة التحكم', 'url' => '/supervisor_dashboard'],
            ['text' => 'الفرص المتاحة', 'url' => '/supervisor/opportunities'],
            ['text' => 'طلبات التقديم', 'url' => '/supervisor-applications'],
            ['text' => 'سجلات الحضور', 'url' => '/supervisor-attendance'],
            ['text' => 'إدارة الطلاب', 'url' => '/supervisor/students'],
            ['text' => 'التقارير المستلمة', 'url' => '/supervisor/supervisor-reports']
        ];
        $profileUrl = '/supervisor_profile';
        $notificationsUrl = '/supervisor/notifications';
        break;

    case 'مشرف تطوع':
    case 'volunteer_supervisor':
        $navLinks = [
            ['text' => 'لوحة التحكم', 'url' => '/volunteer_dashboard'],
            ['text' => 'الفرص التطوعية', 'url' => '/volunteer_opportunities'],
            ['text' => 'طلبات التطوع', 'url' => '/volunteer_requests'],
            ['text' => 'مراجعة الحضور', 'url' => '/volunteer_attendance']
        ];
        $profileUrl = '/volunteer_profile';
        $notificationsUrl = '/volunteer_notifications';
        break;

    case 'جهة خارجية':
    case 'external':
    case 'external_entity':
        $navLinks = [
            ['text' => 'لوحة التحكم', 'url' => '/external_dashboard'],
            ['text' => 'طلبات التوظيف', 'url' => '/external/applications'],
            ['text' => 'إدارة الفرص', 'url' => '/external/opportunities'],
            ['text' => 'الشهادات المعتمدة', 'url' => '/external/certificates'],
            ['text' => 'المتدربين', 'url' => '/external/trainees']
        ];
        $profileUrl = '/external_dashboard';
        $notificationsUrl = '/external/notifications';
        break;

    case 'مدير الحسابات':
    case 'v_manager':
        $navLinks = [
            ['text' => 'لوحة التحكم', 'url' => '/v_manager/dashboard'],
            ['text' => 'المتطوعين', 'url' => '/v_manager/volunteers'],
            ['text' => 'التقارير المرفوعة', 'url' => '/v_manager/reports']
        ];
        $profileUrl = '/v_manager/profile';
        $notificationsUrl = '/volunteer_notifications';
        break;

    case 'إدارة كلية':
    case 'مدير':
    case 'مسؤول':
    case 'admin':
        $navLinks = [
            ['text' => 'لوحة الإدارة', 'url' => '/admin/admin_dashboard'],
            ['text' => 'إدارة الحسابات', 'url' => '/admin/accounts'],
            ['text' => 'اعتماد الشهادات', 'url' => '/admin/certificates'],
            ['text' => 'الإحصائيات الكلية', 'url' => '/admin/statistics']
        ];
        $profileUrl = '/admin/profile';
        $notificationsUrl = '/admin/notifications';
        break;
}
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
                                <a class="nav-link" href="<?= htmlspecialchars($link['url']) ?>">
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
                            <span><?= htmlspecialchars($user_name) ?></span>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark">
                            <li>
                                <a class="dropdown-item text-end" href="<?= htmlspecialchars($profileUrl) ?>">
                                    <i class="bi bi-person ms-2"></i> الملف الشخصي
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