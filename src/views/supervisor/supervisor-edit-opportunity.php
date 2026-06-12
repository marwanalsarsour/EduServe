<?php 
require_once VIEW_PATH . '/layout/header.php'; 

$op = $data['opportunity'] ?? null;
if (!$op) { die("لا توجد بيانات لعرضها"); }
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تعديل فرصة تدريب</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>
<body class="d-flex flex-column min-vh-100 bg-light">

<main class="flex-grow-1">
<div class="container my-5">
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4 p-md-5">
            <h4 class="fw-bold mb-4 text-primary">
                <i class="bi bi-pencil-square ms-2"></i> تعديل فرصة التدريب
            </h4>

            <form method="POST" action="/submit_update_opportunity_process">
                <input type="hidden" name="id" value="<?= htmlspecialchars($op['opportunityID'] ?? '') ?>">
                <input type="hidden" name="entityID" value="<?= htmlspecialchars($op['entityID'] ?? '') ?>">

                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold small text-secondary">عنوان التدريب</label>
                        <input type="text" name="title" class="form-control bg-white border-1 py-2" value="<?= htmlspecialchars($op['title'] ?? '') ?>" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold small text-secondary">نوع التدريب</label>
                        <select name="type" class="form-select bg-white border-1 py-2" required>
                            <option value="تطوع" <?= (($op['type'] ?? '') == 'تطوع') ? 'selected' : '' ?>>تطوع</option>
                            <option value="تدريب" <?= (($op['type'] ?? '') == 'تدريب') ? 'selected' : '' ?>>تدريب</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold small text-secondary">اسم الشركة / المؤسسة</label>
                        <input type="text" class="form-control bg-white border-1 py-2" value="<?= htmlspecialchars($op['organization'] ?? '') ?>" readonly>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold small text-secondary">الموقع</label>
                        <input type="text" name="location" class="form-control bg-white border-1 py-2" value="<?= htmlspecialchars($op['location'] ?? '') ?>">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold small text-secondary">عدد المقاعد</label>
                        <input type="number" name="seats" min="1" class="form-control bg-white border-1 py-2" value="<?= htmlspecialchars($op['seats'] ?? '0') ?>" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold small text-secondary">حالة الفرصة</label>
                        <select name="status" class="form-select bg-white border-1 py-2">
                            <option value="نشط" <?= (($op['status'] ?? '') == 'نشط') ? 'selected' : '' ?>>نشط</option>
                            <option value="مغلق" <?= (($op['status'] ?? '') == 'مغلق') ? 'selected' : '' ?>>مغلق</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold small text-secondary">اسم الموظف المسؤول</label>
                        <input type="text" class="form-control bg-white border-1 py-2" value="<?= htmlspecialchars($op['employeeName'] ?? '') ?>" readonly>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold small text-secondary">بريد التواصل</label>
                        <input type="email" class="form-control bg-white border-1 py-2" value="<?= htmlspecialchars($op['contact_email'] ?? '') ?>" readonly>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-bold small text-secondary">الوصف</label>
                        <textarea name="description" rows="4" class="form-control bg-white border-1" required><?= htmlspecialchars($op['description'] ?? '') ?></textarea>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-bold small text-secondary">الشروط والمتطلبات</label>
                        <textarea name="conditions" rows="3" class="form-control bg-white border-1"><?= htmlspecialchars($op['conditions'] ?? '') ?></textarea>
                    </div>
                </div>

                <div class="mt-5 text-start">
                    <button type="submit" class="btn btn-primary rounded-pill px-5 fw-bold">
                        <i class="bi bi-save ms-1"></i> حفظ التغييرات
                    </button>
                    <a href="/supervisor/opportunities" class="btn btn-link text-secondary text-decoration-none">إلغاء</a>
                </div>
            </form>
        </div>
    </div>
</div>
</main>
<footer class="mt-auto py-3 bg-white text-center border-top">
    <small>© 2026 EduServe - جامعة بوليتكنك فلسطين</small>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>