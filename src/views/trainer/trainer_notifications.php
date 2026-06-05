<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مركز الإشعارات - EduServe</title>
    <link rel="icon" type="image/png" href="/public/images/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="/public/css/styles.css">
</head>
<body class="bg-light">

    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-4 text-start">
            <h4 class="fw-bold mb-0 text-dark">الإشعارات والتحديثات</h4>
            <a href="/trainer/dashboard" class="btn btn-sm btn-outline-secondary rounded-pill">
                <i class="bi bi-house ms-1"></i>الرئيسية
            </a>
        </div>

        <div class="card shadow-sm border-0 rounded-4 overflow-hidden text-start">
            <div class="list-group list-group-flush">
                <?php if(!empty($data['notifications'])): ?>
                    <?php foreach($data['notifications'] as $notif): ?>
                        <div class="list-group-item list-group-item-action p-4 border-start border-4 <?= $notif['type'] == 'report' ? 'border-info' : 'border-success' ?>">
                            <div class="d-flex w-100 justify-content-between align-items-center mb-1">
                                <div class="d-flex align-items-center">
                                    <?php if($notif['type'] == 'report'): ?>
                                        <i class="bi bi-file-earmark-text text-info fs-5 ms-2"></i>
                                    <?php else: ?>
                                        <i class="bi bi-person-check text-success fs-5 ms-2"></i>
                                    <?php endif; ?>
                                    <h6 class="mb-0 fw-bold"><?= $notif['type'] == 'report' ? 'تقرير جديد' : 'تسجيل حضور' ?></h6>
                                </div>
                                <small class="text-muted small"><?= $notif['time_ago'] ?></small>
                            </div>
                            <p class="mb-0 text-secondary small pe-4"><?= htmlspecialchars($notif['message']) ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="p-5 text-center text-muted">
                        <i class="bi bi-clipboard-x fs-1 d-block mb-3 opacity-25"></i>
                        <p>لا توجد نشاطات حديثة لطلابك حالياً.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>