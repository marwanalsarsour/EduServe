<?php 
require_once VIEW_PATH . '/layout/header.php'; 
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>مراجعة طلبات الانضمام | EduServe</title>
    <link rel="icon" type="image/png" href="/public/images/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light text-end">


<div class="container py-5">
    <div class="row mb-4">
        <div class="col-md-8">
            <h3 class="fw-bold text-primary">طلبات انضمام الطلاب</h3>
            <p class="text-muted small">مراجعة ملفات الطلاب المتقدمين لفرص التطوع (قبول أو رفض).</p>
        </div>
    </div>

    <?php if (isset($_GET['status']) && $_GET['status'] == 'success'): ?>
        <div class="alert alert-success shadow-sm">تم تحديث حالة الطلب بنجاح.</div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm overflow-hidden">
        <table class="table mb-0 align-middle text-center">
            <thead class="bg-primary text-white">
                <tr>
                    <th class="py-3 px-4">اسم الطالب</th>
                    <th>التخصص</th>
                    <th>الفرصة المطلوبة</th>
                    <th>تاريخ التقديم</th>
                    <th>السجل الأكاديمي</th>
                    <th>اتخاذ قرار</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($applications)): ?>
                    <?php foreach ($applications as $app): ?>
                    <tr>
                        <td class="fw-bold px-4"><?= htmlspecialchars($app['student_name']) ?></td>
                        <td><?= htmlspecialchars($app['major']) ?></td>
                        <td><span class="badge bg-info-subtle text-info p-2"><?= htmlspecialchars($app['opportunity_title']) ?></span></td>
                        <td><?= date('Y-m-d', strtotime($app['applied_at'])) ?></td>
                        <td>
                            <a href="/view_student_cv?id=<?= $app['student_id'] ?>" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-file-earmark-person ms-1"></i>عرض السجل
                            </a>
                        </td>
                        <td>
                            <a href="/handle_application?id=<?= $app['id'] ?>&action=approve" class="btn btn-sm btn-success px-3 ms-1" onclick="return confirm('تأكيد قبول الطالب؟')">قبول</a>
                            <a href="/handle_application?id=<?= $app['id'] ?>&action=reject" class="btn btn-sm btn-danger px-3" onclick="return confirm('تأكيد رفض الطلب؟')">رفض</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="6" class="py-4">لا توجد طلبات معلقة حالياً.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>