<?php 
require_once VIEW_PATH . '/layout/header.php'; 
?>

<?php
$op = $data['opportunity'] ?? null;
if (!$op) { die("لا توجد بيانات لعرضها"); }
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تعديل فرصة تدريب - EduServe</title>
    <link rel="icon" type="image/png" href="/public/images/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100 bg-light">



<main class="flex-grow-1">
<div class="container my-5">
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4 p-md-5">
            <h4 class="fw-bold mb-4 text-primary">
                <i class="bi bi-pencil-square ms-2"></i>
                تعديل فرصة التدريب
            </h4>

            <form method="POST" action="/submit_update_opportunity_process">
                <input type="hidden" name="id" value="<?= htmlspecialchars($op['id']) ?>">

                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold small text-secondary">عنوان التدريب</label>
                        <input type="text" name="title" class="form-control bg-white border-1 py-2" value="<?= htmlspecialchars($op['title']) ?>" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold small text-secondary">نوع التدريب</label>
                        <select name="type" class="form-select bg-white border-1 py-2" required>
                            <option value="volunteer" <?= ($op['type']=='volunteer')?'selected':'' ?>>تطوعي</option>
                            <option value="internship" <?= ($op['type']=='internship')?'selected':'' ?>>تدريب عملي</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold small text-secondary">اسم الشركة / المؤسسة</label>
                        <input type="text" name="organization" class="form-control bg-white border-1 py-2" value="<?= htmlspecialchars($op['organization']) ?>" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold small text-secondary">الموقع</label>
                        <input type="text" name="location" class="form-control bg-white border-1 py-2" value="<?= htmlspecialchars($op['location']) ?>" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold small text-secondary">مدة التدريب</label>
                        <input type="text" name="duration" class="form-control bg-white border-1 py-2" value="<?= htmlspecialchars($op['duration']) ?>" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold small text-secondary">تاريخ البدء</label>
                        <input type="date" name="start_date" class="form-control bg-white border-1 py-2" value="<?= htmlspecialchars($op['start_date']) ?>" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold small text-secondary">آخر موعد للتقديم</label>
                        <input type="date" name="deadline" class="form-control bg-white border-1 py-2" value="<?= htmlspecialchars($op['deadline']) ?>" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold small text-secondary">عدد المقاعد</label>
                        <input type="number" name="seats" min="1" class="form-control bg-white border-1 py-2" value="<?= htmlspecialchars($op['seats']) ?>" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold small text-secondary">بريد التواصل</label>
                        <input type="email" name="contact_email" class="form-control bg-white border-1 py-2" value="<?= htmlspecialchars($op['contact_email'] ?? '') ?>">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold small text-secondary">رقم الهاتف</label>
                        <input type="text" name="contact_phone" class="form-control bg-white border-1 py-2" value="<?= htmlspecialchars($op['contact_phone'] ?? '') ?>">
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-bold small text-secondary">حالة الفرصة</label>
                        <select name="status" class="form-select bg-white border-1 py-2">
                            <option value="active" <?= ($op['status']=='active')?'selected':'' ?>>متاحة</option>
                            <option value="closed" <?= ($op['status']=='closed')?'selected':'' ?>>مغلقة</option>
                        </select>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-bold small text-secondary">الوصف</label>
                        <textarea name="description" rows="4" class="form-control bg-white border-1" required><?= htmlspecialchars($op['description']) ?></textarea>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-bold small text-secondary">المتطلبات الأساسية</label>
                        <textarea name="requirements" rows="3" class="form-control bg-white border-1"><?= htmlspecialchars($op['requirements']) ?></textarea>
                    </div>
                </div>

                <div class="mt-5 text-start">
                    <button type="submit" class="btn btn-primary rounded-pill px-5 fw-bold">
                        <i class="bi bi-save ms-1"></i> حفظ التغييرات
                    </button>
                    <a href="/supervisor_dashboard" class="btn btn-link text-secondary text-decoration-none">إلغاء</a>
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