<?php 
require_once VIEW_PATH . '/layout/header.php'; 
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تفاصيل الفرصة - <?= htmlspecialchars($opportunity['Title']) ?></title>
    <link rel="icon" type="image/png" href="/images/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="d-flex flex-column min-vh-100 bg-light">
    <main class="flex-grow-1 flex-fill">
        <div class="container my-4">

            <div class="mb-3">
                <a href="/student_opportunities" class="text-decoration-none text-secondary">
                    <i class="bi bi-arrow-right"></i> العودة لقائمة الفرص
                </a>
            </div>

            <div class="row g-4 my-2">
                <div class="col-12 col-lg-8">

                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4">

                            <div class="d-flex flex-column flex-md-row justify-content-between gap-2">
                                <div>
                                    <h3 class="fw-bold mb-1 text-primary" id="opTitle"><?= htmlspecialchars($opportunity['Title']) ?></h3>
                                    <p class="text-muted mb-0">
                                        <span id="opOrg" class="fw-bold text-dark"><?= htmlspecialchars($opportunity['OrganizationName']) ?></span>
                                        <span class="mx-2">•</span>
                                        <span id="opLocation"><i class="bi bi-geo-alt"></i> <?= htmlspecialchars($opportunity['Location']) ?></span>
                                    </p>
                                </div>

                                <div class="d-flex align-items-start gap-2">
                                    <span class="badge bg-info text-dark" id="opType">
                                        <?= ($opportunity['Type'] === 'Training' ? 'تدريب ميداني' : 'عمل تطوعي') ?>
                                    </span>
                                    <span class="badge bg-success" id="opStatus">متاح</span>
                                </div>
                            </div>

                            <hr class="my-4">

                            <div class="row g-3 text-center">
                                <div class="col-6 col-md-3">
                                    <div class="border rounded p-3 h-100 bg-white">
                                        <div class="text-muted small mb-1"><i class="bi bi-clock ms-1"></i> المدة</div>
                                        <div class="fw-bold" id="opDuration"><?= htmlspecialchars($opportunity['Duration'] ?? 'غير محدد') ?></div>
                                    </div>
                                </div>

                                <div class="col-6 col-md-3">
                                    <div class="border rounded p-3 h-100 bg-white">
                                        <div class="text-muted small mb-1"><i class="bi bi-calendar-event ms-1"></i> تاريخ البدء</div>
                                        <div class="fw-bold" id="opStartDate"><?= $opportunity['StartDate'] ?: '--/--/----' ?></div>
                                    </div>
                                </div>

                                <div class="col-6 col-md-3">
                                    <div class="border rounded p-3 h-100 bg-white">
                                        <div class="text-muted small mb-1"><i class="bi bi-hourglass-split ms-1"></i> الموعد النهائي</div>
                                        <div class="fw-bold text-danger" id="opDeadline"><?= $opportunity['Deadline'] ?: 'مفتوح' ?></div>
                                    </div>
                                </div>

                                <div class="col-6 col-md-3">
                                    <div class="border rounded p-3 h-100 bg-white">
                                        <div class="text-muted small mb-1"><i class="bi bi-people ms-1"></i> المقاعد</div>
                                        <div class="fw-bold" id="opSeats"><?= $opportunity['Capacity'] ?? '1' ?></div>
                                    </div>
                                </div>
                            </div>

                            <h5 class="mt-4 fw-bold text-dark">الوصف</h5>
                            <div id="opDescription" class="mb-3 text-secondary" style="line-height: 1.8;">
                                <?= nl2br(htmlspecialchars($opportunity['Description'])) ?>
                            </div>

                            <h5 class="mt-4 fw-bold text-dark">المتطلبات الأساسية</h5>
                            <div id="opRequirements" class="text-secondary">
                                <?= $opportunity['Requirements'] ? nl2br(htmlspecialchars($opportunity['Requirements'])) : 'لا يوجد متطلبات محددة لهذه الفرصة.' ?>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-4">
                    <div class="card shadow-sm border-0 sticky-top" style="top: 20px;">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-3">الإجراءات المتاحة</h5>

                            <a id="applyBtn" href="/student_apply?id=<?= $opportunity['OpportunityID'] ?>" class="btn btn-success w-100 py-2 mb-2 shadow-sm">
                                <i class="bi bi-send ms-1"></i> قدم الآن
                            </a>

                            <button class="btn btn-outline-secondary w-100 mb-3" type="button" id="saveBtn">
                                <i class="bi bi-bookmark ms-1"></i> حفظ الفرصة
                            </button>

                            <div class="card bg-light border-0 mt-3">
                                <div class="card-body p-3">
                                    <h6 class="fw-bold mb-3 border-bottom pb-2">معلومات الجهة المنظمة</h6>
                                    <p class="mb-2 small" id="opContactEmail">
                                        <i class="bi bi-envelope text-primary ms-1"></i> 
                                        <a href="mailto:<?= htmlspecialchars($opportunity['OrgEmail']) ?>" class="text-decoration-none text-muted">
                                            <?= htmlspecialchars($opportunity['OrgEmail']) ?>
                                        </a>
                                    </p>
                                    <p class="mb-0 small" id="opContactPhone">
                                        <i class="bi bi-telephone text-primary ms-1"></i> 
                                        <span class="text-muted"><?= htmlspecialchars($opportunity['OrgPhone'] ?: 'لا يوجد هاتف') ?></span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <footer class="mt-auto py-3 bg-primary text-white text-center">
        <div class="container">
            <small>
                © 2026 EduServe - جامعة بوليتكنك فلسطين
            </small>
        </div>
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>