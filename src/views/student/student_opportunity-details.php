<?php 
require_once VIEW_PATH . '/layout/header.php'; 

$opp = [];
if (isset($opportunity) && is_array($opportunity)) {
    $opp = $opportunity;
} elseif (isset($data['opportunity']) && is_array($data['opportunity'])) {
    $opp = $data['opportunity'];
}

$title = !empty($opp['title']) ? htmlspecialchars($opp['title']) : 'بدون عنوان';
$orgName = !empty($opp['OrganizationName']) ? htmlspecialchars($opp['OrganizationName']) : 'الجهة المنظمة';
$location = !empty($opp['location']) ? htmlspecialchars($opp['location']) : 'غير محدد';
$oppType = $opp['type'] ?? '';

$duration = !empty($opp['duration']) ? htmlspecialchars($opp['duration']) : 'غير محدد';
$startDate = !empty($opp['startDate']) ? htmlspecialchars($opp['startDate']) : (!empty($opp['start_date']) ? htmlspecialchars($opp['start_date']) : '--/--/----');
$deadline = !empty($opp['deadline']) ? htmlspecialchars($opp['deadline']) : 'مفتوح';
$seats = isset($opp['seats']) ? htmlspecialchars($opp['seats']) : '1';

$description = !empty($opp['description']) ? htmlspecialchars($opp['description']) : 'لا يوجد وصف متاح.';
$requirements = !empty($opp['requirements']) ? htmlspecialchars($opp['requirements']) : 'لا يوجد متطلبات محددة.';

$orgEmail = !empty($opp['OrgEmail']) ? htmlspecialchars($opp['OrgEmail']) : 'غير متوفر';
$orgPhone = !empty($opp['OrgPhone']) ? htmlspecialchars($opp['OrgPhone']) : 'غير متوفر';
$oppID = $opp['opportunityID'] ?? 0;
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تفاصيل الفرصة - <?= $title ?></title>
    <link class="icon" type="image/png" href="/images/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css">
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
                                    <h3 class="fw-bold mb-1 text-primary" id="opTitle"><?= $title ?></h3>
                                    <p class="text-muted mb-0">
                                        <span id="opOrg" class="fw-bold text-dark"><?= $orgName ?></span>
                                        <span class="mx-2">•</span>
                                        <span id="opLocation"><i class="bi bi-geo-alt"></i> <?= $location ?></span>
                                    </p>
                                </div>

                                <div class="d-flex align-items-start gap-2">
                                    <span class="badge bg-info text-dark" id="opType">
                                        <?= ($oppType === 'تدريب' ? 'تدريب ميداني' : 'عمل تطوعي') ?>
                                    </span>
                                    <span class="badge bg-success" id="opStatus">متاح</span>
                                </div>
                            </div>

                            <hr class="my-4">

                            <div class="row g-3 text-center">
                                <div class="col-6 col-md-3">
                                    <div class="border rounded p-3 h-100 bg-white">
                                        <div class="text-muted small mb-1"><i class="bi bi-clock ms-1"></i> المدة</div>
                                        <div class="fw-bold" id="opDuration"><?= $duration ?></div>
                                    </div>
                                </div>

                                <div class="col-6 col-md-3">
                                    <div class="border rounded p-3 h-100 bg-white">
                                        <div class="text-muted small mb-1"><i class="bi bi-calendar-event ms-1"></i> تاريخ البدء</div>
                                        <div class="fw-bold" id="opStartDate"><?= $startDate ?></div>
                                    </div>
                                </div>

                                <div class="col-6 col-md-3">
                                    <div class="border rounded p-3 h-100 bg-white">
                                        <div class="text-muted small mb-1"><i class="bi bi-hourglass-split ms-1"></i> الموعد النهائي</div>
                                        <div class="fw-bold text-danger" id="opDeadline"><?= $deadline ?></div>
                                    </div>
                                </div>

                                <div class="col-6 col-md-3">
                                    <div class="border rounded p-3 h-100 bg-white">
                                        <div class="text-muted small mb-1"><i class="bi bi-people ms-1"></i> المقاعد</div>
                                        <div class="fw-bold" id="opSeats"><?= $seats ?></div>
                                    </div>
                                </div>
                            </div>

                            <h5 class="mt-4 fw-bold text-dark">الوصف</h5>
                            <div id="opDescription" class="mb-3 text-secondary" style="line-height: 1.8;">
                                <?= nl2br($description) ?>
                            </div>

                            <h5 class="mt-4 fw-bold text-dark">المتطلبات الأساسية</h5>
                            <div id="opRequirements" class="text-secondary">
                                <?= nl2br($requirements) ?>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-4">
                    <div class="card shadow-sm border-0 sticky-top" style="top: 20px;">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-3">الإجراءات المتاحة</h5>

                            <a id="applyBtn" href="/student_apply?id=<?= $oppID ?>" class="btn btn-success w-100 py-2 mb-2 shadow-sm fw-bold">
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
                                        <a href="mailto:<?= $orgEmail ?>" class="text-decoration-none text-muted">
                                            <?= $orgEmail ?>
                                        </a>
                                    </p>
                                    <p class="mb-0 small" id="opContactPhone">
                                        <i class="bi bi-telephone text-primary ms-1"></i> 
                                        <span class="text-muted"><?= $orgPhone ?></span>
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
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>