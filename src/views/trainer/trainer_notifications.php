<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مركز الإشعارات - المدرب الميداني</title>
    <link rel="icon" type="image/png" href="/public/images/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100 bg-light">
    <?php require_once '../layout/header.php'; ?>

    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-4 text-start">
            <h4 class="fw-bold mb-0">الإشعارات الواردة</h4>
            <button class="btn btn-sm btn-outline-secondary">تحديد الكل كمقروء</button>
        </div>

        <div class="card shadow-sm border-0 text-start">
            <div class="list-group list-group-flush">
                <?php if(!empty($data['notifications'])): ?>
                    <?php foreach($data['notifications'] as $notif): ?>
                        <div class="list-group-item list-group-item-action p-3 <?= $notif['is_read'] ? '' : 'bg-light border-start border-4 border-primary' ?>">
                            <div class="d-flex w-100 justify-content-between align-items-center">
                                <h6 class="mb-1 fw-bold"><?= $notif['title'] ?></h6>
                                <small class="text-muted small"><?= $notif['time_ago'] ?></small>
                            </div>
                            <p class="mb-1 text-secondary small"><?= $notif['message'] ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="p-5 text-center text-muted">
                        <i class="bi bi-bell-slash fs-1 d-block mb-3"></i>
                        لا توجد إشعارات حالياً  .
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>