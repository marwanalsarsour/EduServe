<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>إدارة الفرص</title>
<link rel="icon" type="image/png" href="/public/images/logo.png">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

</head>

<body class="d-flex flex-column min-vh-100">
<?php require_once '../layout/header.php'; ?>

<div class="container my-4">
<h4 class="fw-bold mb-4">إدارة فرص التدريب</h4>

<a href="/supervisor/add-opportunity" class="btn btn-primary mb-3">
<i class="bi bi-plus-circle"></i> إضافة فرصة
</a>

<table class="table table-bordered text-center">
<thead class="table-dark">
<tr>
<th>العنوان</th>
<th>الجهة</th>
<th>الحالة</th>
<th>التحكم</th>
</tr>
</thead>
<tbody>

<?php if(!empty($data['opportunities'])): ?>
<?php foreach($data['opportunities'] as $opp): ?>
<tr>
<td><?= $opp['title'] ?></td>
<td><?= $opp['organization'] ?></td>
<td><?= $opp['status'] ?></td>
<td>
<a href="/supervisor/edit/<?= $opp['id'] ?>" class="btn btn-warning btn-sm">تعديل</a>
<a href="/supervisor/delete/<?= $opp['id'] ?>" class="btn btn-danger btn-sm">حذف</a>
</td>
</tr>
<?php endforeach; ?>
<?php else: ?>
<tr>
<td colspan="4" class="text-muted">لا توجد فرص حالياً</td>
</tr>
<?php endif; ?>

</tbody>
</table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>