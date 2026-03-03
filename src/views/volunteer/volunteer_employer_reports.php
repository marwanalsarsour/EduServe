<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تقارير جهات التطوع</title>
    <link rel="icon" type="image/png" href="/public/images/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">

<?php require_once '../layout/header.php'; ?>

<div class="container py-5">
    <h3 class="fw-bold text-primary mb-4">تقارير المؤسسات المستضيفة</h3>
    
    <div class="card border-0 shadow-sm overflow-hidden text-center">
        <table class="table mb-0 align-middle">
            <thead class="bg-dark text-white">
                <tr>
                    <th class="py-3 px-4 text-start">المؤسسة</th>
                    <th>اسم الطالب</th>
                    <th>تاريخ التقرير</th>
                    <th>المرفق</th>
                    <th>الإجراء</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="px-4 text-start">جمعية الأمل</td>
                    <td>خالد أحمد</td>
                    <td>2026-03-01</td>
                    <td><i class="bi bi-file-earmark-pdf text-danger fs-5"></i></td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary">مراجعة والرد</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>