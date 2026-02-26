<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة تحكم المشرف الأكاديمي</title>
    <link rel="icon" type="image/png" href="/public/images/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="d-flex flex-column min-vh-100">
<?php 
require_once '../layout/header.php'; 
?>
<main class="flex-grow-1">
<div class="container my-4">

    <!-- Welcome Card -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body p-4 d-flex justify-content-between align-items-center">
            <div>
                <h3 class="fw-bold mb-1">
                    أهلاً بك، <?= $data['supervisor']['name'] ?? 'المشرف' ?>
                </h3>
                <p class="text-muted mb-0">
                    إليك نظرة عامة على طلابك وإدارتهم.
                </p>
            </div>
        </div>
    </div>

    <!-- Statistics -->
    <div class="row g-4 mb-4">

        <div class="col-12 col-md-3">
            <div class="card shadow-sm text-center h-100">
                <div class="card-body">
                    <i class="bi bi-people fs-3 text-primary"></i>
                    <div class="text-muted small mt-2">عدد الطلاب</div>
                    <div class="fs-4 fw-bold">
                        <?= $data['stats']['students_count'] ?? 0 ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-3">
            <div class="card shadow-sm text-center h-100">
                <div class="card-body">
                    <i class="bi bi-file-earmark-text fs-3 text-warning"></i>
                    <div class="text-muted small mt-2">تقارير بانتظار الاعتماد</div>
                    <div class="fs-4 fw-bold">
                        <?= $data['stats']['pending_reports'] ?? 0 ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-3">
            <div class="card shadow-sm text-center h-100">
                <div class="card-body">
                    <i class="bi bi-person-check fs-3 text-success"></i>
                    <div class="text-muted small mt-2">طلبات جديدة</div>
                    <div class="fs-4 fw-bold">
                        <?= $data['stats']['pending_applications'] ?? 0 ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-3">
            <div class="card shadow-sm text-center h-100">
                <div class="card-body">
                    <i class="bi bi-bell fs-3 text-danger"></i>
                    <div class="text-muted small mt-2">إشعارات جديدة</div>
                    <div class="fs-4 fw-bold">
                        <?= $data['stats']['unread_notifications'] ?? 0 ?>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Progress & Reports -->
    <div class="row g-4 mb-4">

        <div class="col-12 col-lg-6">
            <div class="card shadow-sm h-100">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">
                        <i class="bi bi-bar-chart-line ms-1"></i>
                        متوسط تقدم الطلاب
                    </h5>

                    <?php $progress = $data['stats']['average_progress'] ?? 0; ?>

                    <div class="progress" style="height: 12px;">
                        <div class="progress-bar bg-primary"
                             role="progressbar"
                             style="width: <?= $progress ?>%">
                        </div>
                    </div>

                    <div class="mt-2 fw-semibold">
                        <?= $progress ?>%
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6">
            <div class="card shadow-sm h-100">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">
                        <i class="bi bi-check2-square ms-1"></i>
                        التقارير المعتمدة
                    </h5>

                    <div class="fs-4 fw-bold">
                        <?= $data['stats']['approved_reports'] ?? 0 ?>
                    </div>

                    <div class="text-muted small">
                        من أصل <?= $data['stats']['total_reports'] ?? 0 ?> تقرير
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Recent Activity -->
    <div class="card shadow-sm">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0">
                    <i class="bi bi-clock-history ms-1"></i>
                    آخر أنشطة الطلاب
                </h5>
            </div>

            <?php if(!empty($data['recent_activity'])): ?>
                <ul class="list-group list-group-flush">
                    <?php foreach($data['recent_activity'] as $activity): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <div class="fw-semibold">
                                    <?= $activity['student_name'] ?>
                                </div>
                                <div class="text-muted small">
                                    <?= $activity['description'] ?>
                                </div>
                            </div>
                            <span class="text-muted small">
                                <?= $activity['date'] ?>
                            </span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <div class="text-muted">
                    لا توجد أنشطة حديثة.
                </div>
            <?php endif; ?>

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