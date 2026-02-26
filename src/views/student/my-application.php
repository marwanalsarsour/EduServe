<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>طلباتي</title>
    <link rel="icon" type="image/png" href="/public/images/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="bg-light d-flex flex-column min-vh-100">

    <nav class="navbar navbar-expand-lg bg-primary" data-bs-theme="dark">
        <div class="container-fluid">
            <div class="p-1 me-3 m-1 ms-4">
                <img src="../../assets/img/LogoNav.png" alt="LogoNav">
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
                            <a class="nav-link active" aria-current="page" href="/View/Student/my-application.html">طلباتي</a>
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

    <div class="flex-grow-1">
        <div class="container py-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold mb-0">
                    طلباتي
                </h4>

                <a href="opportunities.html" class="btn btn-primary">
                    <i class="bi bi-plus-circle ms-1"></i>
                    التقديم على فرصة جديدة
                </a>
                <!-- احط هيك اشي تحت كلمة طلباتي؟؟؟ -->
                <!-- <p class="fw-semibold mb-2">حالات الطلب التي تم التقديم عليها</p> -->
            </div>

            <!-- لما يصير في خطأ في الصفحة تظهر رساله معينه يحددها الباك اند واذا بدنا بنلغيه -->
            <div id="applicationsMsg" class="alert d-none" role="alert"></div>

            <div class="card shadow-sm border-0">
                <div class="card-body p-4">

                    <!-- لما يكون فش طلبات يعني لما يكون في طلبات يظهر الجدول فش تظهر هاي الرساله 
          وبنقدر نلغيها و نخلي الجدول فاضي(فارغ)-->
                    <div id="noApplications" class="text-center text-muted py-5 d-none">
                        <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                        لا يوجد طلبات حتى الآن.
                    </div>

                    <div class="table-responsive">
                        <table class="table align-middle text-center mb-0" id="applicationsTable">
                            <thead class="table-light">
                                <tr>
                                    <th>الفرصة</th>
                                    <th>النوع</th>
                                    <th>الحالة</th>
                                </tr>
                            </thead>
                            <tbody id="applicationsBody">

                            </tbody>
                        </table>
                    </div>

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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>


</body>

</html>