<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>التقييم النهائي</title>
<link rel="icon" type="image/png" href="/public/images/logo.png">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="d-flex flex-column min-vh-100">
<?php require_once '../layout/header.php'; ?>

<div class="container my-4">
<h4 class="fw-bold mb-4">إدخال التقييم النهائي</h4>

<form method="POST" action="/supervisor/save-evaluation" class="card p-4 shadow-sm">

<input type="hidden" name="student_id" value="<?= $data['student']['id'] ?? '' ?>">

<div class="mb-3">
<label class="form-label">الدرجة النهائية</label>
<input type="number" name="final_grade" class="form-control" required>
</div>

<div class="mb-3">
<label class="form-label">ملاحظات</label>
<textarea name="notes" class="form-control"></textarea>
</div>

<button class="btn btn-success">حفظ التقييم</button>

</form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>