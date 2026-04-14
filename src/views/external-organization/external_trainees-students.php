<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>الطلاب المتدربين</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="/src/public/images/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="d-flex flex-column min-vh-100">
    <?php require_once '../layout/header.php'; ?>
    <div class="container my-4">
        <!-- العنوان -->
        <div class="card shadow-sm border-1 mb-4">
            <div class="card-body p-4">
                <h4 class="fw-bold mb-1">
                    <i class="bi bi-people ms-1"></i>
                    الطلاب المتدربين
                </h4>
                <p class="text-muted mb-0">
                    عرض جميع الطلاب المتدربين داخل الشركة / المؤسسة
                </p>
            </div>
        </div>
        <!--  البحث وفلتره -->
        <div class="card shadow-sm mb-4">
            <div class="card-body p-3">
                <div class="row g-3">
                    <div class="col-md-4">
                        <input type="text" id="searchInput" class="form-control" placeholder="بحث باسم الطالب...">
                    </div>
                    <div class="col-md-4">
                        <select id="statusFilter" class="form-select">
                            <option value="">كل الحالات</option>
                            <option value="active">نشط</option>
                            <option value="completed">منتهي</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-primary w-100" onclick="filterStudents()">
                            <i class="bi bi-search"></i> بحث
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- جدول الطلاب -->
        <div class="card shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 text-center">

                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>اسم الطالب</th>
                                <th>التخصص</th>
                                <th>الفرصة</th>
                                <th>المدرب</th>
                                <th>عدد الساعات</th>
                                <th>الحالة</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>

                        <tbody id="studentsTable">
                            <!-- طالب نشط -->
                            <!-- في الاجراءات لا يظهر بوتون اصدار الشهادات الا للطلاب ال انهوا التدريب والا لا تظهر
                               اما بوتون عرض ملف الشخصي للطالب يظهر في كلا الحالتين -->
                            <tr data-status="active" data-id="1">
                                <td>1</td>
                                <td>أحمد محمد</td>
                                <td>علم الحاسوب</td>
                                <td>تدريب ويب</td>
                                <td>محمد أحمد</td>
                                <td>120</td>
                                <td><span class="badge bg-success">نشط</span></td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <!-- Portfolio فقط -->
                                        <button class="btn btn-sm btn-outline-info portfolioBtn" data-student-id="101">
                                            <i class="bi bi-person-badge"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <!-- طالب منتهي -->
                            <tr data-status="completed" data-id="2">
                                <td>2</td>
                                <td>محمود خالد</td>
                                <td>هندسة برمجيات</td>
                                <td>تدريب موبايل</td>
                                <td>علي حسن</td>
                                <td>150</td>
                                <td><span class="badge bg-secondary">منتهي</span></td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <!-- Portfolio -->
                                        <button class="btn btn-sm btn-outline-info portfolioBtn" data-student-id="102">
                                            <i class="bi bi-person-badge"></i>
                                        </button>
                                        <!-- شهادة (فقط للمنتهي) -->
                                        <button class="btn btn-sm btn-outline-success" onclick="goToCertificate(2)">
                                            <i class="bi bi-award"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>