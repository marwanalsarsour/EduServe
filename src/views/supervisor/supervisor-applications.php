<?php 
require_once VIEW_PATH . '/layout/header.php'; 
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة طلبات التدريب - EduServe</title>
    <link rel="icon" type="image/png" href="/public/images/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100 bg-light">



<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold m-0 text-primary">طلبات التدريب المقدمة</h4>
        <span class="badge bg-primary rounded-pill"><?= count($data['applications']) ?> طلب معلق</span>
    </div>

    <?php if(isset($_SESSION['success_msg'])): ?>
        <div class="alert alert-success border-0 shadow-sm"><?= $_SESSION['success_msg']; unset($_SESSION['success_msg']); ?></div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm rounded-3">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 text-center">
                <thead class="table-dark">
                    <tr>
                        <th class="py-3">اسم الطالب</th>
                        <th class="py-3">الفرصة التدريبية</th>
                        <th class="py-3">الحالة الحالية</th>
                        <th class="py-3">الإجراء المتخذ</th>
                    </tr>
                </thead>
                <tbody>
                <?php if(!empty($data['applications'])): ?>
                    <?php foreach($data['applications'] as $app): ?>
                    <tr>
                        <td class="fw-bold text-dark"><?= $app['student_name'] ?></td>
                        <td><?= $app['opportunity'] ?></td>
                        <td>
                            <span class="badge bg-warning text-dark">بانتظار المراجعة</span>
                        </td>
                        <td>
                            <form method="POST" action="/submit_application_action">
                                <input type="hidden" name="id" value="<?= $app['id'] ?>">
                                <button name="action" value="accept" class="btn btn-success btn-sm px-3 rounded-pill">
                                    <i class="bi bi-check-lg"></i> قبول
                                </button>
                                <button name="action" value="reject" class="btn btn-outline-danger btn-sm px-3 rounded-pill">
                                    <i class="bi bi-x-lg"></i> رفض
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="py-5 text-muted">
                            <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                            لا توجد طلبات تدريب حالياً بانتظار الموافقة.
                        </td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<footer class="mt-auto py-3 bg-white text-center border-top">
    <small>© 2026 EduServe - جامعة بوليتكنك فلسطين</small>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>