<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تعديل فرصة تطوع</title>
    <link rel="icon" type="image/png" href="/public/images/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100 bg-light">

<?php require_once '../layout/header.php'; ?>

<div class="container mt-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="volunteer_opportunities.php">إدارة الفرص</a></li>
            <li class="breadcrumb-item active" aria-current="page">تعديل فرصة</li>
        </ol>
    </nav>

    <div class="card border-0 shadow-sm mx-auto" style="max-width: 800px;">
        <div class="card-header bg-primary text-white py-3">
            <h5 class="mb-0 fw-bold"><i class="bi bi-pencil-square ms-2"></i>تعديل بيانات فرصة التطوع</h5>
        </div>
        <div class="card-body p-4 text-start">
            <form action="volunteer_process.php" method="POST">
                <input type="hidden" name="opportunity_id" value="123">

                <div class="mb-3">
                    <label class="form-label fw-bold small">عنوان الفرصة</label>
                    <input type="text" name="title" class="form-control" value="تنظيم فعاليات معرض الكتاب" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold small">الجهة المستضيفة</label>
                        <input type="text" name="org" class="form-control" value="عمادة شؤون الطلاب" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold small">عدد الساعات المعتمدة</label>
                        <input type="number" name="hours" class="form-control" value="25" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold small">وصف المهام والمسؤوليات</label>
                    <textarea name="description" class="form-control" rows="4">تنظيم دخول الزوار، مساعدة المشاركين في ترتيب الكتب، وتوجيه الطلاب...</textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold small">حالة الفرصة</label>
                        <select name="status" class="form-select">
                            <option value="active" selected>نشطة (منشورة للطلاب)</option>
                            <option value="inactive">متوقفة (مسودة)</option>
                            <option value="closed">مكتملة</option>
                        </select>
                    </div>
                </div>

                <hr class="my-4">
                <div class="d-flex justify-content-end gap-2">
                    <a href="volunteer_opportunities.php" class="btn btn-light px-4">إلغاء</a>
                    <button type="submit" name="update_opp" class="btn btn-primary px-4">حفظ التعديلات</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>