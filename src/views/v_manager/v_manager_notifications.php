<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مركز الإشعارات - EduServe</title>
    <link rel="icon" type="image/png" href="/public/images/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .border-right-danger { border-right: 5px solid red !important; }
        .text-custom-black { color: black; }
        .text-custom-red { color: red; }
        .bg-custom-white { background-color: white; }
        .notification-time { font-size: 0.75rem; color: gray; }
    </style>
</head>
<body class="d-flex flex-column min-vh-100 bg-light text-end">
    <?php require_once '../src/views/layout/header.php'; ?>

    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-0 text-custom-black">الإشعارات الواردة</h4>
                <p class="text-muted small mb-0">متابعة آخر التحديثات والنشاطات من قاعدة البيانات</p>
            </div>
            <?php if(!empty($notifications)): ?>
                <button onclick="location.reload()" class="btn btn-sm btn-danger rounded-pill px-4 shadow-sm fw-bold">
                    <i class="bi bi-arrow-clockwise ms-1"></i> تحديث القائمة
                </button>
            <?php endif; ?>
        </div>

        <div class="card shadow-sm border-0 overflow-hidden rounded-4">
            <div class="list-group list-group-flush">
                <?php if(!empty($notifications)): ?>
                    <?php foreach($notifications as $notif): ?>
                        <div class="list-group-item list-group-item-action p-4 border-0 mb-1 bg-custom-white border-right-danger shadow-sm">
                            <div class="d-flex w-100 justify-content-between align-items-center">
                                <h6 class="mb-1 fw-bold text-custom-black">
                                    <i class="bi bi-dot text-custom-red fs-4"></i>
                                    <?= htmlspecialchars($notif['title']) ?>
                                </h6>
                                <small class="notification-time">
                                    <?= date('Y-m-d H:i', strtotime($notif['event_time'])) ?>
                                </small>
                            </div>
                            
                            <p class="mb-1 text-secondary small pe-4"><?= htmlspecialchars($notif['message']) ?></p>
                            
                            <div class="pe-4 mt-2">
                                <a href="/v_manager/student-details?id=<?= $notif['id'] ?>" class="btn btn-sm p-0 text-custom-red fw-bold small">
                                    عرض الملف الشخصي <i class="bi bi-chevron-left small"></i>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="p-5 text-center text-muted bg-custom-white">
                        <i class="bi bi-bell-slash fs-1 d-block mb-3 text-light"></i>
                        <h5 class="fw-bold text-custom-black">السجل فارغ</h5>
                        <p class="mb-0">لا توجد تحديثات أو نشاطات مسجلة لطلابك في الوقت الحالي.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>