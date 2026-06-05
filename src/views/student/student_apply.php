<?php 
require_once VIEW_PATH . '/layout/header.php'; 

$opp = $opportunity ?? [];

$title = htmlspecialchars($opp['title'] ?? $opp['Title'] ?? 'بدون عنوان');
$orgName = htmlspecialchars($opp['OrganizationName'] ?? $opp['organizationName'] ?? 'مؤسسة العطاء');
$location = htmlspecialchars($opp['location'] ?? $opp['Location'] ?? 'غير محدد');
$oppType = $opp['type'] ?? $opp['Type'] ?? '';

$oppID = $opp['opportunityID'] ?? $opp['OpportunityID'] ?? 0;
$orgID = $opp['organizationID'] ?? $opp['OrganizationID'] ?? 0;
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تقديم طلب - <?= $title ?></title>
    <link rel="icon" type="image/png" href="/images/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">
    <main class="flex-grow-1">
        <div class="container my-4">
            <div class="mb-3">
                <a id="backToDetails" href="/student_opportunity-details?id=<?= $oppID ?>" class="text-decoration-none text-secondary">
                    <i class="bi bi-arrow-right"></i> العودة لتفاصيل الفرصة
                </a>
            </div>

            <div class="row g-4 justify-content-center">
                <div class="col-12 col-lg-8">
                    <div class="card shadow-sm mb-3 border-0">
                        <div class="card-body p-4">
                            <div class="d-flex flex-column flex-md-row justify-content-between gap-2">
                                <div>
                                    <h4 class="fw-bold mb-1" id="opTitle"><?= $title ?></h4>
                                    <p class="text-muted mb-0">
                                        <span id="opOrg" class="fw-bold"><?= $orgName ?></span>
                                        <span class="mx-2">•</span>
                                        <span id="opLocation"><i class="bi bi-geo-alt"></i> <?= $location ?></span>
                                    </p>
                                </div>
                                <div class="d-flex align-items-start gap-2">
                                    <span class="badge bg-info text-dark" id="opType">
                                        <?= (strpos($oppType, 'Train') !== false || $oppType === 'تدريب' ? 'تدريب ميداني' : 'عمل تطوعي') ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-4">نموذج التقديم</h5>
                            <form action="/submit_application" method="POST" enctype="multipart/form-data" id="applyForm">
                                <input type="hidden" name="opportunity_id" value="<?= $oppID ?>">
                                <input type="hidden" name="entity_id" value="<?= $orgID ?>">

                                <div class="row g-3">
                                    <div class="col-12 col-md-6">
                                        <label class="form-label fw-semibold">البريد الإلكتروني الجامعي</label>
                                        <input type="email" class="form-control" name="student_email" placeholder="number@ppu.edu.ps" required>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label class="form-label fw-semibold">التخصص</label>
                                        <input type="text" class="form-control" name="major" placeholder="مثال: هندسة أنظمة حاسوب" required>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">رقم التواصل</label>
                                        <input type="tel" class="form-control" name="phone" placeholder="059xxxxxxx" required>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">لماذا تتقدم لهذه الفرصة؟</label>
                                        <textarea class="form-control" name="motivation" rows="4" placeholder="اكتب نبذة قصيرة عن مهاراتك ودوافعك..." required></textarea>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">رفع السيرة الذاتية (CV)</label>
                                        <input type="file" class="form-control" name="cv_file" accept=".pdf" required>
                                        <div class="form-text">يرجى رفع الملف بصيغة PDF فقط.</div>
                                    </div>
                                </div>

                                <div class="d-flex gap-2 mt-4">
                                    <button id="submitBtn" type="submit" class="btn btn-primary px-4">
                                        <i class="bi bi-send me-1"></i> إرسال الطلب
                                    </button>
                                    <a href="/student_opportunities" class="btn btn-outline-secondary">إلغاء</a>
                                </div>

                                <?php if (isset($_SESSION['error'])): ?>
                                    <div class="alert alert-danger mt-3 mb-0">
                                        <?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
                                    </div>
                                <?php endif; ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>