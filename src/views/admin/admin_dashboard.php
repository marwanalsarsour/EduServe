<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title> لوحة تحكم </title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="/EduServe/src/public/images/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="d-flex flex-column min-vh-100">
    <?php require_once '../layout/header.php'; ?>
    <main class="flex-grow-1">
        <div class="container my-4">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body p-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                    <div>
                        <h3 class="fw-bold mb-1">
                            أهلاً بك، <span id="adminName">إدارة الكلية</span>
                        </h3>
                        <p class="text-muted mb-0">
                            إليك نظرة عامة على آخر التطورات.
                        </p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="/EduServe/src/views/admin/admin_students-management.html" class="btn btn-primary">
                            <i class="bi bi-people ms-1"></i> إدارة الطلاب
                        </a>
                        <a href="/EduServe/src/views/admin/admin_opportunities-management.html" class="btn btn-outline-primary">
                            <i class="bi bi-briefcase ms-1"></i> إدارة الفرص
                        </a>
                    </div>
                </div>
            </div>

            <!-- الأنشطة الأخيرة -->
            <div class="card shadow-sm mb-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold mb-0">
                            <i class="bi bi-clock-history ms-1"></i> آخر الأنشطة
                        </h5>
                        <a href="/EduServe/src/views/admin/admin_application-management.html" class="btn btn-sm btn-outline-primary"> عرض الكل </a>
                    </div>
                    <div id="recentActivity" class="text-muted"> لا يوجد أنشطة حديثة حالياً. </div>
                </div>
            </div>

            <!-- الإحصائيات -->
            <div class="row g-4 mb-4">
                <!-- الطلاب -->
                <div class="col-12 col-lg-6">
                    <div class="card shadow-sm h-100">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h5 class="fw-bold mb-1"> الطلاب </h5>
                                    <div class="text-muted small"> إجمالي الطلاب المسجلين </div>
                                </div>
                                <span class="badge bg-primary">
                                    <i class="bi bi-people"></i>
                                </span>
                            </div>
                            <hr class="my-3">
                            <div class="d-flex justify-content-between">
                                <span class="text-muted small"> عدد الطلاب </span>
                                <span class="fw-semibold" id="studentsCount"> 0 </span>
                            </div>
                            <div class="mt-3 d-flex gap-2">
                                <a href="/EduServe/src/views/admin/admin_students-management.html" class="btn btn-sm btn-outline-primary"> عرض الطلاب </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- الفرص -->
                <div class="col-12 col-lg-6">
                    <div class="card shadow-sm h-100">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h5 class="fw-bold mb-1"> الفرص </h5>
                                    <div class="text-muted small"> إجمالي الفرص المتاحة </div>
                                </div>
                                <span class="badge bg-primary">
                                    <i class="bi bi-briefcase"></i>
                                </span>
                            </div>
                            <hr class="my-3">
                            <div class="d-flex justify-content-between">
                                <span class="text-muted small"> عدد الفرص </span>
                                <span class="fw-semibold" id="opportunitiesCount"> 0 </span>
                            </div>
                            <div class="mt-3 d-flex gap-2">
                                <a href="/EduServe/src/views/admin/admin_opportunities-management.html" class="btn btn-sm btn-outline-primary"> إدارة الفرص </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- الطلبات -->
            <div class="row g-4 mb-4">
                <div class="col-12 col-lg-6">
                    <div class="card shadow-sm h-100">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h5 class="fw-bold mb-1"> طلبات </h5>
                                    <div class="text-muted small"> طلبات الطلاب المقدمة </div>
                                </div>
                                <span class="badge bg-primary">
                                    <i class="bi bi-file-earmark-text"></i>
                                </span>
                            </div>
                            <hr class="my-3">
                            <div class="d-flex justify-content-between">
                                <span class="text-muted small"> عدد الطلبات </span>
                                <span class="fw-semibold" id="applicationsCount"> 0 </span>
                            </div>
                            <div class="mt-3 d-flex gap-2">
                                <a href="/EduServe/src/views/admin/admin_application-management.html" class="btn btn-sm btn-outline-primary"> عرض الطلبات </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- التقارير -->
                <div class="col-12 col-lg-6">
                    <div class="card shadow-sm h-100">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h5 class="fw-bold mb-1"> التقارير </h5>
                                    <div class="text-muted small">  تقارير المرفوعة من الطلاب</div>
                                </div>
                                <span class="badge bg-primary">
                                    <i class="bi bi-bar-chart"></i>
                                </span>
                            </div>
                            <hr class="my-3">
                            <div class="d-flex justify-content-between">
                                <span class="text-muted small"> عدد التقارير </span>
                                <span class="fw-semibold" id="reportsCount"> 0 </span>
                            </div>
                            <div class="mt-3 d-flex gap-2">
                                <a href="/EduServe/src/views/admin/admin_report-management.html" class="btn btn-sm btn-outline-primary"> عرض التقارير </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- الشهادات -->
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold mb-0">
                            <i class="bi bi-award ms-1"></i> الشهادات
                        </h5>
                        <a href="certificates.html" class="btn btn-sm btn-outline-primary"> إدارة الشهادات </a>
                    </div>
                    <div class="row g-3">
                        <div class="col-12 col-md-4">
                            <div class="border rounded p-3">
                                <div class="text-muted small"> إجمالي الشهادات </div>
                                <div class="fs-4 fw-bold" id="certTotal"> 0 </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="border rounded p-3">
                                <div class="text-muted small"> آخر شهادة صادرة </div>
                                <div class="fw-semibold" id="certLatestTitle"> — </div>
                                <div class="text-muted small" id="certLatestDate"> — </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="border rounded p-3">
                                <div class="text-muted small"> الجهات المسجلة </div>
                                <div class="fw-semibold" id="companiesCount"> 0 </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>