<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم - مسؤول النشاط</title>
    <link rel="icon" type="image/png" href="/public/images/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="/public/css/styles.css">
</head>
<body class="bg-light text-end">
    <?php require_once '../src/views/layout/header.php'; ?>

    <div class="container py-5">
        <div class="row mb-4">
            <div class="col-12">
                <h3 class="fw-bold text-dark mb-1">مرحباً بك، مسؤول النشاط التطوعي</h3>
                <p class="text-muted small">نظرة عامة على نشاط المتطوعين اليوم</p>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-danger text-white">
                    <div class="d-flex align-items-center">
                        <div>
                            <h2 class="fw-bold mb-0"><?= $data['active_volunteers'] ?></h2>
                            <p class="mb-0 small opacity-75">متطوع نشط</p>
                        </div>
                        <i class="bi bi-people fs-1 opacity-50 ms-auto"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white border-bottom border-4 border-danger">
                    <div class="d-flex align-items-center">
                        <div>
                            <h2 class="fw-bold mb-0 text-dark"><?= $data['total_hours'] ?></h2>
                            <p class="mb-0 text-muted small">ساعة منجزة كلياً</p>
                        </div>
                        <i class="bi bi-clock-history fs-1 text-danger opacity-25 ms-auto"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white border-bottom border-4 border-warning">
                    <div class="d-flex align-items-center">
                        <div>
                            <h2 class="fw-bold mb-0 text-dark"><?= $data['notifications_count'] ?></h2>
                            <p class="mb-0 text-muted small">إشعارات جديدة</p>
                        </div>
                        <i class="bi bi-bell fs-1 text-warning opacity-25 ms-auto"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-5">
            <h5 class="fw-bold mb-3">الوصول السريع</h5>
            <div class="d-flex gap-2 flex-wrap">
                <a href="/v_manager/attendance" class="btn btn-danger rounded-pill px-4 shadow-sm fw-bold">
                    <i class="bi bi-calendar-check ms-2"></i>رصد الحضور اليومي
                </a>
                <a href="/v_manager/volunteers" class="btn btn-outline-dark rounded-pill px-4 shadow-sm fw-bold">
                    <i class="bi bi-list-ul ms-2"></i>قائمة المتطوعين
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>