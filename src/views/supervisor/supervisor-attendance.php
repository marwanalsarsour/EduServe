<?php 
require_once VIEW_PATH . '/layout/header.php'; 
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مراجعة الحضور - EduServe</title>
    <link rel="icon" type="image/png" href="/public/images/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100 bg-light">



<div class="container my-5">
    <h4 class="fw-bold mb-4 text-primary">مراجعة الحضور الأسبوعي للطلاب</h4>

    <?php if(isset($_SESSION['success_msg'])): ?>
        <div class="alert alert-success border-0 shadow-sm"><?= $_SESSION['success_msg']; unset($_SESSION['success_msg']); ?></div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm rounded-3">
        <div class="table-responsive">
            <table class="table table-hover align-middle text-center mb-0">
                <thead class="table-dark">
                    <tr>
                        <th class="py-3">اسم الطالب</th>
                        <th class="py-3">الأسبوع</th>
                        <th class="py-3">عدد الساعات</th>
                        <th class="py-3">الحالة</th>
                        <th class="py-3">الإجراء</th>
                    </tr>
                </thead>
                <tbody>
                <?php if(!empty($data['attendance'])): ?>
                    <?php foreach($data['attendance'] as $att): ?>
                    <tr>
                        <td class="fw-bold"><?= $att['student_name'] ?></td>
                        <td>الأسبوع <?= $att['week'] ?></td>
                        <td><span class="badge bg-info text-dark"><?= $att['hours'] ?> ساعة</span></td>
                        <td><span class="badge bg-warning text-dark">بانتظار الاعتماد</span></td>
                        <td>
                            <form method="POST" action="/submit_attendance_review_action">
                                <input type="hidden" name="id" value="<?= $att['id'] ?>">
                                <button name="action" value="approve" class="btn btn-success btn-sm rounded-pill px-3">
                                    <i class="bi bi-check-circle"></i> اعتماد
                                </button>
                                <button name="action" value="reject" class="btn btn-outline-danger btn-sm rounded-pill px-3">
                                    <i class="bi bi-x-circle"></i> رفض
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="py-5 text-muted">لا يوجد سجلات حضور بانتظار المراجعة حالياً.</td>
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