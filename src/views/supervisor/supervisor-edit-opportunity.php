<?php
// حماية من الخطأ إذا ما انمررت البيانات
$op = $data['opportunity'] ?? null;

if (!$op) {
    die("لا توجد بيانات لعرضها");
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تعديل فرصة تدريب</title>
    <link rel="icon" type="image/png" href="/public/images/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="d-flex flex-column min-vh-100">

<?php require_once '../layout/header.php'; ?>

<main class="flex-grow-1">
<div class="container my-5">

<div class="card shadow-sm">
<div class="card-body p-4">

<h4 class="fw-bold mb-4">
<i class="bi bi-pencil-square ms-2"></i>
تعديل فرصة التدريب
</h4>

<form method="POST" action="/supervisor/update-opportunity">

<input type="hidden" name="id" value="<?= htmlspecialchars($op['id']) ?>">

<div class="row g-3">

<div class="col-md-6">
<label class="form-label fw-semibold">عنوان التدريب</label>
<input type="text" name="title" class="form-control"
value="<?= htmlspecialchars($op['title']) ?>" required>
</div>

<div class="col-md-6">
<label class="form-label fw-semibold">نوع التدريب</label>
<select name="type" class="form-select" required>
<option value="volunteer" <?= ($op['type']=='volunteer')?'selected':'' ?>>تطوعي</option>
<option value="internship" <?= ($op['type']=='internship')?'selected':'' ?>>تدريب عملي</option>
</select>
</div>

<div class="col-md-6">
<label class="form-label fw-semibold">اسم الشركة / المؤسسة</label>
<input type="text" name="organization" class="form-control"
value="<?= htmlspecialchars($op['organization']) ?>" required>
</div>

<div class="col-md-6">
<label class="form-label fw-semibold">الموقع</label>
<input type="text" name="location" class="form-control"
value="<?= htmlspecialchars($op['location']) ?>" required>
</div>

<div class="col-md-6">
<label class="form-label fw-semibold">مدة التدريب</label>
<input type="text" name="duration" class="form-control"
value="<?= htmlspecialchars($op['duration']) ?>" required>
</div>

<div class="col-md-6">
<label class="form-label fw-semibold">تاريخ البدء</label>
<input type="date" name="start_date" class="form-control"
value="<?= htmlspecialchars($op['start_date']) ?>" required>
</div>

<div class="col-md-6">
<label class="form-label fw-semibold">آخر موعد للتقديم</label>
<input type="date" name="deadline" class="form-control"
value="<?= htmlspecialchars($op['deadline']) ?>" required>
</div>

<div class="col-md-6">
<label class="form-label fw-semibold">عدد المقاعد</label>
<input type="number" name="seats" min="1" class="form-control"
value="<?= htmlspecialchars($op['seats']) ?>" required>
</div>

<div class="col-md-6">
<label class="form-label fw-semibold">بريد التواصل</label>
<input type="email" name="contact_email" class="form-control"
value="<?= htmlspecialchars($op['contact_email'] ?? '') ?>">
</div>

<div class="col-md-6">
<label class="form-label fw-semibold">رقم الهاتف</label>
<input type="text" name="contact_phone" class="form-control"
value="<?= htmlspecialchars($op['contact_phone'] ?? '') ?>">
</div>

<div class="col-md-6">
<label class="form-label fw-semibold">حالة الفرصة</label>
<select name="status" class="form-select">
<option value="active" <?= ($op['status']=='active')?'selected':'' ?>>متاحة</option>
<option value="closed" <?= ($op['status']=='closed')?'selected':'' ?>>مغلقة</option>
</select>
</div>

<div class="col-12">
<label class="form-label fw-semibold">الوصف</label>
<textarea name="description" rows="4" class="form-control" required><?= htmlspecialchars($op['description']) ?></textarea>
</div>

<div class="col-12">
<label class="form-label fw-semibold">المتطلبات الأساسية</label>
<textarea name="requirements" rows="3" class="form-control"><?= htmlspecialchars($op['requirements']) ?></textarea>
</div>

</div>

<div class="mt-4 text-start">
<button type="submit" class="btn btn-primary px-4">
<i class="bi bi-save ms-1"></i>
تحديث البيانات
</button>

<a href="/supervisor/opportunities" class="btn btn-outline-secondary">
إلغاء
</a>
</div>

</form>

</div>
</div>

</div>
</main>

<footer class="mt-5 py-3 bg-primary text-white text-center">
<div class="container">
<small>© 2026 EduServe - جامعة بوليتكنك فلسطين</small>
</div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>