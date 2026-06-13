<?php 
require_once VIEW_PATH . '/layout/header.php'; 
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($data['title'] ?? 'لوحة التحكم') ?></title>
    <link rel="icon" type="image/png" href="/public/images/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background-color: whitesmoke; }
        .card { transition: transform 0.2s; }
        .card:hover { transform: translateY(-5px); }
        .col-custom { flex: 0 0 16.66%; max-width: 16.66%; padding: 0 0.5rem;}
        @media (max-width: 992px) { .col-custom { flex: 0 0 50%; max-width: 50%; margin-bottom: 1rem; } }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">

<main class="flex-grow-1">
<div class="container my-5">

    <div class="card shadow-sm border-0 mb-4 bg-white">
        <div class="card-body p-4 d-flex justify-content-between align-items-center">
            <div>
                <h3 class="fw-bold mb-1 text-dark">
                    أهلاً بك، <?= htmlspecialchars($data['supervisor']['name'] ?? 'المشرف الأكاديمي') ?>
                </h3>
                <p class="text-muted mb-0">إليك نظرة شاملة على تقدم طلابك وإدارة تقاريرهم اليوم.</p>
            </div>
            <i class="bi bi-person-badge fs-1 text-primary opacity-25"></i>
        </div>
    </div>

    <div class="row g-0 mb-4">
        <div class="col-custom">
            <div class="card shadow-sm text-center h-100 border-0">
                <div class="card-body">
                    <div class="p-3 bg-primary bg-opacity-10 rounded-circle d-inline-block mb-2">
                        <i class="bi bi-people fs-3 text-primary"></i>
                    </div>
                    <div class="text-muted small">إجمالي الطلاب</div>
                    <div class="fs-4 fw-bold"><?= htmlspecialchars($data['stats']['students_count'] ?? 0) ?></div>
                </div>
            </div>
        </div>

        <div class="col-custom">
            <div class="card shadow-sm text-center h-100 border-0">
                <div class="card-body">
                    <div class="p-3 bg-warning bg-opacity-10 rounded-circle d-inline-block mb-2">
                        <i class="bi bi-file-earmark-text fs-3 text-warning"></i>
                    </div>
                    <div class="text-muted small">تقارير المراجعة</div>
                    <div class="fs-4 fw-bold"><?= htmlspecialchars($data['stats']['pending_reports'] ?? 0) ?></div>
                </div>
            </div>
        </div>

        <div class="col-custom">
            <div class="card shadow-sm text-center h-100 border-0">
                <div class="card-body">
                    <div class="p-3 bg-success bg-opacity-10 rounded-circle d-inline-block mb-2">
                        <i class="bi bi-person-check fs-3 text-success"></i>
                    </div>
                    <div class="text-muted small">طلبات التدريب</div>
                    <div class="fs-4 fw-bold"><?= htmlspecialchars($data['stats']['pending_applications'] ?? 0) ?></div>
                </div>
            </div>
        </div>

        <div class="col-custom">
            <div class="card shadow-sm text-center h-100 border-0">
                <div class="card-body">
                    <div class="p-3 bg-danger bg-opacity-10 rounded-circle d-inline-block mb-2">
                        <i class="bi bi-bell fs-3 text-danger"></i>
                    </div>
                    <div class="text-muted small">تنبيهات جديدة</div>
                    <div class="fs-4 fw-bold"><?= htmlspecialchars($data['stats']['unread_notifications'] ?? 0) ?></div>
                </div>
            </div>
        </div>

        <div class="col-custom">
            <div class="card shadow-sm text-center h-100 border-0 position-relative">
                <div class="card-body">
                    <div class="p-3 bg-info bg-opacity-10 rounded-circle d-inline-block mb-2">
                        <i class="bi bi-clipboard-check fs-3 text-info"></i>
                    </div>
                    <div class="text-muted small">فرص بانتظار الموافقة</div>
                    <div class="fs-4 fw-bold text-info"><?= htmlspecialchars($data['stats']['pending_opportunities'] ?? 0) ?></div>
                    <a href="/supervisor_pending-opportunities" class="stretched-link"></a>
                </div>
            </div>
        </div>
        <div class="col-custom">
    <div class="card shadow-sm text-center h-100 border-0 position-relative">
        <div class="card-body">
            <div class="p-3 bg-secondary bg-opacity-10 rounded-circle d-inline-block mb-2">
                <i class="bi bi-clipboard-data fs-3 text-secondary"></i>
            </div>

            <div class="text-muted small">
                معايير التقييم
            </div>

            <div class="fs-6 fw-bold text-secondary">
                إدارة البنود والدرجات
            </div>

            <a href="/supervisor_evaluation_criteria" class="stretched-link"></a>
        </div>
    </div>
</div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-12 col-lg-6">
            <div class="card shadow-sm h-100 border-0">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3"><i class="bi bi-bar-chart-line me-2 text-primary"></i>متوسط تقدم الطلاب</h5>
                    <?php $progress = $data['stats']['average_progress'] ?? 0; ?>
                    <div class="progress mb-2" style="height: 15px; border-radius: 10px;">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" 
                             role="progressbar" style="width: <?= (int)$progress ?>%"></div>
                    </div>
                    <div class="fw-bold text-primary"><?= htmlspecialchars($progress) ?>% اكتمل</div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6">
            <div class="card shadow-sm h-100 border-0">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3"><i class="bi bi-check2-square me-2 text-success"></i>حالة التقارير</h5>
                    <div class="fs-3 fw-bold text-success"><?= htmlspecialchars($data['stats']['approved_reports'] ?? 0) ?></div>
                    <div class="text-muted small">تقارير معتمدة من إجمالي <?= htmlspecialchars($data['stats']['total_reports'] ?? 0) ?> تقرير تم رفعه</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <h5 class="fw-bold mb-4"><i class="bi bi-clock-history me-2 text-secondary"></i>آخر أنشطة الطلاب</h5>
            <?php if(!empty($data['recent_activity'])): ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>اسم الطالب</th>
                                <th>النشاط</th>
                                <th>التوقيت</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($data['recent_activity'] as $activity): ?>
                                <tr>
                                    <td class="fw-semibold"><?= htmlspecialchars($activity['student_name'] ?? '') ?></td>
                                    <td class="text-muted"><?= htmlspecialchars($activity['description'] ?? '') ?></td>
                                    <td><span class="badge bg-light text-dark"><?= htmlspecialchars($activity['date'] ?? '') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="alert alert-light text-center">لا توجد سجلات نشاط حالياً.</div>
            <?php endif; ?>
        </div>
    </div>

</div>
</main>

<footer class="mt-auto py-3 bg-dark text-white text-center">
    <div class="container">
        <small>© 2026 EduServe - Palestine Polytechnic University</small>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>