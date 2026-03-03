<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>مراجعة طلبات الانضمام</title>
    <link rel="icon" type="image/png" href="/public/images/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">

<?php require_once '../layout/header.php'; ?>

<div class="container py-5">
    <div class="row mb-4">
        <div class="col-md-8 text-start">
            <h3 class="fw-bold text-primary">طلبات انضمام الطلاب</h3>
            <p class="text-muted small">مراجعة ملفات الطلاب المتقدمين لفرص التطوع (قبول أو رفض).</p>
        </div>
    </div>

    <div class="card border-0 shadow-sm overflow-hidden text-center">
        <table class="table mb-0 align-middle">
            <thead class="bg-primary text-white">
                <tr>
                    <th class="py-3">اسم الطالب</th>
                    <th>التخصص</th>
                    <th>الفرصة المطلوبة</th>
                    <th>تاريخ التقديم</th>
                    <th>السجل الأكاديمي</th>
                    <th>اتخاذ قرار</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="fw-bold">ياسين محمد عمر</td>
                    <td>هندسة أنظمة حاسوب</td>
                    <td><span class="badge bg-info-subtle text-info p-2">برمجة تطبيقات</span></td>
                    <td>2026-03-02</td>
                    <td>
                        <button class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-file-earmark-person ms-1"></i>عرض السجل
                        </button>
                    </td>
                    <td>
                        <button class="btn btn-sm btn-success px-3 ms-1">قبول</button>
                        <button class="btn btn-sm btn-danger px-3">رفض</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>