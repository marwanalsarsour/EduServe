<?php 
require_once VIEW_PATH . '/layout/header.php'; 
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم - EduServe</title>
    <link rel="icon" type="image/png" href="/assets/img/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="d-flex flex-column min-vh-100 bg-light">
    <main class="flex-grow-1">
        <div class="container my-4">

            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body p-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                    <div>
                        <h3 class="fw-bold mb-1">أهلاً بك، <span id="studentName"><?php echo htmlspecialchars($_SESSION['user_name'] ?? 'يا طالب'); ?></span> </h3>
                        <p class="text-muted mb-0">إليك نظرة عامة على آخر التطورات في EduServe.</p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="/student_opportunities" class="btn btn-primary">
                            <i class="bi bi-search ms-1"></i> تصفح الفرص
                        </a>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm mb-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold mb-0">
                            <i class="bi bi-clock-history ms-1"></i>
                            الأنشطة الأخيرة
                        </h5>
                        <div class="d-flex gap-2">
                            <a href="/student_calendar" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-calendar-event ms-1"></i>
                                التقويم التفاعلي
                            </a>
                            <a href="/student_my-application" class="btn btn-sm btn-outline-primary">
                                عرض الكل
                            </a>
                        </div>
                    </div>
                    <div id="recentActivity">
                        <?php if (isset($latestRequest) && !empty($latestRequest)): ?>
                            <div class="text-dark">
                                <i class="bi bi-info-circle ms-2 text-primary"></i>
                                قمت بالتقدم لفرصة: <strong><?php echo htmlspecialchars($latestRequest['OpportunityTitle'] ?? 'غير محدد'); ?></strong> 
                                في (<?php echo htmlspecialchars($latestRequest['OrganizationName'] ?? 'غير محدد'); ?>) 
                                بتاريخ <?php echo !empty($latestRequest['requestDate']) ? date('Y-m-d', strtotime($latestRequest['requestDate'])) : 'غير محدد'; ?>
                                <span class="badge bg-info text-dark p-2 ms-2"><?php echo htmlspecialchars($latestRequest['supervisorStatus'] ?? 'قيد المراجعة'); ?></span>
                            </div>
                        <?php else: ?>
                            <div class="text-muted">لا يوجد أنشطة حديثة بعد.</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="row g-4 mb-4">
                <div class="col-12 col-lg-6">
                    <div class="card shadow-sm h-100 border-0">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start gap-2">
                                <div>
                                    <h5 class="fw-bold mb-1">التدريب الميداني</h5>
                                    <div class="text-muted small">
                                        الحالة: <span id="trainingStatusText" class="fw-semibold text-primary"><?php echo $studentData['TrainingStatus'] ?? 'غير محدد'; ?></span>
                                    </div>
                                </div>
                                <span id="trainingStatusBadge" class="badge bg-primary">نشط</span>
                            </div>

                            <hr class="my-3">

                            <?php 
                                $doneHours = $studentData['HoursCompleted'] ?? 0;
                                $totalHours = $studentData['RequiredHours'] ?? 150;
                                $progress = ($totalHours > 0) ? ($doneHours / $totalHours) * 100 : 0;
                            ?>

                            <div class="d-flex justify-content-between small text-muted">
                                <span><i class="bi bi-clock ms-1"></i> الساعات</span>
                                <span>
                                    <span id="trainingHoursDone" class="fw-semibold"><?php echo $doneHours; ?></span> /
                                    <span id="trainingHoursTotal"><?php echo $totalHours; ?></span>
                                </span>
                            </div>

                            <div class="progress mt-2" style="height: 10px;">
                                <div id="trainingProgressBar" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: <?php echo $progress; ?>%">
                                </div>
                            </div>

                            <div class="mt-3">
                                <div class="text-muted small">الشركة / المؤسسة</div>
                                <div id="trainingOrg" class="fw-semibold"><?php echo htmlspecialchars($latestRequest['OrganizationName'] ?? 'لم يتم التحديد'); ?></div>
                            </div>

                            <div class="mt-3 d-flex gap-2">
                                <a href="/student_attendance" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-calendar-check ms-1"></i> الحضور
                                </a>
                                <a href="/student_reports" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-bar-chart ms-1"></i> التقارير
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-6">
                    <div class="card shadow-sm h-100 border-0">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start gap-2">
                                <div>
                                    <h5 class="fw-bold mb-1">العمل التطوعي</h5>
                                    <div class="text-muted small">
                                        الحالة: <span id="volStatusText" class="fw-semibold text-success">متاح</span>
                                    </div>
                                </div>
                                <span id="volStatusBadge" class="badge bg-success">متطوع</span>
                            </div>
                            <hr class="my-3">
                            <div class="d-flex justify-content-between small text-muted">
                                <span><i class="bi bi-clock ms-1"></i> الساعات</span>
                                <span>
                                    <span id="volHoursDone" class="fw-semibold">0</span> /
                                    <span id="volHoursTotal">50</span>
                                </span>
                            </div>
                            <div class="progress mt-2" style="height: 10px;">
                                <div id="volProgressBar" class="bg-success progress-bar" role="progressbar" style="width: 0%"></div>
                            </div>
                            <div class="mt-3">
                                <div class="text-muted small">المؤسسة</div>
                                <div id="volOrg" class="fw-semibold">—</div>
                            </div>
                            <div class="mt-3 d-flex gap-2">
                                <a href="/student_attendance" class="btn btn-sm btn-outline-success">
                                    <i class="bi bi-calendar-check ms-1"></i> الحضور
                                </a>
                                <a href="/student_reports" class="btn btn-sm btn-outline-success">
                                    <i class="bi bi-bar-chart ms-1"></i> التقارير
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0">
    <div class="card-body p-4">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold mb-0">
                <i class="bi bi-person-badge ms-1"></i>
                الملف الرقمي (Portfolio)
            </h5>

            <a href="/student_Portfolio" class="btn btn-sm btn-primary">
                <i class="bi bi-box-arrow-up-right ms-1"></i>
                عرض الملف الرقمي
            </a>
        </div>

        <div class="row g-3">

            <div class="col-12 col-md-4">
                <div class="border rounded p-3 h-100 bg-light">
                    <div class="text-muted small">إجمالي الشهادات</div>
                    <div class="fs-4 fw-bold text-primary">
                        <?= $certsCount ?? 0 ?>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="border rounded p-3 h-100 bg-light">
                    <div class="text-muted small">التدريبات المنجزة</div>
                    <div class="fs-4 fw-bold text-success">
                        <?= $trainingCount ?? 0 ?>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="border rounded p-3 h-100 bg-light">
                    <div class="text-muted small">الأعمال التطوعية</div>
                    <div class="fs-4 fw-bold text-danger">
                        <?= $volunteerCount ?? 0 ?>
                    </div>
                </div>
            </div>

        </div>

        <div class="alert alert-light border mt-4 mb-0">
            <i class="bi bi-info-circle ms-1"></i>
            يحتوي الملف الرقمي على الشهادات، التدريبات المنجزة، الأعمال التطوعية والإنجازات التي حصل عليها الطالب خلال مسيرته الأكاديمية.
             </div>

             </div>
            </div>

        </div>
    </main>

    <footer class="py-3 bg-white border-top text-center mt-4">
        <small class="text-muted">© 2026 EduServe - جامعة بوليتكنك فلسطين</small>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>