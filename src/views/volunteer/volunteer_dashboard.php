<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم - مشرف التطوع</title>
    <link rel="icon" type="image/png" href="/public/images/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">

<?php require_once '../layout/header.php'; ?>

<div class="container py-5">
    <div class="row g-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm text-center p-4">
                <div class="rounded-circle bg-primary bg-opacity-10 p-3 d-inline-block mb-3 mx-auto">
                    <i class="bi bi-megaphone text-primary fs-3"></i>
                </div>
                <h6 class="text-muted">الفرص النشطة</h6>
                <h3 class="fw-bold">12</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm text-center p-4">
                <div class="rounded-circle bg-warning bg-opacity-10 p-3 d-inline-block mb-3 mx-auto">
                    <i class="bi bi-person-plus text-warning fs-3"></i>
                </div>
                <h6 class="text-muted">طلبات بانتظار المراجعة</h6>
                <h3 class="fw-bold">5</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm text-center p-4">
                <div class="rounded-circle bg-success bg-opacity-10 p-3 d-inline-block mb-3 mx-auto">
                    <i class="bi bi-clock-history text-success fs-3"></i>
                </div>
                <h6 class="text-muted">ساعات بانتظار الاعتماد</h6>
                <h3 class="fw-bold">120</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm text-center p-4">
                <div class="rounded-circle bg-info bg-opacity-10 p-3 d-inline-block mb-3 mx-auto">
                    <i class="bi bi-bell text-info fs-3"></i>
                </div>
                <h6 class="text-muted">إشعارات اليوم</h6>
                <h3 class="fw-bold">7</h3>
            </div>
        </div>
    </div>

    <div class="mt-5 card border-0 shadow-sm p-4">
        <h5 class="fw-bold mb-4">أحدث طلبات التطوع بانتظار قرارك</h5>
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>الطالب</th>
                        <th>الفرصة</th>
                        <th>التاريخ</th>
                        <th>الإجراء</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>أحمد محمود</td>
                        <td>مساعدة إدارية</td>
                        <td>2026-03-03</td>
                        <td><a href="volunteer_requests.php" class="btn btn-sm btn-outline-primary">مراجعة الطلب</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>