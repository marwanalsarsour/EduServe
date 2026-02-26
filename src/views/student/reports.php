<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>التقارير</title>
    <link rel="icon" type="image/png" href="/public/images/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="bg-light d-flex flex-column min-vh-100">

    <nav class="navbar navbar-expand-lg bg-primary" data-bs-theme="dark">
        <div class="container-fluid">
            <div class="p-1 me-3 m-1 ms-4">
                <img src="/assets/img/LogoNav.png" alt="LogoNav">
            </div>
            <span class="navbar-brand text-white mb-0 h1">EduServe</span>
            <button class="navbar-toggler me-3" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
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
                            <a class="nav-link" aria-current="page" href="/View/Student/opportunities.html">الفرص</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="/View/Student/my-application.html">طلباتي</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="/View/Student/attendance.html">الحضور</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active pe-3" aria-current="page"
                                href="/View/Student/reports.html">التقارير</a>
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

    <div class="flex-grow-1">
        <div class="container py-4">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold mb-0">
                    التقارير
                </h4>

                <a href="report-submit.html" class="btn btn-primary">
                    <i class="bi bi-upload ms-1"></i>
                    رفع تقرير
                </a>
            </div>

            <div id="reportsMsg" class="alert d-none"></div>

            <div class="card shadow-sm border-0">
                <div class="card-body table-responsive">

                    <table class="table table-bordered text-center align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>اسم التقرير</th>
                                <th>تاريخ الرفع</th>
                                <th>الحالة</th>
                                <th>تحميل</th>
                            </tr>
                        </thead>

                        <tbody id="reportsTableBody"></tbody>

                    </table>

                </div>
            </div>

        </div>
    </div>

    <footer class="mt-5 py-3 bg-primary text-white text-center">
        <div class="container">
            <small>
                © 2026 EduServe - جامعة بوليتكنك فلسطين
            </small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"> </script>

</body>

</html>