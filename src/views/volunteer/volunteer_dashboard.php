<?php 
require_once VIEW_PATH . '/layout/header.php'; 
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم - مشرف التطوع | EduServe</title>
    <link rel="icon" type="image/png" href="/public/images/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .col-custom { flex: 0 0 20%; max-width: 20%; }
        @media (max-width: 992px) { .col-custom { flex: 0 0 50%; max-width: 50%; } }
        .card { transition: transform 0.2s; cursor: pointer; }
        .card:hover { transform: translateY(-5px); }
    </style>
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="row g-3 mb-4">

        <div class="col-custom">
            <div class="card border-0 shadow-sm text-center p-3 h-100 position-relative">
                <div class="rounded-circle bg-primary bg-opacity-10 p-2 d-inline-block mb-2 mx-auto">
                    <i class="bi bi-megaphone text-primary fs-4"></i>
                </div>
                <h6 class="text-muted small">الفرص النشطة</h6>
                <h4 class="fw-bold"><?= $data['stats']['active_opportunities'] ?></h4>
                <a href="/volunteer_opportunities" class="stretched-link"></a>
            </div>
        </div>

        <div class="col-custom">
            <div class="card border-0 shadow-sm text-center p-3 h-100 position-relative">
                <div class="rounded-circle bg-warning bg-opacity-10 p-2 d-inline-block mb-2 mx-auto">
                    <i class="bi bi-person-plus text-warning fs-4"></i>
                </div>
                <h6 class="text-muted small">طلبات المراجعة</h6>
                <h4 class="fw-bold"><?= $data['stats']['pending_applications'] ?></h4>
                <a href="/volunteer_requests" class="stretched-link"></a>
            </div>
        </div>

        <div class="col-custom">
            <div class="card border-0 shadow-sm text-center p-3 h-100 position-relative">
                <div class="rounded-circle bg-success bg-opacity-10 p-2 d-inline-block mb-2 mx-auto">
                    <i class="bi bi-clock-history text-success fs-4"></i>
                </div>
                <h6 class="text-muted small">ساعات بانتظار الاعتماد</h6>
                <h4 class="fw-bold"><?= $data['stats']['pending_hours'] ?></h4>
                <a href="/volunteer_attendance" class="stretched-link"></a>
            </div>
        </div>

        <div class="col-custom">
            <div class="card border-0 shadow-sm text-center p-3 h-100 position-relative">
                <div class="rounded-circle bg-info bg-opacity-10 p-2 d-inline-block mb-2 mx-auto">
                    <i class="bi bi-bell text-info fs-4"></i>
                </div>
                <h6 class="text-muted small">إشعارات اليوم</h6>
                <h4 class="fw-bold"><?= $data['stats']['today_notifications'] ?></h4>
                <a href="/volunteer_notifications" class="stretched-link"></a>
            </div>
        </div>

        <div class="col-custom">
            <div class="card border-0 shadow-sm text-center p-3 h-100 position-relative">
                <div class="rounded-circle bg-secondary bg-opacity-10 p-2 d-inline-block mb-2 mx-auto">
                    <i class="bi bi-clipboard-check text-secondary fs-4"></i>
                </div>
                <h6 class="text-muted small">فرص بانتظار الموافقة</h6>
                <h4 class="fw-bold text-secondary"><?= htmlspecialchars($data['stats']['pending_opportunities'] ?? 0) ?></h4>
                <a href="/supervisor_pending-opportunities" class="stretched-link"></a>
            </div>
        </div>

    </div>

    <div class="mt-5 card border-0 shadow-sm p-4">
        <h5 class="fw-bold mb-4 text-primary">
            <i class="bi bi-list-stars me-2"></i>
            أحدث طلبات التطوع بانتظار قرارك
        </h5>

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
                            <td>
                                <strong><?= htmlspecialchars($app['student_name']) ?></strong>
                            </td>

                            <td>
                                <span class="badge bg-info text-dark bg-opacity-10">
                                    <?= htmlspecialchars($app['opportunity_title']) ?>
                                </span>
                            </td>

                            <td>
                                <?= date('d/m/Y', strtotime($app['created_at'])) ?>
                            </td>

                            <td class="text-center">
                                <a href="/volunteer_view_student?id=<?= $app['id'] ?>"
                                   class="btn btn-sm btn-primary rounded-pill px-3">
                                    مراجعة الطلب
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">
                                لا توجد طلبات جديدة بانتظار المراجعة.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>

            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>