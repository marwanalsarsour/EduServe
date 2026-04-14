<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة تحكم</title>
    <link rel="icon" href="/src/public/images/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="d-flex flex-column min-vh-100">
    <?php require_once '../layout/header.php'; ?>
    <div class="flex-grow-1">
        <div class="container my-4">
            <!-- العنوان -->
            <div class="card shadow-sm mb-4">
                <div
                    class="card-body p-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                    <div>
                        <h3 class="fw-bold mb-1">
                            أهلاً بك،
                            <span id="orgName">اسم المؤسسة/الشركة</span>
                        </h3>
                        <p class="text-muted mb-0">
                            إدارة فرص التدريب والعمل التطوعي الخاصة بمؤسستك
                        </p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="external_adding-opportunities.html" class="btn btn-primary">
                            <i class="bi bi-plus-circle ms-1"></i> إضافة فرص
                        </a>
                    </div>
                </div>
            </div>
            <!-- ادارة الفرص -->
            <div class="row g-4 mb-4">
                <div class="col-12 col-lg-3">
                    <div class="card shadow-sm h-100">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h5 class="fw-bold mb-1">
                                        الفرص المنشورة
                                    </h5>
                                    <div class="text-muted small">
                                        إجمالي الفرص المتاحة
                                    </div>
                                </div>
                                <span class="badge bg-primary fs-6" id="opportunitiesCount"> 0
                                </span>
                            </div>
                            <hr>
                            <div class="text-muted small">
                                عدد الطلاب المسجلين في الفرص
                            </div>
                            <div class="fs-4 fw-bold" id="studentsApplied"> 0
                            </div>
                            <div class="mt-3">
                                <a href="external_opportunities-management.html" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-briefcase ms-1"></i> إدارة الفرص
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ادارة الطلبات -->
                <div class="col-12 col-lg-3">
                    <div class="card shadow-sm h-100">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h5 class="fw-bold mb-1">
                                        طلبات الطلاب
                                    </h5>
                                    <div class="text-muted small">
                                        طلبات بانتظار المراجعة
                                    </div>
                                </div>
                                <span class="badge bg-primary fs-6" id="pendingApplications">
                                    0
                                </span>
                            </div>
                            <hr>
                            <div class="text-muted small">
                                إجمالي الطلبات المقدمة
                            </div>
                            <div class="fs-4 fw-bold" id="totalApplications"> 0
                            </div>
                            <div class="mt-3">
                                <a href="external_application-management.html" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-file-earmark-text ms-1"></i>
                                    إدارة الطلبات
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- إدارة المدربين -->
                <div class="col-12 col-lg-3">
                    <div class="card shadow-sm h-100">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h5 class="fw-bold mb-1">إدارة المدربين</h5>
                                    <div class="text-muted small">عدد المدربين داخل الشركة</div>
                                </div>
                                <span class="badge bg-primary fs-6" id="trainersCount">0</span>
                            </div>
                            <hr>
                            <div class="text-muted small">عدد الطلاب الموزعين عليهم</div>
                            <div class="fs-4 fw-bold" id="assignedStudents">0</div>
                            <div class="mt-3">
                                <a href="external_trainers-management.html" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-people ms-1"></i>
                                    إدارة المدربين
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- إدارة المسؤولين -->
                <div class="col-12 col-lg-3">
                    <div class="card shadow-sm h-100">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h5 class="fw-bold mb-1">إدارة المسؤولين</h5>
                                    <div class="text-muted small">عدد المسؤولين داخل المؤسسة</div>
                                </div>
                                <span class="badge bg-primary fs-6 text-light" id="supervisorsCount">0</span>
                            </div>
                            <hr>
                            <div class="text-muted small">عدد الطلاب تحت إشرافهم</div>
                            <div class="fs-4 fw-bold" id="supervisedStudents">0</div>
                            <div class="mt-3">
                                <a href="external_officials-management.html" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-person-badge ms-1"></i>
                                    إدارة المسؤولين
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4 mb-4">
                <!-- الطلاب المتدربين -->
                <div class="col-12 col-lg-6">
                    <div class="border rounded p-4 h-100">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="fw-bold mb-0">
                                <i class="bi bi-people ms-1"></i>
                                الطلاب المتدربين
                            </h5>
                            <a href="external_trainees-students.html" class="btn btn-sm btn-outline-primary">
                                عرض الطلاب
                            </a>
                        </div>
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="border rounded p-3 text-center">
                                    <div class="text-muted small">
                                        عدد المتدربين الحاليين
                                    </div>
                                    <div class="fs-4 fw-bold" id="activeTrainees">
                                        0
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="border rounded p-3 text-center">
                                    <div class="text-muted small">
                                        إجمالي الطلاب
                                    </div>
                                    <div class="fs-4 fw-bold" id="totalStudents">
                                        0
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-muted small mt-3">
                            * يمكنك متابعة جميع الطلاب المسجلين في التدريب داخل المؤسسة.
                        </div>
                    </div>
                </div>
                <!-- إصدار الشهادات -->
                <div class="col-12 col-lg-6">
                    <div class="border rounded p-4 h-100">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="fw-bold mb-0">
                                <i class="bi bi-award ms-1"></i>
                                إصدار الشهادات
                            </h5>
                            <a href="external_certificates.html" class="btn btn-sm btn-outline-primary">
                                إصدار شهادة
                            </a>
                        </div>
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="border rounded p-3 text-center">
                                    <div class="text-muted small">
                                        إجمالي الشهادات
                                    </div>
                                    <div class="fs-4 fw-bold" id="certificatesTotal">
                                        0
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="border rounded p-3 text-center">
                                    <div class="text-muted small">
                                        إجمالي خطابات التوصية
                                    </div>
                                    <div class="fs-4 fw-bold" id="recommendationtotal">
                                        0
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-muted small mt-3">
                            * يمكنك إصدار الشهادات وخطابات التوصية للطلاب بسهولة.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>