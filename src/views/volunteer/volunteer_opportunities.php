<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>إدارة فرص التطوع</title>
    <link rel="icon" type="image/png" href="/public/images/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">

<?php require_once '../layout/header.php'; ?>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">التحكم بفرص التطوع</h3>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addOppModal">
            <i class="bi bi-plus-lg ms-2"></i>إضافة فرصة تطوع
        </button>
    </div>

    <div class="card border-0 shadow-sm overflow-hidden">
        <table class="table mb-0 align-middle">
            <thead class="bg-primary text-white">
                <tr>
                    <th class="py-3 px-4">عنوان الفرصة</th>
                    <th>جهة التطوع</th>
                    <th>عدد الساعات</th>
                    <th>الحالة</th>
                    <th class="text-center">التحكم</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="px-4 fw-bold">تطوير موقع جمعية الأمل</td>
                    <td>جمعية الأمل الخيرية</td>
                    <td>40 ساعة</td>
                    <td><span class="badge bg-success">نشط</span></td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i></button>
                        <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="addOppModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header">
                <h5 class="fw-bold">إضافة فرصة تطوع</h5>
                <button type="button" class="btn-close ms-0" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4 text-start">
                <form action="process.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">اسم الفرصة التطوعية</label>
                        <input type="text" class="form-control" placeholder="مثال: تنظيم فعاليات تقنية">
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold">المؤسسة المستضيفة</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold">عدد الساعات المطلوبة</label>
                            <input type="number" class="form-control">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">وصف المهام</label>
                        <textarea class="form-control" rows="3"></textarea>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary px-5">نشر الفرصة</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>