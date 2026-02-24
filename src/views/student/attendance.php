<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>توثيق الحضور</title>
    <link rel="icon" type="image/png" href="/images/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="bg-light d-flex flex-column min-vh-100">
<?php 
require_once VIEW_PATH . '/layout/header.php'; 
?>
  <!--   <nav class="navbar navbar-expand-lg bg-primary" data-bs-theme="dark">
        <div class="container-fluid">
            <div class="p-1 me-3 m-1 ms-4">
                <img src="/public/images/LogoNav.png" alt="LogoNav">
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
                            <a class="nav-link active" aria-current="page"
                                href="/View/Student/attendance.html">الحضور</a>
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
    </nav> -->

    <div class="flex-grow-1">
        <div class="container py-4">

            <h4 class="fw-bold mb-4">
                <i class="bi bi-calendar-check ms-2"></i>
                توثيق ساعات الحضور
            </h4>
            <div class="card shadow-sm mb-4 border-0">
                <div class="card-body">
                    <!-- هاي عشان نعرف اذا هو تدريب او عمل تطوعي -->
                    <h5 id="opportunityType" class="fw-bold text-primary mb-2">
                        -
                    </h5>

                    <h6 id="organizationName" class="text-muted">
                        <!-- هون اسم الشركة --> -
                    </h6>

                </div>
            </div>

            <div id="attendanceMsg" class="alert d-none"></div>

            <div class="card shadow-sm border-0">
                <div class="card-body table-responsive">

                    <table class="table table-bordered text-center align-middle">

                        <thead class="table-light">
                            <tr>
                                <th>التاريخ</th>
                                <th>اليوم</th>
                                <th>ساعة القدوم</th>
                                <th>ساعة المغادرة</th>
                                <th>مجموع الساعات</th>
                                <th>توقيع الطالب</th>
                                <th>توقيع المشرف</th>
                            </tr>
                        </thead>

                        <tbody id="attendanceTableBody"></tbody>

                    </table>

                </div>
            </div>

            <!-- هون لازم تضبط اديش عدد الساعات المقطوعه عن طريق ال اي دي تاعها -->
            <div class="card mt-3 shadow-sm border-0">
                <div class="card-body d-flex justify-content-between align-items-center">

                    <h6 class="mb-0 fw-bold">
                        إجمالي الساعات الكلي:
                        <span id="totalHours" class="text-primary">0 ساعة</span>
                    </h6>

                    <button class="btn btn-success" onclick="saveChanges()">
                        <i class="bi bi-save ms-1"></i>
                        حفظ التغييرات
                    </button>

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