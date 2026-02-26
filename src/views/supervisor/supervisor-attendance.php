<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>مراجعة الحضور</title>
<link rel="icon" type="image/png" href="/public/images/logo.png">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

</head>

<body class="d-flex flex-column min-vh-100">
<?php require_once '../layout/header.php'; ?>

<div class="container my-4">
<h4 class="fw-bold mb-4">الحضور الأسبوعي</h4>

<table class="table table-bordered text-center">
<thead class="table-dark">
<tr>
<th>الطالب</th>
<th>الأسبوع</th>
<th>الساعات</th>
<th>الحالة</th>
<th>الإجراء</th>
</tr>
</thead>
<tbody>

<?php if(!empty($data['attendance'])): ?>
<?php foreach($data['attendance'] as $att): ?>
<tr>
<td><?= $att['student_name'] ?></td>
<td><?= $att['week'] ?></td>
<td><?= $att['hours'] ?></td>
<td><?= $att['status'] ?></td>
<td>
<form method="POST" action="/supervisor/attendance-action">
<input type="hidden" name="id" value="<?= $att['id'] ?>">
<button name="action" value="approve" class="btn btn-success btn-sm">اعتماد</button>
<button name="action" value="reject" class="btn btn-danger btn-sm">رفض</button>
</form>
</td>
</tr>
<?php endforeach; ?>
<?php else: ?>
<tr>
<td colspan="5" class="text-muted">لا يوجد سجل حضور</td>
</tr>
<?php endif; ?>

</tbody>
</table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>