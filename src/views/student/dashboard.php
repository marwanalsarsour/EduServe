<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم</title>
    <link rel="icon" type="image/png" href="../../assets/img/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="d-flex flex-column min-vh-100">

  <nav class="navbar navbar-expand-lg bg-primary" data-bs-theme="dark">
        <div class="container-fluid">
            <div class="p-1 me-3 m-1 ms-4">
                <img src="/assets/img/LogoNav.png" alt="LogoNav">
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
                            <a class="nav-link" aria-current="page" href="/View/Student/dashboard.html">لوحة التحكم</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page"
                                href="/View/Student/opportunities.html">الفرص</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="/View/Student/my-application.html">طلباتي</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="/View/Student/attendance.html">الحضور</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link pe-3" aria-current="page" href="/View/Student/reports.html">التقارير</a>
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
    <main class="flex-grow-1">
        <div class="container my-4">

            <div class="card shadow-sm border-0 mb-4">
                <div
                    class="card-body p-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                    <div>
                        <h3 class="fw-bold mb-1">أهلاً بك، <span id="studentName">يا طالب</span> </h3>
                        <p class="text-muted mb-0">إليك نظرة عامة على آخر التطورات.</p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="opportunities.html" class="btn btn-primary">
                            <i class="bi bi-search ms-1"></i> تصفح الفرص
                        </a>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm mb-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold mb-0"><i class="bi bi-clock-history ms-1"></i> الأنشطة الأخيرة</h5>
                        <a href="my-applications.html" class="btn btn-sm btn-outline-primary">
                            عرض الكل
                        </a>
                    </div>

                    <div id="recentActivity" class="text-muted">
                        لا يوجد أنشطة حديثة بعد.
                    </div>
                </div>
            </div>

            <div class="row g-4 mb-4">
                <div class="col-12 col-lg-6">
                    <div class="card shadow-sm h-100">
                        <div class="card-body p-4">

                            <div class="d-flex justify-content-between align-items-start gap-2">
                                <div>
                                    <h5 class="fw-bold mb-1">
                                        التدريب الميداني
                                    </h5>
                                    <div class="text-muted small">
                                        الحالة: <span id="trainingStatusText" class="fw-semibold">—</span>
                                    </div>
                                </div>
                                <span id="trainingStatusBadge" class="badge bg-primary">—</span>
                            </div>

                            <hr class="my-3">

                            <div class="d-flex justify-content-between small text-muted">
                                <span><i class="bi bi-clock ms-1"></i> الساعات</span>
                                <span>
                                    <span id="trainingHoursDone" class="fw-semibold">0</span> /
                                    <span id="trainingHoursTotal">150</span>
                                </span>
                            </div>

                            <div class="progress mt-2" style="height: 10px;">
                                <div id="trainingProgressBar" class="progress-bar" role="progressbar" style="width: 0%">
                                </div>
                            </div>

                            <div class="mt-3">
                                <div class="text-muted small">الشركة / المؤسسة</div>
                                <div id="trainingOrg" class="fw-semibold">—</div>
                            </div>

                            <div class="mt-3 d-flex gap-2">
                                <a href="attendance.html" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-calendar-check ms-1"></i> الحضور
                                </a>
                                <a href="reports.html" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-bar-chart ms-1"></i> التقارير
                                </a>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-6">
                    <div class="card shadow-sm h-100">
                        <div class="card-body p-4">

                            <div class="d-flex justify-content-between align-items-start gap-2">
                                <div>
                                    <h5 class="fw-bold mb-1">
                                        العمل التطوعي
                                    </h5>
                                    <div class="text-muted small">
                                        الحالة: <span id="volStatusText" class="fw-semibold">—</span>
                                    </div>
                                </div>
                                <span id="volStatusBadge" class="badge bg-success">—</span>
                            </div>
                            <hr class="my-3">
                            <div class="d-flex justify-content-between small text-muted">
                                <span><i class="bi bi-clock ms-1"></i> الساعات</span>
                                <span>
                                    <span id="volHoursDone" class="fw-semibold">0</span> /
                                    <span id="volHoursTotal">0</span>
                                </span>
                            </div>

                            <div class="progress mt-2" style="height: 10px;">
                                <div id="volProgressBar" class="bg-success progress-bar" role="progressbar"
                                    style="width: 0%"></div>
                            </div>

                            <div class="mt-3">
                                <div class="text-muted small">المؤسسة</div>
                                <div id="volOrg" class="fw-semibold">—</div>
                            </div>

                            <div class="mt-3 d-flex gap-2">
                                <a href="attendance.html" class="btn btn-sm btn-outline-success">
                                    <i class="bi bi-calendar-check ms-1"></i> الحضور
                                </a>
                                <a href="reports.html" class="btn btn-sm btn-outline-success">
                                    <i class="bi bi-bar-chart ms-1"></i> التقارير
                                </a>
                            </div>

                        </div>
                    </div>
                </div>

            </div>

            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold mb-0"><i class="bi bi-patch-check ms-1"></i> الشهادات</h5>
                        <a href="certificates.html" class="btn btn-sm btn-outline-primary">
                            عرض الشهادات
                        </a>
                    </div>

                    <div class="row g-3">
                        <div class="col-12 col-md-4">
                            <div class="border rounded p-3 h-100">
                                <div class="text-muted small">إجمالي الشهادات</div>
                                <div class="fs-4 fw-bold" id="certTotal">0</div>
                            </div>
                        </div>

                        <div class="col-12 col-md-4">
                            <div class="border rounded p-3 h-100">
                                <div class="text-muted small">آخر شهادة حاصل عليها</div>
                                <div class="fw-semibold" id="certLatestTitle">—</div>
                                <div class="text-muted small" id="certLatestDate">—</div>
                            </div>
                        </div>

                        <div class="col-12 col-md-4">
                            <div class="border rounded p-3 h-100">
                                <div class="text-muted small">حالة الشهادات</div>
                                <div id="certStatus" class="fw-semibold">—</div>
                            </div>
                        </div>
                    </div>

                    <div class="text-muted small mt-3">
                        * ستظهر الشهادات هنا بعد إتمام الساعات المقررة واعتمادها من قبل المشرفين.
                    </div>
                </div>
            </div>

        </div>
    </main>

    <footer class="mt-5 py-3 bg-primary text-white text-center">
        <div class="container">
            <small>
                © 2026 EduServe - جامعة بوليتكنك فلسطين
            </small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>