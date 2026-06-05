<?php 
require_once VIEW_PATH . '/layout/header.php'; 
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تعديل فرصة تطوع | EduServe</title>
    <link rel="icon" type="image/png" href="/public/images/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100 bg-light">



<div class="container mt-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/volunteer_opportunities">إدارة الفرص</a></li>
            <li class="breadcrumb-item active" aria-current="page">تعديل فرصة</li>
        </ol>
    </nav>

    <div class="card border-0 shadow-sm mx-auto" style="max-width: 800px;">
        <div class="card-header bg-primary text-white py-3">
            <h5 class="mb-0 fw-bold"><i class="bi bi-pencil-square ms-2"></i>تعديل بيانات فرصة التطوع</h5>
        </div>
        <div class="card-body p-4 text-start">
            <form action="/volunteer_update_opportunity" method="POST">
                <input type="hidden" name="opportunity_id" value="<?= $opportunity['id'] ?>">

                <div class="mb-3 text-end">
                    <label class="form-label fw-bold small text-secondary">عنوان الفرصة</label>
                    <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($opportunity['title']) ?>" required>
                </div>

                <div class="row text-end">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold small text-secondary">الجهة المستضيفة</label>
                        <input type="text" name="org" class="form-control" value="<?= htmlspecialchars($opportunity['org_name']) ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold small text-secondary">عدد الساعات المعتمدة</label>
                        <input type="number" name="hours" class="form-control" value="<?= $opportunity['hours'] ?>" required>
                    </div>
                </div>

                <div class="mb-3 text-end">
                    <label class="form-label fw-bold small text-secondary">وصف المهام والمسؤوليات</label>
                    <textarea name="description" class="form-control" rows="4"><?= htmlspecialchars($opportunity['description']) ?></textarea>
                </div>

                <div class="row text-end">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold small text-secondary">حالة الفرصة</label>
                        <select name="status" class="form-select">
                            <option value="active" <?= $opportunity['status'] == 'active' ? 'selected' : '' ?>>نشطة (منشورة للطلاب)</option>
                            <option value="inactive" <?= $opportunity['status'] == 'inactive' ? 'selected' : '' ?>>متوقفة (مسودة)</option>
                            <option value="closed" <?= $opportunity['status'] == 'closed' ? 'selected' : '' ?>>مكتملة</option>
                        </select>
                    </div>
                </div>

                <hr class="my-4">
                <div class="d-flex justify-content-end gap-2">
                    <a href="/volunteer_opportunities" class="btn btn-light px-4">إلغاء</a>
                    <button type="submit" name="update_opp" class="btn btn-primary px-4">حفظ التعديلات</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>