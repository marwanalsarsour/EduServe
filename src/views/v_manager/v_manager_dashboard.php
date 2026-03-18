<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>لوحة التحكم - مسؤول النشاط</title>
    <link rel="icon" type="image/png" href="/public/images/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="/public/css/styles.css">
</head>
<body class="bg-light">
    <?php require_once '../layout/header.php'; ?>

    <div class="container py-5">
        <div class="row mb-4">
            <div class="col-12 text-start">
                <h3 class="fw-bold text-dark mb-1">مرحباً بك، مسؤول النشاط التطوعي</h3>
                <p class="text-muted small">نظرة عامة على نشاط المتطوعين اليوم</p>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-danger text-white">
                    <div class="d-flex align-items-center">
                        <div class="text-start">
                            <h2 class="fw-bold mb-0">12</h2>
                            <p class="mb-0 small opacity-75">متطوع نشط</p>
                        </div>
                        <i class="bi bi-people fs-1 opacity-50 ms-auto"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white border-bottom border-4 border-danger text-start">
                    <div class="d-flex align-items-center">
                        <div>
                            <h2 class="fw-bold mb-0 text-dark">540</h2>
                            <p class="mb-0 text-muted small">ساعة منجزة كلياً</p>
                        </div>
                        <i class="bi bi-clock-history fs-1 text-danger opacity-25 ms-auto"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white border-bottom border-4 border-warning text-start">
                    <div class="d-flex align-items-center">
                        <div>
                            <h2 class="fw-bold mb-0 text-dark">8</h2>
                            <p class="mb-0 text-muted small">إشعارات جديدة</p>
                        </div>
                        <i class="bi bi-bell fs-1 text-warning opacity-25 ms-auto"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-5 text-start">
            <h5 class="fw-bold mb-3">الوصول السريع</h5>
            <div class="d-flex gap-2">
                <a href="v_manager_attendance.php" class="btn btn-danger rounded-pill px-4 shadow-sm fw-bold">رصد الحضور اليومي</a>
                <a href="v_manager_list.php" class="btn btn-outline-dark rounded-pill px-4 shadow-sm fw-bold">قائمة المتطوعين</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>