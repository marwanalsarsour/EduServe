<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] !== true) {
    
    header('Location: /login');
    exit();
}
?>
<nav class="navbar navbar-expand-lg bg-primary" data-bs-theme="dark">
        <div class="container-fluid">
            <div class="p-1 me-3 m-1 ms-4">
                <img src="/public/images/LogoNav.png" alt="LogoNav">
            </div>
            <span class="navbar-brand text-white mb-0 h1">EduServe</span>
            <button class="navbar-toggler me-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
                aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar"
                aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasNavbarLabel">EduServe</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body bg-primary">
                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3 fw-bold me-5 gap-3">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="/student_dashboard">لوحة التحكم</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page"
                                href="/student_opportunities">الفرص</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="/student_my-application">طلباتي</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="student_attendance">الحضور</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link pe-3" aria-current="page" href="student_reports">التقارير</a>
                        </li>
                        <div class="dropdown">
                            <a class="btn btn-outline-light dropdown-toggle" href="#" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle me-1"></i> <span id="studentName">الطالب</span>
                            </a>

                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark">
                                <li>
                                    <a class="dropdown-item" href="/student/profile.html">
                                        <i class="bi bi-person me-2"></i> الملف الشخصي
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="/student/settings.html">
                                        <i class="bi bi-gear me-2"></i> الإعدادات
                                    </a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <a class="dropdown-item text-danger" href="/auth/login.html">
                                        <i class="bi bi-box-arrow-right me-2"></i> تسجيل الخروج
                                    </a>
                                </li>
                            </ul>
                        </div>


                    </ul>
                </div>
            </div>
        </div>
    </nav>