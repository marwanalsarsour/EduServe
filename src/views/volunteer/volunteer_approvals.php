<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>اعتماد الساعات والتقييم</title>
    <link rel="icon" type="image/png" href="/public/images/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">

<?php require_once '../layout/header.php'; ?>

<div class="container py-5">
    <h3 class="fw-bold mb-4 text-primary">اعتماد الساعات والتقييم النهائي</h3>

    <div class="card border-0 shadow-sm overflow-hidden text-center">
        <table class="table mb-0 align-middle">
            <thead class="bg-dark text-white">
                <tr>
                    <th class="py-3">اسم الطالب</th>
                    <th>الفرصة</th>
                    <th>الحضور الميداني</th>
                    <th>اعتماد الساعات</th>
                    <th>التقييم</th>
                    <th>حفظ</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="fw-bold">ليان عمر</td>
                    <td>برمجة تطبيقات</td>
                    <td><span class="text-success small fw-bold">مؤكد من المؤسسة</span></td>
                    <td><input type="number" class="form-control form-control-sm mx-auto" style="width: 70px;" value="30"></td>
                    <td>
                        <select class="form-select form-select-sm mx-auto" style="width: 120px;">
                            <option>ناجح</option>
                            <option>راسب</option>
                        </select>
                    </td>
                    <td><button class="btn btn-sm btn-success px-3">اعتماد</button></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>