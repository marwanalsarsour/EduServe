<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>مراجعة كشوف الحضور</title>
    <link rel="icon" type="image/png" href="/public/images/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">

<?php require_once '../layout/header.php'; ?>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-primary">مراجعة الحضور الميداني</h3>
        <span class="badge bg-warning text-dark px-3 py-2">بانتظار الاعتماد الأكاديمي</span>
    </div>

    <div class="card border-0 shadow-sm overflow-hidden text-center">
        <table class="table mb-0 align-middle">
            <thead class="bg-dark text-white">
                <tr>
                    <th class="py-3 px-4">الطالب</th>
                    <th>التاريخ</th>
                    <th>وقت الحضور</th>
                    <th>وقت الانصراف</th>
                    <th>ساعات اليوم</th>
                    <th>حالة المدرب الميداني</th>
                    <th>الإجراء</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="px-4 fw-bold">ليان علي</td>
                    <td>2026-03-01</td>
                    <td>08:00 AM</td>
                    <td>01:00 PM</td>
                    <td>5 ساعات</td>
                    <td><span class="text-success small fw-bold"><i class="bi bi-check-circle-fill ms-1"></i>مؤكد ميدانياً</span></td>
                    <td>
                        <button class="btn btn-sm btn-primary px-3 shadow-sm">اعتماد اليوم</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>