<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم - مشرف التطوع | EduServe</title>
    <link rel="icon" type="image/png" href="/public/images/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">

<?php require_once BASE_PATH . '/views/layout/header.php'; ?>

<div class="container py-5">
    <div class="row g-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm text-center p-4">
                <div class="rounded-circle bg-primary bg-opacity-10 p-3 d-inline-block mb-3 mx-auto">
                    <i class="bi bi-megaphone text-primary fs-3"></i>
                </div>
                <h6 class="text-muted">الفرص النشطة</h6>
                <h3 class="fw-bold"><?= $data['stats']['active_opportunities'] ?></h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm text-center p-4">
                <div class="rounded-circle bg-warning bg-opacity-10 p-3 d-inline-block mb-3 mx-auto">
                    <i class="bi bi-person-plus text-warning fs-3"></i>
                </div>
                <h6 class="text-muted">طلبات بانتظار المراجعة</h6>
                <h3 class="fw-bold"><?= $data['stats']['pending_applications'] ?></h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm text-center p-4">
                <div class="rounded-circle bg-success bg-opacity-10 p-3 d-inline-block mb-3 mx-auto">
                    <i class="bi bi-clock-history text-success fs-3"></i>
                </div>
                <h6 class="text-muted">ساعات بانتظار الاعتماد</h6>
                <h3 class="fw-bold"><?= $data['stats']['pending_hours'] ?></h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm text-center p-4">
                <div class="rounded-circle bg-info bg-opacity-10 p-3 d-inline-block mb-3 mx-auto">
                    <i class="bi bi-bell text-info fs-3"></i>
                </div>
                <h6 class="text-muted">إشعارات اليوم</h6>
                <h3 class="fw-bold"><?= $data['stats']['today_notifications'] ?></h3>
            </div>
        </div>
    </div>

    <div class="mt-5 card border-0 shadow-sm p-4">
        <h5 class="fw-bold mb-4 text-primary"><i class="bi bi-list-stars me-2"></i>أحدث طلبات التطوع بانتظار قرارك</h5>
        <div class="table-responsive">
            <table class="table align-middle table-hover">
                <thead class="table-light">
                    <tr>
                        <th>الطالب</th>
                        <th>الفرصة</th>
                        <th>التاريخ</th>
                        <th class="text-center">الإجراء</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($data['applications'])): ?>
                        <?php foreach($data['applications'] as $app): ?>
                        <tr>
                            <td><strong><?= htmlspecialchars($app['student_name']) ?></strong></td>
                            <td><span class="badge bg-info text-dark bg-opacity-10"><?= htmlspecialchars($app['opportunity_title']) ?></span></td>
                            <td><?= date('d/m/Y', strtotime($app['created_at'])) ?></td>
                            <td class="text-center">
                                <a href="/volunteer_review_request/<?= $app['id'] ?>" class="btn btn-sm btn-primary rounded-pill px-3">مراجعة الطلب</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="4" class="text-center py-5 text-muted">لا توجد طلبات جديدة بانتظار المراجعة.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>