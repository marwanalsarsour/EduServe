<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>اعتماد التقارير</title>
    <link rel="icon" type="image/png" href="/public/images/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="d-flex flex-column min-vh-100">
<?php 
require_once '../layout/header.php'; 
?>

<div class="container my-4">
<h4 class="fw-bold mb-4">طلبات التدريب المقدمة</h4>

<table class="table table-bordered text-center">
<thead class="table-dark">
<tr>
<th>الطالب</th>
<th>الفرصة</th>
<th>الحالة</th>
<th>الإجراء</th>
</tr>
</thead>
<tbody>
<?php if(!empty($data['applications'])): ?>
    <?php foreach($data['applications'] as $app): ?>
<tr>
<td><?= $app['student_name'] ?></td>
<td><?= $app['opportunity'] ?></td>
<td><?= $app['status'] ?></td>
<td>
<form method="POST" action="/supervisor/application-action">
<input type="hidden" name="id" value="<?= $app['id'] ?>">
<button name="action" value="accept" class="btn btn-success btn-sm">قبول</button>
<button name="action" value="reject" class="btn btn-danger btn-sm">رفض</button>
</form>
</td>
</tr>
<?php endforeach; ?>
<?php else: ?>
<tr>
    <td colspan="4" class="text-muted">
        لا توجد طلبات حالياً
    </td>
</tr>
<?php endif; ?>

</tbody>
</table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>