<?php 
require_once VIEW_PATH . '/layout/header.php'; 
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم - إدارة الكلية</title>
    <link class="no-print" rel="icon" type="image/png" href="/public/images/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .text-custom-black { color: black; }
        .text-custom-red { color: red; }
        .btn-custom-red { background-color: red; color: white; border: none; }
        .btn-custom-red:hover { background-color: darkred; color: white; }
        .border-custom-red { border-bottom: 4px solid red !important; }
        .border-custom-black { border-bottom: 4px solid black !important; }
    </style>
</head>
<body class="bg-light flex-column min-vh-100">
    

    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold text-custom-black mb-1">لوحة التحكم الإدارية</h3>
                <p class="text-muted small mb-0">نظرة عامة ومباشرة على العمليات الجارية في المنظومة.</p>
            </div>
            <div class="text-muted small fw-bold">تاريخ اليوم: <?= date('Y-m-d') ?></div>
        </div>

        <div class="row g-4 mb-5">
            <div class="col-12 col-sm-6 col-md-3">
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white border-custom-black">
                    <small class="text-muted d-block mb-1 fw-bold">إجمالي الحسابات</small>
                    <h2 class="fw-bold text-custom-black mb-0"><?= htmlspecialchars($stats['totalAccounts'] ?? 0) ?></h2>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white border-custom-red">
                    <small class="text-muted d-block mb-1 fw-bold">الطلاب النشطون</small>
                    <h2 class="fw-bold text-custom-red mb-0"><?= htmlspecialchars($stats['activeStudents'] ?? 0) ?></h2>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white border-custom-black">
                    <small class="text-muted d-block mb-1 fw-bold">شهادات معلقة</small>
                    <h2 class="fw-bold text-custom-black mb-0"><?= htmlspecialchars($stats['pendingCertificates'] ?? 0) ?></h2>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white border-custom-red">
                    <small class="text-muted d-block mb-1 fw-bold">تقارير this الشهر</small>
                    <h2 class="fw-bold text-custom-red mb-0"><?= htmlspecialchars($stats['monthlyReports'] ?? 0) ?></h2>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-12 col-lg-6">
                <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
                    <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                        <h6 class="fw-bold mb-0 text-custom-black"><i class="bi bi-lightning-charge ms-2 text-custom-red"></i>آخر التنبيهات والنشاطات</h6>
                    </div>
                    <div class="card-body px-4 py-3">
                        <?php if (!empty($notifications) && is_array($notifications)): ?>
                            <?php foreach ($notifications as $notification): ?>
                                <div class="alert alert-light border border-start border-3 border-danger shadow-sm mb-3 small text-end py-3 rounded-3 d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="bi <?= htmlspecialchars($notification['icon']) ?> text-custom-red fs-5 ms-2"></i>
                                        <strong><?= htmlspecialchars($notification['title']) ?>:</strong> 
                                        <?= htmlspecialchars($notification['message']) ?>
                                        <br>
                                        <span class="text-muted extra-small ms-4"><i class="bi bi-clock ms-1"></i><?= htmlspecialchars($notification['time']) ?></span>
                                    </div>
                                    <a href="<?= htmlspecialchars($notification['link']) ?>" class="btn btn-sm btn-custom-red rounded-pill px-3 fw-bold no-print text-nowrap">
                                        <?= htmlspecialchars($notification['btn_text']) ?>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="text-center text-muted py-5">
                                <i class="bi bi-bell-slash display-6 d-block mb-2 text-secondary"></i>
                                لا توجد تنبيهات أو طلبات معلقة حالياً. المنظومة مستقرة تماماً.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
                    <div class="card-header bg-white border-0 pt-4 px-4">
                        <h6 class="fw-bold mb-0 text-custom-black"><i class="bi bi-gear-wide-connected ms-2 text-custom-red"></i>الروابط والوصول السريع</h6>
                    </div>
                    <div class="card-body px-4 py-3">
                        <div class="d-grid gap-2">
                            <a href="/admin/accounts" class="btn btn-outline-dark text-start py-3 rounded-3 fw-bold"><i class="bi bi-person-plus ms-2 text-custom-red"></i> إدارة الحسابات وتعديل الصلاحيات</a>
                            <a href="/admin/certificates" class="btn btn-custom-red text-start py-3 rounded-3 fw-bold"><i class="bi bi-pen ms-2"></i> إصدار وتوقيع الشهادات الرقمية</a>
                            <a href="/admin/statistics" class="btn btn-outline-secondary text-custom-black text-start py-3 rounded-3 fw-bold"><i class="bi bi-printer ms-2 text-custom-red"></i> الإحصائيات العامة وطباعة التقارير الرسمية</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>