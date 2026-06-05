<?php 
require_once VIEW_PATH . '/layout/header.php'; 
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مركز الإشعارات الفورية - إدارة الكلية</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .border-right-danger { border-right: 5px solid red !important; }
        .text-custom-black { color: black; }
        .text-custom-red { color: red; }
        .bg-custom-white { background-color: white; }
    </style>
</head>
<body class="bg-light flex-column min-vh-100">


    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-0 text-custom-black">مركز استقبال الإشعارات والعمليات الفورية</h4>
                <p class="text-muted small mb-0">تنبيهات تلقائية حول حالات الطلاب المعلقة، والساعات المعتمدة المستحقة للشهادات.</p>
            </div>
            <button onclick="location.reload()" class="btn btn-sm btn-outline-danger rounded-pill px-4 fw-bold">
                <i class="bi bi-arrow-clockwise"></i> تحديث السجل الفوري
            </button>
        </div>

        <div class="card shadow-sm border-0 overflow-hidden rounded-4">
            <div class="list-group list-group-flush">
                
                <?php if (!empty($notifications) && is_array($notifications)): ?>
                    <?php foreach ($notifications as $notification): ?>
                        <div class="list-group-item list-group-item-action p-4 border-0 mb-1 bg-custom-white border-right-danger shadow-sm">
                            <div class="d-flex w-100 justify-content-between align-items-center">
                                <h6 class="mb-1 fw-bold text-custom-black">
                                    <i class="bi <?= $notification['icon'] ?> text-custom-red fs-5 ms-2"></i> 
                                    <?= htmlspecialchars($notification['title']) ?>
                                </h6>
                                <small class="text-muted small">
                                    <?php 
                                        $timeAgo = strtotime($notification['time']);
                                        $diff = time() - $timeAgo;
                                        if ($diff < 60) echo "الآن";
                                        elseif ($diff < 3600) echo "منذ " . round($diff / 60) . " دقيقة";
                                        elseif ($diff < 86400) echo "منذ " . round($diff / 3600) . " ساعة";
                                        else echo date('Y-m-d', $timeAgo);
                                    ?>
                                </small>
                            </div>
                            <p class="mb-1 text-secondary small pe-4"><?= $notification['message'] ?></p>
                            <div class="pe-4 mt-2">
                                <a href="<?= $notification['link'] ?>" class="btn btn-sm p-0 text-custom-red fw-bold small">
                                    <?= $notification['btn_text'] ?> <i class="bi bi-chevron-left small"></i>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="text-center p-5 bg-custom-white">
                        <i class="bi bi-bell-slash text-muted fs-1 mb-3 d-block"></i>
                        <h6 class="fw-bold text-secondary">لا توجد إشعارات أو عمليات معلقة حالياً</h6>
                        <p class="text-muted small mb-0">جميع تقارير الساعات مدققة ومقرة، ولا يوجد طلاب جدد بانتظار إصدار الشهادات.</p>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>